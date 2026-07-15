<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Engineer Dashboard | CSMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f4f7fb;
            color: #111827;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 245px;
            background: linear-gradient(180deg, #006b5a, #003f35);
            color: white;
            padding: 22px 16px;
            border-radius: 0 18px 18px 0;
            transition: width 0.3s ease;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 35px;
        }

        .logo-left {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            font-size: 20px;
        }

        .logo-icon {
            width: 38px;
            height: 38px;
            background: rgba(255, 193, 7, 0.16);
            color: #ffc107;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .menu-icon {
            font-size: 20px;
            cursor: pointer;
            opacity: 0.9;
        }

        .menu {
            list-style: none;
        }

        .menu li {
            margin-bottom: 9px;
        }

        .menu a,
        .menu button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
            padding: 13px 14px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            transition: 0.3s;
            border: none;
            background: transparent;
            cursor: pointer;
            text-align: left;
            font-family: inherit;
        }

        .menu a:hover,
        .menu a.active,
        .menu button:hover {
            background: rgba(255,255,255,0.16);
        }

        .menu span {
            width: 22px;
            font-size: 17px;
            display: inline-flex;
            justify-content: center;
        }

        .logout-form {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        /* Sidebar Collapsed State */
        .sidebar.collapsed {
            width: 90px;
        }
        .sidebar.collapsed .logo-left span,
        .sidebar.collapsed .menu a text,
        .sidebar.collapsed .logout-form button text {
            display: none;
        }
        .sidebar.collapsed .menu a,
        .sidebar.collapsed .logout-form button {
            justify-content: center;
            padding: 13px 0;
        }

        /* Main */
        .main {
            flex: 1;
        }

        .topbar {
            height: 75px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            border-bottom: 1px solid #e5e7eb;
        }

        .topbar h1 {
            font-size: 25px;
            color: #111827;
        }

        .top-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .icon-btn {
            position: relative;
            font-size: 20px;
            color: #374151;
            cursor: pointer;
        }

        .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #f97316;
            color: white;
            width: 17px;
            height: 17px;
            font-size: 11px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #d1fae5;
            color: #065f46;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .user-info h4 {
            font-size: 14px;
        }

        .user-info p {
            font-size: 12px;
            color: #6b7280;
        }

        .content {
            padding: 28px;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #bbf7d0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Stat cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 166px rgba(0,0,0,0.06);
            border: 1px solid #e5e7eb;
        }

        .stat-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #374151;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .blue { background: #0ea5e9; }
        .green { background: #10b981; }
        .purple { background: #6366f1; }
        .yellow { background: #f59e0b; }

        .stat-number {
            font-size: 34px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-text {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 14px;
        }

        .view-link {
            color: #2563eb;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
        }

        .review-link {
            color: #f97316;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
        }

        /* Main layout */
        .status-update-card {
    margin-bottom: 22px;
}

.status-update-form {
    display: grid;
    grid-template-columns: 1fr 1fr 220px;
    gap: 18px;
    align-items: end;
}

.status-update-form .form-group {
    margin-bottom: 0;
}

.status-update-form label {
    display: block;
    margin-bottom: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #374151;
}

.status-update-form .submit-btn {
    width: 100%;
}

@media (max-width: 900px) {
    .status-update-form {
        grid-template-columns: 1fr;
    }
}

        .card-title {
            font-size: 17px;
            margin-bottom: 18px;
            font-weight: bold;
            color: #111827;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead {
            background: #f8fafc;
        }

        th, td {
            padding: 13px 14px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            color: #374151;
            font-size: 13px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-pending { background: #fee2e2; color: #b91c1c; }
        .status-progress { background: #fef3c7; color: #b45309; }
        .status-completed { background: #dcfce7; color: #15803d; }

        .table-footer {
            text-align: center;
            margin-top: 14px;
        }

        .table-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
        }

        /* Status update form & general forms */
        .form-group {
            margin-bottom: 14px;
        }

        .form-group select,
        .form-group textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            outline: none;
            background-color: white;
        }

        .form-group textarea {
            height: 88px;
            resize: vertical;
        }

        .submit-btn {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 8px;
            background: #00a884;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s ease;
        }

        .submit-btn:hover {
            background: #007a5c;
        }

        /* Bottom section */
        .bottom-grid {
            display: grid;
            grid-template-columns: 0.9fr 1.6fr 0.9fr;
            gap: 22px;
            margin-bottom: 25px;
        }

        .verification-number {
            font-size: 38px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .verification-text {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .progress-line {
            width: 100%;
            height: 8px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress-fill {
            width: 65%;
            height: 100%;
            background: #00a884;
            border-radius: 10px;
        }

        .percentage {
            text-align: right;
            font-size: 13px;
            color: #374151;
            margin-bottom: 5px;
        }

        .report-list {
            list-style: none;
        }

        .report-list li {
            display: grid;
            grid-template-columns: 1fr 1.5fr 0.9fr 0.7fr;
            gap: 10px;
            padding: 11px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
            align-items: center;
        }

        .estimate-number {
            font-size: 38px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        @media (max-width: 1100px) {
            .stats-grid,
            .main-grid,
            .bottom-grid {
                grid-template-columns: 1fr;
            }

            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-radius: 0;
            }
            .status-update-card {
    margin-bottom: 22px;
}

.status-update-form {
    display: grid;
    grid-template-columns: 1fr 1fr 220px;
    gap: 18px;
    align-items: end;
}

.status-update-form .form-group {
    margin-bottom: 0;
}

.status-update-form label {
    display: block;
    margin-bottom: 8px;
    font-size: 13px;
    font-weight: 700;
    color: #374151;
}

.status-update-form .submit-btn {
    width: 100%;
}

@media (max-width: 900px) {
    .status-update-form {
        grid-template-columns: 1fr;
    }
}
        }

        /* =====================================
   ENGINEER SEARCH AND FILTER
===================================== */

.request-filter-form {
    width: 100%;
    margin-bottom: 20px;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    width: 100%;
}

.filter-group input,
.filter-group select {
    height: 44px;
    border: 1px solid #d1d5db;
    border-radius: 9px;
    background: #ffffff;
    color: #111827;
    font-size: 14px;
    outline: none;
    transition: 0.2s ease;
}

.filter-group input {
    flex: 1;
    min-width: 280px;
    padding: 0 14px;
}

.filter-group select {
    width: 210px;
    padding: 0 12px;
    cursor: pointer;
}

.filter-group input::placeholder {
    color: #9ca3af;
}

.filter-group input:focus,
.filter-group select:focus {
    border-color: #007a5c;
    box-shadow: 0 0 0 3px rgba(0, 122, 92, 0.12);
}

.filter-btn {
    height: 44px;
    padding: 0 20px;
    border: none;
    border-radius: 9px;
    background: #007a5c;
    color: #ffffff;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: 0.2s ease;
}

.filter-btn:hover {
    background: #005f48;
    transform: translateY(-1px);
}

.clear-filter-btn {
    height: 44px;
    padding: 0 18px;
    border-radius: 9px;
    background: #e5e7eb;
    color: #374151;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s ease;
}

.clear-filter-btn:hover {
    background: #d1d5db;
    color: #111827;
}

@media (max-width: 768px) {
    .filter-group {
        flex-direction: column;
        align-items: stretch;
    }

    .filter-group input,
    .filter-group select,
    .filter-btn,
    .clear-filter-btn {
        width: 100%;
        min-width: 100%;
    }
}
    </style>
</head>
<body>

<div class="dashboard">

    <aside class="sidebar" id="sidebar">
        <div class="logo">
            <div class="logo-left">
                <div class="logo-icon">
                    <i class="fa-solid fa-helmet-safety"></i>
                </div>
                <span>CSMS</span>
            </div>
            <div class="menu-icon" id="toggleSidebar">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>

        <ul class="menu">
            <li><a href="#" class="active"><span><i class="fa-solid fa-house"></i></span> <text>Dashboard</text></a></li>
            <li><a href="#"><span><i class="fa-solid fa-list-check"></i></span> <text>Assigned Requests</text></a></li>
            
    </a></li>
            <li>
                <a href="{{ route('engineer.estimates') }}">
                    <span><i class="fa fa-calculator"></i></span> <text>Estimates</text>
                </a>
            </li>
            <li>
                <a href="{{ route('engineer.technicalreport.create', ['project_request_id' => 'PR-001']) }}">
                    <span><i class="fas fa-file-alt"></i></span> <text>Technical Report</text>
                </a>
            </li>
            <!-- <li><a href="#"><span><i class="fa-solid fa-chart-line"></i></span> <text>Status Updates</text></a></li> -->
            <!-- <li><a href="#"><span><i class="fa-solid fa-boxes-stacked"></i></span> <text>Materials</text></a></li> -->
            <li>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit">
                        <span><i class="fa-solid fa-right-from-bracket"></i></span> <text>Logout</text>
                    </button>
                </form>
            </li>
        </ul>
    </aside>
    <main class="main">

        <div class="topbar">
            <h1>Engineer Dashboard</h1>

            <div class="top-right">
                <div class="icon-btn">
                    <i class="fa-solid fa-bell"></i>
                    <span class="badge">3</span>
                </div>
                <div class="icon-btn">
                    <i class="fa-solid fa-circle-question"></i>
                </div>
                <div class="user">
                    <div class="avatar">
                        <i class="fa-solid fa-user-gear"></i>
                    </div>
                    <div class="user-info">
                        <h4>{{ Auth::user()->name ?? 'Engineer User' }}</h4>
                        <p>Engineer</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">

            @if(session('success'))
                <div class="success-message">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="stats-grid">
                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon blue">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <span>Assigned Requests</span>
                    </div>
                    <div class="stat-number">{{ isset($assignedRequests) ? $assignedRequests->count() : 0 }}</div>
                    <div class="stat-text">Active Assignments</div>
                    
                </div>

                <!-- <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon green">
                            <i class="fa-solid fa-ruler-combined"></i>
                        </div>
                        <span>Measurements</span>
                    </div>
                    <div class="stat-number">14</div>
                    <div class="stat-text">Pending Verification</div>
                    <a href="#" class="view-link">View All</a>
                </div> -->

                <!-- <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon purple">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <span>Reports</span>
                    </div>
                    <div class="stat-number">8</div>
                    <div class="stat-text">Reports Submitted</div>
                    <a href="#" class="view-link">View All</a>
                </div> -->

                <!-- <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon yellow">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <span>Pending Updates</span>
                    </div>
                    <div class="stat-number">3</div>
                    <div class="stat-text">Awaiting Update</div>
                    <a href="#" class="review-link">View All</a>
                </div> -->
            </div>
            <div class="card status-update-card">
    <h3 class="card-title">Status Update</h3>

    @if(isset($assignedRequests) && count($assignedRequests) > 0)

        <form
            method="POST"
            action="{{ route('engineer.status.update') }}"
            class="status-update-form"
        >
            @csrf

            <div class="form-group">
                <label>Request</label>

                <select name="request_id" required>
                    <option value="" disabled selected>
                        Select Request
                    </option>

                    @foreach($assignedRequests as $request)
                        <option value="{{ $request->id }}">
                            R-{{ $request->id }} -
                            {{ $request->project_type ?? $request->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>

                <select name="status" required>
                    <option value="" disabled selected>
                        Update Status
                    </option>

                    <option value="In Progress">In Progress</option>
                    <option value="Measurement Completed">
                        Measurement Completed
                    </option>
                    <option value="Report Submitted">
                        Report Submitted
                    </option>
                    <option value="Delayed">Delayed</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <button type="submit" class="submit-btn">
                Submit Update
            </button>
        </form>

    @else

        <p style="
            font-size:13px;
            color:#6b7280;
            text-align:center;
            padding:20px 0;
        ">
            No requests available for status updates.
        </p>

    @endif
</div>

            <div class="main-grid">
                <div class="card" id="assignedRequests">
                    <h3 class="card-title">My Assigned Requests</h3>
                    <form method="GET"
      action="{{ route('engineer.dashboard') }}#assignedRequests"
      class="request-filter-form">

    <div class="filter-group">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search ID, Project Type, Client or Location">

        <select name="status">
            <option value="">All Statuses</option>
            <option value="Assigned" {{ request('status')=='Assigned' ? 'selected' : '' }}>Assigned</option>
            <option value="In Progress" {{ request('status')=='In Progress' ? 'selected' : '' }}>In Progress</option>
            <option value="Measurement Completed" {{ request('status')=='Measurement Completed' ? 'selected' : '' }}>Measurement Completed</option>
            <option value="Report Submitted" {{ request('status')=='Report Submitted' ? 'selected' : '' }}>Report Submitted</option>
            <option value="Completed" {{ request('status')=='Completed' ? 'selected' : '' }}>Completed</option>
        </select>

        <button type="submit" class="filter-btn">
            <i class="fa-solid fa-magnifying-glass"></i>
            Search
        </button>

        @if(request('search') || request('status'))
            <a href="{{ route('engineer.dashboard') }}#assignedRequests"
               class="clear-filter-btn">
                Clear
            </a>
        @endif

    </div>
</form>
                    <table>
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Title</th>
                                <th>Client</th>
                                <th>Due Date</th>
                                <th>Width</th>
                                    <th>Height</th>
                                    <th>Budget</th>
                                    <th>Location</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($assignedRequests))
                                @forelse($assignedRequests as $request)
                                    <tr>
                                        <td>R-{{ $request->id }}</td>
                                        <td>{{ $request->project_type ?? $request->title }}</td>
                                        <td>{{ $request->name ?? $request->client_name }}</td>
                                        <td>{{ $request->due_date ?? 'Not set' }}</td>
                                        <td>{{ $request->width ?? '-' }}</td>
                                        <td>{{ $request->height ?? '-' }}</td>
                                        <td>LKR {{ number_format($request->budget, 2) }}</td>
                                        <td>{{ $request->location }}</td>
                                        <td>
                                            <span class="status-badge {{ $request->status == 'Completed' ? 'status-completed' : ($request->status == 'In Progress' ? 'status-progress' : 'status-pending') }}">
                                                {{ $request->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" style="text-align: center; color: #6b7280;">No assigned requests found</td>
                                    </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="9" style="text-align: center; color: #6b7280;">No assigned requests found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="table-footer">
                        <a href="#">View All Assignments</a>
                    </div>
                </div>


               

                            <div class="form-group">
                                <!-- <textarea name="remarks" placeholder="Add update remarks..." required></textarea> -->
                            </div>

                           
                        </form>
                   
                        <p style="font-size: 13px; color: #6b7280; text-align: center; padding: 20px 0;"></p>
                    
                </div>
            </div>

            
                <div class="card" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-radius: 8px; background: #fff; padding: 15px;">
    
    <h4 style="color: #00695c; margin: 0 0 15px 0; font-size: 15px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 5px;">
        📊 Project Reports
    </h4>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-size: 14px; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #e0e0e0; color: #555; font-weight: 600;">
                    <th style="padding: 10px 12px; width: 15%;">Request ID</th>
                    <th style="padding: 10px 12px; width: 45%;"> Client</th>
                    <th style="padding: 10px 12px; width: 40%; text-align: right;">Status </th>
                </tr>
            </thead>
            <tbody>
                @forelse($assignedRequests as $item)
                    <tr style="border-bottom: 1px solid #f0f0f0; transition: background 0.2s;">
                        
                        <td style="padding: 12px; font-weight: 700; color: #111;">
                            R-{{ $item->id }}
                        </td>

                        <td style="padding: 12px;">
                            <span style="font-weight: 600; color: #333; display: block;">
                                {{ Str::limit($item->project_name ?? $item->name, 25) }}
                            </span>
                            <!-- <small style="color: #777; font-size: 12px;">
                                Client: {{ $item->client_name ?? 'N/A' }}
                            </small> -->
                        </td>

                        <td style="padding: 12px; text-align: right;">
    <div style="display: inline-flex; gap: 8px; align-items: center;">
        
        @if($item->estimate)
            <a href="{{ route('engineer.estimates.report', $item->id) }}" target="_blank" title="View Estimate PDF" style="background-color: #00695c; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 12px; font-weight: 600; display: inline-block;">
                📄 Estimate PDF
            </a>
        @endif

   @if($item->technicalReport)
    <a href="{{ route('view.technical_report.pdf', $item->id) }}"
       target="_blank"
       style="background:#1976d2;color:white;padding:6px 12px;text-decoration:none;border-radius:4px;font-size:12px;font-weight:600;">
        📄 Technical PDF
    </a>
@endif
        @if(!$item->estimate && !$item->technicalReport)
            <span style="color: #c62828; font-size: 12px; font-weight: 700; background: #ffebee; padding: 4px 10px; border-radius: 4px; border: 1px solid #ffcdd2; display: inline-block;">
                Pending
            </span>
        @endif

    </div>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="padding: 20px; color: #888; text-align: center; font-weight: 500;">
                            No assigned requests found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
    </div>
</div>
</div>
                </div>

                <!-- <div class="card">
                    <h3 class="card-title">Recent Reports</h3>
                    <ul class="report-list">
                        <li>
                            <span>TR-2024-056</span>
                            <span>Office Renovation - Structural Report</span>
                            <span>May 30, 2024</span>
                            <span class="status-badge status-completed">Submitted</span>
                        </li>
                        <li>
                            <span>TR-2024-055</span>
                            <span>Site Office - Material Report</span>
                            <span>May 28, 2024</span>
                            <span class="status-badge status-completed">Submitted</span>
                        </li>
                        <li>
                            <span>TR-2024-054</span>
                            <span>Boundary Wall - Site Inspection</span>
                            <span>May 26, 2024</span>
                            <span class="status-badge status-progress">Draft</span>
                        </li>
                    </ul>
                    <div class="table-footer">
                        <a href="#">View All Reports</a>
                    </div>
                </div>

                <div class="card">
                    <h3 class="card-title">Material Estimates</h3>
                    <div class="estimate-number">5</div>
                    <div class="stat-text">Estimates Prepared</div>
                    <a href="#" class="view-link">View All Estimates</a>
                </div> -->
            <!-- </div> -->

        </div>
    </main>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        if(toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('collapsed');
            });
        }
    });
</script>

</body>
</html>