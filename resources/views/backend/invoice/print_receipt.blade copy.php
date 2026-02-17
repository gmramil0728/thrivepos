<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $order->invoice_no }}</title>
    <style>
        @media print {
            @page {
                width: 80mm;
                margin: 0;
            }
            body {
                width: 80mm;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            width: 80mm;
            padding: 5mm;
            font-size: 12px;
            line-height: 1.4;
        }

        .center {
            text-align: center;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            font-size: 18px;
            margin: 5px 0;
        }

        .header p {
            font-size: 11px;
            margin: 2px 0;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .double-divider {
            border-top: 2px solid #000;
            margin: 8px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 11px;
        }

        .items-table {
            width: 100%;
            margin: 10px 0;
        }

        .items-table th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding: 3px 0;
            font-size: 11px;
        }

        .items-table td {
            padding: 3px 0;
            font-size: 11px;
        }

        .item-name {
            width: 60%;
        }

        .item-qty {
            width: 10%;
            text-align: center;
        }

        .item-price {
            width: 15%;
            text-align: right;
        }

        .item-total {
            width: 15%;
            text-align: right;
        }

        .totals {
            margin-top: 10px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 11px;
        }

        .grand-total {
            font-size: 14px;
            font-weight: bold;
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 11px;
        }

        .payment-section {
            margin-top: 10px;
            font-size: 11px;
            background: #f0f0f0;
            padding: 8px;
        }

        @media print {
            button {
                display: none;
            }
        }

        .print-btn {
            margin: 10px auto;
            display: block;
            padding: 10px 20px;
            background: #000;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
    </style>
</head>
<body>
    {{-- <button class="print-btn" onclick="window.print()">Print Receipt</button> --}}

    <!-- Header -->
    <div class="header">
        <h2>THRIVE ICT SOLUTIONS CORP</h2>
        <p>Pasay City</p>
        <p>Tel: (123) 456-7890</p>
        <p>TIN: 000-000-000-000</p>
    </div>

    <div class="divider"></div>

    <!-- Receipt Info -->
    <div class="info-row">
        <span>Receipt #:</span>
        <span class="bold">{{ $order->invoice_no }}</span>
    </div>
    <div class="info-row">
        <span>Date:</span>
        <span>{{ date('M d, Y h:i A', strtotime($order->created_at)) }}</span>
    </div>
    <div class="info-row">
        <span>Cashier:</span>
        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
    </div>

    <div class="divider"></div>

    <!-- Customer Info -->
    <div class="info-row">
        <span>Customer:</span>
        <span class="bold">{{ $order->customer->name }}</span>
    </div>
    @if($order->customer->phone)
    <div class="info-row">
        <span>Phone:</span>
        <span>{{ $order->customer->phone }}</span>
    </div>
    @endif
    <div class="divider"></div>

    <!-- Items -->
    <table class="items-table">
        <thead>
            <tr>
                <th class="item-name">Item</th>
                <th class="item-qty">Qty</th>
                <th class="item-price">Price</th>
                <th class="item-total">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderItems as $item)
            <tr>
                <td class="item-name">{{ $item->product->product_name }}</td>
                <td class="item-qty">{{ $item->quantity }}</td>
                <td class="item-price">{{ number_format($item->unitcost, 2) }}</td>
                <td class="item-total">{{ number_format($item->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <!-- Totals -->
    <div class="totals">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>₱{{ number_format($order->sub_total, 2) }}</span>
        </div>

        @if($order->discount_amount > 0)
        <div class="total-row">
            <span>Discount:</span>
            <span>-₱{{ number_format($order->discount_amount, 2) }}</span>
        </div>
        @endif

        @if($order->vat > 0)
        <div class="total-row">
            <span>VAT (12%):</span>
            <span>₱{{ number_format($order->vat, 2) }}</span>
        </div>
        @endif

        <div class="double-divider"></div>

        <div class="total-row grand-total">
            <span>TOTAL AMOUNT:</span>
            <span>₱{{ number_format($order->total, 2) }}</span>
        </div>
    </div>

    <!-- Payment Info -->
    <div class="payment-section">
        <div class="total-row">
            <span>Payment Method:</span>
            <span class="bold">{{ strtoupper($order->payment_method ?? 'CASH') }}</span>
        </div>
        <div class="total-row">
            <span>Amount Paid:</span>
            <span class="bold">₱{{ number_format($order->pay, 2) }}</span>
        </div>
        @if($order->due > 0)
        <div class="total-row">
            <span>Due Amount:</span>
            <span class="bold">₱{{ number_format($order->due, 2) }}</span>
        </div>
        @else
        <div class="total-row">
            <span>Change:</span>
            <span class="bold">₱{{ number_format($order->pay - $order->total, 2) }}</span>
        </div>
        @endif
        <div class="total-row">
            <span>Status:</span>
            <span class="bold">{{ strtoupper($order->payment_status) }}</span>
        </div>
    </div>

    <div class="double-divider"></div>

    <!-- Footer -->
    <div class="footer">
        <p class="bold">Thank you for your purchase!</p>
        <p>Please come again</p>
        <br>
        <p style="font-size: 10px;">This serves as your official receipt</p>
        <p style="font-size: 10px;">{{ date('M d, Y h:i:s A') }}</p>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        };

        // Close window after printing
        window.onafterprint = function() {
            setTimeout(function() {
                // window.close();
                window.location.href = "{{ route('pos') }}";
            }, 1000);
        };
    </script>


</body>
</html>
