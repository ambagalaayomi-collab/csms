<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Project Proposal</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 13px;
            line-height: 1.6;
        }

        .header {
            background: #003f35;
            color: white;
            padding: 18px;
            text-align: center;
            border-radius: 6px;
        }

        .header h1 {
            margin: 0;
            font-size: 23px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 13px;
        }

        .section {
            margin-top: 22px;
        }

        .section h2 {
            font-size: 17px;
            color: #003f35;
            border-bottom: 2px solid #047857;
            padding-bottom: 6px;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        td, th {
            border: 1px solid #d1d5db;
            padding: 9px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #ecfdf5;
            color: #003f35;
            width: 35%;
        }

        .amount {
            font-size: 18px;
            font-weight: bold;
            color: #047857;
        }

        .details-box {
            border: 1px solid #d1d5db;
            padding: 12px;
            border-radius: 6px;
            background: #f9fafb;
            white-space: pre-line;
        }

        .footer {
            margin-top: 35px;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>CONSTRUCTION SITE MANAGEMENT SYSTEM</h1>
    <p>PROJECT PROPOSAL</p>
</div>

<div class="section">
    <table>
        <tr>
            <th>Proposal No</th>
            <td>P-{{ str_pad($proposal->id, 4, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <th>Date</th>
            <td>{{ $proposal->created_at->format('d M Y') }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <h2>Client Information</h2>

    <table>
        <tr>
            <th>Name</th>
            <td>{{ $projectRequest->name }}</td>
        </tr>

        <tr>
            <th>Phone</th>
            <td>{{ $projectRequest->phone }}</td>
        </tr>

        <tr>
            <th>Email</th>
            <td>{{ $projectRequest->email }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <h2>Project Summary</h2>

    <table>
        <tr>
            <th>Project Type</th>
            <td>{{ $projectRequest->project_type }}</td>
        </tr>

        <tr>
            <th>Location</th>
            <td>{{ $projectRequest->location }}</td>
        </tr>

        <tr>
            <th>Dimensions</th>
            <td>{{ $projectRequest->width }}m × {{ $projectRequest->height }}m</td>
        </tr>

        <tr>
            <th>Client Expected Budget</th>
            <td>LKR {{ number_format($projectRequest->budget, 2) }}</td>
        </tr>

        <tr>
            <th>Client Expected Timeline</th>
            <td>{{ $projectRequest->timeline }}</td>
        </tr>

        <tr>
            <th>Client Requirements</th>
            <td>{{ $projectRequest->requirements }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <h2>Scope of Work</h2>

    <div class="details-box">
- Site preparation
- Foundation construction
- Structural work
- Finishing
    </div>
</div>

<div class="section">
    <h2>Cost Breakdown</h2>

    <table>
        <!-- <tr>
            <th>Labor Cost</th>
            <td>LKR __________________</td>
        </tr>

        <tr>
            <th>Material Cost</th>
            <td>LKR __________________</td>
        </tr>

        <tr>
            <th>Equipment Cost</th>
            <td>LKR __________________</td>
        </tr> -->

        <tr>
            <th>Total Estimated Cost</th>
            <td class="amount">
                LKR {{ number_format($proposal->total_budget, 2) }}
            </td>
        </tr>
    </table>
</div>

<div class="section">
    <h2>Project Timeline</h2>

    <table>
        <tr>
            <th>Estimated Duration</th>
            <td>{{ $proposal->estimated_duration }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <h2>Terms & Conditions</h2>

    <div class="details-box">
{{ $proposal->proposal_details }}
    </div>
</div>

<div class="section">
    <h2>Prepared By</h2>

    <table>
        <tr>
            <th>Project Manager Name</th>
            <td>{{ $manager->name }}</td>
        </tr>
    </table>
</div>

<div class="section">
    <h2>Client Approval</h2>

    <table>
        <tr>
            <th>Status</th>
            <td>{{ $proposal->status }}</td>
        </tr>

        <tr>
            <th>Client Comment</th>
            <td>{{ $proposal->response_comment ?? 'No response yet' }}</td>
        </tr>

        <tr>
            <th>Signature</th>
            <td style="height:50px;"></td>
        </tr>
    </table>
</div>

<div class="footer">
    This proposal PDF was generated by the Construction Site Management System.
</div>

</body>
</html>