@extends('admin_dashboard')
@section('admin')


<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('all.product') }}">Products</a></li>
                            <li class="breadcrumb-item active">Edit Product</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Edit Product</h4>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <form id="myForm" method="post" action="{{ route('product.update') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <input type="hidden" name="id" value="{{ $product->id }}">

                            <h5 class="mb-4 text-uppercase text-primary">
                                <i class="mdi mdi-package-variant-closed me-1"></i> Update General Information
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="product_code" class="form-label">Product Code</label>
                                        <input type="text" name="product_code" id="product_code" class="form-control" value="{{ old('product_code', $product->product_code) }}">
                                        @error('product_code') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" name="product_name" id="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}">
                                        @error('product_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select name="category_id" class="form-select" id="category_id">
                                            @foreach($category as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="supplier_id" class="form-label">Supplier</label>
                                        <select name="supplier_id" class="form-select" id="supplier_id">
                                            @foreach($supplier as $sup)
                                                <option value="{{ $sup->id }}" {{ old('supplier_id', $product->supplier_id) == $sup->id ? 'selected' : '' }}>
                                                    {{ $sup->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('supplier_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <hr class="my-4 border-light">

                            <h5 class="mb-4 text-uppercase text-primary">
                                <i class="mdi mdi-currency-usd me-1"></i> Pricing & Inventory Update
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="product_garage" class="form-label">Inventory Storage/Location</label>
                                        <input type="text" name="product_garage" id="product_garage" class="form-control" value="{{ old('product_garage', $product->product_garage) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="inventory_count" class="form-label">Inventory Count</label>
                                        <input type="number" name="inventory_count" id="inventory_count" class="form-control" value="{{ old('inventory_count', $product->inventory_count) }}">
                                    </div>
                                    @error('inventory_count') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="buying_date" class="form-label">Buying Date</label>
                                        <input type="date" name="buying_date" id="buying_date" class="form-control" value="{{ old('buying_date', $product->buying_date) }}">
                                    </div>
                                    @error('buying_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="expire_date" class="form-label">Expire Date</label>
                                        <input type="date" name="expire_date" id="expire_date" class="form-control" value="{{ old('expire_date', $product->expire_date) }}">
                                    </div>
                                    @error('expire_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="buying_price" class="form-label">Buying Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="text" name="buying_price" id="buying_price" class="form-control" value="{{ old('buying_price', $product->buying_price) }}">
                                        </div>
                                        @error('buying_price') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="selling_price" class="form-label">Selling Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="text" name="selling_price" id="selling_price" class="form-control" value="{{ old('selling_price', $product->selling_price) }}">
                                        </div>
                                        @error('selling_price') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 border-light">

                            <div class="row align-items-center bg-light-subtle p-3 rounded-3 mx-0">
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label for="image" class="form-label fw-bold text-dark">Update Product Image</label>
                                        <input type="file" name="product_image" id="image" class="form-control">
                                        <small class="text-muted mt-1 d-block">Leave empty to keep the current image.</small>
                                    </div>
                                    @error('product_image') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 text-center">
                                    <div class="image-preview-wrapper mt-2 mt-md-0">
                                        <img id="showImage" src="{{ (!empty($product->product_image)) ? asset($product->product_image) : url('upload/no_image.jpg') }}" 
                                             class="rounded shadow-sm border-white img-thumbnail"
                                             alt="preview" style="width: 120px; height: 100px; object-fit: cover;">
                                    </div>                                    
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <a href="{{ route('all.product') }}" class="btn btn-light waves-effect me-2">Cancel</a>
                                <button type="submit" class="btn btn-info waves-effect waves-light px-4">
                                    <i class="mdi mdi-content-save me-1"></i> Update Product
                                </button>
                            </div>
                        </form>

                    </div> </div> </div> </div> </div> </div> 
@endsection

@section('jscripts')
    <script type="text/javascript">
        $(document).ready(function(){
            // Live Image Preview
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#showImage').attr('src',e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

        });
    </script>
@endsection