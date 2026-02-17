<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;

class SupplierController extends Controller
{
    //
    public function SupplierAll(){

        $supplier = Supplier::latest()->get();
        return view('backend.supplier.all_supplier',compact('supplier'));

    } // End Method 


    public function SupplierAdd(){
         return view('backend.supplier.add_supplier');
    } // End Method 



     public function SupplierStore(Request $request){

        $validateData = $request->validate([
            'name' => 'required|max:200',
            // 'email' => 'required|unique:customers|max:200',
            'phone' => 'required|max:200',
            'address' => 'required|max:400',
            'shopname' => 'required|max:200',
            // 'account_holder' => 'required|max:200', 
            // 'account_number' => 'required', 
            'type' => 'required', 
            // 'image' => 'required',  
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
 
        $save_url = '';

        if ($request->file('image')) { 
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            
            Image::read($image)
                    ->scale(width: 300) // Height automatically calculates to maintain aspect ratio
                    ->save(public_path('upload/supplier/' . $name_gen));
            $save_url = 'upload/supplier/'.$name_gen;
        }
        

        Supplier::insert([

            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'shopname' => $request->shopname,
            'type' => $request->type,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'bank_branch' => $request->bank_branch,
            'city' => $request->city,
            'image' => $save_url,
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Supplier Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('supplier.all')->with($notification); 
    } // End Method 


 public function SupplierEdit($id){

        $supplier = Supplier::findOrFail($id);
        return view('backend.supplier.edit_supplier',compact('supplier'));

    } // End Method 


     

    public function SupplierUpdate(Request $request)
    {
        $supplier_id = $request->id;

        // Validation
        $request->validate([
            'name'    => 'required|string|max:255',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'shopname' => $request->shopname,
            'type' => $request->type,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'bank_branch' => $request->bank_branch,
            'city' => $request->city,           
            'updated_at' => Carbon::now(),
        ];

        // Handle image if uploaded
        if ($request->file('image')) {        

            $supplier = Supplier::findOrFail($supplier_id);
            
            if (file_exists($supplier->image)) {
                unlink($supplier->image);                
            }

            

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            // Resize while maintaining aspect ratio
            Image::read($image)
            ->scale(width: 300) // Height automatically calculates to maintain aspect ratio
                ->save(public_path('upload/supplier/' . $name_gen));

            $data['image'] = 'upload/supplier/' . $name_gen;
        }

        // Update employee
        Supplier::findOrFail($supplier_id)->update($data);

        // Notification
        $notification = [
            'message'    => 'Supplier Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('supplier.all')->with($notification);
    }



 public function SupplierDelete($id){

        $supplier = Supplier::findOrFail($id);        
        if (file_exists($supplier->image)) {
            unlink($supplier->image);
        }

        Supplier::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Supplier Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    } // End Method 

 public function SupplierDetails($id){

        $supplier = Supplier::findOrFail($id);
        return view('backend.supplier.details_supplier',compact('supplier'));

    } // End Method 

}
