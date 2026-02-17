<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\CompanySetting;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class EmployeeController extends Controller
{
    public function EmployeeAll(){
        $employee = Employee::latest()->get();
        return view('backend.employee.all_employee', compact('employee'));
    }

    public function EmployeeAdd(){
        return view('backend.employee.add_employee');
    }

    public function EmployeeStore(Request $request) {
        // Validation: Changed 'image' to 'nullable'
        $request->validate([
            'name' => 'required|max:200',
            'email' => 'required|max:200|unique:employees',
            'phone' => 'required|max:200',            
            'salary' => 'required|max:200',                     
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',            
        ],
        [
            'name.required' => "Name field is required."
        ]);

        $save_url = null; // Default value if no image is uploaded

        // Handle image ONLY if uploaded
        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

            Image::read($image)
            ->scale(width: 300) 
            ->save(public_path('upload/employee/' . $name_gen));
            
            $save_url = 'upload/employee/'.$name_gen;
        }

        // Employee::insert([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'address' => $request->address,
        //     'experience' => $request->experience,
        //     'designation' => $request->designation,
        //     'salary' => $request->salary,                
        //     'image' => $save_url,
        //     'created_at' => Carbon::now(),
        // ]);

        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'experience' => $request->experience,
            'designation' => $request->designation,
            'salary' => $request->salary,                
            'image' => $save_url,
            // 'created_at' => Carbon::now(), <-- No longer needed with create()
        ]);

        $notification = array(
            'message' => 'Employee Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.employee')->with($notification);
    }

    public function EmployeeEdit($id) {
        $employee = Employee::findOrFail($id);
        return view('backend.employee.edit_employee',compact('employee'));
    }

    public function EmployeeUpdate(Request $request)
    {
        $employee_id = $request->id;

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:employees,email,' . $employee_id,
            'phone'   => 'required|string|max:20',
            'salary'  => 'required|numeric|min:0',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $employee = Employee::findOrFail($employee_id);
        
        $data = [
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'salary'     => $request->salary,
            'designation' => $request->designation,
            'updated_at' => Carbon::now(),
        ];

        if ($request->file('image')) {         
            // Delete old image if it exists
            if ($employee->image && file_exists(public_path($employee->image))) {
                unlink(public_path($employee->image));
            }

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            Image::read($image)
            ->scale(width: 300) 
            ->save(public_path('upload/employee/' . $name_gen));

            $data['image'] = 'upload/employee/' . $name_gen;
        }

        $employee->update($data);

        $notification = [
            'message'    => 'Employee Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.employee')->with($notification);
    }

    public function EmployeeDelete($id){
        $employee = Employee::findOrFail($id);

        // Fixed the path for unlinking
        if ($employee->image && file_exists(public_path($employee->image))) {
            unlink(public_path($employee->image));
        }

        $employee->delete();

        return redirect()->back()->with([
            'message' => 'Employee Deleted Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function EmployeePrintMasterlist(){
        $employees = Employee::latest()->get(); 
        $company = CompanySetting::latest()->first();

        $pdf = Pdf::loadView('backend.employee.print_emp_masterlist', compact('employees','company'))
            ->setPaper('a4')
            ->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path(),
            ]);
            
        return $pdf->download('employees.pdf');
    }
}