<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense; 
use Carbon\Carbon;

use Barryvdh\DomPDF\Facade\Pdf;

class ExpenseController extends Controller
{
    // Simplified Method naming for better readability
    public function AddExpense(){
        return view('backend.expense.add_expense');
    }

    public function StoreExpense(Request $request){
        $request->validate([
            'details' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required',
        ]);
    
        $dateTime = \Carbon\Carbon::parse($request->date);
    
        // Use create() instead of insert() to handle timestamps automatically
        \App\Models\Expense::create([
            'reference_no' => 'EXP-' . strtoupper(\Illuminate\Support\Str::random(8)), // Generates the missing field
            'details' => $request->details,
            'amount' => $request->amount,
            'date' => $request->date,
            'month' => $dateTime->format('F'),
            'year' => $dateTime->format('Y'),
        ]);
    
        $notification = [
            'message' => 'Expense Inserted Successfully',
            'alert-type' => 'success'
        ];
    
        // return redirect()->back()->with($notification); 
        return redirect()->route('year.expense')->with($notification);
    }

    public function TodayExpense(){
        $date = Carbon::now()->format('Y-m-d'); // Use standard SQL format
        $today = Expense::where('date', $date)->latest()->get();
        
        // Calculate total for summary widgets
        $totalAmount = $today->sum('amount');

        return view('backend.expense.today_expense', compact('today', 'totalAmount'));
    }

    public function MonthExpense(){
        $month = Carbon::now()->format('F');
        $year  = Carbon::now()->format('Y');

        $monthexpense = Expense::where('month', $month)
                               ->where('year', $year)
                               ->latest()
                               ->get();
                               
        $totalAmount = $monthexpense->sum('amount');

        return view('backend.expense.month_expense', compact('monthexpense', 'totalAmount', 'month'));
    }

    public function YearExpense(Request $request) {
        $year = date("Y");
        $query = Expense::query();
    
        // 1. Filter by Description (if provided)
        if ($request->filled('search_details')) {
            $query->where('details', 'LIKE', '%' . $request->search_details . '%');
        }
    
        // 2. Filter by Date Range (if provided)
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } else {
            // Default to current year if no date range is set
            $query->where('year', $year);
        }
    
        // $yearexpense = $query->latest()->get();
        $yearexpense = $query->orderBy('date', 'desc')->get();
        $totalAmount = $yearexpense->sum('amount');
    
        return view('backend.expense.year_expense', compact('yearexpense', 'totalAmount', 'year'));
    }

    // This method shows the edit form
    public function EditExpense($id)
    {
        $expense = Expense::findOrFail($id); // Finds the record or throws a 404
        return view('backend.expense.edit_expense', compact('expense'));
    }

    // This method handles the actual database update
    public function UpdateExpense(Request $request, $id)
    {
        // 1. Validate the incoming data
        $request->validate([
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'details' => 'required|string',
        ]);

        // 2. Find and Update
        $expense = Expense::findOrFail($id);
        
        $expense->update([
            'date' => $request->date,
            'amount' => $request->amount,
            'details' => $request->details,
            'month' => date('F', strtotime($request->date)),
            'year' => date('Y', strtotime($request->date)),
        ]);

        // 3. Redirect with a success message
        $notification = array(
            'message' => 'Expense Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('year.expense')->with($notification);
    }

    public function DeleteExpense($id){

        Expense::findOrFail($id)->delete();

         $notification = array(
            'message' => 'Expense Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);  


    }// End Method

    public function ExpenseReportPdf(Request $request) {
        $query = Expense::query();
    
        // Re-apply filters
        if ($request->filled('search_details')) {
            $query->where('details', 'LIKE', '%' . $request->search_details . '%');
        }
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        }
    
        // Sort by date ASCENDING for traceability
        $expenses = $query->orderBy('date', 'asc')->get();
        
        // Grouping retains the sort order of the collection
        $groupedData = $expenses->groupBy(function($item) {
            return date('Y', strtotime($item->date));
        })->map(function($yearGroup) {
            return $yearGroup->groupBy(function($item) {
                return date('F', strtotime($item->date));
            });
        });
    
        $totalAmount = $expenses->sum('amount');
    
        $pdf = Pdf::loadView('backend.expense.report_pdf', compact('groupedData', 'totalAmount'))
                  ->setPaper('a4', 'portrait');
    
        return $pdf->download('Expense_Report_'.date('Y-m-d').'.pdf');
    }


}