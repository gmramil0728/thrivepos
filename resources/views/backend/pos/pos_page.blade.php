@extends('admin_dashboard')
@section('admin')

{{-- Link the external POS stylesheet --}}
<link href="{{asset('backend/assets/css/pos.css')}}" rel="stylesheet" type="text/css" />

<div class="content">
    <div class="container-fluid py-3">

        {{-- ── Page Header ─────────────────────────────────────── --}}
        <div class="pos-header">
            <div class="pos-header-title">
                <div class="pos-header-icon">
                    <i class="fas fa-cash-register"></i>
                </div>
                <div>
                    <h4>Point of Sale</h4>
                    <span>Sell · Checkout · Receipt</span>
                </div>
            </div>
            <div class="pos-header-actions">
                <button class="pos-btn pos-btn-danger" onclick="clearCart()">
                    <i class="fas fa-trash"></i> Clear Cart
                </button>
                <a href="{{ route('dashboard') }}" class="pos-btn pos-btn-ghost">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>
        </div>

        <div class="row g-3">

            {{-- ══════════════════════════════════════════════════
                 LEFT — Product Browser
            ══════════════════════════════════════════════════ --}}
            <div class="col-lg-7">
                <div class="pos-card">
                    <div class="pos-card-body">

                        {{-- Search + Barcode --}}
                        <div class="row g-2 mb-3">
                            <div class="col-md-12">
                                <div class="pos-search-wrap">
                                    <input type="text" id="searchProduct" class="pos-input"
                                           placeholder="Search by name or code…" autofocus>
                                    <i class="fas fa-search pos-search-icon"></i>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <input type="text" id="barcode" class="pos-input"
                                       placeholder="&#xf02a; Scan barcode…" autofocus>
                            </div> --}}
                        </div>

                        {{-- Category Pills --}}
                        <div class="pos-category-bar" id="categoryBar">
                            <button class="pos-cat-btn active"
                                    data-target="all-products"
                                    onclick="switchTab(this, 'all-products')">
                                <i class="fas fa-th-large"></i> All
                            </button>
                            @foreach($categories as $category)
                                <button class="pos-cat-btn"
                                        data-target="cat-{{ $category->id }}"
                                        onclick="switchTab(this, 'cat-{{ $category->id }}')">
                                    {{ $category->category_name }}
                                </button>
                            @endforeach
                        </div>

                        {{-- Products Scrollable Grid --}}
                        <div class="pos-products-scroll">

                            {{-- All Products --}}
                            <div class="tab-pane-pos show" id="all-products">
                                <div class="row g-2" id="allProductsContainer">
                                    @foreach($products as $product)
                                        @php $outOfStock = isset($product->inventory_count) && $product->inventory_count <= 0; @endphp
                                        <div class="col-6 col-sm-4 col-md-3 product-item"
                                             data-name="{{ strtolower($product->product_name) }}"
                                             data-code="{{ strtolower($product->product_code ?? '') }}">
                                            <div class="pos-product-card {{ $outOfStock ? 'out-of-stock' : '' }}"
                                                 onclick="{{ $outOfStock ? '' : "addToCart({$product->id}, '" . addslashes($product->product_name) . "', {$product->selling_price}, " . ($product->inventory_count ?? 'null') . ")" }}">
                                                <img src="{{ asset($product->product_image) }}"
                                                     class="pos-product-img"
                                                     alt="{{ $product->product_name }}">

                                                @if(isset($product->inventory_count))
                                                    @if($product->inventory_count <= 0)
                                                        <span class="pos-stock-badge out">OUT</span>
                                                    @elseif($product->inventory_count <= 5)
                                                        <span class="pos-stock-badge low">{{ $product->inventory_count }} left</span>
                                                    @else
                                                        <span class="pos-stock-badge in">{{ $product->inventory_count }}</span>
                                                    @endif
                                                @endif

                                                <div class="pos-product-info">
                                                    <div class="pos-product-name">{{ $product->product_name }}</div>
                                                    <div class="pos-product-price">₱{{ number_format($product->selling_price, 2) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Category Tabs --}}
                            @foreach($categories as $category)
                                <div class="tab-pane-pos" id="cat-{{ $category->id }}" style="display:none;">
                                    <div class="row g-2">
                                        @foreach($products->where('category_id', $category->id) as $product)
                                            @php $outOfStock = isset($product->inventory_count) && $product->inventory_count <= 0; @endphp
                                            <div class="col-6 col-sm-4 col-md-3 product-item"
                                                 data-name="{{ strtolower($product->product_name) }}"
                                                 data-code="{{ strtolower($product->product_code ?? '') }}">
                                                <div class="pos-product-card {{ $outOfStock ? 'out-of-stock' : '' }}"
                                                     onclick="{{ $outOfStock ? '' : "addToCart({$product->id}, '" . addslashes($product->product_name) . "', {$product->selling_price}, " . ($product->inventory_count ?? 'null') . ")" }}">
                                                    <img src="{{ asset($product->product_image) }}"
                                                         class="pos-product-img"
                                                         alt="{{ $product->product_name }}">

                                                    @if(isset($product->inventory_count))
                                                        @if($product->inventory_count <= 0)
                                                            <span class="pos-stock-badge out">OUT</span>
                                                        @elseif($product->inventory_count <= 5)
                                                            <span class="pos-stock-badge low">{{ $product->inventory_count }} left</span>
                                                        @else
                                                            <span class="pos-stock-badge in">{{ $product->inventory_count }}</span>
                                                        @endif
                                                    @endif

                                                    <div class="pos-product-info">
                                                        <div class="pos-product-name">{{ $product->product_name }}</div>
                                                        <div class="pos-product-price">₱{{ number_format($product->selling_price, 2) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                        </div>{{-- /pos-products-scroll --}}
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════════
                 RIGHT — Order Summary & Checkout
            ══════════════════════════════════════════════════ --}}
            <div class="col-lg-5">
                <div class="pos-card pos-order-panel">
                    <div class="pos-card-body">

                        {{-- Order header --}}
                        <div class="pos-order-header">
                            <div class="pos-order-title">
                                <i class="fas fa-shopping-bag" style="color:var(--amber);"></i>
                                Current Order
                            </div>
                            <span class="pos-order-count">{{ Cart::count() }} items</span>
                        </div>

                        {{-- Cart Items --}}
                        <div class="pos-cart-scroll">
                            @php $allcart = Cart::content(); @endphp
                            @if($allcart->count() > 0)
                                <table class="pos-cart-table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th style="text-align:center;">Qty</th>
                                            <th style="text-align:right;">Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allcart as $cart)
                                        <tr>
                                            <td>
                                                <span class="pos-cart-item-name">{{ $cart->name }}</span>
                                                <span class="pos-cart-item-price">₱{{ number_format($cart->price, 2) }}</span>
                                            </td>
                                            <td>
                                                <div class="pos-qty-group">
                                                    <button class="pos-qty-btn" type="button"
                                                            onclick="updateQty('{{ $cart->rowId }}', {{ $cart->qty - 1 }}, {{ $cart->options->stock ?? 'null' }})">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" class="pos-qty-input"
                                                           value="{{ $cart->qty }}"
                                                           onchange="updateQty('{{ $cart->rowId }}', this.value, {{ $cart->options->stock ?? 'null' }})"
                                                           min="1" max="{{ $cart->options->stock ?? '' }}">
                                                    <button class="pos-qty-btn" type="button"
                                                            onclick="updateQty('{{ $cart->rowId }}', {{ $cart->qty + 1 }}, {{ $cart->options->stock ?? 'null' }})"
                                                            {{ isset($cart->options->stock) && $cart->qty >= $cart->options->stock ? 'disabled' : '' }}>
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                                @if(isset($cart->options->stock) && $cart->qty >= $cart->options->stock)
                                                    <span class="pos-qty-max">Max</span>
                                                @endif
                                            </td>
                                            <td class="pos-cart-total-cell">
                                                ₱{{ number_format($cart->price * $cart->qty, 2) }}
                                            </td>
                                            <td>
                                                <button class="pos-remove-btn"
                                                        onclick="removeCartItem('{{ $cart->rowId }}')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="pos-cart-empty">
                                    <i class="fas fa-shopping-bag"></i>
                                    <p>Cart is empty — tap a product to add</p>
                                </div>
                            @endif
                        </div>

                        <hr class="pos-divider">

                        {{-- Discount --}}
                        <div class="pos-section-label"><i class="fas fa-percentage"></i> Discount</div>
                        <div class="pos-discount-wrap">
                            <div class="row g-2 align-items-center">
                                <div class="col-6">
                                    <div class="pos-toggle-group">
                                        <input type="radio" class="pos-toggle-opt" name="discountType"
                                               id="discountPercent" value="percent" checked
                                               onchange="calculateTotals()">
                                        <label class="pos-toggle-label" for="discountPercent">% Percent</label>

                                        <input type="radio" class="pos-toggle-opt" name="discountType"
                                               id="discountAmount" value="amount"
                                               onchange="calculateTotals()">
                                        <label class="pos-toggle-label" for="discountAmount">₱ Amount</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <input type="number" id="discountValue" class="pos-input"
                                           placeholder="0" min="0" step="0.01" onchange="calculateTotals()">
                                </div>
                            </div>
                        </div>

                        <hr class="pos-divider">

                        {{-- Tax --}}
                        <div class="pos-section-label"><i class="fas fa-calculator"></i> Tax Breakdown</div>
                        <div class="pos-tax-wrap">
                            <div class="pos-tax-row">
                                <span>Subtotal</span>
                                <strong id="subtotal">₱{{ Cart::subtotal() }}</strong>
                            </div>
                            <div class="pos-tax-row">
                                <span>Discount</span>
                                <strong id="discountAmountVAL" style="color:var(--red);">₱0.00</strong>
                            </div>
                            <div class="pos-switch-row">
                                <label class="pos-switch-label" for="vatSwitch">
                                    <input class="form-check-input" type="checkbox" id="vatSwitch" checked onchange="calculateTotals()">
                                    VATable Sale (12%)
                                </label>
                            </div>
                            <div id="vatBreakdown">
                                <div class="pos-tax-row">
                                    <span>VATable Sales (ex. VAT)</span>
                                    <strong id="vatableSales">₱0.00</strong>
                                </div>
                                <div class="pos-tax-row">
                                    <span>VAT Amount</span>
                                    <strong id="vatAmount">₱0.00</strong>
                                </div>
                            </div>
                            <div class="pos-switch-row">
                                <label class="pos-switch-label" for="zeroRated">
                                    <input class="form-check-input" type="checkbox" id="zeroRated" onchange="calculateTotals()">
                                    Zero-Rated: <span id="zeroRatedAmount" style="font-family:var(--mono); color:var(--ink-3);">₱0.00</span>
                                </label>
                            </div>
                            <div class="pos-switch-row">
                                <label class="pos-switch-label" for="vatExempt">
                                    <input class="form-check-input" type="checkbox" id="vatExempt" onchange="calculateTotals()">
                                    VAT-Exempt: <span id="vatExemptAmount" style="font-family:var(--mono); color:var(--ink-3);">₱0.00</span>
                                </label>
                            </div>
                        </div>

                        {{-- Grand Total --}}
                        <div class="pos-total-bar">
                            <div class="pos-total-label">Grand Total</div>
                            <div class="pos-total-value">
                                <span class="currency-sym">₱</span><span id="grandTotal">{{ Cart::total() }}</span>
                            </div>
                        </div>

                        {{-- Customer --}}
                        <div class="pos-section-label" style="margin-bottom:8px;"><i class="fas fa-user"></i> Customer</div>
                        <div class="pos-customer-group mb-3">
                            <select id="customerId" class="pos-select">
                                <option value="" disabled selected>Select customer…</option>
                                @foreach($customer as $cus)
                                    <option value="{{ $cus->id }}">{{ $cus->name }} — {{ $cus->phone ?? 'N/A' }}</option>
                                @endforeach
                            </select>
                            <a href="{{ route('customer.add') }}" class="pos-btn pos-btn-ghost" target="_blank"
                               title="Add new customer">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>

                        {{-- Complete Order --}}
                        <button class="pos-btn pos-btn-amber pos-btn-lg pos-btn-block"
                                onclick="printThermalReceipt()">
                            <i class="fas fa-print"></i> Complete &amp; Print Receipt
                        </button>

                    </div>
                </div>
            </div>

        </div>{{-- /row --}}
    </div>
</div>

{{-- ── Payment Modal ────────────────────────────────────────── --}}
<div class="modal fade pos-modal" id="paymentModal" tabindex="-1"
     aria-labelledby="paymentModalLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">
                    <i class="fas fa-cash-register"></i> Process Payment
                </h5>
                <button type="button" class="btn-close btn-close-white"
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="paymentForm" method="post" action="{{ url('/process-payment') }}">
                @csrf
                <div class="modal-body">

                    {{-- Order Summary --}}
                    <div class="pos-modal-summary mb-4">
                        <div class="pos-modal-summary-row">
                            <span>Total Items</span>
                            <span id="modal-total-items">{{ Cart::count() }}</span>
                        </div>
                        <div class="pos-modal-summary-row">
                            <span>Subtotal</span>
                            <span id="modal-subtotal">₱{{ Cart::subtotal() }}</span>
                        </div>
                        <div class="pos-modal-summary-row">
                            <span>Discount</span>
                            <span id="modal-discount" style="color:var(--red);">₱0.00</span>
                        </div>
                        <div class="pos-modal-summary-row">
                            <span>VATable Sales (ex. VAT)</span>
                            <span id="modal-vatablesales">₱0.00</span>
                        </div>
                        <div class="pos-modal-summary-row">
                            <span>VAT (12%)</span>
                            <span id="modal-vat">₱0.00</span>
                        </div>
                        <div class="pos-modal-summary-row total-row">
                            <span>Total Due</span>
                            <span id="modal-grand-total">₱{{ Cart::total() }}</span>
                        </div>
                    </div>

                    <div class="row g-3">

                        {{-- Payment Method --}}
                        <div class="col-sm-5">
                            <label class="form-label">Payment Method</label>
                            <div class="pos-pay-methods">
                                <input type="radio" class="pos-pay-method-input" name="payment_method"
                                       id="pm-cash" value="cash" checked>
                                <label class="pos-pay-method-tile" for="pm-cash">
                                    <i class="fas fa-money-bill-wave"></i> Cash
                                </label>

                                <input type="radio" class="pos-pay-method-input" name="payment_method"
                                       id="pm-card" value="card">
                                <label class="pos-pay-method-tile" for="pm-card">
                                    <i class="fas fa-credit-card"></i> Card
                                </label>

                                <input type="radio" class="pos-pay-method-input" name="payment_method"
                                       id="pm-gcash" value="gcash">
                                <label class="pos-pay-method-tile" for="pm-gcash">
                                    <i class="fas fa-mobile-alt"></i> GCash
                                </label>

                                <input type="radio" class="pos-pay-method-input" name="payment_method"
                                       id="pm-other" value="other">
                                <label class="pos-pay-method-tile" for="pm-other">
                                    <i class="fas fa-ellipsis-h"></i> Other
                                </label>
                            </div>
                        </div>

                        {{-- Payment Fields --}}
                        <div class="col-sm-7">
                            <div class="mb-3">
                                <label class="form-label">Payment Status</label>
                                <select name="payment_status" id="payment_status"
                                        class="form-select" onchange="togglePaymentFields()">
                                    <option value="paid">Paid — Full Payment</option>
                                    <option value="partial">Partial Payment</option>
                                    <option value="due">Due — Pay Later</option>
                                </select>
                            </div>
                            <div class="row g-2 mb-3" id="paymentAmountSection">
                                <div class="col-6">
                                    <label class="form-label">Amount Paid</label>
                                    <input type="number" name="pay" id="amount_paid"
                                           class="form-control form-control-lg"
                                           step="0.01" min="0" placeholder="0.00"
                                           onkeyup="calculateChange()" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Change</label>
                                    <input type="text" id="change_amount"
                                           class="form-control form-control-lg" readonly>
                                </div>
                            </div>
                            <div class="mb-3 d-none" id="dueAmountSection">
                                <label class="form-label">Due Amount</label>
                                <input type="text" id="due_amount" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    {{-- Hidden fields --}}
                    <input type="hidden" name="customer_id"      id="payment-customer-id">
                    <input type="hidden" name="order_date"       id="payment-order-date"     value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="order_status"     id="payment-order-status"   value="pending">
                    <input type="hidden" name="total_products"   id="payment-total-products">
                    <input type="hidden" name="sub_total"        id="payment-sub-total">
                    <input type="hidden" name="vat"              id="payment-vat">
                    <input type="hidden" name="total"            id="payment-total">
                    <input type="hidden" name="discount_type"    id="payment-discount-type">
                    <input type="hidden" name="discount_value"   id="payment-discount-value">
                    <input type="hidden" name="discount_amount"  id="payment-discount-amount">
                    <input type="hidden" name="action_type"      id="payment-action-type"    value="invoice">

                </div>

                <div class="modal-footer">
                    <button type="button" class="pos-btn pos-btn-ghost"
                            data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="pos-btn pos-btn-green pos-btn-lg"
                            id="confirmPaymentBtn">
                        <i class="fas fa-check"></i> Confirm Transaction
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- invoiceForm still used for invoice creation --}}
<form id="invoiceForm" method="post" action="{{ url('/create-invoice') }}" style="display:none;">
    @csrf
    <input type="hidden" name="customer_id"    id="invoiceCustomerId">
    <input type="hidden" name="discount_type"  id="invoiceDiscountType">
    <input type="hidden" name="discount_value" id="invoiceDiscountValue">
    <input type="hidden" name="tax_type"       id="invoiceTaxType">
</form>

@endsection

@section('jscripts')
<script>
/* ── Active tab tracker ───────────────────────────────────── */
let activeTabId = 'all-products';

/* ── Category tab switcher ────────────────────────────────── */
function switchTab(btn, targetId) {
    // Clear search so we start fresh
    document.getElementById('searchProduct').value = '';
    document.querySelectorAll('.product-item').forEach(i => i.style.display = '');

    // Update active button
    document.querySelectorAll('.pos-cat-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // Show only the target pane
    document.querySelectorAll('.tab-pane-pos').forEach(p => p.style.display = 'none');
    document.getElementById(targetId).style.display = 'block';

    activeTabId = targetId;
}

/* ── Product search ───────────────────────────────────────── */
document.getElementById('searchProduct').addEventListener('keyup', function () {
    const term = this.value.toLowerCase().trim();

    if (term === '') {
        // Restore the active tab when search is cleared
        document.querySelectorAll('.tab-pane-pos').forEach(p => p.style.display = 'none');
        document.getElementById(activeTabId).style.display = 'block';
        document.querySelectorAll('.product-item').forEach(i => i.style.display = '');
        return;
    }

    // While searching: show only all-products pane and filter within it
    document.querySelectorAll('.tab-pane-pos').forEach(p => p.style.display = 'none');
    document.getElementById('all-products').style.display = 'block';

    document.querySelectorAll('#all-products .product-item').forEach(item => {
        const match = item.dataset.name.includes(term) || item.dataset.code.includes(term);
        item.style.display = match ? '' : 'none';
    });
});

/* ═══════════════════════════════════════════════════════════
   AJAX CART — no page reloads
   All cart endpoints must return JSON:
   {
     success: bool,
     message: string,
     cart: [{ rowId, name, price, qty, stock, rowTotal }],
     subtotal: number,   // raw number, no formatting
     count: number
   }
   ═══════════════════════════════════════════════════════════ */

const CSRF = '{{ csrf_token() }}';

/* ── SweetAlert2 v10 dark theme ───────────────────────────── */
// v10 has no 'color' param — style text via injected CSS instead
(function() {
    var s = document.createElement('style');
    s.textContent = '.swal-pos-dark,.swal-pos-dark .swal2-title,.swal-pos-dark .swal2-html-container{color:#f0f2f7 !important}';
    document.head.appendChild(s);
})();
var SWAL_BG    = '#1a1d24';
var SWAL_CLASS = { popup: 'swal-pos-dark' };

/* ── Small toast (non-blocking) ───────────────────────────── */
function posToast(icon, title) {
    Swal.fire({
        icon: icon, title: title,
        toast: true, position: 'top-end',
        showConfirmButton: false,
        timer: 1800, timerProgressBar: true,
        background: SWAL_BG, customClass: SWAL_CLASS,
    });
}

/* ── Re-render the cart panel from JSON data ──────────────── */
function renderCart(data) {
    // Update item count badge
    document.querySelector('.pos-order-count').textContent = data.count + ' items';

    // Update subtotal for calculateTotals()
    window._cartSubtotal = data.subtotal;

    const scroll = document.querySelector('.pos-cart-scroll');

    if (!data.cart || data.cart.length === 0) {
        scroll.innerHTML = `
            <div class="pos-cart-empty">
                <i class="fas fa-shopping-bag"></i>
                <p>Cart is empty — tap a product to add</p>
            </div>`;
        calculateTotals();
        return;
    }

    const rows = data.cart.map(item => `
        <tr data-row="${item.rowId}">
            <td>
                <span class="pos-cart-item-name">${item.name}</span>
                <span class="pos-cart-item-price">₱${fmt(item.price)}</span>
            </td>
            <td>
                <div class="pos-qty-group">
                    <button class="pos-qty-btn" type="button"
                            onclick="updateQty('${item.rowId}', ${item.qty - 1}, ${item.stock ?? 'null'})">
                        <i class="fas fa-minus"></i>
                    </button>
                    <input type="number" class="pos-qty-input"
                           value="${item.qty}"
                           onchange="updateQty('${item.rowId}', this.value, ${item.stock ?? 'null'})"
                           min="1" ${item.stock ? 'max="' + item.stock + '"' : ''}>
                    <button class="pos-qty-btn" type="button"
                            onclick="updateQty('${item.rowId}', ${item.qty + 1}, ${item.stock ?? 'null'})"
                            ${item.stock && item.qty >= item.stock ? 'disabled' : ''}>
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                ${item.stock && item.qty >= item.stock ? '<span class="pos-qty-max">Max</span>' : ''}
            </td>
            <td class="pos-cart-total-cell">₱${fmt(item.rowTotal)}</td>
            <td>
                <button class="pos-remove-btn" onclick="removeCartItem('${item.rowId}')">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>`).join('');

    scroll.innerHTML = `
        <table class="pos-cart-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:right;">Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>${rows}</tbody>
        </table>`;

    calculateTotals();
}

/* ── Number formatter ─────────────────────────────────────── */
function fmt(n) {
    return parseFloat(n).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

/* ── Shared fetch helper ──────────────────────────────────── */
function cartFetch(url, method, params) {
    const opts = {
        method,
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
    };
    if (method === 'POST' && params) {
        var body = new URLSearchParams(Object.assign({}, params, { _token: CSRF }));
        opts.body = body;
        opts.headers['Content-Type'] = 'application/x-www-form-urlencoded';
    }
    return fetch(url, opts).then(r => {
        if (!r.ok) {
            return r.text().then(txt => {
                try {
                    const j = JSON.parse(txt);
                    throw new Error(j.message || `HTTP ${r.status}`);
                } catch(e) {
                    if (e.message.startsWith('HTTP')) throw e;
                    throw new Error(`HTTP ${r.status} — ensure your controller returns JSON`);
                }
            });
        }
        return r.json();
    });
}

/* ── Add to cart ──────────────────────────────────────────── */
function addToCart(id, name, price, stock) {
    if (stock !== undefined && stock !== null && stock <= 0) {
        posToast('error', 'Out of stock!');
        return;
    }

    cartFetch('/add-cart', 'POST', { id, name, qty: 1, price })
        .then(data => {
            if (data.success) {
                renderCart(data);
                posToast('success', `${name} added`);
            } else {
                posToast('error', data.message || 'Could not add item');
            }
        })
        .catch(err => posToast('error', err.message));
}

/* ── Update quantity ──────────────────────────────────────── */
var qtyUpdateInProgress = {};

function updateQty(rowId, qty, maxStock) {
    qty = parseInt(qty);

    // Prevent double-clicks
    if (qtyUpdateInProgress[rowId]) {
        console.log('Update already in progress for', rowId);
        return;
    }

    if (qty < 1) {
        removeCartItem(rowId);
        return;
    }
    if (maxStock !== null && maxStock !== undefined && qty > maxStock) {
        posToast('warning', `Only ${maxStock} in stock`);
        const input = document.querySelector(`tr[data-row="${rowId}"] .pos-qty-input`);
        if (input) input.value = maxStock;
        return;
    }

    qtyUpdateInProgress[rowId] = true;

    // Disable buttons during update
    const row = document.querySelector(`tr[data-row="${rowId}"]`);
    if (row) {
        row.querySelectorAll('.pos-qty-btn').forEach(btn => btn.disabled = true);
    }

    cartFetch(`/cart-update/${rowId}`, 'POST', { qty })
        .then(data => {
            if (data.success) renderCart(data);
            else posToast('error', data.message || 'Update failed');
        })
        .catch(err => posToast('error', err.message))
        .finally(() => {
            qtyUpdateInProgress[rowId] = false;
            // Re-enable buttons
            if (row) {
                row.querySelectorAll('.pos-qty-btn').forEach(btn => btn.disabled = false);
            }
        });
}

/* ── Remove item ──────────────────────────────────────────── */
function removeCartItem(rowId) {
    // Optimistic: fade the row out immediately
    const row = document.querySelector(`tr[data-row="${rowId}"]`);
    if (row) row.style.opacity = '0.3';

    cartFetch(`/cart-remove/${rowId}`, 'GET', null)
        .then(data => {
            if (data.success) {
                renderCart(data);
            } else {
                if (row) row.style.opacity = '1';
                posToast('error', data.message || 'Could not remove item');
            }
        })
        .catch(err => {
            if (row) row.style.opacity = '1';
            posToast('error', err.message);
        });
}

/* ── Clear cart ───────────────────────────────────────────── */
function clearCart() {
    Swal.fire({
        title: 'Clear cart?',
        text: 'All items will be removed.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f0534a', cancelButtonColor: '#515c6e',
        confirmButtonText: 'Clear all', cancelButtonText: 'Cancel',
        background: SWAL_BG, customClass: SWAL_CLASS,
    }).then(r => {
        if (!r.isConfirmed) return;
        cartFetch('/cart-clear-all', 'GET', null)
            .then(data => {
                renderCart(data);
                posToast('success', 'Cart cleared');
            })
            .catch(err => posToast('error', err.message));
    });
}

/* ── Calculate totals ─────────────────────────────────────── */
function calculateTotals() {
    // Use live subtotal from last AJAX response if available, else fall back to server-rendered value
    const subtotal = window._cartSubtotal !== undefined
        ? window._cartSubtotal
        : parseFloat('{{ Cart::subtotal() }}'.replace(/,/g, ''));
    const dtype    = document.querySelector('input[name="discountType"]:checked').value;
    const dval     = parseFloat(document.getElementById('discountValue').value) || 0;

    let discount = dtype === 'percent' ? subtotal * (dval / 100) : dval;
    const after  = subtotal - discount;

    const isVat      = document.getElementById('vatSwitch').checked;
    const isZero     = document.getElementById('zeroRated').checked;
    const isExempt   = document.getElementById('vatExempt').checked;

    let vatBase = 0, vatAmt = 0;
    if (isVat && !isZero && !isExempt) {
        vatBase = after / 1.12;
        vatAmt  = after - vatBase;
    }

    document.getElementById('discountAmountVAL').textContent  = '₱' + discount.toFixed(2);
    document.getElementById('subtotal').textContent           = '₱' + fmt(subtotal);
    document.getElementById('vatableSales').textContent       = '₱' + vatBase.toFixed(2);
    document.getElementById('vatAmount').textContent          = '₱' + vatAmt.toFixed(2);
    document.getElementById('grandTotal').textContent         = after.toFixed(2);

    if (isZero) {
        document.getElementById('zeroRatedAmount').textContent = '₱' + after.toFixed(2);
        document.getElementById('vatSwitch').checked = false;
    }
    if (isExempt) {
        document.getElementById('vatExemptAmount').textContent = '₱' + after.toFixed(2);
        document.getElementById('vatSwitch').checked = false;
    }
}

/* ── Print / Complete order ───────────────────────────────── */
function printThermalReceipt() {
    const cid = document.getElementById('customerId').value;
    if (!cid) {
        Swal.fire({
            icon: 'warning', title: 'Customer Required',
            text: 'Please select a customer before completing the order.',
            confirmButtonColor: '#f5a623',
            background: SWAL_BG, customClass: SWAL_CLASS,
        });
        return;
    }
    // Use live count from DOM badge (kept in sync by renderCart)
    const liveCount = parseInt(document.querySelector('.pos-order-count').textContent) || 0;
    if (liveCount === 0) {
        Swal.fire({
            icon: 'warning', title: 'Empty Cart',
            text: 'Please add products before completing the order.',
            confirmButtonColor: '#f5a623',
            background: SWAL_BG, customClass: SWAL_CLASS,
        });
        return;
    }
    openPaymentModal('receipt');
}

/* ── Open payment modal ───────────────────────────────────── */
function openPaymentModal(actionType) {
    const cid      = document.getElementById('customerId').value;
    // Always read from live AJAX state; fall back to server value on first load
    const subtotal = window._cartSubtotal !== undefined
        ? window._cartSubtotal
        : parseFloat('{{ Cart::subtotal() }}'.replace(/,/g, ''));
    const dtype    = document.querySelector('input[name="discountType"]:checked').value;
    const dval     = parseFloat(document.getElementById('discountValue').value) || 0;

    let discount = dtype === 'percent' ? subtotal * (dval / 100) : dval;
    const after  = subtotal - discount;
    const isVat  = document.getElementById('vatSwitch').checked;
    const isZero = document.getElementById('zeroRated').checked;
    const isEx   = document.getElementById('vatExempt').checked;

    let vatAmt = 0;
    if (isVat && !isZero && !isEx) vatAmt = after - (after / 1.12);

    document.getElementById('modal-total-items').textContent  = '{{ Cart::count() }}';
    document.getElementById('modal-subtotal').textContent     = '₱' + subtotal.toFixed(2);
    document.getElementById('modal-discount').textContent     = '₱' + discount.toFixed(2);
    document.getElementById('modal-vat').textContent          = '₱' + vatAmt.toFixed(2);
    document.getElementById('modal-vatablesales').textContent = '₱' + (after - vatAmt).toFixed(2);
    document.getElementById('modal-grand-total').textContent  = '₱' + after.toFixed(2);

    document.getElementById('amount_paid').value = after.toFixed(2);
    calculateChange();

    document.getElementById('payment-customer-id').value      = cid;
    document.getElementById('payment-total-products').value   = '{{ Cart::count() }}';
    document.getElementById('payment-sub-total').value        = subtotal.toFixed(2);
    document.getElementById('payment-vat').value              = vatAmt.toFixed(2);
    document.getElementById('payment-total').value            = after.toFixed(2);
    document.getElementById('payment-discount-type').value    = dtype;
    document.getElementById('payment-discount-value').value   = dval;
    document.getElementById('payment-discount-amount').value  = discount.toFixed(2);
    document.getElementById('payment-action-type').value      = actionType;

    new bootstrap.Modal(document.getElementById('paymentModal')).show();
}

/* ── Toggle payment fields ────────────────────────────────── */
function togglePaymentFields() {
    const status    = document.getElementById('payment_status').value;
    const amtSec    = document.getElementById('paymentAmountSection');
    const dueSec    = document.getElementById('dueAmountSection');
    const amtInput  = document.getElementById('amount_paid');
    const total     = parseFloat(document.getElementById('modal-grand-total').textContent.replace(/₱|,/g, ''));

    if (status === 'paid') {
        amtSec.classList.remove('d-none');
        dueSec.classList.add('d-none');
        amtInput.value    = total.toFixed(2);
        amtInput.required = true;
        document.getElementById('payment-order-status').value = 'complete';
        calculateChange();
    } else if (status === 'partial') {
        amtSec.classList.remove('d-none');
        dueSec.classList.remove('d-none');
        amtInput.value    = '';
        amtInput.required = true;
        document.getElementById('payment-order-status').value = 'pending';
    } else {
        amtSec.classList.add('d-none');
        dueSec.classList.remove('d-none');
        amtInput.value    = '0';
        amtInput.required = false;
        document.getElementById('due_amount').value    = '₱' + total.toFixed(2);
        document.getElementById('change_amount').value = '₱0.00';
        document.getElementById('payment-order-status').value = 'pending';
    }
}

/* ── Calculate change ─────────────────────────────────────── */
function calculateChange() {
    const total  = parseFloat(document.getElementById('modal-grand-total').textContent.replace(/₱|,/g, ''));
    const paid   = parseFloat(document.getElementById('amount_paid').value) || 0;
    const change = paid - total;
    const due    = total - paid;

    document.getElementById('change_amount').value =
        change >= 0 ? '₱' + change.toFixed(2) : '₱0.00';

    if (due > 0 && document.getElementById('payment_status').value === 'partial') {
        document.getElementById('due_amount').value = '₱' + due.toFixed(2);
    } else {
        if (document.getElementById('due_amount'))
            document.getElementById('due_amount').value = '₱0.00';
    }
}

/* ── Init ─────────────────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', () => calculateTotals());

/* ── Session alerts ───────────────────────────────────────── */
@if(session('message'))
@php
    $swalType  = session('alert-type', 'info');
    $swalTitle = $swalType === 'success' ? 'Success!' : ($swalType === 'error' ? 'Error!' : 'Info');
    $swalText  = session('message');
@endphp
Swal.fire({
    icon:  "{{ $swalType }}",
    title: "{{ $swalTitle }}",
    text:  "{{ $swalText }}",
    toast: true, position: 'top-end',
    showConfirmButton: false, timer: 3000, timerProgressBar: true,
    background: SWAL_BG, customClass: SWAL_CLASS,
});
@endif
</script>
@endsection