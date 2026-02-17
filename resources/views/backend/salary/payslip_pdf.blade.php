<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .header-table, .details-table, .earnings-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .bg-light { background-color: #f8f9fa; }
        .fw-bold { font-weight: bold; }
        .text-primary { color: #007bff; }
        
        /* The main earnings table */
        .earnings-table th { background-color: #343a40; color: white; padding: 10px; }
        .earnings-table td { padding: 10px; border-bottom: 1px solid #dee2e6; }
        
        .footer-sig { margin-top: 50px; }
        .sig-box { width: 200px; border-top: 1px solid #000; text-align: center; display: inline-block; }

        #watermark {
            position: fixed; top: 25%; left: 25%;
            opacity: 0.1; transform: rotate(-45deg);
            font-size: 100px; color: green; z-index: -1000;
        }

        body { 
            font-family: 'DejaVu Sans', sans-serif; /* This font supports the Peso symbol */
            font-size: 12px; 
            color: #333; 
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="50%">
                <h2 class="text-primary" style="margin:0;">{{ $company->name }}</h2>
                <p>{{ $company->address }}<br>Contact: {{ $company->contact }}</p>
            </td>
            <td width="50%" class="text-end">
                <h1 style="margin:0;">PAYSLIP</h1>
                <p>Ref: {{ $payslip->transaction_id }}<br>Generated: {{ date('M d, Y') }}</p>
            </td>
        </tr>
    </table>

    <div class="bg-light" style="padding: 15px; border-radius: 5px;">
        <table class="details-table">
            <tr>
                <td width="50%">
                    <strong>Employee:</strong> {{ $payslip->employee->name }}<br>
                    <strong>ID:</strong> EMP-{{ $payslip->employee_id }}<br>
                    <strong>Designation:</strong> {{ $payslip->employee->designation }}
                </td>
                <td width="50%" class="text-end">
                    <strong>Period:</strong> {{ $payslip->salary_month }} {{ $payslip->salary_year }}<br>
                    <strong>Method:</strong> {{ $payslip->payment_method }}<br>
                    <strong>Paid On:</strong> {{ date('M d, Y', strtotime($payslip->created_at)) }}
                </td>
            </tr>
        </table>
    </div>

    <table class="earnings-table">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-end">Earnings</th>
                <th class="text-end">Deductions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Basic Salary</td>
                <td class="text-end">₱{{ number_format($payslip->basic_salary, 2) }}</td>
                <td class="text-end">-</td>
            </tr>
            @if($payslip->advance_salary > 0)
            <tr>
                <td>Advance Salary Deduction</td>
                <td class="text-end">-</td>
                <td class="text-end" style="color: red;">₱{{ number_format($payslip->advance_salary, 2) }}</td>
            </tr>
            @endif
            <tr class="fw-bold" style="font-size: 16px;">
                <td class="text-end">TOTAL NET PAY</td>
                <td colspan="2" class="text-end text-primary">₱{{ number_format($payslip->paid_amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer-sig">
        <table width="100%">
            <tr>
                <td class="text-center"><div class="sig-box">Employee Signature</div></td>
                <td class="text-center"><div class="sig-box">Manager Signature</div></td>
            </tr>
        </table>
    </div>

</body>
</html>