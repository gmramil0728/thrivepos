<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\Backend\SalaryController;
use App\Http\Controllers\Backend\AttendanceController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ExpenseController;
use App\Http\Controllers\Backend\PosController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\OrderReceiptController;
use App\Http\Controllers\Backend\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('index');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [AdminController::class, 'AdminDashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

//redirect to login page for invalid attempt
Route::get('/register', function () {
    return redirect('/login');
});



Route::get('/admin/logout', [AdminController::class, 'AdminDestroy'])->name('admin.logout');

Route::middleware(['auth'])->group(function(){

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/profile/changepassword', [AdminController::class, 'AdminChangePassword'])->name('admin.changepassword');
    Route::post('/admin/profile/changepassword/update', [AdminController::class, 'AdminChangePasswordUpdate'])->name('admin.profile.changepassword.update');

    // EMPLOYEE
    Route::controller(EmployeeController::class)->group(function(){
        Route::get('/employee/all', 'EmployeeAll')->name('all.employee')->middleware('permission:employee.all');
        Route::get('/employee/add', 'EmployeeAdd')->name('employee.add')->middleware('permission:employee.add');
        Route::post('/employee/store', 'EmployeeStore')->name('employee.store');
        Route::get('/employee/edit/{id}', 'EmployeeEdit')->name('employee.edit');
        Route::post('/employee/update', 'EmployeeUpdate')->name('employee.update');
        Route::get('/employee/delete/{id}', 'EmployeeDelete')->name('employee.delete');

        Route::get('/employee/print-masterlist', 'EmployeePrintMasterlist')->name('employee.print.masterlist');
    });

    // CUSTOMER
    Route::controller(CustomerController::class)->group(function(){
        Route::get('/customer/all', 'CustomerAll')->name('customer.all');
        Route::get('/customer/add', 'CustomerAdd')->name('customer.add');
        Route::post('/customer/store', 'CustomerStore')->name('customer.store');
        Route::get('/customer/edit/{id}', 'CustomerEdit')->name('customer.edit');
        Route::post('/customer/update', 'CustomerUpdate')->name('customer.update');
        Route::get('/customer/delete/{id}', 'CustomerDelete')->name('customer.delete');
    });

    // SUPPLIER
    Route::controller(SupplierController::class)->group(function(){
        Route::get('/supplier/all', 'SupplierAll')->name('supplier.all');
        Route::get('/supplier/add', 'SupplierAdd')->name('supplier.add');
        Route::post('/supplier/store', 'SupplierStore')->name('supplier.store');
        Route::get('/supplier/edit/{id}', 'SupplierEdit')->name('supplier.edit');
        Route::post('/supplier/update', 'SupplierUpdate')->name('supplier.update');
        Route::get('/supplier/delete/{id}', 'SupplierDelete')->name('supplier.delete');
        Route::get('/supplier/details/{id}','SupplierDetails')->name('supplier.details');
    });

    /// Salary
    Route::controller(SalaryController::class)->group(function(){

        Route::get('/add/advance/salary','AddAdvanceSalary')->name('add.advance.salary');
        Route::post('/advance/salary/store','AdvanceSalaryStore')->name('advance.salary.store');
        Route::get('/all/advance/salary','AllAdvanceSalary')->name('all.advance.salary');
     
        Route::get('/edit/advance/salary/{id}','EditAdvanceSalary')->name('edit.advance.salary');
        Route::post('/advance/salary/update','AdvanceSalaryUpdate')->name('advance.salary.update');
        Route::get('/delete/advance/salary/{id}','DeleteAdvanceSalary')->name('delete.advance.salary');

        Route::get('/view/payslip/{id}', 'ViewPayslip')->name('view.payslip');

        // Route for generating/viewing the professional PDF payslip
        Route::get('/salary/payslip/download/{id}', 'DownloadPayslip')->name('payslip.download');
        Route::get('/payroll/report/pdf', 'PayrollReportPdf')->name('payroll.report.pdf');
    
    });

    /// Pay Salary All Route 
    Route::controller(SalaryController::class)->group(function(){

        Route::get('/pay/salary','PaySalary')->name('pay.salary');
        Route::get('/pay/now/salary/{id}','PayNowSalary')->name('pay.now.salary');
        Route::post('/employe/salary/store','EmployeSalaryStore')->name('employe.salary.store');
        Route::get('/month/salary','MonthSalary')->name('month.salary');
    
    });

    ///Attendance All Route 
    Route::controller(AttendanceController::class)->group(function(){

        Route::get('/employee/attend/list','EmployeeAttendanceList')->name('employee.attend.list'); 
        Route::get('/add/employee/attend','AddEmployeeAttendance')->name('add.employee.attend'); 
        Route::post('/employee/attend/store','EmployeeAttendanceStore')->name('employee.attend.store'); 
        
        Route::get('/edit/employee/attend/{date}','EditEmployeeAttendance')->name('employee.attend.edit'); 
        Route::get('/view/employee/attend/{date}','ViewEmployeeAttendance')->name('employee.attend.view'); 

        Route::post('/employee/attendance/update', 'UpdateEmployeeAttendance')->name('employee.attend.update');
    
        // Monthly Attendance Route
        Route::get('/monthly/attendance', 'MonthlyAttendance')->name('monthly.attendance');

    });

    ///Category All Route 
    Route::controller(CategoryController::class)->group(function(){

        Route::get('/all/category','AllCategory')->name('all.category');
        Route::post('/store/category','StoreCategory')->name('category.store');  
        Route::get('/edit/category/{id}','EditCategory')->name('edit.category');
        Route::post('/update/category','UpdateCategory')->name('category.update'); 
        Route::get('/delete/category/{id}','DeleteCategory')->name('delete.category');
        
        
    });

    ///Product All Route 
    Route::controller(ProductController::class)->group(function(){

        Route::get('/all/product','AllProduct')->name('all.product');
        Route::get('/add/product','AddProduct')->name('add.product');
        Route::post('/store/product','StoreProduct')->name('product.store');
        Route::get('/edit/product/{id}','EditProduct')->name('edit.product');
        Route::post('/update/product','UpdateProduct')->name('product.update');
        Route::get('/delete/product/{id}','DeleteProduct')->name('delete.product');

        Route::get('/barcode/product/{id}','BarcodeProduct')->name('barcode.product');
        
        Route::get('/import/product','ImportProduct')->name('import.product');
        Route::get('/export','Export')->name('export');
        Route::post('/import','Import')->name('import');
    });

    ///Category All Route 
    Route::controller(ExpenseController::class)->group(function(){

        Route::get('/add/expense','AddExpense')->name('add.expense');
        Route::post('/store/expense','StoreExpense')->name('expense.store');
        Route::get('/today/expense','TodayExpense')->name('today.expense');
        Route::get('/edit/expense/{id}','EditExpense')->name('edit.expense');
        Route::post('/update/expense/{id}','UpdateExpense')->name('expense.update');
        Route::get('/month/expense','MonthExpense')->name('month.expense');
        Route::get('/year/expense','YearExpense')->name('year.expense');
        Route::get('/delete/expense/{id}','DeleteExpense')->name('delete.expense');

        Route::get('/expense/report/pdf', 'ExpenseReportPdf')->name('expense.report.pdf');
   
   });

   //REPORT
   Route::controller(ReportController::class)->group(function(){

        Route::get('/report/sales','SalesReport')->name('sales.report');
        

    });

   ///Expense All Route 
    Route::controller(PosController::class)->group(function(){

        // Route::get('/pos','Pos')->name('pos');
        // Route::post('/add-cart','AddCart');
        // Route::get('/allitem','AllItem');
        // Route::post('/cart-update/{rowId}','CartUpdate');
        // Route::get('/cart-remove/{rowId}','CartRemove');

        // Route::post('/create-invoice','CreateInvoice');

        // POS Routes
        Route::get('/pos', [PosController::class, 'Pos'])->name('pos');

        // Cart Management
        Route::post('/add-cart', [PosController::class, 'AddCart'])->name('add.cart');
        Route::post('/cart-update/{rowId}', [PosController::class, 'CartUpdate'])->name('cart.update');
        Route::get('/cart-remove/{rowId}', [PosController::class, 'CartRemove'])->name('cart.remove');
        Route::get('/cart-clear-all', [PosController::class, 'CartClearAll'])->name('cart.clear');

        // Payment Processing (NEW)
        Route::post('/process-payment', [PosController::class, 'ProcessPayment'])->name('process.payment');

        // Invoice & Receipt (UPDATED)
        Route::get('/view-invoice/{order_id}', [PosController::class, 'ViewInvoice'])->name('view.invoice');
        Route::get('/print-receipt/{order_id}', [PosController::class, 'PrintReceipt'])->name('print.receipt');

        // Legacy Invoice Route (keep for backward compatibility)
        Route::post('/create-invoice', [PosController::class, 'CreateInvoice'])->name('create.invoice');
        Route::get('/print-thermal-receipt', [PosController::class, 'PrintThermalReceipt'])->name('print.thermal.receipt');

        // Search & Barcode (Optional - for AJAX functionality)
        Route::post('/search-product', [PosController::class, 'SearchProduct'])->name('search.product');
        Route::post('/scan-barcode', [PosController::class, 'ScanBarcode'])->name('scan.barcode');

        // All Items (if needed for other views)
        Route::get('/all-item', [PosController::class, 'AllItem'])->name('all.item');


        
   });

   ///Order All Route 
    Route::controller(OrderController::class)->group(function(){

        Route::post('/final-invoice','FinalInvoice');
        Route::get('/pending/order','PendingOrder')->name('pending.order');
        Route::get('/order/details/{order_id}','OrderDetails')->name('order.details');
        Route::post('/order/status/update','OrderStatusUpdate')->name('order.status.update');
    
        Route::get('/complete/order','CompleteOrder')->name('complete.order');

        Route::get('/stock','StockManage')->name('stock.manage');
        Route::get('/order/invoice-download/{order_id}','OrderInvoice');

         //// Due All Route 

        Route::get('/pending/due','PendingDue')->name('pending.due');
        Route::get('/order/due/{id}','OrderDueAjax');
        Route::post('/update/due','UpdateDue')->name('update.due');
    
   });

   ///Permission All Route 
Route::controller(RoleController::class)->group(function(){

    Route::get('/all/permission','AllPermission')->name('all.permission');
    Route::get('/add/permission','AddPermission')->name('add.permission');
    Route::post('/store/permission','StorePermission')->name('permission.store');
    Route::get('/edit/permission/{id}','EditPermission')->name('edit.permission');
   
   Route::post('/update/permission','UpdatePermission')->name('permission.update');
      Route::get('/delete/permission/{id}','DeletePermission')->name('delete.permission');
   
   });
   
   
   ///Roles All Route 
   Route::controller(RoleController::class)->group(function(){
   
    Route::get('/all/roles','AllRoles')->name('all.roles');
    Route::get('/add/roles','AddRoles')->name('add.roles');
    Route::post('/store/roles','StoreRoles')->name('roles.store');
    Route::get('/edit/roles/{id}','EditRoles')->name('edit.roles');
   
   Route::post('/update/roles','UpdateRoles')->name('roles.update');
    Route::get('/delete/roles/{id}','DeleteRoles')->name('delete.roles');
   
   });
   
   ///Add Roles in Permission All Route 
   Route::controller(RoleController::class)->group(function(){
   
    Route::get('/add/roles/permission','AddRolesPermission')->name('add.roles.permission');
     Route::post('/role/permission/store','StoreRolesPermission')->name('role.permission.store');
   
      Route::get('/all/roles/permission','AllRolesPermission')->name('all.roles.permission');
   
     Route::get('/admin/edit/roles/{id}','AdminEditRoles')->name('admin.edit.roles');
   
       Route::post('/role/permission/update/{id}','RolePermissionUpdate')->name('role.permission.update');
   
     Route::get('/admin/delete/roles/{id}','AdminDeleteRoles')->name('admin.delete.roles');
    
   });

   ///Admin User All Route 
    Route::controller(AdminController::class)->group(function(){

        Route::get('/all/admin','AllAdmin')->name('all.admin');
        Route::get('/add/admin','AddAdmin')->name('add.admin');
        Route::post('/store/admin','StoreAdmin')->name('admin.store');
        Route::get('/edit/admin/{id}','EditAdmin')->name('edit.admin');
        Route::post('/update/admin','UpdateAdmin')->name('admin.update');
        Route::get('/delete/admin/{id}','DeleteAdmin')->name('delete.admin');

        // Database Backup 
        Route::get('/database/backup','DatabaseBackup')->name('database.backup');
        Route::get('/backup/now','BackupNow');
        Route::get('{getFilename}','DownloadDatabase');
        Route::get('/delete/database/{getFilename}','DeleteDatabase');


        Route::get('/company/setting','CompanySetting')->name('company.setting');
        Route::post('/company/update','CompanyUpdate')->name('company.update');
   
   
   });

   /*
    |--------------------------------------------------------------------------
    | Order Receipt Routes with Filtering & Bulk Operations
    |--------------------------------------------------------------------------
    |
    | Add these routes to your web.php file
    |
    */

    Route::middleware(['auth', 'admin'])->group(function () {
        
        // Main complete orders page with filtering support
        Route::get('/complete-orders', [OrderReceiptController::class, 'completeOrders'])
            ->name('orders.complete');
        
        // Print receipt (opens in new window)
        Route::get('/order/receipt-print/{id}', [OrderReceiptController::class, 'printReceipt'])
            ->name('order.receipt.print');
        
        // Download receipt as PDF
        Route::get('/order/receipt-download/{id}', [OrderReceiptController::class, 'downloadReceipt'])
            ->name('order.receipt.download');
        
        // Email receipt to customer
        Route::post('/order/email-receipt/{id}', [OrderReceiptController::class, 'emailReceipt'])
            ->name('order.receipt.email');
        
        // Reprint receipt (with logging)
        Route::get('/order/receipt-reprint/{id}', [OrderReceiptController::class, 'reprintReceipt'])
            ->name('order.receipt.reprint');
        
        // Bulk email receipts
        Route::post('/order/bulk-email-receipts', [OrderReceiptController::class, 'bulkEmailReceipts'])
            ->name('order.bulk.email');
        
        // Export filtered orders to Excel
        Route::get('/order/export-filtered', [OrderReceiptController::class, 'exportFiltered'])
            ->name('order.export.filtered');
        
        // Print filtered report
        Route::get('/order/print-filtered-report', [OrderReceiptController::class, 'printFilteredReport'])
            ->name('order.print.filtered');
        
        // Get orders statistics
        Route::get('/order/stats', [OrderReceiptController::class, 'getOrdersStats'])
            ->name('order.stats');
        
        // View order details
        // Route::get('/order/details/{id}', [OrderReceiptController::class, 'orderDetails'])
        //     ->name('order.details');
    });


    /*
    |--------------------------------------------------------------------------
    | API Routes for AJAX Filtering (Optional)
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth', 'admin'])->prefix('api')->group(function () {
        
        // Get filtered orders via AJAX
        Route::post('/orders/filter', [OrderReceiptController::class, 'filterOrders'])
            ->name('api.orders.filter');
        
        // Get order summary stats
        Route::post('/orders/summary', [OrderReceiptController::class, 'getOrdersSummary'])
            ->name('api.orders.summary');
    });

    


});



