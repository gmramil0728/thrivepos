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
                    <h4 class="page-title">Complete Orders</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
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
                                @foreach($orders as $key=> $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td> 
                                        <img src="{{ isset($customer->image) ? asset($customer->image) : asset('upload/no_image.jpg') }}" 
                                             style="width:50px; height: 40px; border-radius: 4px;" 
                                             alt="{{ $customer->name ?? 'Unknown' }} "> 
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
                                    <td>${{ number_format($item->pay, 2) }}</td>
                                    <td> 
                                        <span class="badge bg-success">{{ ucfirst($item->order_status) }}</span> 
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Download Invoice PDF -->
                                            <a href="{{ url('order/invoice-download/'.$item->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="Download Invoice">
                                                <i class="mdi mdi-download"></i> PDF
                                            </a>
                                            
                                            <!-- Print Receipt -->
                                            <a href="{{ url('order/receipt-print/'.$item->id) }}" 
                                               class="btn btn-sm btn-info" 
                                               target="_blank"
                                               title="Print Receipt">
                                                <i class="mdi mdi-printer"></i> Print
                                            </a>
                                            
                                            <!-- View Order Details -->
                                            <a href="{{ url('order/details/'.$item->id) }}" 
                                               class="btn btn-sm btn-secondary" 
                                               title="View Details">
                                                <i class="mdi mdi-eye"></i> View
                                            </a>
                                            
                                            <!-- Email Receipt -->
                                            <button type="button" 
                                                    class="btn btn-sm btn-success" 
                                                    onclick="emailReceipt({{ $item->id }})"
                                                    title="Email Receipt">
                                                <i class="mdi mdi-email"></i> Email
                                            </button>
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

@push('scripts')
<script>
    // Email receipt function
    function emailReceipt(orderId) {
        Swal.fire({
            title: 'Email Receipt',
            text: 'Send receipt to customer email?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, send it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make AJAX request to send email
                $.ajax({
                    url: '/order/email-receipt/' + orderId,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Sent!',
                            'Receipt has been emailed to customer.',
                            'success'
                        );
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Failed to send email. Please try again.',
                            'error'
                        );
                    }
                });
            }
        });
    }

    // Initialize DataTable with export options
    $(document).ready(function() {
        $('#basic-datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            order: [[3, 'desc']], // Sort by order date descending
            pageLength: 25
        });
    });
</script>
@endpush

@endsection