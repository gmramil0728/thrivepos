<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .report-title { font-size: 18px; font-weight: bold; text-transform: uppercase; margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f2f2f2; border: 1px solid #ccc; padding: 8px; text-align: left; }
        td { border: 1px solid #eee; padding: 8px; }
        .text-end { text-align: right; }
        .footer { margin-top: 30px; }
        .summary-box { float: right; width: 250px; margin-top: 20px; border: 1px solid #000; padding: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h2 style="margin:0;">{{ $company->name }}</h2>
        <p style="margin:0;">{{ $company->address }}</p>
        <div class="report-title">Payroll Register Report</div>
        <span>Period: <strong>{{ $reportPeriod }}</strong></span>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th>Employee Name</th>
                <th>Reference</th>
                <th>Method</th>
                <th>Month/Year</th>
                <th class="text-end">Basic Salary</th>
                <th class="text-end">Advance</th>
                <th class="text-end">Net Paid</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paidsalary as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->employee->name }}</td>
                <td><code>{{ $item->transaction_id }}</code></td>
                <td>{{ $item->payment_method }}</td>
                <td>{{ $item->salary_month }} {{ $item->salary_year }}</td>
                <td class="text-end">&#8369;{{ number_format($item->basic_salary, 2) }}</td>
                <td class="text-end text-danger">&#8369;{{ number_format($item->advance_salary, 2) }}</td>
                <td class="text-end fw-bold">&#8369;{{ number_format($item->paid_amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box">
        <table style="border:none;">
            <tr>
                <td style="border:none;"><strong>Total Employees:</strong></td>
                <td style="border:none;" class="text-end">{{ $paidsalary->count() }}</td>
            </tr>
            <tr style="font-size: 14px; font-weight: bold;">
                <td style="border:none;">GRAND TOTAL:</td>
                <td style="border:none;" class="text-end text-primary">&#8369;{{ number_format($totalAmount, 2) }}</td>
            </tr>
        </table>
    </div>

</body>
</html>