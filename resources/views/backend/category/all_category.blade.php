@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#signup-modal">
                                <i class="mdi mdi-plus-circle me-1"></i> Add Category
                            </button> 
                        </ol>
                    </div>
                    <h4 class="page-title">Product Categories</h4>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <p class="text-muted font-14 mb-3">
                            Manage your product categories. You can add, edit, or delete categories used for inventory organization.
                        </p>

                        <table id="basic-datatable" class="table table-hover dt-responsive nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%">Sl No.</th> 
                                    <th>Category Name</th>
                                    <th width="20%" class="text-center">Action</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($category as $key => $item)
                                <tr>
                                    <td><span class="badge bg-soft-secondary text-secondary">{{ $key+1 }}</span></td> 
                                    <td class="fw-medium text-dark">{{ $item->category_name }}</td> 
                                    <td class="text-center">
                                        <a href="{{ route('edit.category',$item->id) }}" class="btn btn-sm btn-blue rounded-pill waves-effect waves-light me-1" title="Edit">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </a>
                                        <a href="{{ route('delete.category',$item->id) }}" class="btn btn-sm btn-danger rounded-pill waves-effect waves-light" id="delete" title="Delete">
                                            <i class="mdi mdi-trash-can"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> </div> </div></div>
        </div> </div> <div id="signup-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-white" id="myModalLabel">Add New Category</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4"> 
                <form class="px-2" method="post" action="{{ route('category.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="category_name" class="form-label fw-bold">Category Name</label>
                        <input class="form-control border-primary-subtle" type="text" name="category_name" id="category_name" placeholder="e.g. Electronics, Furniture" required>
                        <small class="text-muted">Ensure the name is unique for better organization.</small>
                    </div>

                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Discard</button>
                        <button class="btn btn-primary px-4" type="submit">Save Category</button>
                    </div>
                </form>
            </div>
        </div></div></div>@endsection