<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Proposal</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root{
            --primary:#03045e;
            --blue:#2563eb;
            --green:#16a34a;
            --orange:#f59e0b;
            --red:#dc2626;
            --yellow:#facc15;
            --gray:#64748b;
            --light:#f8fafc;
            --white:#ffffff;
            --border:#e5e7eb;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial,sans-serif;
        }

        body{
            background:var(--light);
            padding:25px;
            color:#1e293b;
        }

        .steps{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
            flex-wrap:wrap;
            gap:15px;
        }

        .step{
            text-align:center;
            flex:1;
        }

        .dot{
            width:50px;
            height:50px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:auto;
            font-weight:bold;
            background:#e5e7eb;
            color:#64748b;
        }

        .step.done .dot{
            background:var(--green);
            color:white;
        }

        .step.active .dot{
            background:var(--blue);
            color:white;
        }

        .step small{
            display:block;
            margin-top:8px;
            font-weight:600;
        }

        .grid-2{
            display:grid;
            grid-template-columns:2fr 1fr;
            gap:20px;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:20px;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
            border:1px solid var(--border);
        }

        .sec-title{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:20px;
            flex-wrap:wrap;
            gap:10px;
        }

        .sec-title h3{
            color:var(--primary);
            font-size:24px;
        }

        .badge{
            padding:8px 14px;
            border-radius:20px;
            font-size:12px;
            font-weight:bold;
        }

        .badge-orange{
            background:#fff7ed;
            color:#c2410c;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,td{
            padding:14px;
            text-align:left;
            border-bottom:1px solid var(--border);
        }

        th{
            width:40%;
            background:#f8fafc;
            color:#475569;
        }

        .btn-group{
            margin-top:20px;
            display:flex;
            gap:10px;
            flex-wrap:wrap;
        }

        .btn{
            padding:12px 18px;
            border:none;
            border-radius:12px;
            font-weight:bold;
            cursor:pointer;
            text-decoration:none;
            color:white;
        }

        .btn-success{
            background:var(--green);
        }

        .btn-warning{
            background:var(--orange);
        }

        .btn-danger{
            background:var(--red);
        }

        .btn-outline{
            background:white;
            color:#334155;
            border:1px solid var(--border);
        }

        .alert{
            margin-top:18px;
            padding:15px;
            border-radius:12px;
            display:flex;
            gap:10px;
            align-items:flex-start;
        }

        .alert-info{
            background:#eff6ff;
            color:#1d4ed8;
        }

        @media(max-width:900px){
            .grid-2{
                grid-template-columns:1fr;
            }

            .steps{
                justify-content:center;
            }
        }
    </style>
</head>
<body>

<div class="steps">
    <div class="step done">
        <div class="dot"><i class="fa-solid fa-check"></i></div>
        <small>Submitted</small>
    </div>

    <div class="step done">
        <div class="dot"><i class="fa-solid fa-check"></i></div>
        <small>Reviewed</small>
    </div>

    <div class="step active">
        <div class="dot">3</div>
        <small>Awaiting You</small>
    </div>

    <div class="step">
        <div class="dot">4</div>
        <small>Approved</small>
    </div>

    <div class="step">
        <div class="dot">5</div>
        <small>Started</small>
    </div>
</div>

<div class="grid-2">

    <div class="card">
        <div class="sec-title">
            <h3><i class="fa-solid fa-file-contract"></i> Proposal #PRO-103</h3>
            <span class="badge badge-orange">Pending Approval</span>
        </div>

        <table>
            <tr><th>Project Type</th><td>Road Construction</td></tr>
            <tr><th>Location</th><td>Colombo - Kandy</td></tr>
            <tr><th>Estimated Cost</th><td><b style="color:#03045e;">LKR 5,200,000.00</b></td></tr>
            <tr><th>Timeline</th><td>6 Months</td></tr>
            <tr><th>Start Date</th><td>2025-06-01</td></tr>
            <tr><th>Materials</th><td>Asphalt, Cement, Steel, Sand, Bricks, Aggregate</td></tr>
            <tr><th>Workforce</th><td>15 Workers, 2 Engineers</td></tr>
            <tr><th>Scope of Work</th><td>Earthwork, drainage, sub-base, asphalt paving, road marking</td></tr>
            <tr><th>Payment Schedule</th><td>30% on start, 40% at 50%, 30% on handover</td></tr>
        </table>

        <div class="btn-group">
            <button class="btn btn-success">
                <i class="fa-solid fa-check"></i> Approve
            </button>

            <button class="btn btn-warning">
                <i class="fa-solid fa-pen"></i> Request Changes
            </button>

            <button class="btn btn-danger">
                <i class="fa-solid fa-xmark"></i> Reject
            </button>

            <button class="btn btn-outline" onclick="window.print()">
                <i class="fa-solid fa-print"></i> Print
            </button>
        </div>
    </div>

    <div class="card">
        <div class="sec-title">
            <h3><i class="fa-solid fa-coins"></i> Cost Breakdown</h3>
        </div>

        <table>
            <tr><th>Item</th><th>Cost (LKR)</th></tr>
            <tr><td>Materials</td><td>2,800,000</td></tr>
            <tr><td>Labour</td><td>1,400,000</td></tr>
            <tr><td>Equipment</td><td>600,000</td></tr>
            <tr><td>Other</td><td>400,000</td></tr>
            <tr style="background:#fff8e1;font-weight:bold;">
                <td>Total</td>
                <td>5,200,000</td>
            </tr>
        </table>

        <div class="alert alert-info">
            <i class="fa-solid fa-circle-info"></i>
            <div>
                Approving this proposal will start your project on <b>2025-06-01</b>
            </div>
        </div>
    </div>

</div>

</body>
</html>