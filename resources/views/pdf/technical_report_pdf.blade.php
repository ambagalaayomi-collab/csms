<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Technical Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; color: #333; }
        .title { text-align: center; font-size: 22px; font-weight: bold; color: #1e3a8a; border-bottom: 2px solid #1e3a8a; padding-bottom: 10px; margin-bottom: 20px; }
        .info-section { background: #f8fafc; padding: 12px; border: 1px solid #e2e8f0; margin-bottom: 20px; }
        p { margin: 6px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #cbd5e1; padding: 10px; }
        th { background: #1e3a8a; color: white; }
        .section-row td { background: #f1f5f9; font-weight: bold; }
        .text-right { text-align: right; }
        .total-row td { background: #e2e8f0; font-weight: bold; }
        .notes-box { margin-top: 20px; padding: 12px; background: #f1f5f9; border-left: 4px solid #1e3a8a; }
    </style>
</head>
<body>

<div class="title">TECHNICAL REPORT</div>

<div class="info-section">
    <p><strong>Report Date:</strong> {{ $report->date }}</p>
    <p><strong>Request ID:</strong> R-{{ $report->req_id }}</p>
    <p><strong>Project Name:</strong> {{ $requestData->name ?? $report->projectRequest->name ?? 'N/A' }}</p>
    <p><strong>Project Type:</strong> {{ $requestData->project_type ?? $report->projectRequest->project_type ?? 'N/A' }}</p>
    <p><strong>Estimated Duration:</strong> {{ $report->estimated_duration ?? $report->duration }}</p>
</div>

<table>
    <thead>
        <tr>
            <th style="width:50%;">Description</th>
            <th style="width:50%;">Details</th>
        </tr>
    </thead>

    <tbody>
        <tr class="section-row">
            <td colspan="2">SITE MEASUREMENTS</td>
        </tr>

        <!-- <tr>
            <td>Measurement Details</td>
            <td>{!! nl2br(e($report->measurement_details)) !!}</td>
        </tr> -->
       <tr>
    <td>Length</td>
    <td>{{ $report->length }} ft</td>
</tr>

<tr>
    <td>Width</td>
    <td>{{ $report->width }} ft</td>
</tr>

<tr>
    <td>Area</td>
    <td>{{ $report->area }} sq.ft</td>
</tr>

        <tr class="section-row">
            <td colspan="2">COST ESTIMATION</td>
        </tr>

        <tr>
            <td>Material Cost</td>
            <td class="text-right">Rs. {{ number_format($report->material_cost ?? 0, 2) }}</td>
        </tr>

        <tr>
            <td>Labor Cost</td>
            <td class="text-right">Rs. {{ number_format($report->labor_cost ?? 0, 2) }}</td>
        </tr>

        <tr>
            <td>Equipment Cost</td>
            <td class="text-right">Rs. {{ number_format($report->equipment_cost ?? 0, 2) }}</td>
        </tr>

        <tr class="total-row">
            <td>Total Estimated Budget</td>
            <td class="text-right">Rs. {{ number_format($report->total_budget ?? 0, 2) }}</td>
        </tr>

        <tr class="section-row">
            <td colspan="2">DURATION</td>
        </tr>
        

        <tr>
            <td>Estimated Duration</td>
            <td>{{ $report->estimated_duration ?? $report->duration }}</td>
        </tr>
        @if($report->recommendations)
<tr class="section-row">
    <td colspan="2">ENGINEER RECOMMENDATIONS</td>
</tr>

<tr>
    <td colspan="2">
        {{ $report->recommendations }}
    </td>
</tr>
@endif

@if($report->remarks)
<tr class="section-row">
    <td colspan="2">REMARKS</td>
</tr>

<tr>
    <td colspan="2">
        {{ $report->remarks }}
    </td>
</tr>
@endif
    </tbody>
</table>

<div class="notes-box">
    
    
    <strong>Prepared By:</strong> Engineer<br>
    <strong>Generated Date:</strong> {{ now()->format('Y-m-d') }}
</div>

</body>
</html>