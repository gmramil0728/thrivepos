<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $order->invoice_no ?? '0000' }}</title>
    <style>
        @media print {
            @page { width: 80mm; margin: 0; }
            body { width: 80mm; padding: 5mm; }
            .no-print { display: none; }
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 80mm;
            padding: 4mm;
            font-size: 11px;
            color: #000;
            line-height: 1.2;
        }

        .center { text-align: center; }
        .bold { font-weight: bold; }
        .text-uppercase { text-transform: uppercase; }

        /* Header Styling */
        .header { margin-bottom: 8px; }
        .header .logo-text { font-size: 16px; margin-bottom: 2px; display: block; }
        .header p { font-size: 10px; }

        .divider { border-top: 1px dashed #000; margin: 6px 0; }
        .double-divider { border-top: 1px double #000; margin: 6px 0; height: 3px; border-bottom: 1px solid #000; }

        .info-row { display: flex; justify-content: space-between; margin-bottom: 2px; }

        /* Table Styling */
        .items-table { width: 100%; border-collapse: collapse; margin: 8px 0; }
        .items-table th { 
            text-align: left; 
            border-bottom: 1px solid #000; 
            padding-bottom: 4px; 
            font-size: 10px; 
            text-transform: uppercase;
        }
        .items-table td { padding: 4px 0; vertical-align: top; }

        .item-desc { width: 50%; }
        .item-qty { width: 10%; text-align: center; }
        .item-price { width: 20%; text-align: right; }
        .item-total { width: 20%; text-align: right; }

        /* Totals Styling */
        .totals-container { margin-top: 4px; }
        .total-row { display: flex; justify-content: space-between; margin-bottom: 2px; }
        .grand-total { font-size: 13px; margin: 4px 0; border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 4px 0; }

        /* Payment Section */
        .payment-box { 
            background-color: #f9f9f9; 
            border: 1px solid #eee; 
            padding: 6px; 
            margin: 8px 0; 
            border-radius: 2px;
        }

        .footer { margin-top: 15px; font-size: 10px; }
        .print-btn {
            background: #444; color: #fff; border: none; padding: 8px 15px;
            border-radius: 4px; cursor: pointer; margin: 10px auto; display: block;
        }
    </style>
</head>
<body>

    {{-- <button class="print-btn no-print" onclick="window.print()">Manual Print</button> --}}

    <div class="header center">
        <span class="logo-text bold text-uppercase">THRIVE ICT SOLUTIONS CORP</span>
        <p>Pasay City, Philippines</p>
        <p>Tel: (123) 456-7890 | TIN: 000-000-000-000</p>
    </div>

    <div class="divider"></div>

    <div class="info-row">
        <span>Invoice:</span>
        <span class="bold">#{{ $order->invoice_no ?? 'N/A' }}</span>
    </div>
    <div class="info-row">
        <span>Date:</span>
        <span>{{ $order->created_at ? date('d M Y h:i A', strtotime($order->created_at)) : date('d M Y h:i A') }}</span>
    </div>
    <div class="info-row">
        <span>Cashier:</span>
        <span class="text-uppercase">{{ Auth::user()->name ?? 'System Admin' }}</span>
    </div>

    <div class="divider"></div>

    <div class="info-row">
        <span>Customer:</span>
        <span class="bold text-uppercase">{{ $order->customer->name ?? 'WALK-IN CUSTOMER' }}</span>
    </div>
    @if(!empty($order->customer->phone))
    <div class="info-row">
        <span>Phone:</span>
        <span>{{ $order->customer->phone }}</span>
    </div>
    @endif

    <div class="divider"></div>

    <table class="items-table">
        <thead>
            <tr>
                <th class="item-desc">Item</th>
                <th class="item-qty">Qty</th>
                <th class="item-price">Price</th>
                <th class="item-total">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orderItems as $item)
            <tr>
                <td class="item-desc text-uppercase">{{ $item->product->product_name ?? 'Product Deleted' }}</td>
                <td class="item-qty">{{ $item->quantity ?? 0 }}</td>
                <td class="item-price">{{ number_format($item->unitcost ?? 0, 2) }}</td>
                <td class="item-total">{{ number_format($item->total ?? 0, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="center">No items in this order.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="divider"></div>

    <div class="totals-container">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>₱{{ number_format($order->sub_total ?? 0, 2) }}</span>
        </div>

        @if(($order->discount_amount ?? 0) > 0)
        <div class="total-row">
            <span>Discount:</span>
            <span>-₱{{ number_format($order->discount_amount, 2) }}</span>
        </div>
        @endif

        @if(($order->vat ?? 0) > 0)
        <div class="total-row">
            <span>VAT (12%):</span>
            <span>₱{{ number_format($order->vat, 2) }}</span>
        </div>
        @endif

        <div class="total-row grand-total bold">
            <span>TOTAL AMOUNT:</span>
            <span>₱{{ number_format($order->total ?? 0, 2) }}</span>
        </div>
    </div>

    <div class="payment-box">
        <div class="total-row">
            <span>Method:</span>
            <span class="bold text-uppercase">{{ $order->payment_method ?? 'CASH' }}</span>
        </div>
        <div class="total-row">
            <span>Tendered:</span>
            <span class="bold">₱{{ number_format($order->pay ?? 0, 2) }}</span>
        </div>
        
        @if(($order->due ?? 0) > 0)
            <div class="total-row" style="color: #d00;">
                <span>Balance Due:</span>
                <span class="bold">₱{{ number_format($order->due, 2) }}</span>
            </div>
        @else
            <div class="total-row">
                <span>Change:</span>
                <span class="bold">₱{{ number_format(($order->pay ?? 0) - ($order->total ?? 0), 2) }}</span>
            </div>
        @endif

        <div class="total-row">
            <span>Status:</span>
            <span class="bold text-uppercase">{{ $order->payment_status ?? 'PENDING' }}</span>
        </div>
    </div>

    <div class="double-divider"></div>

    <div class="footer center">
        <p class="bold">THANK YOU FOR YOUR PURCHASE!</p>
        <p>This is your Official Receipt</p>
        <p>No Return / No Exchange</p>
        <div style="margin-top: 8px;">
            <p>{{ date('Y-m-d H:i:s') }}</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };

        window.onafterprint = function() {
            // Optional: Redirect back to POS after printing is done/cancelled
            window.location.href = "{{ route('pos') }}";
        };
    </script>

</body>
</html>