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
                            <li class="breadcrumb-item active">Add Product</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Add Product</h4>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <form id="myForm" method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                            @csrf

                            <h5 class="mb-4 text-uppercase text-primary">
                                <i class="mdi mdi-package-variant-closed me-1"></i> General Information
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="product_code" class="form-label">Product Code</label>
                                        <input type="text" name="product_code" id="product_code" class="form-control" value="{{ old('product_code') }}" placeholder="Enter product code">
                                        @error('product_code') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" name="product_name" id="product_name" class="form-control" value="{{ old('product_name') }}" placeholder="Enter product name">
                                        @error('product_name') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select name="category_id" class="form-select" id="category_id">
                                            <option selected disabled>Select Category</option>
                                            @foreach($category as $cat)
                                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="supplier_id" class="form-label">Supplier</label>
                                        <select name="supplier_id" class="form-select" id="supplier_id">
                                            <option selected disabled>Select Supplier</option>
                                            @foreach($supplier as $sup)
                                                <option value="{{ $sup->id }}" {{ old('supplier_id') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                
                            </div>

                            <hr class="my-4 border-light">

                            <h5 class="mb-4 text-uppercase text-primary">
                                <i class="mdi mdi-currency-usd me-1"></i> Pricing & Inventory
                            </h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="product_garage" class="form-label">Inventory Storage/Location</label>
                                        <input type="text" name="product_garage" id="product_garage" class="form-control" value="{{ old('product_garage') }}" placeholder="A1, B2, etc.">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="inventory_count" class="form-label">Inventory Count</label>
                                        <input type="number" name="inventory_count" id="inventory_count" class="form-control" value="{{ old('inventory_count') }}" placeholder="0" min="0" step="1" inputmode="numeric">
                                        @error('inventory_count') <span class="text-danger">{{ $message }}</span> @enderror
                                        
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="buying_date" class="form-label">Buying Date</label>
                                        <input type="date" name="buying_date" id="buying_date" class="form-control" value="{{ old('buying_date') }}">
                                        @error('buying_date') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="expire_date" class="form-label">Expire Date</label>
                                        <input type="date" name="expire_date" id="expire_date" class="form-control" value="{{ old('expire_date') }}">
                                        @error('expire_date') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="buying_price" class="form-label">Buying Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" name="buying_price" id="buying_price" class="form-control" value="{{ old('buying_price') }}">
                                            @error('buying_price') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="selling_price" class="form-label">Selling Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" name="selling_price" id="selling_price" class="form-control" value="{{ old('selling_price') }}">                                                                                        
                                        </div>
                                        @error('selling_price') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 border-light">

                            <div class="row align-items-center bg-light-subtle p-3 rounded-3 mx-0">
                                <div class="col-md-6">
                                    <div class="form-group mb-0">
                                        <label for="image" class="form-label fw-bold text-dark">Product Image</label>
                                        <input type="file" name="product_image" id="image" class="form-control">
                                        <small class="text-muted mt-1 d-block">Recommended size: 500x500px</small>
                                    </div>
                                </div>

                                <div class="col-md-6 text-center">
                                    <div class="image-preview-wrapper mt-2 mt-md-0">
                                        <img id="showImage" src="{{ url('upload/no_image.jpg') }}" 
                                             class="rounded shadow-sm border-white img-thumbnail"
                                             alt="preview" style="width: 120px; height: 100px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="reset" class="btn btn-light waves-effect me-2">Clear Form</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light px-4">
                                    <i class="mdi mdi-content-save me-1"></i> Save Product
                                </button>
                            </div>
                        </form>

                    </div> </div> </div> </div> </div> </div> 
@endsection

@section('jscripts')
    {{-- <script type="text/javascript">
        $(document).ready(function (){
            $('#myForm').validate({
                rules: {
                    product_code: { required : true }, 
                    product_name: { required : true }, 
                    category_id: { required : true }, 
                    supplier_id: { required : true },                        
                    inventory_count: { required : true }, 
                    buying_date: { required : true },                     
                    buying_price: { required : true }, 
                    selling_price: { required : true },                     
                },
                messages :{
                    product_code: { required : 'Please Enter Product Code' }, 
                    product_name: { required : 'Please Enter Product Name' }, 
                    category_id: { required : 'Please Select Category' },
                    supplier_id: { required : 'Please Select Supplier' },                                    
                    inventory_count: { required : 'Please Enter Inventory Count' },
                    buying_date: { required : 'Please Select Buying Date' },                    
                    buying_price: { required : 'Please Enter Buying Price' },
                    selling_price: { required : 'Please Enter Selling Price' },                    
                },
                errorElement : 'span', 
                errorPlacement: function (error,element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight : function(element, errorClass, validClass){
                    $(element).addClass('is-invalid');
                },
                unhighlight : function(element, errorClass, validClass){
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script> --}}

    <script type="text/javascript">
        $(document).ready(function(){
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