<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Progress</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root{
            --primary:#03045e;
            --blue:#2563eb;
            --green:#16a34a;
            --orange:#f97316;
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

        .card{
            background:var(--white);
            border-radius:20px;
            padding:30px;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
            border:1px solid var(--border);
        }

        .project-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            flex-wrap:wrap;
            gap:20px;
            margin-bottom:25px;
        }

        .project-header h2{
            color:var(--primary);
            font-size:28px;
        }

        .project-header p{
            margin-top:10px;
            font-size:15px;
            color:var(--gray);
        }

        .badge{
            padding:8px 14px;
            border-radius:20px;
            font-size:13px;
            font-weight:bold;
        }

        .badge-blue{
            background:#dbeafe;
            color:#1d4ed8;
        }

        .progress-box{
            margin:25px 0;
        }

        .progress-info{
            display:flex;
            justify-content:space-between;
            margin-bottom:10px;
            font-weight:bold;
            color:var(--primary);
        }

        .progress{
            width:100%;
            height:24px;
            background:#e5e7eb;
            border-radius:30px;
            overflow:hidden;
        }

        .progress-bar{
            height:100%;
            width:45%;
            background:linear-gradient(90deg,#16a34a,#22c55e);
            border-radius:30px;
            color:white;
            font-weight:bold;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .stats{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:20px;
            margin:30px 0;
        }

        .stat{
            background:#f8fafc;
            padding:20px;
            border-radius:16px;
            border:1px solid var(--border);
            text-align:center;
        }

        .stat i{
            font-size:28px;
            color:var(--primary);
            margin-bottom:12px;
        }

        .stat h3{
            font-size:24px;
            color:var(--primary);
            margin-bottom:6px;
        }

        .stat small{
            color:var(--gray);
        }

        .updates-title{
            color:var(--primary);
            margin-bottom:20px;
            font-size:22px;
        }

        .table-wrap{
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,td{
            padding:16px;
            text-align:left;
            border-bottom:1px solid var(--border);
        }

        th{
            background:#f8fafc;
            color:var(--gray);
        }

        tr:hover{
            background:#f9fafb;
        }

        .progress-chip{
            background:#dcfce7;
            color:#166534;
            padding:6px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:bold;
        }

        @media(max-width:900px){
            .stats{
                grid-template-columns:1fr;
            }
        }
    </style>
</head>
<body>

<div class="card">

    <div class="project-header">
        <div>
            <h2><i class="fa-solid fa-road"></i> Colombo - Kandy Road Project</h2>
            <p>
                <b>Status:</b>
                <span class="badge badge-blue">Ongoing</span>
            </p>
        </div>
    </div>

    <div class="progress-box">
        <div class="progress-info">
            <span>Overall Project Progress</span>
            <span>45%</span>
        </div>

        <div class="progress">
            <div class="progress-bar">45%</div>
        </div>
    </div>

    <div class="stats">
        <div class="stat">
            <i class="fa-solid fa-calendar-days"></i>
            <h3>75</h3>
            <small>Days Remaining</small>
        </div>

        <div class="stat">
            <i class="fa-solid fa-users-gear"></i>
            <h3>18</h3>
            <small>Workers Assigned</small>
        </div>

        <div class="stat">
            <i class="fa-solid fa-coins"></i>
            <h3>LKR 5.2M</h3>
            <small>Current Budget</small>
        </div>
    </div>

    <h3 class="updates-title">
        <i class="fa-solid fa-clock-rotate-left"></i> Recent Updates
    </h3>

    <div class="table-wrap">
        <table>
            <tr>
                <th>Date</th>
                <th>Update</th>
                <th>Progress</th>
            </tr>

            <tr>
                <td>2025-03-15</td>
                <td>Foundation 50% completed</td>
                <td><span class="progress-chip">45%</span></td>
            </tr>

            <tr>
                <td>2025-02-28</td>
                <td>Excavation completed</td>
                <td><span class="progress-chip">25%</span></td>
            </tr>

            <tr>
                <td>2025-02-10</td>
                <td>Project officially started</td>
                <td><span class="progress-chip">5%</span></td>
            </tr>
        </table>
    </div>

</div>

</body>
</html>