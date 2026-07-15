<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Manager Dashboard | CSMS</title>
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

        .sidebar {
            width: 230px;
            background: linear-gradient(180deg, #006b5a, #003f35);
            color: white;
            padding: 22px 16px;
            border-radius: 0 18px 18px 0;
            flex-shrink: 0;
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
        }

        .menu a:hover,
        .menu a.active,
        .menu button:hover {
            background: rgba(255, 255, 255, 0.16);
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
            min-width: 0;
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
            padding: 22px;
            max-width: 100%;
            overflow-x: hidden;
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

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #fecaca;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(150px, 1fr));
            gap: 14px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
        }

        .stat-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #374151;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 18px;
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
        .orange { background: #f59e0b; }
        .red { background: #ef4444; }
        .teal { background: #009879; }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-text {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 14px;
        }

        .view-link,
        .table-footer a {
            color: #047857;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
        }

        .main-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 22px;
            margin-bottom: 25px;
        }

        .card-title {
            font-size: 17px;
            margin-bottom: 18px;
            font-weight: bold;
            color: #111827;
        }

        .card#clientRequests {
            overflow: hidden;
        }

        .request-action-panel {
            background: #ffffff;
            border: 1px solid #dfe5eb;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 22px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        }

        .request-action-panel h3 {
            color: #003f35;
            font-size: 17px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .request-action-grid {
            display: grid;
            grid-template-columns: 1.45fr 1.25fr 1.2fr 150px;
            gap: 14px;
            align-items: end;
        }

        .action-field label {
            display: block;
            color: #374151;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 7px;
        }

        .action-field select {
            width: 100%;
            height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            padding: 0 11px;
            background: white;
            color: #111827;
            outline: none;
            font-size: 13px;
        }

        .action-field select:focus {
            border-color: #047857;
            box-shadow: 0 0 0 3px rgba(4, 120, 87, 0.10);
        }

        .action-button-field button {
            width: 100%;
            height: 42px;
            border: none;
            border-radius: 9px;
            background: #007a5c;
            color: white;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .action-button-field button:hover {
            background: #005f48;
        }

        .action-message {
            margin-top: 12px;
            min-height: 18px;
            font-size: 12px;
            font-weight: bold;
            color: #b45309;
        }

        .selected-request-summary {
            display: none;
            margin-top: 16px;
            padding: 12px 14px;
            border-radius: 10px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            font-size: 12px;
            color: #166534;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
            table-layout: fixed;
        }

        thead {
            background: #f8fafc;
        }

        th,
        td {
            padding: 10px 9px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        th {
            color: #374151;
            font-size: 12px;
            font-weight: 700;
        }

        th:nth-child(1), td:nth-child(1) { width: 75px; }
        th:nth-child(2), td:nth-child(2) { width: 175px; }
        th:nth-child(3), td:nth-child(3) { width: 120px; }
        th:nth-child(4), td:nth-child(4) { width: 130px; }
        th:nth-child(5), td:nth-child(5) { width: 75px; }
        th:nth-child(6), td:nth-child(6) { width: 75px; }
        th:nth-child(7), td:nth-child(7) { width: 110px; }
        th:nth-child(8), td:nth-child(8) { width: 140px; }
        th:nth-child(9), td:nth-child(9) { width: 95px; }
        th:nth-child(10), td:nth-child(10) { width: 110px; }

        .request-row {
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .request-row:hover {
            background: #f8fafc;
        }

        .request-row.selected {
            background: #ecfdf5;
            box-shadow: inset 4px 0 0 #047857;
        }

        .client-info strong {
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
        }

        .client-info small {
            display: block;
            color: #6b7280;
            font-size: 11.5px;
            line-height: 1.35;
        }

        .status {
            padding: 5px 9px;
            border-radius: 12px;
            font-size: 11.5px;
            font-weight: bold;
            display: inline-block;
            white-space: nowrap;
        }

        .status-pending { background: #fef3c7; color: #b45309; }
        .status-review { background: #ecfdf5; color: #047857; }
        .status-approved { background: #dcfce7; color: #15803d; }
        .status-rejected { background: #fee2e2; color: #b91c1c; }
        .status-change { background: #fef3c7; color: #b45309; }
        .status-proposal { background: #e0f2fe; color: #0369a1; }

        .client-response-box {
            margin-top: 7px;
            font-size: 11.5px;
            color: #374151;
            line-height: 1.4;
        }

        .client-response-box small {
            color: #6b7280;
        }

        .table-footer {
            text-align: center;
            margin-top: 14px;
        }

        .empty-row {
            text-align: center;
            color: #6b7280;
            padding: 25px;
        }

        .view-pdf-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 14px;
            background: #047857;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: bold;
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .request-action-grid {
                grid-template-columns: 1fr 1fr;
            }

            table {
                min-width: 1000px;
            }
        }

        @media (max-width: 900px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-radius: 0;
            }

            .stats-grid,
            .request-action-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding: 0 18px;
            }

            .content {
                padding: 18px;
            }

            table {
                min-width: 1000px;
            }
            .modal {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    width: 500px;
    max-width: 92%;
    border-radius: 14px;
    padding: 25px;
    position: relative;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
}

.modal-content h2 {
    margin-bottom: 18px;
    color: #003f35;
}

.close-btn {
    position: absolute;
    right: 18px;
    top: 12px;
    font-size: 28px;
    cursor: pointer;
    color: #6b7280;
}

.modal-content label {
    display: block;
    font-weight: bold;
    margin: 12px 0 6px;
    color: #374151;
}

.modal-content textarea {
    width: 100%;
    min-height: 130px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    outline: none;
    font-size: 14px;
    padding: 11px;
    resize: vertical;
}

.submit-proposal-btn {
    margin-top: 18px;
    width: 100%;
    background: #003f35;
    color: white;
    border: none;
    padding: 13px;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
}

.submit-proposal-btn:hover {
    background: #047857;
}
        }
    
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0,0,0,.55);
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-content {
            background: #fff;
            width: 500px;
            max-width: 100%;
            border-radius: 14px;
            padding: 25px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
        }

        .modal-content h2 {
            margin-bottom: 18px;
            color: #003f35;
        }

        .close-btn {
            position: absolute;
            right: 18px;
            top: 12px;
            font-size: 28px;
            cursor: pointer;
            color: #6b7280;
        }

        .modal-content label {
            display: block;
            font-weight: bold;
            margin: 12px 0 6px;
            color: #374151;
        }

        .modal-content textarea {
            width: 100%;
            min-height: 130px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            padding: 11px;
            resize: vertical;
        }

        .submit-proposal-btn {
            margin-top: 18px;
            width: 100%;
            background: #003f35;
            color: #fff;
            border: none;
            padding: 13px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .submit-proposal-btn:hover {
            background: #047857;
        }
        /* =====================================
   MANAGER SEARCH AND FILTER
===================================== */

.manager-filter-form {
    width: 100%;
    margin-bottom: 20px;
}

.manager-filter-group {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.manager-search-box {
    position: relative;
    flex: 1;
    min-width: 280px;
}

.manager-search-box i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 14px;
}

.manager-search-box input {
    width: 100%;
    height: 44px;
    border: 1px solid #d1d5db;
    border-radius: 9px;
    padding: 0 14px 0 40px;
    background: #ffffff;
    color: #111827;
    font-size: 14px;
    outline: none;
    transition: 0.2s ease;
}

.manager-search-box input::placeholder {
    color: #9ca3af;
}

.manager-status-filter {
    width: 190px;
    height: 44px;
    border: 1px solid #d1d5db;
    border-radius: 9px;
    padding: 0 12px;
    background: #ffffff;
    color: #111827;
    font-size: 14px;
    outline: none;
    cursor: pointer;
    transition: 0.2s ease;
}

.manager-search-box input:focus,
.manager-status-filter:focus {
    border-color: #047857;
    box-shadow: 0 0 0 3px rgba(4, 120, 87, 0.12);
}

.manager-search-btn {
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

.manager-search-btn:hover {
    background: #005f48;
    transform: translateY(-1px);
}

.manager-clear-btn {
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
    gap: 7px;
    transition: 0.2s ease;
}

.manager-clear-btn:hover {
    background: #d1d5db;
    color: #111827;
}

@media (max-width: 768px) {
    .manager-filter-group {
        flex-direction: column;
        align-items: stretch;
    }

    .manager-search-box,
    .manager-status-filter,
    .manager-search-btn,
    .manager-clear-btn {
        width: 100%;
        min-width: 100%;
    }
}

    </style>
</head>

<body>
<div class="dashboard">

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
            <li>
                <a href="#" class="active">
                    <span><i class="fa-solid fa-house"></i></span>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="#clientRequests">
                    <span><i class="fa-solid fa-clipboard-list"></i></span>
                    Client Requests
                </a>
            </li>

            <li>
                <a href="#requestActions">
                    <span><i class="fa-solid fa-file-signature"></i></span>
                    Proposals
                </a>
            </li>

            <li>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit">
                        <span><i class="fa-solid fa-right-from-bracket"></i></span>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </aside>

    <main class="main">
        <div class="topbar">
            <h1>Project Manager Dashboard</h1>

            <div class="top-right">
                <div class="icon-btn" title="New client requests">
                    <i class="fa-solid fa-bell"></i>
                    <span class="badge">{{ $pendingRequests ?? 0 }}</span>
                </div>

                <div class="icon-btn">
                    <i class="fa-solid fa-circle-question"></i>
                </div>

                <div class="user">
                    <div class="avatar">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>

                    <div class="user-info">
                        <h4>{{ Auth::user()->name ?? 'Project Manager' }}</h4>
                        <p>Project Manager</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">

            @if(session('login_success'))
                <div class="success-message">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('login_success') }}
                </div>
            @endif

            @if(session('status_success'))
                <div class="success-message">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('status_success') }}
                </div>
            @endif

            @if(session('proposal_success'))
                <div class="success-message">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('proposal_success') }}
                </div>
            @endif

            @if(session('assign_success') || session('success'))
                <div class="success-message">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('assign_success') ?? session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif

            <div class="stats-grid">
                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon green">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <span>All Requests</span>
                    </div>
                    <div class="stat-number">{{ $totalRequests ?? 0 }}</div>
                    <div class="stat-text">Total client requests</div>
                    <a href="#clientRequests" class="view-link">View Requests</a>
                </div>

                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon orange">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <span>Notifications</span>
                    </div>
                    <div class="stat-number">{{ $pendingRequests ?? 0 }}</div>
                    <div class="stat-text">Pending requests</div>
                    <a href="#clientRequests" class="view-link">Review Now</a>
                </div>

                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon dark-green">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <span>Approved</span>
                    </div>
                    <div class="stat-number">{{ $approvedRequests ?? 0 }}</div>
                    <div class="stat-text">Approved requests</div>
                    <a href="#clientRequests" class="view-link">View Approved</a>
                </div>

                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon red">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                        <span>Rejected</span>
                    </div>
                    <div class="stat-number">{{ $rejectedRequests ?? 0 }}</div>
                    <div class="stat-text">Rejected requests</div>
                    <a href="#clientRequests" class="view-link">View Rejected</a>
                </div>

                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon teal">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <span>Proposals</span>
                    </div>
                    <div class="stat-number">{{ $proposalCount ?? 0 }}</div>
                    <div class="stat-text">PDF proposals sent</div>
                    <a href="#requestActions" class="view-link">Manage Proposals</a>
                </div>
            </div>

            <div class="main-grid">
                <div class="card" id="clientRequests">
                    <h3 class="card-title">
                        Client Request Notifications & Proposal Management
                    </h3>

                    <form method="GET"
      <form method="GET"
      action="{{ route('project.manager.dashboard') }}"
      class="manager-filter-form">

    <div class="manager-filter-group">

        <div class="manager-search-box">
            <i class="fa-solid fa-magnifying-glass"></i>

            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search ID, client, project or location">
        </div>

        <select name="status" class="manager-status-filter">
            <option value="">All Statuses</option>

            <option value="Pending"
                {{ request('status') === 'Pending' ? 'selected' : '' }}>
                Pending
            </option>

            <option value="Assigned"
                {{ request('status') === 'Assigned' ? 'selected' : '' }}>
                Assigned
            </option>

            <option value="In Review"
                {{ request('status') === 'In Review' ? 'selected' : '' }}>
                In Review
            </option>

            <option value="Proposal Sent"
                {{ request('status') === 'Proposal Sent' ? 'selected' : '' }}>
                Proposal Sent
            </option>

            <option value="Approved"
                {{ request('status') === 'Approved' ? 'selected' : '' }}>
                Approved
            </option>

            <option value="Rejected"
                {{ request('status') === 'Rejected' ? 'selected' : '' }}>
                Rejected
            </option>

            <option value="Changes Requested"
                {{ request('status') === 'Changes Requested' ? 'selected' : '' }}>
                Changes Requested
            </option>

            <option value="Completed"
                {{ request('status') === 'Completed' ? 'selected' : '' }}>
                Completed
            </option>
        </select>

        <button type="submit" class="manager-search-btn">
            <i class="fa-solid fa-magnifying-glass"></i>
            Search
        </button>

        @if(request('search') || request('status'))
            <a href="{{ route('project.manager.dashboard') }}"
               class="manager-clear-btn">
                <i class="fa-solid fa-rotate-left"></i>
                Clear
            </a>
        @endif

    </div>
</form>

                    <div class="request-action-panel" id="requestActions">
                        <h3>
                            <i class="fa-solid fa-gear"></i>
                            Request Actions
                        </h3>

                        <div class="request-action-grid">
                            <div class="action-field">
                                <label for="selected_request">Request</label>

                             <select id="selected_request">
    <option value="">Select Request</option>

    @foreach($clientRequests as $item)

        @if($item->technicalReport)

            @php
                $itemProposal = ($proposals ?? collect())
                    ->where('project_request_id', $item->id)
                    ->sortByDesc('created_at')
                    ->first();
            @endphp

            <option
    value="{{ $item->id }}"
    data-status="{{ $item->status }}"
    data-name="{{ $item->name }}"
    data-project="{{ $item->project_type }}"
    data-location="{{ $item->location }}"
    data-has-proposal="{{ $itemProposal ? '1' : '0' }}"
    data-proposal-id="{{ $itemProposal ? $itemProposal->id : '' }}"
    data-proposal-sent="{{ $itemProposal && $itemProposal->status === 'Sent' ? '1' : '0' }}"
    data-pdf-url="{{ $itemProposal
        ? route('proposal.pdf', $itemProposal->id)
        : '' }}"
>
    R-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
    - {{ $item->name }}
</option>

        @endif

    @endforeach
</select>
                            </div>

                            <div class="action-field">
                                <label for="selected_action">Action</label>

                                <select id="selected_action">
                                    <option value="">Select Action</option>
                                    <option value="view_pdf">View Proposal PDF</option>
                                    <option value="create_proposal">Create Proposal</option>
                                    <option value="send_client">Send To Client</option>
                                    <option value="update_status">Update Status</option>
                                    
                                </select>
                            </div>

                            <div class="action-field" id="statusField" style="display:none;">
                                <label for="selected_status">Status</label>

                                <select id="selected_status">
                                    <option value="Pending">Pending</option>
                                    <option value="In Review">In Review</option>
                                    <option value="Proposal Sent">Proposal Sent</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                    <option value="Changes Requested">Changes Requested</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>

                            <div class="action-button-field">
                                <button type="button" id="applyActionBtn">
                                    <i class="fa-solid fa-play"></i>
                                    Apply
                                </button>
                            </div>
                        </div>

                        <div class="selected-request-summary" id="selectedRequestSummary"></div>
                        <p id="actionMessage" class="action-message"></p>
                    </div>

                    <form method="POST" id="hiddenStatusForm" style="display:none;">
                        @csrf
                        <input type="hidden" name="status" id="hiddenStatusInput">
                    </form>

                    <form method="POST" id="hiddenEngineerForm" style="display:none;">
                        @csrf
                    </form>

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Client</th>
                                    <th>Project</th>
                                    <th>Location</th>
                                    <th>Width</th>
                                    <th>Height</th>
                                    <th>Budget</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($clientRequests as $request)
                                    @php
                                        $latestProposal = ($proposals ?? collect())
                                            ->where('project_request_id', $request->id)
                                            ->sortByDesc('created_at')
                                            ->first();
                                    @endphp

                                    <tr class="request-row"
                                        data-request-id="{{ $request->id }}"
                                        onclick="selectRequestFromRow('{{ $request->id }}')">

                                        <td>
                                            R-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}
                                        </td>

                                        <td class="client-info">
                                            <strong>{{ $request->name }}</strong>
                                            <small>{{ $request->phone }}</small>
                                            <small>{{ $request->email }}</small>
                                        </td>

                                        <td>{{ $request->project_type }}</td>
                                        <td>{{ $request->location }}</td>
                                        <td>{{ $request->width ?? '-' }}</td>
                                        <td>{{ $request->height ?? '-' }}</td>
                                        <td>LKR {{ number_format($request->budget, 2) }}</td>

                                        <td>
                                            @if($request->status === 'Pending')
                                                <span class="status status-pending">Pending</span>
                                            @elseif($request->status === 'In Review')
                                                <span class="status status-review">In Review</span>
                                            @elseif($request->status === 'Approved')
                                                <span class="status status-approved">Approved</span>
                                            @elseif($request->status === 'Rejected')
                                                <span class="status status-rejected">Rejected</span>
                                            @elseif($request->status === 'Changes Requested')
                                                <span class="status status-change">Changes Requested</span>
                                            @elseif($request->status === 'Proposal Sent')
                                                <span class="status status-proposal">Proposal Sent</span>
                                            @else
                                                <span class="status status-pending">
                                                    {{ $request->status }}
                                                </span>
                                            @endif

                                            @if($latestProposal)
                                                <div class="client-response-box">
                                                    <small>Proposal:</small>
                                                    <strong>{{ $latestProposal->status }}</strong>

                                                    @if($latestProposal->response_comment)
                                                        <br>
                                                        <small>
                                                            {{ $latestProposal->response_comment }}
                                                        </small>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $request->created_at ? $request->created_at->diffForHumans() : '-' }}
                                        </td>

                                       <td>
    {{-- 1. දැනටමත් Technical Report එකක් තියෙනවා නම් --}}
    @if($request->technicalReport)
        
        @if($latestProposal && !empty($latestProposal->pdf_path))

    @if($latestProposal->status === 'Sent')

        <span style="
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:7px 12px;
            background:#e0f2fe;
            color:#0369a1;
            border-radius:8px;
            font-size:12px;
            font-weight:bold;
        ">
            <i class="fa-solid fa-circle-check"></i>
            Proposal Sent
        </span>

    @else

        <a href="{{ route('proposal.pdf', $latestProposal->id) }}"
           target="_blank"
           class="view-pdf-btn">
            <i class="fa-solid fa-file-pdf"></i>
            View PDF
        </a>
         @endif
        @else
            {{-- Technical Report එක තිබුණත් තවම Proposal PDF එකක් හදලා නැත්නම් --}}
            <span style="color:#9ca3af; font-size:12px; font-weight:bold; display:block;">
                No Proposal PDF
            </span>
        @endif

    {{-- 2. Technical Report එකක් නැති අලුත්ම Request එකක් නම් --}}
    @else
        <div style="margin-bottom: 5px;">
            <span style="color:#dc2626; font-size:12px; font-weight:bold;">
                Technical Report Not Available
            </span>
        </div>

        {{-- 🔄 මෙතනදී තමයි දැනටමත් Send කරලද නැද්ද කියලා බලන්නේ --}}
        @if($request->status == 'Assigned')
            <span style="background-color: #def7ec; color: #03543f; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; display: inline-block;">
                <i class="fa-solid fa-circle-check"></i> Sent to Engineer
            </span>
        @else
            <form action="{{ route('manager.requests.assign', $request->id) }}" method="POST" style="margin-top: 5px;">
                @csrf
                <button type="submit" class="assign-btn" style="background-color: #e8940e; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 11px;">
                    <i class="fa-solid fa-paper-plane"></i>
                    Send To Engineer
                </button>
            </form>
        @endif

    @endif
</td>
                                    </tr>
                                @empty
    <tr>
        <td colspan="10" class="empty-row">

            @if(request('search') || request('status'))
                No matching client requests found.
            @else
                No request notifications found.
            @endif

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
    </main>
    
</div>

<div id="proposalModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeProposalModal()">&times;</span>

        <h2>Create Proposal</h2>

        <form method="POST" id="proposalForm">
            @csrf

            <label for="proposal_details">Terms & Conditions</label>

            <textarea
                name="proposal_details"
                id="proposal_details"
                placeholder="Enter proposal terms and conditions"
                required></textarea>

            <button type="submit" class="submit-proposal-btn">
                <i class="fa-solid fa-file-pdf"></i>
                Create PDF
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const requestSelect = document.getElementById('selected_request');
    const actionSelect = document.getElementById('selected_action');
    const statusField = document.getElementById('statusField');
    const statusSelect = document.getElementById('selected_status');
    const applyBtn = document.getElementById('applyActionBtn');
    const message = document.getElementById('actionMessage');

    function selectedOption() {
        return requestSelect.options[requestSelect.selectedIndex];
    }

    function refreshActionState() {
        const option = selectedOption();
        const createOption = actionSelect.querySelector(
            'option[value="create_proposal"]'
        );

        message.textContent = '';

        if (!option || !option.value) {
            createOption.disabled = false;
            createOption.textContent = 'Create Proposal';
            return;
        }

        if (option.dataset.status) {
            statusSelect.value = option.dataset.status;
        }

        if (option.dataset.hasProposal === '1') {
            createOption.disabled = true;
            createOption.textContent = 'Proposal Already Created';

            if (actionSelect.value === 'create_proposal') {
                actionSelect.value = '';
            }
        } else {
            createOption.disabled = false;
            createOption.textContent = 'Create Proposal';
        }
    }

    requestSelect.addEventListener('change', refreshActionState);

    actionSelect.addEventListener('change', function () {
        statusField.style.display =
            this.value === 'update_status' ? 'block' : 'none';

        message.textContent = '';
    });

    applyBtn.addEventListener('click', function () {
        const option = selectedOption();

        if (!option || !option.value) {
            message.textContent = 'Please select a request.';
            return;
        }

        const requestId = option.value;
        const action = actionSelect.value;

        if (!action) {
            message.textContent = 'Please select an action.';
            return;
        }

        // 1. View PDF Action
        if (action === 'view_pdf') {
            const pdfUrl = option.dataset.pdfUrl;

            if (!pdfUrl) {
                message.textContent = 'Proposal PDF is not available for this request.';
                return;
            }

            window.open(pdfUrl, '_blank');
            return;
        }

        // 2. Create Proposal Action
        if (action === 'create_proposal') {
            if (option.dataset.hasProposal === '1') {
                message.textContent = 'A proposal has already been created for this request.';
                return;
            }

            openProposalModal(requestId);
            return;
        }

        // 3. Send to Client Action (Form Submit ක්‍රමයට නිවැරදි කර ඇත)
        if (action === 'send_client') {
    if (option.dataset.hasProposal !== '1') {
        message.textContent =
            'Please create a proposal before sending it to the client.';
        return;
    }

    if (option.dataset.proposalSent === '1') {
        message.textContent =
            'This proposal has already been sent to the client.';
        return;
    }

    const proposalId = option.dataset.proposalId;

    if (!proposalId) {
        message.textContent = 'Proposal ID is not available.';
        return;
    }

    const confirmed = confirm(
        'Are you sure you want to send this proposal to the client?'
    );

    if (!confirmed) {
        return;
    }

    const form = document.getElementById('hiddenStatusForm');

    form.action =
        '/manager/proposal/' + proposalId + '/send-client';

    form.submit();
    return;
}

        // 4. Update Status Action
        if (action === 'update_status') {
            const form = document.getElementById('hiddenStatusForm');

            document.getElementById('hiddenStatusInput').value = statusSelect.value;

            form.action = '/project-request/' + requestId + '/status';
            form.submit();
        }
    });

    window.selectRequestFromRow = function (id) {
        requestSelect.value = String(id);
        requestSelect.dispatchEvent(new Event('change'));

        document.querySelectorAll('.request-row').forEach(function (row) {
            row.classList.remove('selected');
        });

        const row = document.querySelector(
            '.request-row[data-request-id="' + id + '"]'
        );

        if (row) {
            row.classList.add('selected');
        }
    };

    window.openProposalModal = function (requestId) {
        const modal = document.getElementById('proposalModal');
        const form = document.getElementById('proposalForm');

        form.action = '/project-request/' + requestId + '/proposal';
        modal.style.display = 'flex';

        document.getElementById('proposal_details').focus();
    };

    window.closeProposalModal = function () {
        document.getElementById('proposalModal').style.display = 'none';
    };

    window.addEventListener('click', function (event) {
        const modal = document.getElementById('proposalModal');

        if (event.target === modal) {
            closeProposalModal();
        }
        
    });


    refreshActionState();
});
</script>
</body>
</html>