<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Engineer Dashboard | CSMS</title>
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

        /* Sidebar */
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
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
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
        .main-grid {
            display: grid;
            grid-template-columns: 2fr 0.9fr;
            gap: 22px;
            margin-bottom: 25px;
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

        .status {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
        }

        .in-progress {
            background: #fef3c7;
            color: #b45309;
        }

        .pending {
            background: #fee2e2;
            color: #b91c1c;
        }

        .completed {
            background: #dcfce7;
            color: #15803d;
        }

        .draft {
            background: #fef3c7;
            color: #b45309;
        }

        .submitted {
            background: #dcfce7;
            color: #15803d;
        }

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

        /* Status update */
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
        }

        .submit-btn:hover {
            background: #007a5c;
        }

        /* Bottom section */
        .bottom-grid {
            display: grid;
            grid-template-columns: 0.9fr 1.6fr 0.9fr;
            gap: 22px;
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
            .menu-icon {
    cursor: pointer;
    font-size: 24px;
    color: white;
}

.sidebar.collapsed {
    width: 90px;
}

.sidebar.collapsed .logo-left span {
    display: none;
}

.sidebar.collapsed .menu a {
    justify-content: center;
    font-size: 0;
}

.sidebar.collapsed .menu a span {
    font-size: 20px;
}

.sidebar.collapsed .logout-form button {
    justify-content: center;
    font-size: 0;
}

.sidebar.collapsed .logout-form button span {
    font-size: 20px;
}
        }
    </style>
    <script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleBtn.addEventListener('click', function () {
        sidebar.classList.toggle('collapsed');
    });
</script>
</head>
<body>
    

<div class="dashboard">

    <!-- Sidebar -->
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
            <li><a href="#" class="active"><span><i class="fa-solid fa-house"></i></span> Dashboard</a></li>
            <li><a href="#"><span><i class="fa-solid fa-list-check"></i></span> Assigned Requests</a></li>
            <li><a href="#"><span><i class="fa-solid fa-ruler-combined"></i></span> Measurements</a></li>
            <li><a href="#"><span><i class="fa-solid fa-calculator"></i></span> Estimates</a></li>
            <li><a href="#"><span><i class="fa-solid fa-file-lines"></i></span> Technical Reports</a></li>
            <li><a href="#"><span><i class="fa-solid fa-chart-line"></i></span> Status Updates</a></li>
            <li><a href="#"><span><i class="fa-solid fa-boxes-stacked"></i></span> Materials</a></li>
           

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

            @if(session('login_success'))
                <div class="success-message">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('login_success') }}
                </div>
            @endif

            <!-- Stat Cards -->
            <div class="stats-grid">
                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon blue">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <span>Assigned Requests</span>
                    </div>
                    <div class="stat-number">6</div>
                    <div class="stat-text">Active Assignments</div>
                    <a href="#" class="view-link">View All</a>
                </div>

                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon green">
                            <i class="fa-solid fa-ruler-combined"></i>
                        </div>
                        <span>Measurements</span>
                    </div>
                    <div class="stat-number">14</div>
                    <div class="stat-text">Pending Verification</div>
                    <a href="#" class="view-link">View All</a>
                </div>

                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon purple">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <span>Reports</span>
                    </div>
                    <div class="stat-number">8</div>
                    <div class="stat-text">Reports Submitted</div>
                    <a href="#" class="view-link">View All</a>
                </div>

                <div class="card">
                    <div class="stat-title">
                        <div class="stat-icon yellow">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <span>Pending Updates</span>
                    </div>
                    <div class="stat-number">3</div>
                    <div class="stat-text">Awaiting Update</div>
                    <a href="#" class="review-link">View All</a>
                </div>
            </div>

            <!-- Middle Section -->
            <div class="main-grid">
                <div class="card">
                    <h3 class="card-title">My Assigned Requests</h3>

                    <table>
                        <thead>
                            <tr>
                                <th>Request ID</th>
                                <th>Title</th>
                                <th>Client</th>
                                <th>Due Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>R-2024-056</td>
                                <td>Office Renovation</td>
                                <td>John Doe</td>
                                <td>May 30, 2024</td>
                                <td><span class="status in-progress">In Progress</span></td>
                            </tr>

                            <tr>
                                <td>R-2024-049</td>
                                <td>Site Office Construction</td>
                                <td>John Doe</td>
                                <td>May 28, 2024</td>
                                <td><span class="status in-progress">In Progress</span></td>
                            </tr>

                            <tr>
                                <td>R-2024-047</td>
                                <td>Community Hall</td>
                                <td>ABC Corp</td>
                                <td>May 25, 2024</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>

                            <tr>
                                <td>R-2024-039</td>
                                <td>Boundary Wall</td>
                                <td>XYZ Ltd.</td>
                                <td>May 27, 2024</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="table-footer">
                        <a href="#">View All Assignments</a>
                    </div>
                </div>

                <div class="card">
                    <h3 class="card-title">Status Update</h3>

                    <form method="POST" action="#">
                        @csrf

                        <div class="form-group">
                            <select name="request_id" required>
                                <option value="">Select Request</option>
                                <option value="R-2024-056">R-2024-056 - Office Renovation</option>
                                <option value="R-2024-049">R-2024-049 - Site Office Construction</option>
                                <option value="R-2024-047">R-2024-047 - Community Hall</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <select name="status" required>
                                <option value="">Update Status</option>
                                <option>In Progress</option>
                                <option>Measurement Completed</option>
                                <option>Report Submitted</option>
                                <option>Delayed</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <textarea name="remarks" placeholder="Add update remarks..."></textarea>
                        </div>

                        <button type="submit" class="submit-btn">
                            Submit Update
                        </button>
                    </form>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="bottom-grid">
                <div class="card">
                    <h3 class="card-title">Measurements Verification</h3>
                    <div class="verification-number">14</div>
                    <div class="verification-text">Pending Verification</div>

                    <div class="percentage">65%</div>
                    <div class="progress-line">
                        <div class="progress-fill"></div>
                    </div>
                </div>

                <div class="card">
                    <h3 class="card-title">Recent Reports</h3>

                    <ul class="report-list">
                        <li>
                            <span>TR-2024-056</span>
                            <span>Office Renovation - Structural Report</span>
                            <span>May 30, 2024</span>
                            <span class="status submitted">Submitted</span>
                        </li>

                        <li>
                            <span>TR-2024-055</span>
                            <span>Site Office - Material Report</span>
                            <span>May 28, 2024</span>
                            <span class="status submitted">Submitted</span>
                        </li>

                        <li>
                            <span>TR-2024-054</span>
                            <span>Boundary Wall - Site Inspection</span>
                            <span>May 26, 2024</span>
                            <span class="status draft">Draft</span>
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
                </div>
            </div>

        </div>
    </main>

</div>


</body>
</html>