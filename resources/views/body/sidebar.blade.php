<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">
            <ul id="side-menu">

                <!-- DASHBOARD -->
                <li class="menu-title">Point of Sale System</li>
                <li>
                    <a href="{{ url('/dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <!-- POS -->
                @if(Auth::user()->can('pos.menu'))
                <li>
                    <a href="{{ route('pos') }}">
                        <span class="badge bg-danger float-end">Hot</span>
                        <i class="mdi mdi-cash-register"></i>
                        <span> POS </span>
                    </a>
                </li>
                @endif


                <!-- MODULES -->
                <li class="menu-title mt-2">Management</li>

                @if(Auth::user()->can('employee.menu'))
                <li>
                    <a href="{{ route('all.employee') }}">
                        <i class="mdi mdi-account-tie-outline"></i>
                        <span> Employees </span>
                    </a>

                    {{-- <a href="#employee" data-bs-toggle="collapse">
                        <i class="mdi mdi-account-tie-outline"></i>
                        <span> Employees </span>
                        <span class="menu-arrow"></span>
                    </a> --}}
                    {{-- <div class="collapse" id="employee">
                        <ul class="nav-second-level">
                            @if(Auth::user()->can('employee.all'))
                            <li><a href="{{ route('employee.all') }}">All Employees</a></li>
                            @endif
                            @if(Auth::user()->can('employee.add'))
                            <li><a href="{{ route('employee.add') }}">Add Employee</a></li>
                            @endif
                        </ul>
                    </div> --}}
                </li>
                @endif

                @if(Auth::user()->can('customer.menu'))
                    
                <li>
                    <a href="{{ route('customer.all') }}">
                        <i class="mdi mdi-account-group-outline"></i>
                        <span> Customers </span>
                    </a>
                    {{-- <a href="#customers" data-bs-toggle="collapse">
                        <i class="mdi mdi-account-group-outline"></i>
                        <span> Customers </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="customers">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('customer.all') }}">All Customers</a></li>
                            <li><a href="{{ route('customer.add') }}">Add Customer</a></li>
                        </ul>
                    </div> --}}
                </li>
                @endif

                @if(Auth::user()->can('supplier.menu'))
                <li>
                    <a href="{{ route('supplier.all') }}">
                        <i class="mdi mdi-truck-delivery-outline"></i>
                        <span> Suppliers </span>
                    </a>
                    {{-- <a href="#suppliers" data-bs-toggle="collapse">
                        <i class="mdi mdi-truck-delivery-outline"></i>
                        <span> Suppliers </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="suppliers">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('supplier.all') }}">All Suppliers</a></li>
                            <li><a href="{{ route('supplier.add') }}">Add Supplier</a></li>
                        </ul>
                    </div> --}}
                </li>
                @endif

                @if(Auth::user()->can('category.menu'))
                <li>
                    <a href="{{ route('all.category') }}">
                        <i class="mdi mdi-shape-outline"></i>
                        <span> Categories </span>
                    </a>

                    {{-- <a href="#categories" data-bs-toggle="collapse">
                        <i class="mdi mdi-shape-outline"></i>
                        <span> Categories </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="categories">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('all.category') }}">All Categories</a></li>
                        </ul>
                    </div> --}}
                </li>
                @endif

                @if(Auth::user()->can('product.menu'))
                <li>
                    <a href="{{ route('all.product') }}">
                        <i class="mdi mdi-package-variant-closed"></i>
                        <span> Products </span>
                    </a>

                    {{-- <a href="#products" data-bs-toggle="collapse">
                        <i class="mdi mdi-package-variant-closed"></i>
                        <span> Products </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="products">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('all.product') }}">All Products</a></li>
                            <li><a href="{{ route('add.product') }}">Add Product</a></li>
                            <li><a href="{{ route('import.product') }}">Import Product</a></li>
                        </ul>
                    </div> --}}
                </li>
                @endif

                


                <!-- OPERATIONS -->
                <li class="menu-title mt-2">Operations</li>

                @if(Auth::user()->can('orders.menu'))
                <li>
                    <a href="#orders" data-bs-toggle="collapse">
                        <i class="mdi mdi-text-box-search-outline"></i>
                        <span> Orders </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="orders">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('pending.order') }}">Pending Orders</a></li>
                            <li><a href="{{ route('complete.order') }}">Completed Orders</a></li>
                            {{-- <li><a href="{{ route('pending.due') }}">Pending Due</a></li> --}}
                        </ul>
                    </div>
                </li>
                @endif

                

                @if(Auth::user()->can('stock.menu'))
                <li>
                    <a href="{{ route('stock.manage') }}">
                        <i class="mdi mdi-warehouse"></i>
                        <span> Stock Inventory </span>
                    </a>
                    {{-- <a href="#stock" data-bs-toggle="collapse">
                        <i class="mdi mdi-warehouse"></i>
                        <span> Stock </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="stock">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('stock.manage') }}">Manage Stock</a></li>
                        </ul>
                    </div> --}}
                </li>
                @endif


                <!-- HR & FINANCE -->
                <li class="menu-title mt-2">HR & Finance</li>

                @if(Auth::user()->can('salary.menu'))
                <li>
                    <a href="#salary" data-bs-toggle="collapse">
                        <i class="mdi mdi-cash-multiple"></i>
                        <span> Salary </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="salary">
                        <ul class="nav-second-level">
                            {{-- <li><a href="{{ route('add.advance.salary') }}">Advance Salary</a></li> --}}
                            <li><a href="{{ route('all.advance.salary') }}">Salary Advance</a></li>
                            <li><a href="{{ route('pay.salary') }}">Pay Salary</a></li>
                            <li><a href="{{ route('month.salary') }}">Pay History</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                {{-- @if(Auth::user()->can('attendence.menu')) --}}
                <li>
                    <a href="#attendance" data-bs-toggle="collapse">
                        <i class="mdi mdi-calendar-check-outline"></i>
                        <span> Attendance </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="attendance">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('employee.attend.list') }}">Attendance List</a></li>
                            <li><a href="{{ route('monthly.attendance') }}">Attendance Report</a></li>
                        </ul>
                    </div>
                </li>
                {{-- @endif --}}

                @if(Auth::user()->can('expense.menu'))
                <li>
                    <a href="{{ route('year.expense') }}">
                        <i class="mdi mdi-cash-minus"></i>
                        <span> Expenses </span>
                    </a>
                    {{-- <a href="#expenses" data-bs-toggle="collapse">
                        <i class="mdi mdi-cash-minus"></i>
                        <span> Expenses </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="expenses">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('add.expense') }}">Add Expense</a></li>
                            <li><a href="{{ route('today.expense') }}">Today</a></li>
                            <li><a href="{{ route('month.expense') }}">Monthly</a></li>
                            <li><a href="{{ route('year.expense') }}">Yearly</a></li>
                        </ul>
                    </div> --}}
                </li>
                @endif

                <li class="menu-title mt-2">REPORTS</li>

                <li>
                    <a href="{{ route('sales.report') }}">
                        <i class="mdi mdi-finance"></i>
                        <span> Sales Report</span>                        
                    </a>                    
                </li>


                <!-- SYSTEM -->
                <li class="menu-title mt-2">System</li>

                <li>
                    <a href="{{ route('company.setting') }}">
                        <i class="mdi mdi-office-building"></i>
                        <span> Company  Settings </span>                        
                    </a>                    
                </li>


                @if(Auth::user()->can('roles.menu'))
                <li>
                    <a href="#roles" data-bs-toggle="collapse">
                        <i class="mdi mdi-shield-account-outline"></i>
                        <span> Roles & Permissions </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="roles">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('all.permission') }}">Permissions</a></li>
                            <li><a href="{{ route('all.roles') }}">Roles</a></li>
                            {{-- <li><a href="{{ route('add.roles.permission') }}">Assign Roles</a></li> --}}
                            <li><a href="{{ route('all.roles.permission') }}">Role Matrix</a></li>
                        </ul>
                    </div>
                </li>
                @endif

                

                @if(Auth::user()->can('admin.menu'))
                
                <li>
                    <a href="{{ route('all.admin') }}">
                        <i class="mdi mdi-cog-outline"></i>
                        <span> Admin Users</span>                        
                    </a>                    
                </li>

                {{-- <li>
                    <a href="#admins" data-bs-toggle="collapse">
                        <i class="mdi mdi-cog-outline"></i>
                        <span> Admin Settings </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="admins">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('all.admin') }}">All Admins</a></li>
                            <li><a href="{{ route('add.admin') }}">Add Admin</a></li>
                        </ul>
                    </div>
                </li> --}}
                @endif

                <li>
                    <a href="#backup" data-bs-toggle="collapse">
                        <i class="mdi mdi-database-arrow-down-outline"></i>
                        <span> Database Backup </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="backup">
                        <ul class="nav-second-level">
                            <li><a href="{{ route('database.backup') }}">Run Backup</a></li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
