<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;

class CustomerController extends Controller
{
     public function CustomerAll(){

        $customer = Customer::latest()->get();
        return view('backend.customer.all_customer',compact('customer'));
    } // End Method 


    public function CustomerAdd(){
         return view('backend.customer.add_customer');
    } // End Method 


     public function CustomerStore(Request $request){

        $validateData = $request->validate([
            'name' => 'required|max:200',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'email' => 'required|unique:customers|max:200',
            // 'phone' => 'required|max:200',
            // 'address' => 'required|max:400',
            // 'shopname' => 'required|max:200',
            // 'account_holder' => 'required|max:200', 
            // 'account_number' => 'required', 
            // 'image' => 'required',  
        ]);

        $save_url = '';

        if ($request->file('image')) { 
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            
            Image::read($image)
                    ->scale(width: 300) // Height automatically calculates to maintain aspect ratio
                    ->save(public_path('upload/customer/' . $name_gen));
            $save_url = 'upload/customer/'.$name_gen;
        }

 
        

        Customer::insert([

            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'shopname' => $request->shopname,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'bank_branch' => $request->bank_branch,
            'city' => $request->city,
            'image' => $save_url,
            'created_at' => Carbon::now(), 

        ]);

         $notification = array(
            'message' => 'Customer Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.all')->with($notification); 
    } // End Method 

    public function CustomerEdit($id){

        $customer = Customer::findOrFail($id);
        return view('backend.customer.edit_customer',compact('customer'));

    } // End Method 



    public function CustomerUpdate(Request $request)
    {
        $customer_id = $request->id;

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
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'bank_branch' => $request->bank_branch,
            'city' => $request->city,            
            'updated_at' => Carbon::now(),
        ];

        // Handle image if uploaded
        if ($request->file('image')) {        

            $customer = Customer::findOrFail($customer_id);
            
            if (file_exists($customer->image)) {
                unlink($customer->image);
                // dd(true);
            }

            

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            // Resize while maintaining aspect ratio
            Image::read($image)
            ->scale(width: 300) // Height automatically calculates to maintain aspect ratio
                ->save(public_path('upload/customer/' . $name_gen));

            $data['image'] = 'upload/customer/' . $name_gen;
        }

        // Update employee
        Customer::findOrFail($customer_id)->update($data);

        // Notification
        $notification = [
            'message'    => 'Customer Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('customer.all')->with($notification);
    }


    public function CustomerDelete($id){

        $customer = Customer::findOrFail($id);        
        if (file_exists($customer->image)) {
            unlink($customer->image);
        }
        

        Customer::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Customer Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification); 

    } // End Method 





}
 