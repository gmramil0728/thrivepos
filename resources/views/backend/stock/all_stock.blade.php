@extends('admin_dashboard')
@section('admin')

<style>
    .bg-soft-info {
        background-color: rgba(59, 175, 218, 0.15);
        color: #3bafda;
    }
    .bg-soft-success {
        background-color: rgba(26, 188, 156, 0.15);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.02);
    }
</style>

<div class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('import.product') }}" class="btn btn-info rounded-pill waves-effect waves-light">
                                <i class="mdi mdi-upload me-1"></i> Import
                            </a>  
                            <a href="{{ route('export') }}" class="btn btn-danger rounded-pill waves-effect waves-light">
                                <i class="mdi mdi-download me-1"></i> Export
                            </a>  
                            <a href="{{ route('add.product') }}" class="btn btn-primary rounded-pill waves-effect waves-light">
                                <i class="mdi mdi-plus-circle me-1"></i> Add Product
                            </a>
                        </div>
                    </div>
                    <h4 class="page-title">Product Inventory</h4>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        
                        <table id="basic-datatable" class="table dt-responsive nowrap w-100 table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Sl</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Supplier</th>
                                    <th>Code</th>
                                    <th>Stock</th> 
                                    {{-- <th class="text-center">Action</th> --}}
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($product as $key => $item)
                                <tr class="align-middle">
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        <img src="{{ asset($item->product_image) }}" 
                                             class="rounded shadow-sm border" 
                                             style="width: 50px; height: 45px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $item->product_name }}</span>
                                    </td>
                                    <td><span class="badge bg-soft-info text-info">{{ $item['category']['category_name'] }}</span></td>
                                    <td>{{ $item['supllier']['name'] }}</td>
                                    <td><code class="text-primary fw-bold">{{ $item->product_code }}</code></td>
                                    <td> 
                                        @if($item->inventory_count <= 5)
                                            <span class="badge bg-danger">Low: {{ $item->inventory_count }}</span>
                                        @else
                                            <span class="badge bg-soft-success text-success p-1 px-2 border border-success">
                                                <i class="mdi mdi-package-variant-closed me-1"></i>{{ $item->inventory_count }}
                                            </span>
                                        @endif
                                    </td>
                                    {{-- <td class="text-center">
                                        <div class="btn-group dropdown">
                                            <a href="javascript: void(0);" class="table-action-btn dropdown-toggle arrow-none btn btn-light btn-xs" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('edit.product', $item->id) }}"><i class="mdi mdi-pencil me-2 text-muted"></i>Edit</a>
                                                <a class="dropdown-item" href="{{ route('barcode.product', $item->id) }}"><i class="mdi mdi-barcode me-2 text-muted"></i>Barcode</a>
                                                <a class="dropdown-item" href="{{ route('delete.product', $item->id) }}" id="delete"><i class="mdi mdi-trash-can me-2 text-muted"></i>Delete</a>
                                            </div>
                                        </div>
                                    </td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> </div> </div></div>
        </div> </div> @endsection

@section('jscripts')
<script type="text/javascript">
    $(document).ready(function() {
        // Check if the table exists and initialize
        if ($('#basic-datatable').length > 0) {
            $('#basic-datatable').DataTable({
                "language": {
                    "paginate": {
                        "previous": "<i class='mdi mdi-chevron-left'>",
                        "next": "<i class='mdi mdi-chevron-right'>"
                    }
                },
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                }
            });
        }
    });
</script>
@endsection