<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->invoice_no }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
            @page {
                margin: 0.5cm;
            }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .invoice-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .invoice-header {
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-info h2 {
            color: #0d6efd;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .invoice-title {
            font-size: 48px;
            font-weight: bold;
            color: #0d6efd;
        }

        .badge-paid {
            background: #28a745;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
        }

        .badge-partial {
            background: #ffc107;
            color: #000;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
        }

        .badge-due {
            background: #dc3545;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
        }

        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .items-table {
            margin-top: 30px;
        }

        .items-table th {
            background: #0d6efd;
            color: white;
            padding: 12px;
        }

        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .totals-section {
            margin-top: 30px;
            float: right;
            width: 400px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .total-row.subtotal {
            background: #f8f9fa;
        }

        .total-row.discount {
            background: #fff3cd;
            color: #856404;
        }

        .total-row.grand-total {
            background: #0d6efd;
            color: white;
            font-size: 20px;
            font-weight: bold;
            border: none;
        }

        .payment-info {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            border-left: 4px solid #0d6efd;
        }

        .footer {
            margin-top: 80px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Print Invoice
        </button>
        <a href="{{ route('pos') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to POS
        </a>
        <a href="{{ route('dashboard') }}" class="btn btn-info">
            <i class="fas fa-home"></i> Dashboard
        </a>
    </div>

    <div class="invoice-container">
        
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="row">
                <div class="col-md-6 company-info">
                    <h2>YOUR COMPANY NAME</h2>
                    <p class="mb-1">123 Business Street, City, State 12345</p>
                    <p class="mb-1">Phone: (123) 456-7890</p>
                    <p class="mb-1">Email: info@yourcompany.com</p>
                    <p class="mb-0"><strong>TIN:</strong> 000-000-000-000</p>
                </div>
                <div class="col-md-6 text-end">
                    <div class="invoice-title">INVOICE</div>
                    <p class="mb-1"><strong>Invoice #:</strong> {{ $order->invoice_no }}</p>
                    <p class="mb-1"><strong>Date:</strong> {{ date('F d, Y', strtotime($order->order_date)) }}</p>
                    <p class="mb-1"><strong>Status:</strong> 
                        @if($order->payment_status == 'paid')
                            <span class="badge-paid">PAID</span>
                        @elseif($order->payment_status == 'partial')
                            <span class="badge-partial">PARTIAL</span>
                        @else
                            <span class="badge-due">DUE</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <h5 class="mb-3">Bill To:</h5>
                    <p class="mb-1"><strong>{{ $order->customer->name }}</strong></p>
                    @if($order->customer->email)
                    <p class="mb-1">{{ $order->customer->email }}</p>
                    @endif
                    @if($order->customer->phone)
                    <p class="mb-1">Phone: {{ $order->customer->phone }}</p>
                    @endif
                    @if($order->customer->address)
                    <p class="mb-0">{{ $order->customer->address }}</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="payment-info">
                    <h5 class="mb-3">Payment Information:</h5>
                    <p class="mb-1"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method ?? 'Cash') }}</p>
                    <p class="mb-1"><strong>Amount Paid:</strong> ₱{{ number_format($order->pay, 2) }}</p>
                    @if($order->due > 0)
                    <p class="mb-0 text-danger"><strong>Due Amount:</strong> ₱{{ number_format($order->due, 2) }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="table items-table">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 45%;">Item Description</th>
                    <th style="width: 15%;" class="text-center">Quantity</th>
                    <th style="width: 15%;" class="text-end">Unit Price</th>
                    <th style="width: 20%;" class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderItems as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <strong>{{ $item->product->product_name }}</strong>
                        @if($item->product->product_code)
                        <br><small class="text-muted">Code: {{ $item->product->product_code }}</small>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">₱{{ number_format($item->unitcost, 2) }}</td>
                    <td class="text-end"><strong>₱{{ number_format($item->total, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals Section -->
        <div class="totals-section">
            <div class="total-row subtotal">
                <span>Subtotal:</span>
                <span><strong>₱{{ number_format($order->sub_total, 2) }}</strong></span>
            </div>

            @if($order->discount_amount > 0)
            <div class="total-row discount">
                <span>
                    Discount 
                    @if($order->discount_type == 'percent')
                    ({{ $order->discount_value }}%)
                    @endif
                    :
                </span>
                <span><strong>-₱{{ number_format($order->discount_amount, 2) }}</strong></span>
            </div>
            @endif

            @if($order->vat > 0)
            <div class="total-row">
                <span>VAT (12%):</span>
                <span>₱{{ number_format($order->vat, 2) }}</span>
            </div>
            @endif

            <div class="total-row grand-total">
                <span>TOTAL AMOUNT:</span>
                <span>₱{{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <div style="clear: both;"></div>

        <!-- Footer -->
        <div class="footer">
            <p class="mb-2"><strong>Thank you for your business!</strong></p>
            <p class="mb-1" style="font-size: 14px;">Payment is due within 30 days</p>
            <p style="font-size: 12px;" class="text-muted">This is a computer-generated invoice and is valid without signature.</p>
        </div>

    </div>

    <script>
        // Auto-print option (uncomment if you want auto-print)
        // window.onload = function() { window.print(); }
    </script>

</body>
</html>
