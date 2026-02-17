<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function EmployeeAttendanceList(){
        $allData = Attendance::select('date')->groupBy('date')->orderBy('date','desc')->get();
        return view('backend.attendance.view_employee_attend',compact('allData'));
    } 

    public function AddEmployeeAttendance(){
        $employees = Employee::all();
        return view('backend.attendance.add_employee_attend',compact('employees'));
    } 

    public function EmployeeAttendanceStore(Request $request)
    {
        $date = date('Y-m-d', strtotime($request->date));

        // CHECK FOR DUPLICATE: Prevent adding if date already exists
        $checkAttendance = Attendance::where('date', $date)->first();
        if ($checkAttendance) {
            $notification = array(
                'message' => 'Attendance for this date already exists. Please use the Edit option.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $countemployee = count($request->employee_id);

        for ($i = 0; $i < $countemployee; $i++) {
            $attend_status = 'attend_status' . $i;
            $attend = new Attendance();
            $attend->date = $date;
            $attend->employee_id = $request->employee_id[$i];
            $attend->attend_status = ucfirst($request->$attend_status); // Standardize to 'Present'
            $attend->save();
        }

        $notification = array(
            'message' => 'Attendance Data Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('employee.attend.list')->with($notification);
    }

    public function UpdateEmployeeAttendance(Request $request)
    {
        $date = date('Y-m-d', strtotime($request->date));

        // 1. Delete all existing records for this specific date first
        Attendance::where('date', $date)->delete();

        // 2. Re-insert the updated records
        $countemployee = count($request->employee_id);

        for ($i = 0; $i < $countemployee; $i++) {
            $attend_status = 'attend_status' . $i;
            $attend = new Attendance();
            $attend->date = $date;
            $attend->employee_id = $request->employee_id[$i];
            $attend->attend_status = ucfirst($request->$attend_status); // Ensures 'Present' is capitalized
            $attend->save();
        }

        $notification = array(
            'message' => 'Attendance Data Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('employee.attend.list')->with($notification);
    } 
    
    public function EditEmployeeAttendance($date){
        $employees = Employee::all();
        $editData = Attendance::where('date',$date)->get();
        // Pass a variable to let the form know this is an edit
        return view('backend.attendance.edit_employee_attend',compact('employees','editData'));
    } 

    public function ViewEmployeeAttendance($date){
        $details = Attendance::where('date',$date)->get();
        return view('backend.attendance.details_employee_attend',compact('details'));
    } 

    public function MonthlyAttendance(Request $request) {
        // Get month and year from request or default to current
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');
    
        // Calculate how many days are in that specific month/year
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        $employees = Employee::with(['attendance' => function($query) use ($month, $year) {
            $query->whereMonth('date', $month)->whereYear('date', $year);
        }])->get();
    
        return view('backend.attendance.monthly_attendance', compact('employees', 'daysInMonth', 'month', 'year'));
    }
    
}