<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ProjectRequest;
use App\Models\Proposal;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        $clientRequests = ProjectRequest::orderBy('created_at', 'desc')->get();
        $proposals = Proposal::latest()->get();

        $totalRequests = $clientRequests->count();
        $pendingRequests = $clientRequests->where('status', 'Pending')->count();
        $approvedRequests = $clientRequests->where('status', 'Approved')->count();
        $rejectedRequests = $clientRequests->where('status', 'Rejected')->count();
        $proposalCount = $proposals->count();

        return view('project_manager.dashboard', compact(
            'clientRequests',
            'proposals',
            'totalRequests',
            'pendingRequests',
            'approvedRequests',
            'rejectedRequests',
            'proposalCount'
        ));
    }
}