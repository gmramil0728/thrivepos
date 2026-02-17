<div class="col-md-3 col-sm-6 product-item" data-name="{{ strtolower($product->product_name) }}">
    <div class="card product-card h-100 {{ $product->inventory_count <= 0 ? 'opacity-50' : '' }}" 
         onclick="addToCart({{ $product->id }}, '{{ addslashes($product->product_name) }}', {{ $product->selling_price }}, {{ $product->inventory_count }})">
        
        <div class="position-relative">
            <img src="{{ asset($product->product_image) }}" class="card-img-top product-image" alt="product">
            @if($product->inventory_count <= 0)
                <span class="badge badge-stock bg-danger text-white">Out of Stock</span>
            @elseif($product->inventory_count <= 5)
                <span class="badge badge-stock bg-warning text-dark">Low: {{ $product->inventory_count }}</span>
            @else
                <span class="badge badge-stock bg-success text-white">In Stock: {{ $product->inventory_count }}</span>
            @endif
        </div>

        <div class="card-body p-3">
            <h6 class="fw-bold mb-2 text-dark">{{ $product->product_name }}</h6>
            <div class="d-flex justify-content-between align-items-center">
                <span class="price-tag">₱{{ number_format($product->selling_price, 2) }}</span>
            </div>
        </div>
    </div>
</div>