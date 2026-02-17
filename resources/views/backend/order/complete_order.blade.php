@extends('admin_dashboard')
@section('admin')
<div class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Complete Orders</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Complete Orders</h4>
                </div>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">
                            <i class="mdi mdi-filter-variant"></i> Filter Orders
                        </h4>
                        
                        <form id="filterForm">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="invoice_no" class="form-label">Invoice Number</label>
                                        <input type="text" class="form-control" id="invoice_no" name="invoice_no" 
                                               placeholder="Enter invoice number">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                               placeholder="Enter customer name">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="payment_status" class="form-label">Payment Status</label>
                                        <select class="form-select" id="payment_status" name="payment_status">
                                            <option value="">All Status</option>
                                            <option value="paid">Paid</option>
                                            <option value="partial">Partial</option>
                                            <option value="due">Due</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="min_amount" class="form-label">Min Amount</label>
                                        <input type="number" class="form-control" id="min_amount" name="min_amount" 
                                               placeholder="0.00" step="0.01">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="max_amount" class="form-label">Max Amount</label>
                                        <input type="number" class="form-control" id="max_amount" name="max_amount" 
                                               placeholder="0.00" step="0.01">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label d-block">&nbsp;</label>
                                        <button type="button" id="applyFilter" class="btn btn-primary me-1">
                                            <i class="mdi mdi-filter"></i> Apply Filter
                                        </button>
                                        <button type="button" id="resetFilter" class="btn btn-secondary">
                                            <i class="mdi mdi-refresh"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        <div id="filterSummary" class="alert alert-info" style="display: none;">
                            <i class="mdi mdi-information"></i> 
                            <span id="filterSummaryText"></span>
                            <button type="button" class="btn-close float-end" onclick="$('#filterSummary').hide()"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="header-title mb-0">Order List</h4>
                                <small class="text-muted">
                                    Total: <span id="totalOrders">{{ count($orders) }}</span> orders | 
                                    Filtered: <span id="filteredOrders">{{ count($orders) }}</span> orders
                                </small>
                            </div>
                        </div>
                        
                        <table id="ordersTable" class="table table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAll" title="Select All">
                                    </th>
                                    <th>Sl</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Order Date</th>
                                    <th>Payment</th>
                                    <th>Invoice</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($orders as $key => $item)
                                <tr data-order-id="{{ $item->id }}" 
                                    data-customer-name="{{ strtolower(optional($item->customer)->name ?? 'unknown') }}"
                                    data-invoice="{{ strtolower($item->invoice_no ?? '') }}"
                                    data-order-date="{{ $item->order_date }}"
                                    data-payment-status="{{ $item->payment_status }}"
                                    data-amount="{{ $item->total }}">
                                    <td>
                                        <input type="checkbox" class="order-checkbox" value="{{ $item->id }}">
                                    </td>
                                    <td>{{ $key + 1 }}</td>
                                    <td> 
                                        <img src="{{ optional($item->customer)->image ? asset($item->customer->image) : asset('upload/no_image.jpg') }}" 
                                             style="width:50px; height: 40px; border-radius: 4px;" 
                                             alt="{{ optional($item->customer)->name ?? 'Unknown' }}"> 
                                    </td>
                                    <td>{{ optional($item->customer)->name ?? 'Unknown' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->order_date)->format('M d, Y') }}</td>
                                    <td>
                                        @if($item->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($item->payment_status == 'partial')
                                            <span class="badge bg-warning">Partial</span>
                                        @else
                                            <span class="badge bg-danger">{{ ucfirst($item->payment_status) }}</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $item->invoice_no }}</strong></td>
                                    <td class="text-end">₱{{ number_format($item->total, 2) }}</td>
                                    <td> 
                                        <span class="badge bg-success">{{ ucfirst($item->order_status) }}</span> 
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ url('order/invoice-download/'.$item->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="Download Invoice">
                                                <i class="mdi mdi-download"></i>
                                            </a>
                                            
                                            <a href="{{ url('/print-receipt/'.$item->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               target="_blank"
                                               title="Print Receipt">
                                                <i class="mdi mdi-printer"></i>
                                            </a>

                                            <a href="{{ route('order.details', $item->id) }}" 
                                               class="btn btn-sm btn-success" 
                                               title="View details">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
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

@endsection

@section('jscripts')
<script>
$(document).ready(function() {

    // Update order counts
    function updateOrderCounts(api) {
        var total = api.rows().count();
        var filtered = api.rows({ search: 'applied' }).count();
        $('#totalOrders').text(total);
        $('#filteredOrders').text(filtered);
    }

    // Initialize DataTable
    var table = $('#ordersTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
        // searching:false,  this should be true, else the apply filter will not function
        pageLength: 10,
        columnDefs: [
            { orderable: false, targets: [0, 2, 9] },
            { visible: false, targets: 0 }
        ],
        drawCallback: function() {
            updateOrderCounts(this.api());
        }
    });

    // Hide the default search box since you have custom filters
    $('.dataTables_filter').hide();

    // Select All
    $('#selectAll').on('change', function() {
        $('.order-checkbox:visible').prop('checked', this.checked);
    });

    // Apply Filter
    $('#applyFilter').on('click', function() {
        applyFilters();
    });

    // Reset Filter
    $('#resetFilter').on('click', function() {
        $('#filterForm')[0].reset();
        
        // Clear all custom search filters
        $.fn.dataTable.ext.search = [];
        table.draw();
        
        $('#filterSummary').hide();
        updateOrderCounts(table);
    });

    // Filtering Logic
    function applyFilters() {
        var startDate = $('#start_date').val();
        var endDate = $('#end_date').val();
        var invoiceNo = $('#invoice_no').val().toLowerCase().trim();
        var customerName = $('#customer_name').val().toLowerCase().trim();
        var paymentStatus = $('#payment_status').val();
        var minAmount = parseFloat($('#min_amount').val()) || 0;
        var maxAmount = parseFloat($('#max_amount').val()) || Infinity;

        console.log('Filter params:', { startDate, endDate, invoiceNo, customerName, paymentStatus, minAmount, maxAmount });

        // Clear previous filters
        $.fn.dataTable.ext.search = [];

        // Add new filter
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var row = table.row(dataIndex).node();
            
            // Get data attributes - use attr() not data()
            var orderDate = $(row).attr('data-order-date') || '';
            var invoice = ($(row).attr('data-invoice') || '').toLowerCase();
            var customer = ($(row).attr('data-customer-name') || '').toLowerCase();
            var payment = ($(row).attr('data-payment-status') || '').toLowerCase();
            var amount = parseFloat($(row).attr('data-amount')) || 0;

            // Debug first row
            if (dataIndex === 0) {
                console.log('First row data:', { orderDate, invoice, customer, payment, amount });
            }

            // Date filtering
            if (startDate || endDate) {
                if (!orderDate) return false;
                
                var rowDate = new Date(orderDate);
                if (isNaN(rowDate.getTime())) return false;
                
                rowDate.setHours(0, 0, 0, 0);

                if (startDate) {
                    var start = new Date(startDate);
                    start.setHours(0, 0, 0, 0);
                    if (rowDate < start) return false;
                }

                if (endDate) {
                    var end = new Date(endDate);
                    end.setHours(23, 59, 59, 999);
                    if (rowDate > end) return false;
                }
            }

            // Invoice filtering
            if (invoiceNo && invoice.indexOf(invoiceNo) === -1) {
                return false;
            }

            // Customer name filtering
            if (customerName && customer.indexOf(customerName) === -1) {
                return false;
            }

            // Payment status filtering
            if (paymentStatus && payment !== paymentStatus.toLowerCase()) {
                return false;
            }

            // Amount filtering
            if (amount < minAmount || amount > maxAmount) {
                return false;
            }

            return true;
        });

        table.draw();
        showFilterSummary();
        updateOrderCounts(table);
        
        console.log('Filter applied, visible rows:', table.rows({ search: 'applied' }).count());
    }

    // Show Filter Summary
    function showFilterSummary() {
        var filters = [];
        if ($('#start_date').val()) filters.push('From: ' + $('#start_date').val());
        if ($('#end_date').val()) filters.push('To: ' + $('#end_date').val());
        if ($('#invoice_no').val()) filters.push('Invoice: ' + $('#invoice_no').val());
        if ($('#customer_name').val()) filters.push('Customer: ' + $('#customer_name').val());
        if ($('#payment_status').val()) filters.push('Payment: ' + $('#payment_status').val());
        if ($('#min_amount').val()) filters.push('Min: ₱' + $('#min_amount').val());
        if ($('#max_amount').val()) filters.push('Max: ₱' + $('#max_amount').val());

        if (filters.length > 0) {
            $('#filterSummaryText').text('Active filters: ' + filters.join(' | '));
            $('#filterSummary').show();
        } else {
            $('#filterSummary').hide();
        }
    }

});
</script>
@endsection