<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Estimate Report</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.5;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            color: #047857;
            text-align: center;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #047857;
            padding-bottom: 10px;
        }
        p {
            margin: 6px 0;
            font-size: 14px;
        }
        p strong {
            color: #111;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 10px 12px;
            text-align: left;
        }
        th {
            background-color: #047857;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 13px;
        }
        /* Materials, Labor, Equipment පේළි තද කර පෙන්වීමට */
        .section-title {
            background-color: #f1f5f9;
            font-weight: 700;
            color: #0f172a;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .text-right {
            text-align: right;
        }
        /* මුළු එකතුව පෙන්වන පේළිය */
        .total-row {
            background-color: #e2e8f0;
            font-size: 15px;
            color: #000;
        }
        .total-row td {
            border-top: 2px solid #334155;
            border-bottom: 2px double #334155;
        }
    </style>
</head>
<body>
    <div class="title">COST ESTIMATION REPORT</div>

    <div style="margin-bottom: 20px;">
        <p><strong>Request ID:</strong> R-{{ $projectRequest->id }}</p>
        <p><strong>Project Name:</strong> {{ $projectRequest->project_name ?? $projectRequest->name }}</p>
        <p><strong>Project Type:</strong> {{ $projectRequest->project_type }}</p>
        <p><strong>Estimated Duration:</strong> {{ $projectRequest->estimate->estimated_duration }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item Description</th>
                <th>Quantity</th>
                <th class="text-right">Cost (Rs.)</th>
            </tr>
        </thead>
        <tbody>
            <tr class="section-title"><td colspan="3"> Materials</td></tr>
            <tr><td>Cement</td><td>{{ number_format($projectRequest->estimate->cement_qty, 2) }}</td><td class="text-right">{{ number_format($projectRequest->estimate->cement_cost, 2) }}</td></tr>
            <tr><td>Sand</td><td>{{ number_format($projectRequest->estimate->sand_qty, 2) }}</td><td class="text-right">{{ number_format($projectRequest->estimate->sand_cost, 2) }}</td></tr>
            <tr><td>Steel</td><td>{{ number_format($projectRequest->estimate->steel_qty, 2) }}</td><td class="text-right">{{ number_format($projectRequest->estimate->steel_cost, 2) }}</td></tr>
            <tr><td>Bricks</td><td>{{ number_format($projectRequest->estimate->brick_qty, 2) }}</td><td class="text-right">{{ number_format($projectRequest->estimate->brick_cost, 2) }}</td></tr>

            <tr class="section-title"><td colspan="3">Labor</td></tr>
            <tr><td>Mason</td><td>{{ number_format($projectRequest->estimate->mason_qty, 2) }}</td><td class="text-right">{{ number_format($projectRequest->estimate->mason_cost, 2) }}</td></tr>
            <tr><td>Carpenter</td><td>{{ number_format($projectRequest->estimate->carpenter_qty, 2) }}</td><td class="text-right">{{ number_format($projectRequest->estimate->carpenter_cost, 2) }}</td></tr>
            <tr><td>Helper</td><td>{{ number_format($projectRequest->estimate->helper_qty, 2) }}</td><td class="text-right">{{ number_format($projectRequest->estimate->helper_cost, 2) }}</td></tr>

            <tr class="section-title"><td colspan="3"> Equipment</td></tr>
            <tr><td>Mixer Machine</td><td>{{ number_format($projectRequest->estimate->mixer_qty, 2) }}</td><td class="text-right">{{ number_format($projectRequest->estimate->mixer_cost, 2) }}</td></tr>
            <tr><td>Excavator</td><td>{{ number_format($projectRequest->estimate->excavator_qty, 2) }}</td><td class="text-right">{{ number_format($projectRequest->estimate->excavator_cost, 2) }}</td></tr>
            <tr><td>Truck</td><td>{{ number_format($projectRequest->estimate->truck_qty, 2) }}</td><td class="text-right">{{ number_format($projectRequest->estimate->truck_cost, 2) }}</td></tr>

            <tr class="total-row">
                <td colspan="2" class="text-right"><strong>Grand Total Estimated Cost:</strong></td>
                <td class="text-right"><strong>Rs. {{ number_format($projectRequest->estimate->grand_total, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    @if($projectRequest->estimate->remarks)
        <p style="margin-top: 20px; background: #f8fafc; padding: 10px; border-left: 4px solid #cbd5e1;">
            <strong>Remarks:</strong> {{ $projectRequest->estimate->remarks }}
        </p>
    @endif
</body>
</html>