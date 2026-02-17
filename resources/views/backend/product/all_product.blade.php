@extends('admin_dashboard')
@section('admin')

<style>
    .custom-table-container {
        padding: 20px; /* This ensures the table never touches the card edges */
    }
    .dataTables_wrapper .row {
        margin-bottom: 15px; /* Spacing between search bar and table */
    }
    .badge-soft-success {
        background-color: rgba(28, 187, 140, 0.1);
        color: #1cbb8c;
    }
    .badge-soft-danger {
        background-color: rgba(243, 47, 76, 0.1);
        color: #f32f4c;
    }
    .table thead th {
        background-color: #f8f9fa;
        border-bottom-width: 1px;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }
</style>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Product Management</h4>
                    <div class="page-title-right d-none d-md-block">
                        <div class="btn-group">
                            <a href="{{ route('import.product') }}" class="btn btn-outline-secondary btn-sm">Import</a>
                            <a href="{{ route('export') }}" class="btn btn-outline-secondary btn-sm">Export</a>
                            <a href="{{ route('add.product') }}" class="btn btn-primary btn-sm ms-2">
                                <i class="mdi mdi-plus me-1"></i> Add Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="custom-table-container">
                            <div class="table-responsive">
                                <table id="basic-datatable" class="table table-centered table-nowrap mb-0 w-100">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Image</th>
                                            <th>Code</th>
                                            <th>Product Name</th>
                                            <th>Category</th>                                            
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($product as $key=> $item)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>
                                                <img src="{{ asset($item->product_image) }}" class="rounded shadow-sm" style="width: 45px; height: 35px; object-fit: cover;">
                                            </td>
                                            <td><span class="badge bg-light text-body">{{ $item->product_code }}</span></td>
                                            <td class="fw-medium">{{ $item->product_name }}</td>
                                            <td>{{ $item['category']['category_name'] }}</td>                                            
                                            <td class="fw-bold text-end">₱{{ number_format($item->selling_price, 2) }}</td>
                                            <td>
                                                @if($item->expire_date >= Carbon\Carbon::now()->format('Y-m-d'))
                                                    <span class="badge badge-soft-success">Valid</span>
                                                @else
                                                    <span class="badge badge-soft-danger">Expired</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="{{ route('edit.product',$item->id) }}" class="btn btn-soft-primary btn-sm" title="Edit"><i class="mdi mdi-pencil"></i></a>
                                                    <a href="{{ route('barcode.product',$item->id) }}" class="btn btn-soft-info btn-sm" title="Barcode"><i class="mdi mdi-barcode"></i></a>
                                                    <a href="{{ route('delete.product',$item->id) }}" class="btn btn-soft-danger btn-sm" id="delete" title="Delete"><i class="mdi mdi-trash-can"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> </div> </div> </div> </div> </div> </div> </div> 

@endsection

@section('jscripts')
<script>
    $(document).ready(function() {
        $('#basic-datatable').DataTable({
            // 'dom' is the key: this wraps the top/bottom controls in rows with padding
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            language: {
                search: "",
                searchPlaceholder: "Search inventory...",
                lengthMenu: "_MENU_ per page"
            }
        });
    });
</script>
@endsection