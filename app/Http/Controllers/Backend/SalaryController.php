<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdvanceSalary; 
use App\Models\Employee; 
use App\Models\PaySalary; 
use Carbon\Carbon;

use Barryvdh\DomPDF\Facade\Pdf;

class SalaryController extends Controller
{
    /**
     * Show form to add advance salary
     */
    public function AddAdvanceSalary(){
        $employee = Employee::orderBy('name', 'ASC')->get();
        return view('backend.salary.add_advance_salary', compact('employee'));
    }

    /**
     * Store a new advance salary request
     */
    public function AdvanceSalaryStore(Request $request){

        $request->validate([
            'employee_id' => 'required',
            'month' => 'required',
            'year' => 'required',
            'advance_salary' => 'required|numeric',
            'request_date' => 'required|date',
        ]);
    
        $month = $request->month;
        $year = $request->year;
        $employee_id = $request->employee_id;
    
        // Check if advance already exists for this specific month AND year
        $advanced = AdvanceSalary::where('month', $month)
                                 ->where('year', $year)
                                 ->where('employee_id', $employee_id)
                                 ->first();
    
        if ($advanced) {
            // This throws a validation error specifically for the 'month' field
            return redirect()->back()
                ->withErrors(['month' => 'Advance salary for ' . $month . ' ' . $year . ' has already been paid to this employee.'])
                ->withInput(); // Keeps the user's other inputs filled in
        }
    
        // If no duplicate, proceed to insert
        AdvanceSalary::insert([
            'employee_id' => $request->employee_id,
            'month' => $request->month,
            'year' => $request->year,
            'advance_salary' => $request->advance_salary,
            'request_date' => $request->request_date,
            'created_at' => \Carbon\Carbon::now(), 
        ]);
    
        $notification = array(
            'message' => 'Advance Salary Paid Successfully',
            'alert-type' => 'success'
        );
    
        return redirect()->route('all.advance.salary')->with($notification); 
    }

    /**
     * Display all advance salaries with Eager Loading
     */
    public function AllAdvanceSalary(){
        // Eager load 'employee' to prevent multiple database hits in the loop
        $salary = AdvanceSalary::with('employee')->latest()->get();
        return view('backend.salary.all_advance_salary', compact('salary'));
    }

    public function EditAdvanceSalary($id){
        $employee = Employee::orderBy('name', 'ASC')->get();
        $salary = AdvanceSalary::findOrFail($id);
        return view('backend.salary.edit_advance_salary', compact('salary', 'employee'));
    }

    public function AdvanceSalaryUpdate(Request $request){
        $salary_id = $request->id;

        $request->validate([
            'advance_salary' => 'required|numeric|min:1',
            'request_date'   => 'required|date',
        ]);

        AdvanceSalary::findOrFail($salary_id)->update([
            'employee_id'    => $request->employee_id,
            'month'          => $request->month,
            'year'           => $request->year,
            'advance_salary' => $request->advance_salary,
            'request_date'   => $request->request_date,
        ]);

        return redirect()->route('all.advance.salary')->with([
            'message' => 'Advance Salary Updated Successfully',
            'alert-type' => 'success'
        ]);
    }

    public function DeleteAdvanceSalary($id){
        AdvanceSalary::findOrFail($id)->delete();
        return redirect()->back()->with([
            'message' => 'Record Deleted Successfully',
            'alert-type' => 'info'
        ]);
    }

    /* ---------------- Pay Salary Methods ---------------- */

    public function PaySalary()
    {
        // Get employees with their related advance salary for the previous month
        $month = date("F", strtotime("-1 month")); 
        $year = date('Y');
        
        $employee = Employee::with(['advance' => function($query) use ($month, $year) {
            $query->where('month', $month)->where('year', $year);
        }])->get();
        
        return view('backend.salary.pay_salary', compact('employee'));
    }

    public function PayNowSalary($id)
    {
        $month = date("F", strtotime("-1 month"));
        $year = date('Y');

        // Fetch employee and their specific advance for the target month
        $paysalary = Employee::with(['advance' => function($query) use ($month, $year) {
            $query->where('month', $month)->where('year', $year);
        }])->findOrFail($id);

        return view('backend.salary.paid_salary', compact('paysalary'));
    }

    public function EmployeSalaryStore(Request $request)
    {
        // 1. Validation for required fields
        $request->validate([
            'month' => 'required',
            'id'    => 'required', // Employee ID
        ]);

        $currentYear = date('Y');

        // 2. Check for existing payment
        $isPaid = PaySalary::where('employee_id', $request->id)
                        ->where('salary_month', $request->month)
                        ->where('salary_year', $currentYear)
                        ->exists();

        if ($isPaid) {
            $notification = [
                'message' => "Salary for {$request->month} {$currentYear} has already been paid to this employee.",
                'alert-type' => 'error'
            ];
            return redirect()->route('pay.salary')->with($notification);
        }

        // 3. Generate Unique Transaction Reference
        // Format: PAY-20260216-RANDOM
        $transaction_id = $request->transaction_id ?? 'PAY-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // 4. Create Payroll Record
        // Define the start and end of the pay period based on the month being paid
        // If paying for "January", start is 2026-01-01 and end is 2026-01-31
        $monthString = $request->month . ' ' . date('Y');
        $start_date = Carbon::parse($monthString)->startOfMonth()->format('Y-m-d');
        $end_date = Carbon::parse($monthString)->endOfMonth()->format('Y-m-d');

        PaySalary::create([
            'employee_id'     => $request->id,
            'salary_month'    => $request->month,
            'salary_year'     => date('Y'),
            'period_start'    => $start_date, // Added this
            'period_end'      => $end_date,   // Added this
            'basic_salary'    => $request->paid_amount,
            'advance_salary'  => $request->advance_salary ?? 0,
            'paid_amount'     => $request->due_salary ?? $request->paid_amount,
            'payment_method'  => $request->payment_method,
            'transaction_id'  => $request->transaction_id ?? 'PAY-'.time(),
            'status'          => 'paid',
            'payment_date'    => Carbon::now()->format('Y-m-d'),
        ]);

        $notification = [
            'message' => 'Salary disbursed successfully. Ref: ' . $transaction_id,
            'alert-type' => 'success'
        ];

        return redirect()->route('pay.salary')->with($notification);
    }

    public function MonthSalary(Request $request) {
        $query = PaySalary::with('employee');
    
        // Filter by Month
        if ($request->has('month') && $request->month != null) {
            $query->where('salary_month', $request->month);
        }
    
        // Filter by Year
        if ($request->has('year') && $request->year != null) {
            $query->where('salary_year', $request->year);
        }
    
        // Filter by Payment Method
        if ($request->has('method') && $request->method != null) {
            $query->where('payment_method', $request->method);
        }
    
        $paidsalary = $query->latest()->get();
        
        return view('backend.salary.month_salary', compact('paidsalary'));
    }

    public function ViewPayslip($id) {
        $payslip = PaySalary::with('employee')->findOrFail($id);
        
        // Fetch company details (assuming you have a Company model)
        // If you don't have a model yet, you can use DB::table('companies')->first();
        $company = \App\Models\CompanySetting::first(); 
    
        return view('backend.salary.payslip', compact('payslip', 'company'));
    }

    public function DownloadPayslip($id) {
        $payslip = PaySalary::with('employee')->findOrFail($id);
        $company = \App\Models\CompanySetting::first();
    
        // Load the view and pass data
        $pdf = Pdf::loadView('backend.salary.payslip_pdf', compact('payslip', 'company'))->setPaper('a4')->setOption([
            'tempDir' => public_path(),
            'chroot' => public_path(),
        ]);
    
        // Set paper to A4 and orientation to Portrait
        // $pdf->setPaper('a4', 'portrait');
    
        // Return the PDF for download or inline view
        // return $pdf->stream('Payslip-'.$payslip->transaction_id.'.pdf');

        
        return $pdf->download('Payslip-'.$payslip->transaction_id.'.pdf');
        
    }

    public function PayrollReportPdf(Request $request) {
        $query = PaySalary::with('employee');
    
        // Apply the same filters used in your index view
        if ($request->month) {
            $query->where('salary_month', $request->month);
        }
        if ($request->year) {
            $query->where('salary_year', $request->year);
        }
        if ($request->method) {
            $query->where('payment_method', $request->method);
        }
    
        $paidsalary = $query->latest()->get();
        $company = \App\Models\CompanySetting::first();
        
        // Summary Data
        $totalAmount = $paidsalary->sum('paid_amount');
        $reportPeriod = ($request->month ?? 'All Time') . ' ' . ($request->year ?? '');
    
        $pdf = Pdf::loadView('backend.salary.payroll_report_pdf', compact('paidsalary', 'company', 'reportPeriod', 'totalAmount'));
        
        // Set to Landscape for professional tabular reports
        return $pdf->setPaper('a4', 'landscape')->stream('Payroll_Report_'.$reportPeriod.'.pdf');
    }

}