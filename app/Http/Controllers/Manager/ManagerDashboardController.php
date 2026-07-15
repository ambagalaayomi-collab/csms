<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\ProjectRequest;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        /*
        |--------------------------------------------------------------------------
        | Filtered requests for the table
        |--------------------------------------------------------------------------
        */

        $clientRequests = ProjectRequest::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('id', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('project_type', 'like', '%' . $search . '%')
                        ->orWhere('location', 'like', '%' . $search . '%');
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | All proposals
        |--------------------------------------------------------------------------
        */

        $proposals = Proposal::latest()->get();

        /*
        |--------------------------------------------------------------------------
        | Dashboard card counts
        | Counts remain unchanged when searching/filtering
        |--------------------------------------------------------------------------
        */

        $totalRequests = ProjectRequest::count();

        $pendingRequests = ProjectRequest::where(
            'status',
            'Pending'
        )->count();

        $approvedRequests = ProjectRequest::where(
            'status',
            'Approved'
        )->count();

        $rejectedRequests = ProjectRequest::where(
            'status',
            'Rejected'
        )->count();

        $proposalCount = Proposal::count();

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

        $projectRequest->assigned_engineer_id =
            $request->assigned_engineer_id;

        $projectRequest->due_date = $request->due_date;
        $projectRequest->status = 'Assigned';

        $projectRequest->save();

        return back()->with(
            'success',
            'Request sent to engineer successfully.'
        );
    }
}