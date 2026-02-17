@extends('admin_dashboard')
@section('admin')
<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Complete Orders</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Pending Orders</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

        <!-- Filter Section -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-3">
                            <i class="mdi mdi-filter-variant"></i> Filter Orders
                        </h4>
                        
                        <form id="filterForm">
                            <div class="row">
                                <!-- Date Range Filter -->
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
                                
                                <!-- Invoice Number Filter -->
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="invoice_no" class="form-label">Invoice Number</label>
                                        <input type="text" class="form-control" id="invoice_no" name="invoice_no" 
                                               placeholder="Enter invoice number">
                                    </div>
                                </div>
                                
                                <!-- Customer Name Filter -->
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" id="customer_name" name="customer_name" 
                                               placeholder="Enter customer name">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- Payment Status Filter -->
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="payment_status" class="form-label">Payment Status</label>
                                        <select class="form-select" id="payment_status" name="payment_status">
                                            <option value="">All Status</option>
                                            <option value="paid">Paid</option>
                                            <option value="pending">Pending</option>
                                            <option value="failed">Failed</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Amount Range -->
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
                                
                                <!-- Action Buttons -->
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
                        
                        <!-- Filter Summary -->
                        <div id="filterSummary" class="alert alert-info" style="display: none;">
                            <i class="mdi mdi-information"></i> 
                            <span id="filterSummaryText"></span>
                            <button type="button" class="btn-close float-end" onclick="$('#filterSummary').hide()"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Filter Section -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Action Buttons for Filtered Results -->
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="header-title mb-0">Order List</h4>
                                <small class="text-muted">
                                    Total: <span id="totalOrders">{{ count($orders) }}</span> orders | 
                                    Filtered: <span id="filteredOrders">{{ count($orders) }}</span> orders
                                </small>
                            </div>
                            {{-- <div>
                                <button type="button" id="printFiltered" class="btn btn-success">
                                    <i class="mdi mdi-printer"></i> Print Filtered Results
                                </button>
                                <button type="button" id="exportFiltered" class="btn btn-info">
                                    <i class="mdi mdi-file-excel"></i> Export to Excel
                                </button>
                                <button type="button" id="bulkEmailReceipts" class="btn btn-warning">
                                    <i class="mdi mdi-email-multiple"></i> Email All Receipts
                                </button>
                            </div> --}}
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
                                    <th>Total</th>
                                    <th>Amount Paid</th>
                                    <th>Amount Due</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($orders as $key=> $item)
                                <tr data-order-id="{{ $item->id }}" 
                                    data-customer-name="{{ strtolower(optional($item->customer)->name ?? 'Unknown') }}"
                                    data-invoice="{{ $item->invoice_no }}"
                                    data-order-date="{{ $item->order_date }}"
                                    data-payment-status="{{ $item->payment_status }}"
                                    data-amount="{{ $item->pay }}">
                                    <td>
                                        <input type="checkbox" class="order-checkbox" value="{{ $item->id }}">
                                    </td>
                                    <td>{{ $key+1 }}</td>
                                    <td> 
                                        <img src="{{ isset($customer->image) ? asset($customer->image) : asset('upload/no_image.jpg') }}" 
                                             style="width:50px; height: 40px; border-radius: 4px;" 
                                             alt="{{ $item->customer->name ?? 'Unknown'}}"> 
                                    </td>
                                    <td>{{ $item['customer']['name'] ?? 'Unknown' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->order_date)->format('M d, Y') }}</td>
                                    <td>
                                        @if($item->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @else
                                            <span class="badge bg-warning">{{ ucfirst($item->payment_status) }}</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $item->invoice_no }}</strong></td>
                                    <td class="text-end">{{ number_format($item->total, 2) }}</td>
                                    <td class="text-end">{{ number_format($item->pay, 2) }}</td>
                                    <td class="text-end">{{ number_format($item->due, 2) }}</td>
                                    <td> 
                                        <span class="badge bg-success">{{ ucfirst($item->order_status) }}</span> 
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('order.details',$item->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="View details">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            
                                            {{-- <a href="{{ url('order/receipt-print/'.$item->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               target="_blank"
                                               title="Print Receipt">
                                                <i class="mdi mdi-printer"></i>
                                            </a> --}}
                                            
                                            {{-- <a href="{{ url('order/details/'.$item->id) }}" 
                                               class="btn btn-sm btn-secondary" 
                                               title="View Details">
                                                <i class="mdi mdi-eye"></i>
                                            </a> --}}
                                            
                                            {{-- <button type="button" 
                                                    class="btn btn-sm btn-success" 
                                                    onclick="emailReceipt({{ $item->id }})"
                                                    title="Email Receipt">
                                                <i class="mdi mdi-email"></i>
                                            </button> --}}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row-->
        
    </div> <!-- container -->
</div> <!-- content -->



@endsection

@section('jscripts')

<script>
    $(document).ready(function() {
    
        // Initialize DataTable
        let table = $('#ordersTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            // order: [[4, 'desc']],            
            searching:false,    
            pageLength: 10,
            columnDefs: [
                // { orderable: false, targets: [0, 2, 9] }
                { orderable: false, targets: [2, 9] },
                { visible: false, targets: 0 }
            ],
            drawCallback: function () {
                updateOrderCounts(this.api()); // ✅ safe reference
            }
        });
    
        // Update order counts
        function updateOrderCounts(api) {
            let total = api.rows().count();
            let filtered = api.rows({ search: 'applied' }).count();
            $('#totalOrders').text(total);
            $('#filteredOrders').text(filtered);
        }
    
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
            table.search('').columns().search('').draw();
            $('#filterSummary').hide();
            updateOrderCounts(table);
        });
    
        // Filtering Logic
        function applyFilters() {
            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();
            let invoiceNo = $('#invoice_no').val().toLowerCase();
            let customerName = $('#customer_name').val().toLowerCase();
            let paymentStatus = $('#payment_status').val();
            let minAmount = parseFloat($('#min_amount').val()) || 0;
            let maxAmount = parseFloat($('#max_amount').val()) || Infinity;
    
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                let row = table.row(dataIndex).node();
                let orderDate = $(row).data('order-date');
                let invoice = $(row).data('invoice');
                let customer = $(row).data('customer-name');
                let payment = $(row).data('payment-status');
                let amount = parseFloat($(row).data('amount'));
    
                // if (startDate && orderDate < startDate) return false;
                // if (endDate && orderDate > endDate) return false;

                if (orderDate) {
                    let rowDate = new Date(orderDate);
                    let start = startDate ? new Date(startDate) : null;
                    let end = endDate ? new Date(endDate) : null;

                    // Remove time for fair comparison
                    if (start) start.setHours(0,0,0,0);
                    if (end) end.setHours(23,59,59,999);

                    if (start && rowDate < start) return false;
                    if (end && rowDate > end) return false;
                }


                if (invoiceNo && !invoice.toLowerCase().includes(invoiceNo)) return false;
                if (customerName && !customer.includes(customerName)) return false;
                if (paymentStatus && payment !== paymentStatus) return false;
                if (amount < minAmount || amount > maxAmount) return false;
    
                return true;
            });
    
            table.draw();
            $.fn.dataTable.ext.search.pop();
    
            showFilterSummary();
            updateOrderCounts(table);
        }
    
        // Show Filter Summary
        function showFilterSummary() {
            let filters = [];
            if ($('#start_date').val()) filters.push(`From: ${$('#start_date').val()}`);
            if ($('#end_date').val()) filters.push(`To: ${$('#end_date').val()}`);
            if ($('#invoice_no').val()) filters.push(`Invoice: ${$('#invoice_no').val()}`);
            if ($('#customer_name').val()) filters.push(`Customer: ${$('#customer_name').val()}`);
            if ($('#payment_status').val()) filters.push(`Payment: ${$('#payment_status').val()}`);
            if ($('#min_amount').val()) filters.push(`Min: $${$('#min_amount').val()}`);
            if ($('#max_amount').val()) filters.push(`Max: $${$('#max_amount').val()}`);
    
            if (filters.length > 0) {
                $('#filterSummaryText').text('Active filters: ' + filters.join(' | '));
                $('#filterSummary').show();
            }
        }
    
        // Export Filtered
        // $('#exportFiltered').on('click', function() {
        //     table.button('.buttons-excel').trigger();
        // });
    
        // Bulk Email
        // $('#bulkEmailReceipts').on('click', function() {
        //     let selectedOrders = [];
        //     $('.order-checkbox:checked').each(function() {
        //         selectedOrders.push($(this).val());
        //     });
    
        //     if (selectedOrders.length === 0) {
        //         Swal.fire('No Orders Selected', 'Please select at least one order.', 'warning');
        //         return;
        //     }
    
        //     Swal.fire({
        //         title: 'Email Receipts',
        //         text: `Send receipts for ${selectedOrders.length} selected orders?`,
        //         icon: 'question',
        //         showCancelButton: true
        //     }).then((result) => {
        //         if (result.isConfirmed) bulkEmailReceipts(selectedOrders);
        //     });
        // });
    
        // function bulkEmailReceipts(orderIds) {
        //     Swal.fire({ title: 'Sending...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
    
        //     $.post('/order/bulk-email-receipts', {
        //         _token: '{{ csrf_token() }}',
        //         order_ids: orderIds
        //     }, function(response) {
        //         Swal.fire('Success', `Sent ${response.sent} receipts.`, 'success');
        //     }).fail(function() {
        //         Swal.fire('Error', 'Failed to send receipts.', 'error');
        //     });
        // }
    
    });
    
    // Email single receipt
    // function emailReceipt(orderId) {
    //     Swal.fire({
    //         title: 'Email Receipt?',
    //         icon: 'question',
    //         showCancelButton: true
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             $.post('/order/email-receipt/' + orderId, {
    //                 _token: '{{ csrf_token() }}'
    //             }, function() {
    //                 Swal.fire('Sent!', 'Receipt emailed successfully.', 'success');
    //             }).fail(function() {
    //                 Swal.fire('Error!', 'Email failed.', 'error');
    //             });
    //         }
    //     });
    // }
    </script>
    
@endsection