<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReceiptMail;
use Carbon\Carbon;

class OrderReceiptController extends Controller
{
    /**
     * Display complete orders with filtering
     */
    public function completeOrders(Request $request)
    {
        $query = Order::with(['customer', 'orderItems'])
                     ->where('order_status', 'complete');

        // Apply filters if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('order_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('order_date', '<=', $request->end_date);
        }

        if ($request->has('invoice_no') && $request->invoice_no) {
            $query->where('invoice_no', 'LIKE', '%' . $request->invoice_no . '%');
        }

        if ($request->has('customer_name') && $request->customer_name) {
            $query->whereHas('customer', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->customer_name . '%');
            });
        }

        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('min_amount') && $request->min_amount) {
            $query->where('pay', '>=', $request->min_amount);
        }

        if ($request->has('max_amount') && $request->max_amount) {
            $query->where('pay', '<=', $request->max_amount);
        }

        $orders = $query->orderBy('order_date', 'desc')->get();

        return view('admin.orders.complete_orders', compact('orders'));
    }

    /**
     * Display printable receipt
     */
    public function printReceipt($id)
    {
        $order = Order::with(['customer', 'orderItems.product'])->findOrFail($id);
        
        return view('admin.orders.receipt_print', compact('order'));
    }

    /**
     * Download receipt as PDF
     */
    public function downloadReceipt($id)
    {
        $order = Order::with(['customer', 'orderItems.product'])->findOrFail($id);
        
        $pdf = Pdf::loadView('admin.orders.receipt_pdf', compact('order'));
        
        return $pdf->download('receipt-' . $order->invoice_no . '.pdf');
    }

    /**
     * Email receipt to customer
     */
    public function emailReceipt(Request $request, $id)
    {
        $order = Order::with(['customer', 'orderItems.product'])->findOrFail($id);
        
        try {
            // Generate PDF
            $pdf = Pdf::loadView('admin.orders.receipt_pdf', compact('order'));
            
            // Send email with PDF attachment
            Mail::to($order->customer->email)->send(new ReceiptMail($order, $pdf));
            
            // Log the email action
            activity()
                ->performedOn($order)
                ->log('Receipt emailed to ' . $order->customer->email);
            
            return response()->json([
                'success' => true,
                'message' => 'Receipt sent successfully to ' . $order->customer->email
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send receipt: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reprint receipt (same as print but logs the action)
     */
    public function reprintReceipt($id)
    {
        $order = Order::with(['customer', 'orderItems.product'])->findOrFail($id);
        
        // Log the reprint action
        activity()
            ->performedOn($order)
            ->log('Receipt reprinted for order ' . $order->invoice_no);
        
        return view('admin.orders.receipt_print', compact('order'));
    }

    /**
     * Bulk email receipts to multiple customers
     */
    public function bulkEmailReceipts(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id'
        ]);

        $orderIds = $request->order_ids;
        $sent = 0;
        $failed = 0;
        $errors = [];

        foreach ($orderIds as $orderId) {
            try {
                $order = Order::with(['customer', 'orderItems.product'])->findOrFail($orderId);
                
                // Generate PDF
                $pdf = Pdf::loadView('admin.orders.receipt_pdf', compact('order'));
                
                // Send email
                Mail::to($order->customer->email)->send(new ReceiptMail($order, $pdf));
                
                // Log the action
                activity()
                    ->performedOn($order)
                    ->log('Receipt emailed (bulk) to ' . $order->customer->email);
                
                $sent++;
            } catch (\Exception $e) {
                $failed++;
                $errors[] = "Order #{$orderId}: " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => true,
            'sent' => $sent,
            'failed' => $failed,
            'errors' => $errors
        ]);
    }

    /**
     * Export filtered orders to Excel
     */
    public function exportFiltered(Request $request)
    {
        $query = Order::with(['customer', 'orderItems'])
                     ->where('order_status', 'complete');

        // Apply same filters as completeOrders method
        // if ($request->has('start_date') && $request->start_date) {
        //     $query->whereDate('order_date', '>=', $request->start_date);
        // }

        if ($request->start_date && $request->end_date) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end   = Carbon::parse($request->end_date)->endOfDay();
        
            $query->whereBetween('order_date', [$start, $end]);
        }

        

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('order_date', '<=', $request->end_date);
        }

        if ($request->has('invoice_no') && $request->invoice_no) {
            $query->where('invoice_no', 'LIKE', '%' . $request->invoice_no . '%');
        }

        if ($request->has('customer_name') && $request->customer_name) {
            $query->whereHas('customer', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->customer_name . '%');
            });
        }

        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('min_amount') && $request->min_amount) {
            $query->where('pay', '>=', $request->min_amount);
        }

        if ($request->has('max_amount') && $request->max_amount) {
            $query->where('pay', '<=', $request->max_amount);
        }

        $orders = $query->orderBy('order_date', 'desc')->get();

        // Create Excel export
        return \Excel::download(new OrdersExport($orders), 'filtered_orders_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Print filtered orders report
     */
    public function printFilteredReport(Request $request)
    {
        $query = Order::with(['customer', 'orderItems'])
                     ->where('order_status', 'complete');

        // Apply filters
        $filters = [];
        
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('order_date', '>=', $request->start_date);
            $filters['start_date'] = $request->start_date;
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('order_date', '<=', $request->end_date);
            $filters['end_date'] = $request->end_date;
        }

        if ($request->has('invoice_no') && $request->invoice_no) {
            $query->where('invoice_no', 'LIKE', '%' . $request->invoice_no . '%');
            $filters['invoice_no'] = $request->invoice_no;
        }

        if ($request->has('customer_name') && $request->customer_name) {
            $query->whereHas('customer', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->customer_name . '%');
            });
            $filters['customer_name'] = $request->customer_name;
        }

        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
            $filters['payment_status'] = $request->payment_status;
        }

        if ($request->has('min_amount') && $request->min_amount) {
            $query->where('pay', '>=', $request->min_amount);
            $filters['min_amount'] = $request->min_amount;
        }

        if ($request->has('max_amount') && $request->max_amount) {
            $query->where('pay', '<=', $request->max_amount);
            $filters['max_amount'] = $request->max_amount;
        }

        $orders = $query->orderBy('order_date', 'desc')->get();

        return view('admin.orders.filtered_report_print', compact('orders', 'filters'));
    }

    /**
     * Get orders summary statistics
     */
    public function getOrdersStats(Request $request)
    {
        $query = Order::where('order_status', 'complete');

        // Apply date range filter if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('order_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('order_date', '<=', $request->end_date);
        }

        $stats = [
            'total_orders' => $query->count(),
            'total_revenue' => $query->sum('pay'),
            'average_order_value' => $query->avg('pay'),
            'paid_orders' => $query->where('payment_status', 'paid')->count(),
            'pending_orders' => $query->where('payment_status', 'pending')->count(),
        ];

        return response()->json($stats);
    }
}
