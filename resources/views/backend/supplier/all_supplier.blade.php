@extends('admin_dashboard')
@section('admin')

<style>
    /* Professional edge padding for the DataTable */
    .dataTables_wrapper {
        padding: 1.5rem;
    }
    .table-responsive {
        border: none !important;
    }
    /* Floating row effect */
    #basic-datatable tbody tr {
        transition: all 0.2s;
    }
    #basic-datatable tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
</style>

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-sm-0">Supplier Masterlist</h4>
                    
                    <div class="page-title-right">
                        <a href="{{ route('supplier.add') }}" class="btn btn-primary waves-effect waves-light shadow-sm">
                            <i class="mdi mdi-truck-delivery-outline me-1"></i> Add New Supplier
                        </a>
                    </div>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0"> <div class="table-responsive">
                            <table id="basic-datatable" class="table table-hover align-middle nowrap w-100">
                                <thead class="bg-light-subtle">
                                    <tr>
                                        <th class="border-0 px-3">#</th>
                                        <th class="border-0">Supplier</th>
                                        <th class="border-0">Contact Details</th>
                                        <th class="border-0">Classification</th>
                                        <th class="border-0 text-end px-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($supplier as $key=> $item)
                                    <tr>
                                        <td class="px-3 text-muted">{{ $key+1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-3">
                                                    <img src="{{ (!empty($item->image)) ? url($item->image) : url('upload/no_image.jpg') }}" 
                                                         class="img-fluid rounded-circle border border-2 border-white shadow-sm" 
                                                         style="width: 45px; height: 45px; object-fit: cover;">
                                                </div>
                                                <div>
                                                    <h5 class="m-0 fs-14 text-dark fw-bold">{{ $item->name }}</h5>
                                                    <small class="text-muted">Vendor ID: SUP-{{ 500 + $item->id }}</small>
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
                                            <span class="badge {{ $item->type == 'Distributor' ? 'bg-warning-subtle text-warning' : 'bg-blue-subtle text-blue' }} px-2 py-1 rounded-pill fw-medium">
                                                {{ $item->type }}
                                            </span>
                                        </td>
                                        <td class="text-end px-3">
                                            <div class="d-flex justify-content-end gap-1">
                                                <a href="{{ route('supplier.details',$item->id) }}" class="btn btn-soft-info btn-sm rounded-circle" data-bs-toggle="tooltip" title="View Details">
                                                    <i class="mdi mdi-eye fs-16"></i>
                                                </a>
                                                <a href="{{ route('supplier.edit',$item->id) }}" class="btn btn-soft-primary btn-sm rounded-circle" data-bs-toggle="tooltip" title="Edit">
                                                    <i class="mdi mdi-pencil fs-16"></i>
                                                </a>
                                                <a href="{{ route('supplier.delete',$item->id) }}" class="btn btn-soft-danger btn-sm rounded-circle" id="delete" data-bs-toggle="tooltip" title="Delete">
                                                    <i class="mdi mdi-trash-can fs-16"></i>
                                                </a>
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
            // Re-initialize Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            $('#basic-datatable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [10, 25, 50],
                language: {
                    search: "",
                    searchPlaceholder: "Search suppliers...",
                },
                columnDefs: [
                    { orderable: false, targets: [1, 4] }
                ],
                // Custom DOM to ensure padding inside the card
                dom: "<'row px-3 pt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row px-3 pb-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            });
        });
    </script>
@endsection