<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Expense;
use App\Models\PaySalary;

class ReportController extends Controller
{
    //
    public function SalesReport(Request $request) {
        // Default to current month if no dates are selected
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-t');
    
        // 1. Total Sales (from orders)
        // We use cast because 'total' is a varchar in your DB
        $totalSales = Order::whereBetween('order_date', [$start_date, $end_date])
                            ->where('order_status', 'complete')
                            ->get()
                            ->sum(function($order) {
                                return (float)$order->total;
                            });
    
        // 2. Total Expenses
        $totalExpenses = Expense::whereBetween('date', [$start_date, $end_date])
                                ->sum('amount');
    
        // 3. Total Payroll (from pay_salaries)
        $totalSalary = PaySalary::whereBetween('payment_date', [$start_date, $end_date])
                                ->where('status', 'paid')
                                ->sum('paid_amount');
    
        // 4. Net Profit Calculation
        $netProfit = $totalSales - ($totalExpenses + $totalSalary);
    
        // 5. Get recent orders for the table breakdown
        $orders = Order::whereBetween('order_date', [$start_date, $end_date])
                       ->orderBy('order_date', 'desc')
                       ->get();
    
        return view('backend.report.sales_report', compact(
            'totalSales', 'totalExpenses', 'totalSalary', 'netProfit', 
            'orders', 'start_date', 'end_date'
        ));
    }
}
