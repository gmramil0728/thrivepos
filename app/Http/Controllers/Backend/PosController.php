<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Order;
use App\Models\Orderdetails;
use Gloudemans\Shoppingcart\Facades\Cart;
use Carbon\Carbon;
use DB;

use App\Models\OrderPayment;

class PosController extends Controller
{
    public function Pos(){
        $todaydate = Carbon::now();
        $categories = Category::latest()->get();
        $products = Product::latest()->get();
        $customer = Customer::latest()->get();
        
        return view('backend.pos.pos_page', compact('products', 'customer', 'categories'));
    }

    public function AddCart(Request $request){
        // Get product to check stock
        $product = Product::find($request->id);
        
        if (!$product) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], 404);
            }
            
            $notification = array(
                'message' => 'Product not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        
        // Check if product already exists in cart
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($request) {
            return $cartItem->id === $request->id;
        });

        $requestedQty = $request->qty;
        $currentCartQty = 0;
        
        if ($cartItem->isNotEmpty()) {
            // Product exists, get current quantity
            $item = $cartItem->first();
            $currentCartQty = $item->qty;
            $requestedQty = $currentCartQty + $request->qty;
        }
        
        // Validate stock availability
        if (isset($product->inventory_count)) {
            $availableStock = $product->inventory_count;
            
            if ($requestedQty > $availableStock) {
                $errorMsg = 'Insufficient stock! Only ' . $availableStock . ' items available. You already have ' . $currentCartQty . ' in cart.';
                
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMsg,
                    ], 400);
                }
                
                $notification = array(
                    'message' => $errorMsg,
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
        }

        if ($cartItem->isNotEmpty()) {
            // Product exists, update quantity
            $item = $cartItem->first();
            Cart::update($item->rowId, $requestedQty);
            
            $successMsg = 'Product quantity updated in cart';
            $alertType = 'info';
        } else {
            // Add new product to cart
            Cart::add([
                'id' => $request->id, 
                'name' => $request->name, 
                'qty' => $request->qty, 
                'price' => $request->price,
                'weight' => 0,
                'options' => [
                    'image' => $request->image ?? null,
                    'code' => $request->code ?? null,
                    'stock' => $product->inventory_count ?? null
                ]
            ]);
            
            $successMsg = 'Product added successfully';
            $alertType = 'success';
        }

        // Return JSON for AJAX calls
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMsg,
                'count' => Cart::count(),
                'subtotal' => floatval(str_replace(',', '', Cart::subtotal())),
                'cart' => $this->formatCartForJson(),
            ]);
        }
        
        // Fallback: redirect for non-AJAX
        $notification = array(
            'message' => $successMsg,
            'alert-type' => $alertType
        );
        return redirect()->back()->with($notification);
    }

    public function AllItem(){
        $product_item = Cart::content();
        return view('backend.pos.text_item', compact('product_item'));
    }

    public function CartUpdate(Request $request, $rowId){
        $qty = $request->qty;
        
        if ($qty < 1) {
            $errorMsg = 'Quantity must be at least 1';
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMsg,
                ], 400);
            }
            
            $notification = array(
                'message' => $errorMsg,
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        
        // Get cart item to check product
        $cartItem = Cart::get($rowId);
        
        if ($cartItem) {
            $product = Product::find($cartItem->id);
            
            // Validate stock availability
            if ($product && isset($product->inventory_count)) {
                if ($qty > $product->inventory_count) {
                    $errorMsg = 'Insufficient stock! Only ' . $product->inventory_count . ' items available.';
                    
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => $errorMsg,
                        ], 400);
                    }
                    
                    $notification = array(
                        'message' => $errorMsg,
                        'alert-type' => 'error'
                    );
                    return redirect()->back()->with($notification);
                }
            }
        }
        
        Cart::update($rowId, $qty);
        
        // Return JSON for AJAX
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'count' => Cart::count(),
                'subtotal' => floatval(str_replace(',', '', Cart::subtotal())),
                'cart' => $this->formatCartForJson(),
            ]);
        }
        
        $notification = array(
            'message' => 'Cart updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function CartRemove($rowId){
        Cart::remove($rowId);
        
        // Return JSON for AJAX
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'count' => Cart::count(),
                'subtotal' => floatval(str_replace(',', '', Cart::subtotal())),
                'cart' => $this->formatCartForJson(),
            ]);
        }
        
        $notification = array(
            'message' => 'Item removed from cart',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function CartClearAll(){
        Cart::destroy();
        
        // Return JSON for AJAX
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'count' => 0,
                'subtotal' => 0,
                'cart' => [],
            ]);
        }
        
        $notification = array(
            'message' => 'Cart cleared successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    /**
     * Format cart contents for JSON response
     */
    private function formatCartForJson()
    {
        $cartItems = Cart::content();
        $formatted = [];
        
        foreach ($cartItems as $item) {
            $formatted[] = [
                'rowId' => $item->rowId,
                'name' => $item->name,
                'price' => floatval($item->price),
                'qty' => intval($item->qty),
                'stock' => $item->options->stock ? intval($item->options->stock) : null,
                'rowTotal' => floatval($item->price * $item->qty),
            ];
        }
        
        return $formatted;
    }

    public function CreateInvoice(Request $request){
        $request->validate([
            'customer_id' => 'required|exists:customers,id'
        ]);

        $contents = Cart::content();
        $cust_id = $request->customer_id;
        $customer = Customer::where('id', $cust_id)->first();
        
        // Get discount and tax information
        $discountType = $request->discount_type ?? 'percent';
        $discountValue = $request->discount_value ?? 0;
        $taxType = $request->tax_type ?? 'vatable';
        
        // Calculate totals
        $subtotal = floatval(str_replace(',', '', Cart::subtotal()));
        
        // Calculate discount
        $discountAmount = 0;
        if ($discountType === 'percent') {
            $discountAmount = $subtotal * ($discountValue / 100);
        } else {
            $discountAmount = $discountValue;
        }
        
        $afterDiscount = $subtotal - $discountAmount;
        
        // Calculate tax based on type
        $vatableSales = 0;
        $vatAmount = 0;
        $zeroRatedSales = 0;
        $vatExemptSales = 0;
        $total = $afterDiscount;
        
        switch ($taxType) {
            case 'vatable':
                $vatableSales = $afterDiscount / 1.12;
                $vatAmount = $afterDiscount - $vatableSales;
                break;
            case 'zero-rated':
                $zeroRatedSales = $afterDiscount;
                break;
            case 'vat-exempt':
                $vatExemptSales = $afterDiscount;
                break;
            case 'non-vat':
                // No VAT calculation
                break;
        }
        
        return view('backend.invoice.product_invoice', compact(
            'contents', 
            'customer', 
            'subtotal', 
            'discountAmount', 
            'discountType',
            'vatableSales', 
            'vatAmount', 
            'zeroRatedSales', 
            'vatExemptSales', 
            'total',
            'taxType'
        ));
    }

    public function PrintThermalReceipt(Request $request){
        $customerId = $request->customer_id;
        $customer = Customer::find($customerId);
        $contents = Cart::content();
        
        // Calculate totals
        $subtotal = floatval(str_replace(',', '', Cart::subtotal()));
        $discountType = $request->discount_type ?? 'percent';
        $discountValue = $request->discount_value ?? 0;
        $taxType = $request->tax_type ?? 'vatable';
        
        // Calculate discount
        $discountAmount = 0;
        if ($discountType === 'percent') {
            $discountAmount = $subtotal * ($discountValue / 100);
        } else {
            $discountAmount = $discountValue;
        }
        
        $afterDiscount = $subtotal - $discountAmount;
        
        // Calculate tax
        $vatableSales = 0;
        $vatAmount = 0;
        $total = $afterDiscount;
        
        if ($taxType === 'vatable') {
            $vatableSales = $afterDiscount / 1.12;
            $vatAmount = $afterDiscount - $vatableSales;
        }
        
        return view('backend.invoice.thermal_receipt', compact(
            'contents', 
            'customer', 
            'subtotal', 
            'discountAmount',
            'vatableSales', 
            'vatAmount', 
            'total',
            'taxType'
        ));
    }

    public function SearchProduct(Request $request){
        $search = $request->search;
        
        $products = Product::where('product_name', 'LIKE', "%{$search}%")
                           ->orWhere('product_code', 'LIKE', "%{$search}%")
                           ->get();
        
        return response()->json($products);
    }

    public function ScanBarcode(Request $request){
        $barcode = $request->barcode;
        
        $product = Product::where('product_code', $barcode)
                          ->orWhere('barcode', $barcode)
                          ->first();
        
        if ($product) {
            // Check stock availability
            if (isset($product->inventory_count) && $product->inventory_count < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product out of stock'
                ], 400);
            }
            
            // Check if product already in cart
            $cartItem = Cart::search(function ($cartItem, $rowId) use ($product) {
                return $cartItem->id === $product->id;
            });
            
            $currentCartQty = 0;
            if ($cartItem->isNotEmpty()) {
                $currentCartQty = $cartItem->first()->qty;
            }
            
            // Validate stock
            if (isset($product->inventory_count) && ($currentCartQty + 1) > $product->inventory_count) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock! Only ' . $product->inventory_count . ' available. You have ' . $currentCartQty . ' in cart.'
                ], 400);
            }
            
            // Add to cart automatically
            Cart::add([
                'id' => $product->id, 
                'name' => $product->product_name, 
                'qty' => 1, 
                'price' => $product->selling_price,
                'weight' => 0,
                'options' => [
                    'image' => $product->product_image ?? null,
                    'code' => $product->product_code ?? null,
                    'stock' => $product->inventory_count ?? null
                ]
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'product' => $product
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Product not found'
        ], 404);
    }

    public function ProcessPayment(Request $request){
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_method' => 'required',
            'total' => 'required|numeric',
        ]);
    
        $total = $request->total;
        $pay = $request->pay ?? 0;
        $due = max(0, $total - $pay);
    
        $payment_status = ($due <= 0) ? 'paid' : ($pay > 0 ? 'partial' : 'due');
        $order_status = ($due <= 0) ? 'complete' : 'pending';
    
        $data = [
            'customer_id' => $request->customer_id,
            'order_date' => $request->order_date ?? Carbon::now()->format('Y-m-d'),
            'order_status' => $order_status,
            'total_products' => $request->total_products,
            'sub_total' => $request->sub_total,
            'vat' => $request->vat,
            'invoice_no' => 'EPOS' . mt_rand(10000000, 99999999),
            'total' => $total,
            'payment_status' => $payment_status,
            'payment_method' => $request->payment_method,
            'pay' => $pay,
            'due' => $due,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value ?? 0,
            'discount_amount' => $request->discount_amount ?? 0,
            'created_at' => Carbon::now(),
        ];
    
        $order_id = Order::insertGetId($data);
    
        if ($pay > 0) {
            OrderPayment::create([
                'order_id' => $order_id,
                'amount' => $pay,
                'payment_method' => $request->payment_method,
                'paid_at' => Carbon::now(),
            ]);
        }
    
        $contents = Cart::content();
    
        foreach ($contents as $content) {
            Orderdetails::insert([
                'order_id' => $order_id,
                'product_id' => $content->id,
                'quantity' => $content->qty,
                'unitcost' => $content->price,
                'total' => $content->price * $content->qty,
            ]);
    
            if ($order_status === 'complete') {
                Product::where('id', $content->id)
                    ->decrement('inventory_count', $content->qty);
            }
        }
    
        Cart::destroy();
    
        $notification = [
            'message' => 'Order processed as ' . strtoupper($order_status),
            'alert-type' => 'success'
        ];
    
        $actionType = $request->action_type ?? 'invoice';
        $route = ($actionType === 'receipt') ? 'print.receipt' : 'view.invoice';
        
        return redirect()->route($route, ['order_id' => $order_id])->with($notification);
    }

    public function ViewInvoice($order_id){
        $order = Order::with('customer')->findOrFail($order_id);
        $orderItems = Orderdetails::with('product')->where('order_id', $order_id)->get();

        return view('backend.invoice.view_invoice', compact('order', 'orderItems'));
    }

    public function PrintReceipt($order_id){
        $order = Order::with('customer')->findOrFail($order_id);
        $orderItems = Orderdetails::with('product')->where('order_id', $order_id)->get();

        return view('backend.invoice.print_receipt', compact('order', 'orderItems'));
    }
}