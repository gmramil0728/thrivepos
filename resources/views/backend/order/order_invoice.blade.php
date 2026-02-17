<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sales Invoice - {{ $order->invoice_no ?? 'Draft' }}</title>

    <style type="text/css">
        /* Professional Reset & Typography */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            color: #333; 
            line-height: 1.5; 
            margin: 0; 
            padding: 20px; 
            background-color: #f4f7f9;
        }
        
        /* .invoice-box {
            max-width: 850px;
            margin: auto;
            padding: 30px;
            border: 1px solid #e1e8ed;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        } */

        /* Header Section */
        .header-table { 
            width: 100%; 
            border-bottom: 1px solid rgb(13, 88, 213); 
            padding-bottom: 5px; 
        }
        
        /* Logo Styling */
        .logo {
            max-width: 100px;
            height: auto;
            /* margin-bottom: 10px; */
            padding-right: 5px;
        }

        .brand { 
            color: rgb(13, 88, 213); 
            font-size: 20px; 
            font-weight: bold; 
            margin: 0; 
            text-transform: uppercase;
        }
        
        .company-details { 
            margin: 0; 
            padding: 0px;
            text-align: left; 
            font-size: 9px; 
            color: #555; 
        }

        /* Document Title */
        .doc-title-container { 
            text-align: center; 
            margin: 15px 0; 
            background-color: rgba(13, 88, 213, 0.05); 
            /* padding: 6px; */
            border-radius: 4px;
        }
        .doc-title { 
            margin: 0; 
            font-size: 20px; 
            letter-spacing: 4px; 
            font-weight: bold; 
            color: rgb(13, 88, 213); 
        }

        /* Information Grid */
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { vertical-align: top; width: 50%; }
        .label { font-size: 10px; text-transform: uppercase; color: #7b8a97; font-weight: bold; display: block; margin-bottom: 3px; }
        .value { font-size: 14px; margin: 0; color: #2c3e50; }

        /* Product Table */
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table thead { background-color: #555; color: white; }
        .items-table th { padding: 12px 5px; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; }
        .items-table td { padding: 1px 5px; border-bottom: 1px solid #edf2f7; font-size: 13px; }
        
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Calculation Section */
        .summary-container { margin-top: 30px; width: 100%; display: table; }
        .summary-left { display: table-cell; width: 55%; vertical-align: bottom; font-size: 11px; color: #718096; }
        .summary-right { display: table-cell; width: 45%; }
        
        .totals-table { width: 100%; border-collapse: collapse; }
        .totals-table td { border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        
        .grand-total { 
            font-weight: bold; 
            font-size: 18px; 
            color: rgb(13, 88, 213); 
            background-color: rgba(13, 88, 213, 0.05);
        }

        /* Footer & Signatures */
        .footer { margin-top: 60px; padding-top: 20px; border-top: 1px solid #edf2f7; }
        .signature-container { float: right; width: 220px; text-align: center; margin-top: 20px; }
        .sig-line { border-top: 2px solid #2d3748; margin-bottom: 5px; }
        
        .thanks-msg { 
            text-align: center; 
            color: rgb(13, 88, 213); 
            font-weight: bold;
            margin-top: 40px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <table class="header-table">
        <tr>
            <td>
                @if($company && $company->logo)
                    <img src="{{ public_path($company->logo) }}" class="logo" alt="Logo">
                @endif                
            </td>
            <td>
                <h5 class="brand">{{ $company->name ?? 'Thrive' }}</h5>                
                <span class="company-details">
                  Address: One E-com Centre Building, Ocean Drive Mall of Asia Complex, {{ $company->address ?? 'Company Address' }} <br>
                  Email: sales@thriveictsolutions.com | Contact: +632 76177888 (Tel)
                </span>
                <p style="margin:0; font-size: 12px; font-weight: bold; color: #718096;">VAT REG. TIN: 123-456-789-0000</p>
            </td>
        </tr>
    </table>

    <div class="doc-title-container">
        <h1 class="doc-title">SALES INVOICE</h1>
    </div>

    <table class="info-table">
        <tr>
            <td>
                <span class="label">Sold To:</span>
                @if($order && $order->customer)
                    <p class="value"><strong>{{ $order->customer->name }}</strong></p>
                    <p class="value">{{ $order->customer->shopname ?? 'Individual' }}</p>
                    <p class="value">{{ $order->customer->address ?? 'Address not provided' }}</p>
                    <p class="value">TIN: {{ $order->customer->tin ?? '________________' }}</p>
                @else
                    <p class="value" style="color:#a0aec0; font-style: italic;">General Customer / Walk-in</p>
                @endif
            </td>
            <td class="text-right">
                <span class="label">Billing Details:</span>
                <p class="value">Invoice #: <strong>{{ $order->invoice_no ?? 'N/A' }}</strong></p>
                <p class="value">Date: {{ $order->order_date ?? date('Y-m-d') }}</p>
                <p class="value">Payment: <span style="text-transform: uppercase; font-weight: bold;">{{ $order->payment_status ?? 'Unpaid' }}</span></p>
                <p class="value">Status: {{ $order->order_status ?? 'Pending' }}</p>
            </td>
        </tr>
    </table>
    <br/>

    <table class="items-table">
        <thead>
            <tr>
                <th class="text-left">Product Description</th>
                <th class="text-left">Code</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orderItem as $item)
                @php 
                    $price = (float)str_replace(',', '', $item->product->selling_price ?? 0);
                    $qty = (int)($item->quantity ?? 0);
                    $lineTotal = (float)str_replace(',', '', $item->total ?? 0);
                @endphp
                <tr>
                    <td>
                        <strong>{{ $item->product->product_name ?? 'Item Missing' }}</strong>
                    </td>
                    <td>{{ $item->product->product_code ?? '-' }}</td>
                    <td class="text-center">{{ $qty }}</td>
                    <td class="text-right">{{ number_format($price, 2) }}</td>
                    <td class="text-right">{{ number_format($lineTotal, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px; color: #a0aec0;">No products found in this order.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <hr>

    <div class="summary-container">
        <div class="summary-left">
            <p style="background: #f8fafc; padding: 10px; border-left: 4px solid rgb(13, 88, 213);">
                <strong>Terms & Conditions:</strong><br>
                1. Prices are VAT-inclusive.<br>
                2. Items can be returned/exchanged within 7 days.<br>
                3. Please present this invoice for any claims.
            </p>
        </div>
        <div class="summary-right">
            <table class="totals-table">
                @php
                    $rawTotal = (float)str_replace(',', '', (string)($order->total ?? 0));
                    $rawPay = (float)str_replace(',', '', (string)($order->pay ?? 0));
                    
                    $vatableSales = $rawTotal / 1.12;
                    $vatAmount = $rawTotal - $vatableSales;
                    $dueAmount = $rawTotal - $rawPay;
                @endphp
                <tr>
                    <td>Vatable Sales:</td>
                    <td class="text-right">{{ number_format($vatableSales, 2) }}</td>
                </tr>
                <tr>
                    <td>VAT (12%):</td>
                    <td class="text-right">{{ number_format($vatAmount, 2) }}</td>
                </tr>
                <tr class="grand-total">
                  <td><strong>TOTAL (PHP):</strong></td>
                  <td class="text-right"><strong>{{ number_format($rawTotal, 2) }}</strong></td>
                </tr>
                <tr>
                    <td>Amount Paid:</td>
                    <td class="text-right">{{ number_format($rawPay, 2) }}</td>
                </tr>
                @if($dueAmount > 0)
                <tr>
                    <td style="color:#e53e3e; font-weight: bold;">Balance Due:</td>
                    <td class="text-right" style="color:#e53e3e; font-weight: bold;">{{ number_format($dueAmount, 2) }}</td>
                </tr>
                @endif
                
            </table>
        </div>
    </div>

    <div class="footer">
        <div style="float: left; font-size: 10px; color: #a0aec0;">
            System Generated Invoice<br>
            Timestamp: {{ date('Y-m-d H:i:s') }}
        </div>
        <div class="signature-container">
            <div class="sig-line"></div>
            <p style="margin:0; font-size:12px; font-weight:bold; color: #2d3748;">Authorized Representative</p>
        </div>
        <div style="clear:both;"></div>
        {{-- <p class="thanks-msg">Thank you for your business!</p> --}}
    </div>
</div>

</body>
</html>