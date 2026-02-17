@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-sm-0">Customer Masterlist</h4>
                    
                    <div class="page-title-right">
                        <div class="d-flex gap-2">
                            <a href="{{ route('customer.add') }}" class="btn btn-primary waves-effect waves-light shadow-sm">
                                <i class="mdi mdi-account-plus me-1"></i> Add New Customer
                            </a>
                            {{-- Uncomment when ready --}}
                            {{-- <a href="{{ route('customer.export') }}" class="btn btn-outline-secondary waves-effect shadow-sm">
                                <i class="mdi mdi-download me-1"></i> Export
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table table-hover align-middle nowrap w-100">
                                <thead class="bg-light-subtle border-bottom">
                                    <tr>
                                        <th class="border-0 px-3">#</th>
                                        <th class="border-0">Customer</th>
                                        <th class="border-0">Contact Info</th>
                                        <th class="border-0">Shop Details</th>
                                        <th class="border-0 text-end px-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customer as $key=> $item)
                                    <tr>
                                        <td class="px-3 text-muted">#{{ $key+1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <img src="{{ (!empty($item->image)) ? asset($item->image) : url('upload/no_image.jpg') }}" 
                                                         class="img-fluid rounded-circle border border-2 border-white shadow-sm" 
                                                         style="width: 45px; height: 45px; object-fit: cover;">
                                                </div>
                                                <div>
                                                    <h5 class="m-0 fs-14 text-dark font-bold">{{ $item->name }}</h5>
                                                    <small class="text-muted">ID: CUST-{{ $item->id + 1000 }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark fs-13"><i class="mdi mdi-email-outline me-1 text-primary"></i> {{ $item->email }}</span>
                                                <small class="text-muted mt-1"><i class="mdi mdi-phone-outline me-1 text-success"></i> {{ $item->phone }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info-subtle text-info px-2 py-1 rounded-pill fw-medium">
                                                {{ $item->shopname }}
                                            </span>
                                        </td>
                                        <td class="text-end px-3">
                                            <div class="dropdown d-inline-block">
                                                @if(Auth::user()->can('customer.edit'))
                                                <a href="{{ route('customer.edit', $item->id) }}" class="btn btn-soft-primary btn-sm rounded-circle me-1" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="mdi mdi-pencil fs-16"></i>
                                                </a>
                                                @endif

                                                @if(Auth::user()->can('customer.delete'))
                                                <a href="{{ route('customer.delete', $item->id) }}" class="btn btn-soft-danger btn-sm rounded-circle" id="delete" data-bs-toggle="tooltip" title="Delete">
                                                    <i class="mdi mdi-delete fs-16"></i>
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> </div> </div> </div></div>
        </div> </div>     

@endsection

@section('jscripts')
    <script>
        $(document).ready(function() {
            // Initialize Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            $('#basic-datatable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                language: {
                    search: "",
                    searchPlaceholder: "Search records...",
                    lengthMenu: "Show _MENU_"
                },
                columnDefs: [
                    { orderable: false, targets: [1, 4] }
                ],
                // Add drawing classes to make the table wrapper look cleaner
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            });
        });
    </script>
@endsection