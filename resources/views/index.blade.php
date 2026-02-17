@extends('admin_dashboard')
@section('admin')

@php
    $date = date('Y-m-d');
    
    // --- 1. FINANCIAL METRICS ---
    // Converting varchars to floats for accurate math
    $total_paid = (float)App\Models\Order::sum('pay');
    $total_due = (float)App\Models\Order::sum('due'); 
    $total_expenses = (float)App\Models\Expense::sum('amount');
    $total_salaries = (float)App\Models\PaySalary::where('status', 'paid')->sum('paid_amount');
    
    // Profit Calculation
    $net_profit = $total_paid - ($total_expenses + $total_salaries);
    $today_paid = (float)App\Models\Order::whereDate('order_date', $date)->sum('pay');

    // --- 2. ORDER COUNTS ---
    $today_complete = App\Models\Order::where('order_status', 'complete')->whereDate('order_date', $date)->count();
    $today_pending = App\Models\Order::where('order_status', 'pending')->whereDate('order_date', $date)->count();

    // --- 3. CHART LOGIC (Last 7 Days) ---
    $chartLabels = [];
    $chartData = [];
    for ($i = 6; $i >= 0; $i--) {
        $day = date('Y-m-d', strtotime("-$i days"));
        $chartLabels[] = date('D', strtotime($day));
        $chartData[] = (float)App\Models\Order::whereDate('order_date', $day)->sum('pay');
    }

    // --- 4. TOP SELLING PRODUCTS ---
    // Joining OrderDetails with Orders to get quantity per product
    $topProducts = DB::table('orderdetails')
        ->select('product_id', DB::raw('SUM(CAST(quantity AS UNSIGNED)) as total_qty'), DB::raw('SUM(CAST(total AS DECIMAL(10,2))) as total_revenue'))
        ->groupBy('product_id')
        ->orderBy('total_qty', 'desc')
        ->take(5)
        ->get();
@endphp

<style>
    .content-page { background-color: #f4f7fa; }
    .page-title { font-weight: 700; color: #334155; }
    .widget-flat { border-radius: 12px; transition: all 0.3s ease; border: none; }
    .widget-flat:hover { transform: translateY(-4px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
    .icon-shape { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
    .bg-soft-primary { background: rgba(74, 129, 212, 0.1); color: #4a81d4; }
    .bg-soft-success { background: rgba(26, 188, 156, 0.1); color: #1abc9c; }
    .bg-soft-danger { background: rgba(241, 85, 108, 0.1); color: #f1556c; }
    .bg-soft-warning { background: rgba(247, 184, 75, 0.1); color: #f7b84b; }
    .card-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; }
</style>

<div class="content">
    <div class="container-fluid">
        
        <div class="row align-items-center mb-4 mt-3">
            <div class="col-sm-6">
                <h4 class="page-title mb-0">Operational Overview</h4>
                <p class="text-muted small mb-0">Real-time performance for {{ date('M d, Y') }}</p>
            </div>
            <div class="col-sm-6 text-sm-end">
                <a href="{{ route('sales.report') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                    <i class="mdi mdi-chart-areaspline me-1"></i> Full Sales Report
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card widget-flat border-start border-primary border-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="card-label mb-1">Total Revenue</p>
                                <h3 class="my-2 fw-bold">₱{{ number_format($total_paid, 2) }}</h3>
                            </div>
                            <div class="icon-shape bg-soft-primary"><i class="fe-dollar-sign font-22"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card widget-flat border-start border-danger border-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="card-label mb-1">Expenses + Salary</p>
                                <h3 class="my-2 fw-bold text-danger">₱{{ number_format($total_expenses + $total_salaries, 2) }}</h3>
                            </div>
                            <div class="icon-shape bg-soft-danger"><i class="fe-trending-down font-22"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card widget-flat border-start border-success border-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="card-label mb-1">Net Profit</p>
                                <h3 class="my-2 fw-bold text-success">₱{{ number_format($net_profit, 2) }}</h3>
                            </div>
                            <div class="icon-shape bg-soft-success"><i class="fe-pie-chart font-22"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card widget-flat border-start border-warning border-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="card-label mb-1">Outstanding Due</p>
                                <h3 class="my-2 fw-bold text-warning">₱{{ number_format($total_due, 2) }}</h3>
                            </div>
                            <div class="icon-shape bg-soft-warning"><i class="fe-alert-circle font-22"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Weekly Revenue Analytics</h4>
                        <div id="sales-analytics" style="height: 350px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Today's Cash Flow</h4>
                        <div class="text-center">
                            <h2 class="fw-bold mb-1">₱{{ number_format($today_paid, 2) }}</h2>
                            <p class="text-muted small">Earnings collected today</p>
                        </div>
                        <hr>
                        <div class="mt-2">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="mdi mdi-circle text-success me-1"></i> Paid Orders</span>
                                <span class="fw-bold text-success">{{ $today_complete }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="mdi mdi-circle text-warning me-1"></i> Pending Orders</span>
                                <span class="fw-bold text-warning">{{ $today_pending }}</span>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <a href="{{ route('pending.order') }}" class="btn btn-soft-primary btn-sm">Process Pending Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body">
                        <h4 class="header-title mb-3">Top 5 Selling Products</h4>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product Name</th>
                                        <th class="text-center">Total Quantity Sold</th>
                                        <th class="text-end">Total Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topProducts as $item)
                                    @php $product = App\Models\Product::find($item->product_id); @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($product->product_image) }}" class="me-2 rounded" height="30">
                                                <span>{{ $product->product_name ?? 'Unknown' }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center fw-bold">{{ $item->total_qty }}</td>
                                        <td class="text-end text-success fw-bold">₱{{ number_format($item->total_revenue, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('jscripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            series: [{
                name: 'Daily Sales',
                data: {!! json_encode($chartData) !!}
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            colors: ['#4a81d4'],
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.1 }
            },
            xaxis: {
                categories: {!! json_encode($chartLabels) !!},
            },
            yaxis: {
                labels: {
                    formatter: function (val) { return "₱" + val.toLocaleString(); }
                }
            },
            tooltip: {
                y: { formatter: function (val) { return "₱" + val.toLocaleString(); } }
            }
        };

        var chart = new ApexCharts(document.querySelector("#sales-analytics"), options);
        chart.render().then(() => {
            window.dispatchEvent(new Event('resize'));
        });
    });
</script>
@endsection