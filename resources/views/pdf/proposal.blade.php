<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Proposal</title>

    <style>
        @page {
            margin: 28px 32px 45px 32px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 12px;
            line-height: 1.45;
            margin: 0;
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
            font-size: 22px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 13px;
            letter-spacing: 1px;
        }

        .section {
            margin-top: 18px;
            page-break-inside: avoid;
        }

        .section h2 {
            font-size: 16px;
            color: #003f35;
            border-bottom: 2px solid #047857;
            padding-bottom: 5px;
            margin: 0 0 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            page-break-inside: avoid;
        }

        td,
        th {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #ecfdf5;
            color: #003f35;
            width: 35%;
            font-weight: bold;
        }

        .scope-table th:first-child,
        .scope-table td:first-child {
            width: 18%;
            text-align: center;
        }

        .scope-table th:last-child,
        .scope-table td:last-child {
            width: 82%;
        }

        .amount {
            text-align: right;
            font-weight: bold;
        }

        .total-row th,
        .total-row td {
            background: #ecfdf5;
            color: #003f35;
            font-size: 14px;
            font-weight: bold;
        }

        .details-box {
            border: 1px solid #d1d5db;
            padding: 12px;
            border-radius: 6px;
            background: #f9fafb;
        }

        .terms-list {
            margin: 8px 0 0 18px;
            padding: 0;
        }

        .terms-list li {
            margin-bottom: 6px;
        }

        .signature-line {
            display: inline-block;
            width: 220px;
            border-bottom: 1px solid #111827;
            height: 18px;
        }

        .prepared-box {
            border: 1px solid #d1d5db;
            padding: 14px;
            background: #f9fafb;
        }

        .prepared-box p {
            margin: 5px 0;
        }

        .footer {
            margin-top: 28px;
            padding-top: 10px;
            border-top: 1px solid #d1d5db;
            color: #6b7280;
            text-align: center;
            font-size: 10px;
        }

        .footer strong {
            color: #003f35;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>CONSTRUCTION SITE MANAGEMENT SYSTEM</h1>
        <p>PROJECT PROPOSAL</p>
    </div>

    <div class="section">
        <h2>Proposal Details</h2>

        <table>
            <tr>
                <th>Proposal Number</th>
                <td>
                    P-{{ str_pad($proposal->id, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>

            <tr>
                <th>Project Request ID</th>
                <td>
                    R-{{ str_pad($projectRequest->id, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>

            <tr>
                <th>Issue Date</th>
                <td>
                    {{ $proposal->created_at->format('d M Y') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Client Information</h2>

        <table>
            <tr>
                <th>Client Name</th>
                <td>{{ $projectRequest->name }}</td>
            </tr>

            <tr>
                <th>Phone Number</th>
                <td>{{ $projectRequest->phone }}</td>
            </tr>

            <tr>
                <th>Email Address</th>
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
                <th>Project Location</th>
                <td>{{ $projectRequest->location }}</td>
            </tr>

            <tr>
                <th>Road Length</th>
                <td>{{ $projectRequest->width }} m</td>
            </tr>

            <tr>
                <th>Road Width</th>
                <td>{{ $projectRequest->height }} m</td>
            </tr>

            <tr>
                <th>Estimated Duration</th>
                <td>
                    {{ $technicalReport->estimated_duration
                        ?? $technicalReport->duration
                        ?? $proposal->estimated_duration
                        ?? 'Not specified' }}
                </td>
            </tr>

            <tr>
                <th>Client Expected Budget</th>
                <td>
                    LKR {{ number_format($projectRequest->budget ?? 0, 2) }}
                </td>
            </tr>

            <tr>
                <th>Client Requirements</th>
                <td>
                    {{ $projectRequest->requirements ?? 'No special requirements provided.' }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Scope of Work</h2>

        <table class="scope-table">
            <tr>
                <th>Phase</th>
                <th>Description</th>
            </tr>

            <tr>
                <td>01</td>
                <td>Site Preparation</td>
            </tr>

            <tr>
                <td>02</td>
                <td>Earth Work</td>
            </tr>

            <tr>
                <td>03</td>
                <td>Base Construction</td>
            </tr>

            <tr>
                <td>04</td>
                <td>Concrete / Asphalt Paving</td>
            </tr>

            <tr>
                <td>05</td>
                <td>Drainage Construction</td>
            </tr>

            <tr>
                <td>06</td>
                <td>Finishing and Road Marking</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Cost Breakdown</h2>

        <table>
            <tr>
                <th>Labor Cost</th>
                <td class="amount">
                    LKR {{ number_format($technicalReport->labor_cost ?? 0, 2) }}
                </td>
            </tr>

            <tr>
                <th>Material Cost</th>
                <td class="amount">
                    LKR {{ number_format($technicalReport->material_cost ?? 0, 2) }}
                </td>
            </tr>

            <tr>
                <th>Equipment Cost</th>
                <td class="amount">
                    LKR {{ number_format($technicalReport->equipment_cost ?? 0, 2) }}
                </td>
            </tr>

            <tr>
                <th>Subtotal</th>
                <td class="amount">
                    LKR {{ number_format(
                        ($technicalReport->labor_cost ?? 0)
                        + ($technicalReport->material_cost ?? 0)
                        + ($technicalReport->equipment_cost ?? 0),
                        2
                    ) }}
                </td>
            </tr>

            <tr class="total-row">
                <th>Total Estimated Cost</th>
                <td class="amount">
                    LKR {{ number_format(
                        $technicalReport->total_budget
                            ?? $proposal->total_budget
                            ?? 0,
                        2
                    ) }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Terms & Conditions</h2>

        <div class="details-box">
            @if(!empty($proposal->proposal_details))
                <p>{{ $proposal->proposal_details }}</p>
            @endif

            <ol class="terms-list">
                <li>This proposal is valid for 30 days from the issue date.</li>
                <li>Payment shall be made according to agreed project milestones.</li>
                <li>Construction work will commence after written client approval.</li>
                <li>Material price variations may affect the final project cost.</li>
                <li>Project completion may be affected by weather and unforeseen site conditions.</li>
                <li>Additional work requested by the client may incur additional charges.</li>
            </ol>
        </div>
    </div>

    <div class="section">
        <h2>Prepared By</h2>

        <div class="prepared-box">
            <p>
                <strong>Project Manager:</strong>
                {{ $manager->name ?? 'Project Manager' }}
            </p>

            <p>
                <strong>Designation:</strong>
                Project Manager
            </p>

            <p>
                <strong>Organization:</strong>
                Construction Site Management System
            </p>

            <p style="margin-top: 22px;">
                <strong>Signature:</strong>
                <span class="signature-line"></span>
            </p>

            <p style="margin-top: 12px;">
                <strong>Date:</strong>
                {{ $proposal->created_at->format('d M Y') }}
            </p>
        </div>
    </div>

   <div class="section">
    <h2>Client Response</h2>

    <table width="100%" cellspacing="0" cellpadding="8" border="1">
        <tr>
            <td width="35%"><strong>Client Name</strong></td>
            <td>{{ $proposal->projectRequest->client->name ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td><strong>Response Status</strong></td>
            <td>{{ $proposal->status }}</td>
        </tr>

        <tr>
            <td><strong>Reviewed Through</strong></td>
            <td>Construction Site Management System (CSMS)</td>
        </tr>

        <tr>
            <td><strong>Response Date</strong></td>
            <td>
                @if(in_array($proposal->status, ['Approved','Rejected','Changes Requested']))
                    {{ $proposal->updated_at->format('d M Y h:i A') }}
                @else
                    Pending Client Review
                @endif
            </td>
        </tr>

        <tr>
            <td><strong>Reviewed By</strong></td>
            <td>Client Portal</td>
        </tr>

        @if($proposal->response_comment)
        <tr>
            <td><strong>Client Comment</strong></td>
            <td>{{ $proposal->response_comment }}</td>
        </tr>
        @endif
    </table>

</div>
    <div class="footer">
        <strong>Generated by Construction Site Management System</strong><br>
        Department of Information Technology<br>
        Project Proposal Document
    </div>

</body>
</html>