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

        th, td {
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
        th:nth-child(10), td:nth-child(10) { width: 215px; }

        td {
            color: #111827;
            word-break: break-word;
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

        .action-box {
            width: 195px;
            display: grid;
            gap: 7px;
        }

        .status-form {
            display: grid;
            gap: 6px;
            padding-bottom: 7px;
            border-bottom: 1px solid #e5e7eb;
        }

        .status-form select,
        .modal-content textarea,
        .modal-content input {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 7px;
            font-size: 11.5px;
            outline: none;
        }

        .status-form select {
            height: 34px;
        }

        .update-btn,
        .proposal-btn {
            height: 34px;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }

        .update-btn {
            background: #007a5c;
        }

        .proposal-btn {
            background: #003f35;
        }

        .update-btn:hover {
            background: #005f48;
        }

        .proposal-btn:hover {
            background: #047857;
        }

        .view-pdf-btn {
            height: 32px;
            border-radius: 8px;
            background: #047857;
            color: white;
            text-decoration: none;
            font-size: 11.5px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            inset: 0;
            background: rgba(0,0,0,0.55);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            width: 550px;
            max-width: 92%;
            border-radius: 14px;
            padding: 25px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
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

        .modal-content textarea,
        .modal-content input {
            font-size: 14px;
            padding: 11px;
            margin-top: 4px;
            margin-bottom: 10px;
        }

        .modal-content textarea {
            min-height: 120px;
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

        /* Responsive Breakpoints */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            table {
                min-width: 1250px;
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

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding: 0 18px;
            }

            .content {
                padding: 18px;
            }

            table {
                min-width: 1250px;
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
                <a href="#clientRequests">
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
                    <a href="#clientRequests" class="view-link">Create Proposal</a>
                </div>

            </div>

            <div class="main-grid">
                <div class="card" id="clientRequests">
                    <h3 class="card-title">Client Request Notifications & Proposal Management</h3>

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

                                    <tr>
                                        <td>R-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</td>

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
                                                <span class="status status-pending">{{ $request->status }}</span>
                                            @endif

                                            @if($latestProposal)
                                                <div class="client-response-box">
                                                    <small>Proposal:</small>
                                                    <strong>{{ $latestProposal->status }}</strong>

                                                    @if($latestProposal->response_comment)
                                                        <br>
                                                        <small>{{ $latestProposal->response_comment }}</small>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>

                                        <td>{{ $request->created_at ? $request->created_at->format('M d, Y') : '-' }}</td>

                                        <td>
                                            <div class="action-box">
                                                <form method="POST" action="{{ route('project.request.status.update', $request->id) }}" class="status-form">
                                                    @csrf
                                                    <select name="status" required>
                                                        <option value="Pending" {{ $request->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="In Review" {{ $request->status === 'In Review' ? 'selected' : '' }}>In Review</option>
                                                        <option value="Proposal Sent" {{ $request->status === 'Proposal Sent' ? 'selected' : '' }}>Proposal Sent</option>
                                                    </select>
                                                    <button type="submit" class="update-btn">Update</button>
                                                </form>

                                                @if($latestProposal && $latestProposal->pdf_path)
                                                    <a href="{{ asset('storage/' . $latestProposal->pdf_path) }}" target="_blank" class="view-pdf-btn">
                                                        <i class="fa-solid fa-file-pdf"></i>
                                                        View PDF
                                                    </a>
                                                @endif

                                                <button type="button" class="proposal-btn" onclick="openProposalModal('{{ $request->id }}')">
                                                    Create Proposal
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="empty-row">
                                            No client requests received yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="table-footer">
                        <a href="#clientRequests">Latest requests are shown first</a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Proposal Modal -->
        <div id="proposalModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeProposalModal()">&times;</span>

                <h2>Create Proposal</h2>

                <form method="POST" id="proposalForm">
                    @csrf

                    <label for="proposal_details">Terms & Conditions</label>
                    <textarea
                        id="proposal_details"
                        name="proposal_details"
                        placeholder="Enter proposal details"
                        required></textarea>

                    <label for="total_budget">Total Budget</label>
                    <input
                        id="total_budget"
                        type="number"
                        name="total_budget"
                        placeholder="Enter total budget"
                        required>

                    <label for="estimated_duration">Estimated Duration</label>
                    <input
                        id="estimated_duration"
                        type="text"
                        name="estimated_duration"
                        placeholder="Estimated duration (e.g. 6 Months)"
                        required>

                    <button type="submit" class="submit-proposal-btn">
                        Create PDF
                    </button>
                </form>
            </div>
        </div>
    </main>

</div>

<script>
function openProposalModal(requestId) {
    const modal = document.getElementById('proposalModal');
    const form = document.getElementById('proposalForm');

    form.action = '/project-request/' + requestId + '/proposal';
    modal.style.display = 'flex';
}

function closeProposalModal() {
    document.getElementById('proposalModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('proposalModal');

    if (event.target === modal) {
        closeProposalModal();
    }
}
</script>

</body>
</html>