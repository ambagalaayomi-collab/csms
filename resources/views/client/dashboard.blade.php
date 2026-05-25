<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Dashboard | CSMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome Icons -->
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

        .sidebar {
            width: 245px;
            background: linear-gradient(180deg, #006b5a, #003f35);
            color: white;
            padding: 22px 16px;
            border-radius: 0 18px 18px 0;
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

        .main {
            flex: 1;
            padding: 0;
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
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            font-size: 11px;
            border-radius: 999px;
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

        .stats-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            border: 1px solid #e5e7eb;
        }

        .submit-card {
            border: 1px solid #22c55e;
            background: #f0fdf4;
        }

        .submit-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            color: #065f46;
            margin-bottom: 12px;
        }

        .plus {
            background: #22c55e;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .submit-card p {
            font-size: 14px;
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .new-btn {
            display: inline-block;
            background: #007a5c;
            color: white;
            text-decoration: none;
            padding: 11px 28px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        .new-btn:hover {
            background: #005f48;
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

        .green { background: #10b981; }
        .dark-green { background: #047857; }
        .yellow { background: #f59e0b; }
        .teal { background: #009879; }

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
            color: #047857;
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

        .middle-grid {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 22px;
            margin-bottom: 25px;
        }

        .card-title {
            font-size: 17px;
            margin-bottom: 18px;
            font-weight: bold;
            color: #111827;
        }

        .progress-content {
            display: flex;
            align-items: center;
            gap: 35px;
        }

        .donut {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: conic-gradient(
                #22c55e 0deg 220deg,
                #fbbf24 220deg 295deg,
                #f97316 295deg 335deg,
                #d1d5db 335deg 360deg
            );
            position: relative;
        }

        .donut::after {
            content: "";
            position: absolute;
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 50%;
            top: 30px;
            left: 30px;
        }

        .donut-text {
            position: absolute;
            z-index: 2;
            top: 47px;
            left: 0;
            width: 150px;
            text-align: center;
        }

        .donut-text h2 {
            font-size: 30px;
        }

        .donut-text p {
            font-size: 12px;
            color: #6b7280;
        }

        .legend {
            flex: 1;
        }

        .legend-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 13px;
            font-size: 14px;
        }

        .legend-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 11px 0;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
        }

        .activity-left {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #374151;
        }

        .activity-icon {
            color: #047857;
            font-size: 13px;
        }

        .activity-time {
            color: #6b7280;
            font-size: 12px;
        }

        .view-all {
            display: block;
            text-align: right;
            color: #047857;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            margin-top: 10px;
        }

        .table-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
            border: 1px solid #e5e7eb;
            overflow-x: auto;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead {
            background: #f8fafc;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        th {
            color: #374151;
            font-size: 13px;
        }

        .status {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .pending {
            background: #fef3c7;
            color: #b45309;
        }

        .approved {
            background: #dcfce7;
            color: #15803d;
        }

        .completed {
            background: #d1fae5;
            color: #047857;
        }

        .in-progress {
            background: #ecfdf5;
            color: #047857;
        }

        .rejected {
            background: #fee2e2;
            color: #b91c1c;
        }

        .under-review {
            background: #fef3c7;
            color: #b45309;
        }

        .proposal-response-form {
            min-width: 260px;
            display: grid;
            gap: 8px;
        }

        .proposal-response-form textarea {
            width: 100%;
            min-height: 65px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 9px;
            font-size: 13px;
            outline: none;
            resize: vertical;
        }

        .proposal-action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .approve-btn,
        .reject-btn,
        .change-btn {
            border: none;
            border-radius: 7px;
            padding: 8px 10px;
            color: white;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }

        .approve-btn {
            background: #047857;
        }

        .approve-btn:hover {
            background: #065f46;
        }

        .reject-btn {
            background: #dc2626;
        }

        .reject-btn:hover {
            background: #991b1b;
        }

        .change-btn {
            background: #f59e0b;
        }

        .change-btn:hover {
            background: #b45309;
        }

        .table-footer {
            text-align: center;
            margin-top: 14px;
        }

        .table-footer a {
            color: #047857;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
        }

        @media (max-width: 1000px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-radius: 0;
            }

            .stats-grid,
            .middle-grid {
                grid-template-columns: 1fr;
            }

            .progress-content {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="dashboard">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <div class="logo-left">
                <div class="logo-icon">
                    <i class="fa-solid fa-helmet-safety"></i>
                </div>
                <span>CSMS</span>
            </div>

            <div class="menu-icon">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>

        <ul class="menu">
            <li><a href="#" class="active"><span><i class="fa-solid fa-house"></i></span> Dashboard</a></li>
            <li><a href="#recentRequests"><span><i class="fa-solid fa-clipboard-list"></i></span> My Requests</a></li>
            <li><a href="#myProposals"><span><i class="fa-solid fa-file-signature"></i></span> Proposals</a></li>
            <!-- <li><a href="#"><span><i class="fa-solid fa-circle-check"></i></span> Approvals</a></li>
            <li><a href="#"><span><i class="fa-solid fa-chart-line"></i></span> Project Progress</a></li> -->
            <!-- <li><a href="#"><span><i class="fa-solid fa-gear"></i></span> Settings</a></li> -->

            <li>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit">
                        <span><i class="fa-solid fa-right-from-bracket"></i></span> Logout
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main -->
    <main class="main">

        <!-- Topbar -->
        <div class="topbar">
            <h1>Client Dashboard</h1>

            <div class="top-right">
                <div class="icon-btn">
                    <i class="fa-solid fa-bell"></i>
                    <span class="badge">{{ ($pendingRequests ?? 0) + ($proposalCount ?? 0) }}</span>
                </div>

                <div class="icon-btn">
                    <i class="fa-solid fa-circle-question"></i>
                </div>

                <div class="user">
                    <div class="avatar">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="user-info">
                        <h4>{{ Auth::user()->name ?? 'Client User' }}</h4>
                        <p>Client</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">

            @if(session('request_success'))
                <div class="success-message">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('request_success') }}
                </div>
            @endif

            @if(session('login_success'))
                <div class="success-message">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('login_success') }}
                </div>
            @endif

            @if(session('proposal_response_success'))
                <div class="success-message">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('proposal_response_success') }}
                </div>
            @endif

            <!-- Stats -->
            <div class="stats-grid">

                <div class="card submit-card">
                    <div class="submit-title">
                        <div class="plus">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <span>Submit Project Request</span>
                    </div>
                    <p>Submit a new construction request with location, budget, timeline, and project requirements.</p>
                    <a href="{{ route('client.request.project') }}" class="new-btn">New Request</a>
                </div>

                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon green">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <span>My Requests</span>
                    </div>
                    <div class="stat-number">{{ $totalRequests ?? 0 }}</div>
                    <div class="stat-text">Total submitted requests</div>
                    <a href="#recentRequests" class="view-link">View Requests</a>
                </div>

                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon teal">
                            <i class="fa-solid fa-file-signature"></i>
                        </div>
                        <span>Proposals</span>
                    </div>
                    <div class="stat-number">{{ $proposalCount ?? 0 }}</div>
                    <div class="stat-text">Proposals received</div>
                    <a href="#myProposals" class="view-link">View Proposals</a>
                </div>

                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon yellow">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <span>Pending Actions</span>
                    </div>
                    <div class="stat-number">{{ $pendingRequests ?? 0 }}</div>
                    <div class="stat-text">Waiting for review</div>
                    <a href="#recentRequests" class="review-link">Review Now</a>
                </div>

            </div>

            <!-- Overview -->
            <div class="middle-grid">

                <div class="card">
                    <h3 class="card-title">Project Request Status Overview</h3>

                    <div class="progress-content">
                        <div class="donut">
                            <div class="donut-text">
                                <h2>{{ $totalRequests ?? 0 }}</h2>
                                <p>Total Requests</p>
                            </div>
                        </div>

                        <div class="legend">
                            <div class="legend-item">
                                <div class="legend-left">
                                    <span class="dot" style="background:#fbbf24;"></span>
                                    <span>Pending</span>
                                </div>
                                <strong>{{ $pendingRequests ?? 0 }}</strong>
                            </div>

                            <div class="legend-item">
                                <div class="legend-left">
                                    <span class="dot" style="background:#22c55e;"></span>
                                    <span>Approved</span>
                                </div>
                                <strong>{{ $approvedRequests ?? 0 }}</strong>
                            </div>

                            <div class="legend-item">
                                <div class="legend-left">
                                    <span class="dot" style="background:#047857;"></span>
                                    <span>Completed</span>
                                </div>
                                <strong>{{ $completedRequests ?? 0 }}</strong>
                            </div>

                            <div class="legend-item">
                                <div class="legend-left">
                                    <span class="dot" style="background:#009879;"></span>
                                    <span>Proposals</span>
                                </div>
                                <strong>{{ $proposalCount ?? 0 }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h3 class="card-title">Recent Activity</h3>

                    @forelse(($myRequests ?? collect())->take(4) as $request)
                        <div class="activity-item">
                            <div class="activity-left">
                                <span class="activity-icon"><i class="fa-solid fa-circle"></i></span>
                                <span>
                                    {{ $request->project_type }} request status:
                                    <strong>{{ $request->status }}</strong>
                                </span>
                            </div>
                            <span class="activity-time">{{ $request->updated_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="activity-item">
                            <div class="activity-left">
                                <span>No recent activity yet.</span>
                            </div>
                        </div>
                    @endforelse

                    <a href="#recentRequests" class="view-all">View All Activities</a>
                </div>

            </div>

            <!-- My Requests Table -->
            <div class="table-card" id="recentRequests">
                <h3 class="card-title">My Recent Project Requests</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Request ID</th>
                            <th>Project Type</th>
                            <th>Location</th>
                            <th>Width</th>
                            <th>Height</th>
                            <th>Budget</th>
                            <th>Timeline</th>
                            <th>Status</th>
                            <th>Submitted Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($myRequests ?? [] as $request)
                            <tr>
                                <td>R-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $request->project_type }}</td>
                                <td>{{ $request->location }}</td>
                                 <td>{{ $request->width }} m</td>
                                <td>{{ $request->height }} m</td>
                                <td>LKR {{ number_format($request->budget, 2) }}</td>
                                <td>{{ $request->timeline }}</td>
                                <td>
                                    @if($request->status === 'Pending')
                                        <span class="status pending">Pending</span>
                                    @elseif($request->status === 'Approved')
                                        <span class="status approved">Approved</span>
                                    @elseif($request->status === 'Completed')
                                        <span class="status completed">Completed</span>
                                    @elseif($request->status === 'Rejected')
                                        <span class="status rejected">Rejected</span>
                                    @elseif($request->status === 'Changes Requested')
                                        <span class="status under-review">Changes Requested</span>
                                    @elseif($request->status === 'Proposal Sent')
                                        <span class="status in-progress">Proposal Sent</span>
                                    @else
                                        <span class="status in-progress">{{ $request->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $request->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; color:#6b7280;">
                                    No project requests submitted yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="table-footer">
                    <a href="{{ route('client.request.project') }}">Submit New Request</a>
                </div>
            </div>

            <!-- My Proposals Table -->
            <div class="table-card" id="myProposals">
                <h3 class="card-title">My Proposals</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Proposal ID</th>
                            <th>Request ID</th>
                            <th>Total Budget</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>PDF</th>
                            <th>Client Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($myProposals ?? [] as $proposal)
                            <tr>
                                <td>P-{{ str_pad($proposal->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>R-{{ str_pad($proposal->project_request_id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td>LKR {{ number_format($proposal->total_budget, 2) }}</td>
                                <td>{{ $proposal->estimated_duration }}</td>

                                <td>
                                    @if($proposal->status === 'Sent')
                                        <span class="status pending">Sent</span>
                                    @elseif($proposal->status === 'Approved')
                                        <span class="status approved">Approved</span>
                                    @elseif($proposal->status === 'Rejected')
                                        <span class="status rejected">Rejected</span>
                                    @elseif($proposal->status === 'Changes Requested')
                                        <span class="status under-review">Changes Requested</span>
                                    @else
                                        <span class="status in-progress">{{ $proposal->status }}</span>
                                    @endif
                                </td>

                                <td>
                                    @if($proposal->pdf_path)
                                        <a href="{{ asset('storage/' . $proposal->pdf_path) }}" target="_blank" class="view-link">
                                            View PDF
                                        </a>
                                    @else
                                        No PDF
                                    @endif
                                </td>

                                <td>
                                    @if($proposal->status === 'Sent')
                                        <form method="POST" action="{{ route('proposal.respond', $proposal->id) }}" class="proposal-response-form">
                                            @csrf

                                            <textarea name="response_comment" placeholder="Optional comment"></textarea>

                                            <div class="proposal-action-buttons">
                                                <button type="submit" name="response" value="Approved" class="approve-btn">
                                                    Approve
                                                </button>

                                                <button type="submit" name="response" value="Rejected" class="reject-btn">
                                                    Reject
                                                </button>

                                                <button type="submit" name="response" value="Changes Requested" class="change-btn">
                                                    Request Changes
                                                </button>
                                            </div>
                                        </form>
                                    @else
                                        @if($proposal->response_comment)
                                            <small>{{ $proposal->response_comment }}</small>
                                        @else
                                            <small>Response sent</small>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center; color:#6b7280;">
                                    No proposals received yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</div>

</body>
</html>