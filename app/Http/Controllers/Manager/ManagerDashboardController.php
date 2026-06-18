<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ProjectRequest;
use App\Models\Proposal;
use Illuminate\Http\Request;


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
    public function assignEngineer(Request $request, $id)
{
    $request->validate([
        'assigned_engineer_id' => 'required|exists:users,id',
        'due_date' => 'required|date',
    ]);

    $projectRequest = ProjectRequest::findOrFail($id);

    $projectRequest->assigned_engineer_id = $request->assigned_engineer_id;
    $projectRequest->due_date = $request->due_date;
    $projectRequest->status = 'Assigned';
    $projectRequest->save();

    return back()->with('success', 'Request sent to engineer successfully.');
}
}