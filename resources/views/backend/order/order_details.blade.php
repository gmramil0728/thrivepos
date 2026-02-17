@extends('admin_dashboard')
@section('admin')

{{-- Use POS Fonts --}}
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">

<style>
/* ── POS Unified Design System ────────────────────────── */
:root {
    --pos-bg: #f8fafc; --pos-card: #ffffff;
    --ink: #0f172a; --ink-light: #64748b;
    --primary: #4f46e5; --green: #10b981; --red: #ef4444; --amber: #f59e0b;
    --line: #e2e8f0; --shadow: 0 4px 12px rgba(0,0,0,0.03);
    --radius: 12px;
}

.pos-wrap { font-family: 'DM Sans', sans-serif; background: var(--pos-bg); min-height: 100vh; padding: 25px; color: var(--ink); }

/* ── UI Components ────────────────────────────────────── */
.pos-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
.invoice-badge { font-family: 'DM Mono'; background: #e0e7ff; color: #4338ca; padding: 6px 14px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; }

.pos-card { background: var(--pos-card); border-radius: var(--radius); border: 1px solid var(--line); box-shadow: var(--shadow); margin-bottom: 24px; overflow: hidden; }
.card-label { font-size: 0.7rem; text-transform: uppercase; color: var(--ink-light); letter-spacing: 0.05em; font-weight: 800; margin-bottom: 4px; }

/* ── Customer & Financials ─────────────────────────────── */
.customer-hero { padding: 24px; display: flex; align-items: center; gap: 15px; background: linear-gradient(to right, #ffffff, #f8fafc); }
.customer-avatar { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid #fff; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }

.summary-item { padding: 18px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
.summary-item:last-child { border-bottom: none; }
.summary-value { font-weight: 700; font-size: 1.05rem; }

/* ── Table Styling ────────────────────────────────────── */
.pos-table { width: 100%; border-collapse: collapse; }
.pos-table th { background: #f8fafc; padding: 14px 20px; text-align: left; font-size: 11px; color: var(--ink-light); text-transform: uppercase; letter-spacing: 0.03em; border-bottom: 1px solid var(--line); }
.pos-table td { padding: 16px 20px; border-bottom: 1px solid #f8fafc; vertical-align: middle; }

/* ── Status Badges ────────────────────────────────────── */
.status-pill { padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 800; text-transform: uppercase; }
.pill-paid { background: #dcfce7; color: #15803d; }
.pill-due { background: #fee2e2; color: #b91c1c; }
.pill-partial { background: #fef3c7; color: #92400e; }

/* ── Modal (Same as POS Checkout) ─────────────────────── */
.pos-modal .modal-header { background: #1e293b; color: white; border: none; }
.pos-modal-summary { background: #f8fafc; padding: 20px; border-radius: 10px; border: 1px solid var(--line); }
.pos-pay-method-tile { border: 2px solid var(--line); padding: 15px; border-radius: 10px; text-align: center; cursor: pointer; transition: 0.2s; font-weight: 600; }
.pos-pay-method-input:checked + .pos-pay-method-tile { border-color: var(--primary); background: #eef2ff; color: var(--primary); }
</style>

<div class="pos-wrap">
    <div class="container-fluid">
        
        {{-- Header --}}
        <div class="pos-header">
            <div>
                <h4 class="mb-1 fw-bold">Order Management</h4>
                <span class="invoice-badge">Reference: #{{ $order->invoice_no }}</span>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pending.order') }}" class="btn btn-white border shadow-sm px-4" style="border-radius: 8px;">
                    <i class="fas fa-chevron-left me-2"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            {{-- Left Column: Product Items & History --}}
            <div class="col-lg-8">
                
                {{-- Items Table --}}
                <div class="pos-card">
                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-box-open me-2 text-primary"></i> Order Items</h6>
                        <span class="badge bg-soft-primary text-primary">{{ $orderItem->count() }} Items</span>
                    </div>
                    <table class="pos-table">
                        <thead>
                            <tr>
                                <th>Product Details</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderItem as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($item->product->product_image) }}" class="rounded me-3" width="48" height="48" style="object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $item->product->product_name }}</div>
                                            <small class="text-muted">{{ $item->product->product_code }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-medium">₱{{ number_format($item->product->selling_price, 2) }}</td>
                                <td class="fw-bold text-center" style="width: 80px;">{{ $item->quantity }}</td>
                                <td class="text-end fw-bold">₱{{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Payment History (Ledger) --}}
                <div class="pos-card">
                    <div class="p-3 border-bottom bg-light">
                        <h6 class="mb-0 fw-bold"><i class="fas fa-receipt me-2 text-primary"></i> Payment Timeline</h6>
                    </div>
                    <table class="pos-table">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Method</th>
                                <th class="text-end">Amount Paid</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->payments as $payment)
                            <tr>
                                <td class="text-muted small">{{ $payment->paid_at->format('M d, Y • h:i A') }}</td>
                                <td>
                                    <span class="badge bg-light text-dark text-uppercase" style="font-size: 10px;">
                                        <i class="fas fa-wallet me-1 text-primary"></i> {{ $payment->payment_method }}
                                    </span>
                                </td>
                                <td class="text-end fw-bold text-success">+ ₱{{ number_format($payment->amount, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted small">No payments recorded yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Right Column: Customer & Actions --}}
            <div class="col-lg-4">
                
                {{-- Customer Profile --}}
                <div class="pos-card">
                    <div class="customer-hero">
                        <img src="{{ (!empty($order->customer->image)) ? asset($order->customer->image) : asset('upload/no_image.jpg') }}" class="customer-avatar">
                        <div>
                            <div class="card-label">Customer</div>
                            <h6 class="mb-0 fw-bold text-primary">{{ $order->customer->name ?? 'Walk-in' }}</h6>
                            <small class="text-muted">{{ $order->customer->phone }}</small>
                        </div>
                    </div>
                </div>

                {{-- Financial Summary --}}
                <div class="pos-card">
                    <div class="summary-item">
                        <span class="text-muted">Payment Status</span>
                        @php
                            $statusClass = $order->payment_status == 'paid' ? 'pill-paid' : ($order->payment_status == 'partial' ? 'pill-partial' : 'pill-due');
                        @endphp
                        <span class="status-pill {{ $statusClass }}">{{ $order->payment_status }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="text-muted">Grand Total</span>
                        <span class="summary-value">₱{{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="summary-item">
                        <span class="text-muted">Total Paid</span>
                        <span class="summary-value text-success">₱{{ number_format($order->pay, 2) }}</span>
                    </div>
                    <div class="summary-item bg-light">
                        <span class="fw-bold">Balance Due</span>
                        <span class="summary-value {{ $order->due > 0 ? 'text-danger' : 'text-success' }}">
                            ₱{{ number_format($order->due, 2) }}
                        </span>
                    </div>

                    <div class="p-3">
                        @if($order->due > 0)
                            <button class="btn btn-primary w-100 py-2 fw-bold mb-2" data-bs-toggle="modal" data-bs-target="#settleDueModal" onclick="orderDue({{ $order->id }})">
                                <i class="fas fa-cash-register me-2"></i> Process Payment
                            </button>
                        @endif

                        @if($order->order_status !== 'complete' && $order->due <= 0)
                            <form action="{{ route('order.status.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $order->id }}">
                                <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
                                    <i class="fas fa-check-circle me-2"></i> Mark as Fulfilled
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- ── Settlement Modal (Compact View) ────────────────────────── --}}
<div class="modal fade pos-modal" id="settleDueModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered"> {{-- Standard width is better for short screens --}}
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header py-2 px-3">
                <h6 class="modal-title fw-bold">Payment Settlement</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('update.due') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="order_id">
                {{-- Hidden input since we are paying the full amount --}}
                <input type="hidden" name="pay" id="amount_paid"> 
                
                <div class="modal-body p-3">
                    
                    {{-- 1. Payment Method Selection (Slimmed down) --}}
                    <div class="mb-3">
                        <label class="card-label mb-2">Payment Method</label>
                        <div class="row g-2">
                            <div class="col-4">
                                <input type="radio" class="pos-pay-method-input" name="payment_method" id="m-cash" value="cash" checked onchange="toggleCashFields()">
                                <label class="pos-pay-method-tile w-100 py-2" for="m-cash">Cash</label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="pos-pay-method-input" name="payment_method" id="m-gcash" value="gcash" onchange="toggleCashFields()">
                                <label class="pos-pay-method-tile w-100 py-2" for="m-gcash">GCash</label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="pos-pay-method-input" name="payment_method" id="m-card" value="card" onchange="toggleCashFields()">
                                <label class="pos-pay-method-tile w-100 py-2" for="m-card">Card</label>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Massive Outstanding Amount --}}
                    <div class="pos-modal-summary mb-3 text-center p-3" style="background: #fff5f5; border-color: #feb2b2; border-radius: 12px;">
                        <div class="card-label text-danger mb-0">Total Amount Due</div>
                        <div class="d-block">
                            <span class="fw-800 text-danger" id="modal-due-amount" style="font-family: 'DM Mono', monospace; font-size: 2.8rem; letter-spacing: -2px;">
                                ₱0.00
                            </span>
                        </div>
                    </div>

                    {{-- 3. Cash Calculator (More compact) --}}
                    <div id="cash_calc_area">
                        <div class="p-3 bg-light rounded-3 border mb-3">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <label class="card-label">Cash Tendered</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white py-1">₱</span>
                                        <input type="number" name="cash_received" id="cash_received" class="form-control form-control-sm fw-bold" placeholder="0.00" onkeyup="calculateSettlementChange()">
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="card-label d-block">Change Due</span>
                                    <span id="change_due_display" class="fs-3 fw-800 text-primary">₱0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- 4. Status Bar (Very slim) --}}
                    <div class="d-flex justify-content-between align-items-center px-1">
                        <label class="card-label m-0 text-muted">Balance After Payment</label>
                        <input type="text" id="remaining_due_display" class="fw-bold border-0 p-0 text-end" readonly style="background: transparent; width: 120px; font-size: 1.1rem;">
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 px-3 pb-3">
                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow fw-bold" style="border-radius: 10px;">
                        Complete Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('jscripts')
<script type="text/javascript">
    let currentOrderDue = 0;

    function orderDue(id) {
        $.ajax({
            type: 'GET',
            url: '/order/due/' + id,
            dataType: 'json',
            success: function(data) {
                currentOrderDue = parseFloat(data.due);
                
                // Set hidden and visible fields
                $('#order_id').val(data.id);
                $('#amount_paid').val(currentOrderDue); // Automatically set to full due
                
                // Update massive display
                $('#modal-due-amount').text('₱' + currentOrderDue.toLocaleString(undefined, {minimumFractionDigits: 2}));
                
                // Reset inputs
                $('#cash_received').val('').focus();
                $('#change_due_display').text('₱0.00');
                
                // Balance after full payment is always 0
                $('#remaining_due_display').val('₱0.00').css('color', 'var(--green)');
                
                toggleCashFields();
            }
        });
    }

    function toggleCashFields() {
        const method = $('input[name="payment_method"]:checked').val();
        if (method === 'cash') {
            $('#cash_calc_area').show();
        } else {
            $('#cash_calc_area').hide();
        }
    }

    function calculateSettlementChange() {
        const cashReceived = parseFloat($('#cash_received').val()) || 0;
        
        // Change is Cash - Total Due (since pay is now always Total Due)
        const changeDue = cashReceived - currentOrderDue;
        const finalChangeVal = changeDue > 0 ? changeDue : 0;

        $('#change_due_display').text('₱' + finalChangeVal.toLocaleString(undefined, {minimumFractionDigits: 2}));
    }
</script>
@endsection