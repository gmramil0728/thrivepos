<!DOCTYPE html>
<html>
<head>
    <title>Expense Report</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 30px; }
        .year-section { background: #f4f4f4; padding: 8px; font-weight: bold; font-size: 16px; margin-top: 20px; border-left: 4px solid #4f46e5; }
        .month-header { background: #f9f9f9; padding: 5px 10px; margin: 10px 0; border-bottom: 1px solid #ddd; }
        .month-total { float: right; color: #4f46e5; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th { text-align: left; border-bottom: 2px solid #eee; padding: 8px; color: #666; }
        td { padding: 8px; border-bottom: 1px solid #eee; }
        .text-right { text-align: right; }
        .grand-total { margin-top: 30px; text-align: right; font-size: 18px; font-weight: bold; border-top: 2px solid #333; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Expense Report</h1>
        <p>Generated on: {{ date('M d, Y') }}</p>
    </div>

    @foreach($groupedData as $year => $months)
    <div class="year-section">FISCAL YEAR: {{ $year }}</div>

    @foreach($months as $month => $items)
            <div class="month-header">
                <strong>{{ strtoupper($month) }}</strong>
                <span class="month-total">Monthly Total: ₱{{ number_format($items->sum('amount'), 2) }}</span>
            </div>
            <table>
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Date</th>
                        <th width="20%">Ref No.</th>
                        <th width="40%">Description</th>
                        <th width="20%" class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ date('d-M-Y', strtotime($item->date)) }}</td>
                        <td><code style="color: #444;">{{ $item->reference_no ?? '---' }}</code></td>
                        <td>{{ $item->details }}</td>
                        <td class="text-right">₱{{ number_format($item->amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @endforeach

    <div class="grand-total">
        Grand Total: ₱{{ number_format($totalAmount, 2) }}
    </div>
</body>
</html>