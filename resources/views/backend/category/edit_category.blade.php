@extends('admin_dashboard')
@section('admin')

<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('all.category') }}" class="btn btn-outline-primary rounded-pill waves-effect waves-light btn-sm">
                                    <i class="mdi mdi-arrow-left me-1"></i> Back to List
                                </a>
                            </li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Category</h4>
                </div>
            </div>
        </div>     
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        
                        <h5 class="mb-4 text-uppercase text-primary">
                            <i class="mdi mdi-folder-edit-outline me-1"></i> Category Information
                        </h5>

                        <form method="post" action="{{ route('category.update') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $category->id }}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label for="category_name" class="form-label fw-bold">Category Name</label>
                                        <input type="text" name="category_name" id="category_name" 
                                               class="form-control border-primary-subtle @error('category_name') is-invalid @enderror" 
                                               value="{{ old('category_name', $category->category_name) }}" 
                                               placeholder="Enter category name">
                                        
                                        @error('category_name')
                                            <span class="text-danger mt-1">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted mt-2 d-block">Updating this will affect all products currently linked to this category.</small>
                                    </div>
                                </div>
                            </div> <hr class="my-4 border-light">

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('all.category') }}" class="text-muted text-decoration-underline">Cancel changes</a>
                                <button type="submit" class="btn btn-info waves-effect waves-light px-4">
                                    <i class="mdi mdi-content-save me-1"></i> Update Category
                                </button>
                            </div>
                        </form>

                    </div> </div> </div> </div> </div> </div> @endsection