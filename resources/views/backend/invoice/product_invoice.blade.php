<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ 'INV-' . date('YmdHis') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .total-row.tax {
            background: #e7f3ff;
            font-size: 14px;
        }

        .total-row.grand-total {
            background: #0d6efd;
            color: white;
            font-size: 20px;
            font-weight: bold;
            border: none;
        }

        .footer {
            margin-top: 80px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            text-align: center;
            color: #6c757d;
        }

        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            text-align: center;
            width: 250px;
        }

        .signature-line {
            border-top: 2px solid #000;
            margin-top: 50px;
            padding-top: 5px;
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
                    <p class="mb-1"><strong>Invoice #:</strong> {{ 'INV-' . date('YmdHis') }}</p>
                    <p class="mb-1"><strong>Date:</strong> {{ date('F d, Y') }}</p>
                    <p class="mb-0"><strong>Time:</strong> {{ date('h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <h5 class="mb-3">Bill To:</h5>
                    <p class="mb-1"><strong>{{ $customer->name }}</strong></p>
                    @if($customer->email)
                    <p class="mb-1">{{ $customer->email }}</p>
                    @endif
                    @if($customer->phone)
                    <p class="mb-1">Phone: {{ $customer->phone }}</p>
                    @endif
                    @if($customer->address)
                    <p class="mb-0">{{ $customer->address }}</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <h5 class="mb-3">Payment Info:</h5>
                    <p class="mb-1"><strong>Payment Method:</strong> Cash</p>
                    <p class="mb-1"><strong>Cashier:</strong> {{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="mb-0"><strong>Status:</strong> <span class="badge bg-success">Paid</span></p>
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
                @foreach($contents as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>
                        <strong>{{ $item->name }}</strong>
                        @if($item->options->code)
                        <br><small class="text-muted">Code: {{ $item->options->code }}</small>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td class="text-end">₱{{ number_format($item->price, 2) }}</td>
                    <td class="text-end"><strong>₱{{ number_format($item->price * $item->qty, 2) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals Section -->
        <div class="totals-section">
            <div class="total-row subtotal">
                <span>Subtotal:</span>
                <span><strong>₱{{ number_format($subtotal, 2) }}</strong></span>
            </div>

            @if($discountAmount > 0)
            <div class="total-row discount">
                <span>
                    Discount 
                    @if($discountType == 'percent')
                    ({{ $discountValue }}%)
                    @endif
                    :
                </span>
                <span><strong>-₱{{ number_format($discountAmount, 2) }}</strong></span>
            </div>
            @endif

            @if($taxType === 'vatable')
            <div class="total-row tax">
                <span>VATable Sales:</span>
                <span>₱{{ number_format($vatableSales, 2) }}</span>
            </div>
            <div class="total-row tax">
                <span>VAT (12%):</span>
                <span>₱{{ number_format($vatAmount, 2) }}</span>
            </div>
            @elseif($taxType === 'zero-rated')
            <div class="total-row tax">
                <span>Zero-Rated Sales:</span>
                <span>₱{{ number_format($total, 2) }}</span>
            </div>
            @elseif($taxType === 'vat-exempt')
            <div class="total-row tax">
                <span>VAT-Exempt Sales:</span>
                <span>₱{{ number_format($total, 2) }}</span>
            </div>
            @endif

            <div class="total-row grand-total">
                <span>TOTAL AMOUNT DUE:</span>
                <span>₱{{ number_format($total, 2) }}</span>
            </div>
        </div>

        <div style="clear: both;"></div>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line">Customer Signature</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Authorized Signature</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="mb-2"><strong>Terms & Conditions</strong></p>
            <p class="mb-1" style="font-size: 14px;">Payment is due within 30 days. Please make checks payable to: YOUR COMPANY NAME</p>
            <p style="font-size: 14px;">Thank you for your business!</p>
            <br>
            <p style="font-size: 12px;" class="text-muted">This is a computer-generated invoice and is valid without signature.</p>
        </div>

    </div>

    <script>
        // Auto-print option (uncomment if you want auto-print)
        // window.onload = function() { window.print(); }
    </script>

</body>
</html>
