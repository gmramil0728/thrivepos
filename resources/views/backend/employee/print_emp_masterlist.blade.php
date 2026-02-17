<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Masterlist</title>
    <style>
        @page { 
            margin: 0.5cm 1cm; 
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #334155;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* Top Accent */
        .header-bg {
            background-color: #1e293b;
            height: 40px;
            margin: -0.5cm -1cm 20px -1cm;
        }

        /* Header Layout */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .company-info {
            border-left: 3px solid #3b82f6; /* Modern Blue Accent */
            padding-left: 15px !important;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .company-subtext {
            font-size: 9px;
            color: #64748b;
            margin: 2px 0;
        }

        .report-badge {
            background: #f1f5f9;
            color: #475569;
            /* padding: 5px 10px; */
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }

        /* Table Styling */
        table.main-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.main-table thead th {
            background-color: #f8fafc;
            color: #1e293b;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            padding: 10px 8px;
            border-bottom: 2px solid #e2e8f0;
            text-align: left;
        }

        table.main-table tbody td {
            padding: 10px 8px;
            /* border-bottom: 1px solid #f1f5f9; */
            border-bottom: 1px solid #cbd5e1;
            vertical-align: middle;
        }

        /* Zebra Striping */
        /* .stripe { background-color: #fcfcfc; } */
        .stripe { background-color: #fcfcfc; }

        /* Employee Profile Cell */
        .profile-container {
            width: 100%;
        }

        .employee-img {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            float: left;
            margin-right: 10px;
        }

        .emp-name {
            font-weight: bold;
            color: #1e293b;
            font-size: 11px;
            display: block;
        }

        .emp-id {
            color: #64748b;
            font-size: 8px;
        }

        /* Utility Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .price { color: #0f172a; font-family: 'Courier', monospace; font-size: 11px; }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            font-size: 8px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="header-bg"></div>

    <table class="header-table">
        <tr>
            <td width="60%" class="company-info">
                <h1 class="company-name">{{ $company->name }}</h1>
                <p class="company-subtext">{{ $company->address }}</p>
                <p class="company-subtext">{{ $company->contact }} | {{ $company->email }}</p>
            </td>
            <td width="40%" class="text-right" style="vertical-align: top;">
                <div class="report-badge">Employee Masterlist</div>
                <p class="company-subtext" style="margin-top: 8px;">
                    Date: {{ date('d M Y') }}<br>
                    Total Records: {{ count($employees) }}
                </p>
            </td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th width="35%">Employee Information</th>
                <th width="20%">Contact</th>
                <th width="25%">Address</th>
                <th width="15%" class="text-right">Salary (PHP)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $key => $employee)
            <tr class="{{ $key % 2 == 0 ? '' : 'stripe' }}">
                <td class="text-center" style="color: #cbd5e1; vertical-align: middle;">
                    {{ $key + 1 }}
                </td>
        
                <td style="vertical-align: middle; padding: 5px 8px;">
                    <table style="width: 100%; border: none; border-collapse: collapse;">
                        <tr>
                            <td style="width: 35px; border: none; padding: 0; vertical-align: middle;">
                                @php
                                    $path = ($employee->image && file_exists(public_path($employee->image))) 
                                            ? $employee->image 
                                            : 'upload/no_image.jpg';
                                @endphp
                                <img src="{{ public_path($path) }}" class="employee-img" style="display: block;">
                            </td>
                            <td style="border: none; padding-left: 0px; vertical-align: middle; line-height: 1.2;">
                                <span class="emp-name">{{ $employee->name }}</span>
                                <span class="emp-id">ID: EMP-{{ 1000 + $employee->id }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
        
                <td style="vertical-align: middle;">
                    <div class="font-bold">{{ $employee->email }}</div>
                    <div style="color: #64748b; font-size: 9px;">{{ $employee->phone }}</div>
                </td>
        
                <td style="vertical-align: middle; font-size: 9px; color: #475569;">
                    {{ Str::limit($employee->address ?? 'N/A', 40) }}
                </td>
        
                <td class="text-right font-bold price" style="vertical-align: middle;">
                    {{ number_format($employee->salary, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <table width="100%" style="border: none;">
            <tr>
                <td style="border: none; padding: 0;">
                    Report Generated: {{ \Carbon\Carbon::now()->format('d M Y, h:i A') }}
                </td>
                <td style="border: none; padding: 0;" class="text-right">
                    Page 1 of 1 | System Generated Report
                </td>
            </tr>
        </table>
    </div>

</body>
</html>