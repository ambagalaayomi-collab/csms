<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Controllers\Engineer\EstimateController;
use App\Http\Controllers\Engineer\TechnicalReportController;
use App\Http\Controllers\Manager\ProposalController;

use App\Models\ProjectRequest;
use App\Models\Proposal;
use App\Models\TechnicalReport;
use App\Models\User;


/*
|--------------------------------------------------------------------------
| Home & Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'client' => redirect()->route('client.dashboard'),
            'project_manager' => redirect()->route('project.manager.dashboard'),
            'engineer' => redirect()->route('engineer.dashboard'),
            default => view('welcome'),
        };
    }
    return view('welcome');
})->name('home');

Route::get('/login', function () { return redirect('/'); });
Route::get('/register', function () { return redirect('/'); });

/*
|--------------------------------------------------------------------------
| Authentication Actions
|--------------------------------------------------------------------------
*/
Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'role' => 'required|in:client,project_manager,engineer',
    ]);

    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role'],
    ]);

    return redirect('/')
        ->with('register_success', 'Registration successful. Please login.')
        ->with('open_login_modal', true);
})->name('register');

Route::post('/login', function (Request $request) {
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'role' => 'required|in:client,project_manager,engineer',
    ]);

    if (Auth::attempt([
        'email' => $validated['email'],
        'password' => $validated['password'],
        'role' => $validated['role'],
    ])) {
        $request->session()->regenerate();

        return match (Auth::user()->role) {
            'client' => redirect()->route('client.dashboard')->with('login_success', 'Login successful.'),
            'project_manager' => redirect()->route('project.manager.dashboard')->with('login_success', 'Login successful.'),
            'engineer' => redirect()->route('engineer.dashboard')->with('login_success', 'Login successful.'),
            default => redirect('/'),
        };
    }

    return back()
        ->withErrors(['login_error' => 'Invalid email, password, or role.'])
        ->withInput()
        ->with('open_login_modal', true);
})->name('login');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes Group
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {

    /*
    |--------------------------------------------------------------------------
    | Client Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => [function ($request, $next) {
        if (Auth::user()->role !== 'client') { abort(403); }
        return $next($request);
    }]], function () {

        Route::get('/client/request-project', function () {
            return view('client.request_project');
        })->name('client.request.project');

        Route::post('/project-request/store', function (Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'email' => 'required|email|max:255',
                'project_type' => 'required|string|max:100',
                'location' => 'required|string|max:255',
                'width' => 'required|numeric|min:0',
                'height' => 'required|numeric|min:0',
                'budget' => 'required|numeric|min:0',
                'timeline' => 'required|string|max:100',
                'requirements' => 'required|string',
            ]);

            ProjectRequest::create([
                'client_id' => Auth::id(),
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'project_type' => $validated['project_type'],
                'location' => $validated['location'],
                'width' => $validated['width'],
                'height' => $validated['height'],
                'budget' => $validated['budget'],
                'timeline' => $validated['timeline'],
                'requirements' => $validated['requirements'],
                'status' => 'Pending',
            ]);

            return redirect()->route('client.dashboard')->with('request_success', 'Project request submitted successfully.');
        })->name('project.request.store');

       Route::get('/client/dashboard', function (Request $request) {

    $clientId = Auth::id();

    $search = $request->input('search');
    $status = $request->input('status');

    $myRequests = ProjectRequest::where('client_id', $clientId)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                    ->orWhere('project_type', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%');
            });
        })
        ->when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->latest()
        ->get();

    $myProposals = Proposal::whereHas(
        'projectRequest',
        function ($query) use ($clientId) {
            $query->where('client_id', $clientId);
        }
    )
        ->whereNotNull('pdf_path')
        ->latest()
        ->get();

    return view('client.dashboard', [
        'myRequests' => $myRequests,
        'myProposals' => $myProposals,
        'totalRequests' => ProjectRequest::where(
            'client_id',
            $clientId
        )->count(),
        'pendingRequests' => ProjectRequest::where(
            'client_id',
            $clientId
        )->where('status', 'Pending')->count(),
        'approvedRequests' => ProjectRequest::where(
            'client_id',
            $clientId
        )->where('status', 'Approved')->count(),
        'completedRequests' => ProjectRequest::where(
            'client_id',
            $clientId
        )->where('status', 'Completed')->count(),
        'proposalCount' => $myProposals->count(),
        'notificationCount' => $myProposals->count(),
    ]);

})->name('client.dashboard');

Route::post('/proposal/{id}/respond', function (
    Request $request,
    $id
) {
    $validated = $request->validate([
        'response' => [
            'required',
            'in:Approved,Rejected,Changes Requested'
        ],
        'response_comment' => [
            'nullable',
            'string',
            'max:1000'
        ],
    ]);

    $proposal = Proposal::findOrFail($id);

    // අදාළ clientගේ proposal එකද බලනවා
    if ((int) $proposal->client_id !== (int) Auth::id()) {
        abort(403);
    }

    $proposal->update([
        'status' => $validated['response'],
        'response_comment' =>
            $validated['response_comment'] ?? null,
    ]);

   $projectRequest = ProjectRequest::findOrFail(
    $proposal->project_request_id
);

$projectRequest->status = $validated['response'];
$projectRequest->save();

$technicalReport = TechnicalReport::where(
        'req_id',
        $projectRequest->id
    )
    ->orderByDesc('report_id')
    ->firstOrFail();

$manager = User::find($proposal->manager_id);

$pdf = Pdf::loadView('pdf.proposal', [
    'proposal' => $proposal->fresh(),
    'projectRequest' => $projectRequest,
    'technicalReport' => $technicalReport,
    'manager' => $manager,
]);

if ($proposal->pdf_path) {
    Storage::disk('public')->put(
        $proposal->pdf_path,
        $pdf->output()
    );
}

return redirect()
    ->route('client.dashboard')
    ->with(
        'proposal_response_success',
        'Your response was sent successfully.'
    );
})->name('proposal.respond');


});
   

    /*
    |--------------------------------------------------------------------------
    | Project Manager Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => [function ($request, $next) {
        if (Auth::user()->role !== 'project_manager') { abort(403); }
        return $next($request);
    }]], function () {

        Route::get('/project-manager/dashboard', function (Request $request) {

    $search = trim((string) $request->query('search', ''));
    $status = $request->query('status');

    // R-0005 ලෙස search කළත් database ID 5 ලෙස හඳුනාගැනීමට
    $searchId = preg_replace('/[^0-9]/', '', $search);

    $clientRequests = ProjectRequest::with([
            'technicalReport',
            'estimate'
        ])
        ->when($search !== '', function ($query) use ($search, $searchId) {

            $query->where(function ($subQuery) use ($search, $searchId) {

                $subQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('project_type', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");

                if ($searchId !== '') {
                    $subQuery->orWhere('id', $searchId);
                }
            });
        })
        ->when(!empty($status), function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->latest()
        ->get();

    $proposals = Proposal::latest()->get();

    // Dashboard cards සඳහා filter නොකළ සියලු requests
    $allClientRequests = ProjectRequest::all();

    return view('project_manager.dashboard', [
        'clientRequests' => $clientRequests,
        'proposals' => $proposals,

        'totalRequests' => $allClientRequests->count(),

        'pendingRequests' => $allClientRequests
            ->where('status', 'Pending')
            ->count(),

        'inReviewRequests' => $allClientRequests
            ->where('status', 'In Review')
            ->count(),

        'approvedRequests' => $allClientRequests
            ->where('status', 'Approved')
            ->count(),

        'rejectedRequests' => $allClientRequests
            ->where('status', 'Rejected')
            ->count(),

        'changesRequested' => $allClientRequests
            ->where('status', 'Changes Requested')
            ->count(),

        'proposalSentRequests' => $allClientRequests
            ->where('status', 'Proposal Sent')
            ->count(),

        'proposalCount' => $proposals->count(),

        'sentProposals' => $proposals
            ->where('status', 'Sent')
            ->count(),

        'approvedProposals' => $proposals
            ->where('status', 'Approved')
            ->count(),

        'rejectedProposals' => $proposals
            ->where('status', 'Rejected')
            ->count(),

        'changedProposals' => $proposals
            ->where('status', 'Changes Requested')
            ->count(),
    ]);

})->name('project.manager.dashboard');

        Route::post('/project-request/{id}/status', function (Request $request, $id) {
            $validated = $request->validate([
                'status' => 'required|in:Pending,In Review,Approved,Rejected,Changes Requested,Completed,Proposal Sent',
            ]);

            $projectRequest = ProjectRequest::findOrFail($id);
            $projectRequest->status = $validated['status'];
            $projectRequest->save();

            return redirect()->route('project.manager.dashboard')->with('status_success', 'Request status updated successfully.');
        })->name('project.request.status.update');

        Route::post('/manager/requests/{id}/assign', function ($id) {
            $engineer = User::where('role', 'engineer')->first();

            if (!$engineer) {
                return back()->with('error', 'No engineer account is available.');
            }

            $projectRequest = ProjectRequest::findOrFail($id);
            $projectRequest->assigned_engineer_id = $engineer->id;
            $projectRequest->due_date = now()->addDays(7);
            $projectRequest->status = 'Assigned';
            $projectRequest->save();

            return back()->with('success', 'Request sent to the engineer successfully.');
        })->name('manager.requests.assign');

        /* Create Proposal PDF (Duplicate එක ඉවත් කර තනි රවුට් එකක් ලෙස තබා ඇත) */
        Route::post('/project-request/{id}/proposal', function (Request $request, $id) {
            $validated = $request->validate([
                'proposal_details' => 'required|string',
            ]);

            $projectRequest = ProjectRequest::findOrFail($id);

            $existingProposal = Proposal::where('project_request_id', $projectRequest->id)->first();
            if ($existingProposal) {
                return redirect()->route('project.manager.dashboard')->with('error', 'A proposal has already been created for this request.');
            }

            $technicalReport = TechnicalReport::where('req_id', $projectRequest->id)
                ->orderByDesc('report_id')
                ->first();

            if (!$technicalReport) {
                return redirect()->route('project.manager.dashboard')->with('error', 'Technical report is not available for this request.');
            }

            if ($technicalReport->total_budget === null) {
                return redirect()->route('project.manager.dashboard')->with('error', 'Total budget is not available.');
            }

            $duration = $technicalReport->estimated_duration ?: $technicalReport->duration ?: 'Not specified';

            $proposal = Proposal::create([
                'project_request_id' => $projectRequest->id,
                'client_id' => $projectRequest->client_id,
                'manager_id' => Auth::id(),
                'proposal_details' => $validated['proposal_details'],
                'total_budget' => $technicalReport->total_budget,
                'estimated_duration' => $duration,
                'status' => 'Sent',
            ]);

            $pdf = Pdf::loadView('pdf.proposal', [
                'proposal' => $proposal,
                'projectRequest' => $projectRequest,
                'technicalReport' => $technicalReport,
                'manager' => Auth::user(),
            ]);

            $fileName = 'proposal_' . $proposal->id . '.pdf';
            $pdfPath = 'proposals/' . $fileName;

            Storage::disk('public')->put($pdfPath, $pdf->output());

            $proposal->update(['pdf_path' => $pdfPath]);

            $projectRequest->status = 'Proposal Sent';
            $projectRequest->save();

            return redirect()->route('project.manager.dashboard')->with('proposal_success', 'Proposal PDF created successfully.');
        })->name('proposal.store');

        Route::post('/proposal/{id}/status', function (Request $request, $id) {
            $validated = $request->validate([
                'status' => 'required|in:Sent,In Review,Approved,Rejected,Changes Requested,draft',
            ]);

            $proposal = Proposal::findOrFail($id);
            $proposal->status = $validated['status'];
            $proposal->save();

            $projectRequest = ProjectRequest::find($proposal->project_request_id ?? $proposal->request_id);
            if ($projectRequest) {
                $projectRequest->status = ($validated['status'] === 'Sent') ? 'Proposal Sent' : $validated['status'];
                $projectRequest->save();
            }

            return redirect()->route('project.manager.dashboard')->with('proposal_status_success', 'Proposal status updated.');
        })->name('proposal.status.update');

        /* Controller-driven Proposal Management */
        Route::prefix('manager')->name('manager.')->group(function () {
            Route::get('/proposals/create/{technicalReport}', [ProposalController::class, 'create'])->name('proposals.create');
            Route::post('/proposals', [ProposalController::class, 'store'])->name('proposals.store');
            Route::get('/proposals/{proposal}', [ProposalController::class, 'show'])->name('proposals.show');
            Route::get('/proposals/{proposal}/pdf', [ProposalController::class, 'generatePdf'])->name('proposals.pdf');
        });

        Route::post('/manager/proposal/{id}/send-client', [ProposalController::class, 'sendToClient'])->name('proposal.send.client');
    });
    Route::middleware(['auth'])->group(function () {
    Route::post(
    '/manager/proposal/{id}/send-client',
    [ProposalController::class, 'sendToClient']
)->name('proposal.send.client');
});
    /*
    |--------------------------------------------------------------------------
    | Engineer Routes
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => [function ($request, $next) {
        if (Auth::user()->role !== 'engineer') { abort(403); }
        return $next($request);
    }]], function () {
        
        Route::prefix('engineer')->name('engineer.')->group(function () {
            Route::get('/dashboard', function (Request $request) {
$search = $request->input('search');
$status = $request->input('status');

$assignedRequests = ProjectRequest::with([
        'technicalReport',
        'estimate'
    ])
    ->where('assigned_engineer_id', Auth::id())

    ->when($search, function ($query) use ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('id', 'like', "%{$search}%")
              ->orWhere('project_type', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%");
        });
    })

    ->when($status, function ($query) use ($status) {
        $query->where('status', $status);
    })

    ->get()
    ->sortByDesc(function ($request) {
        return max(
            $request->technicalReport?->updated_at?->timestamp ?? 0,
            $request->estimate?->updated_at?->timestamp ?? 0,
            $request->updated_at?->timestamp ?? 0
        );
    })
    ->values();
                return view('engineer.dashboard', [
                    'assignedRequests' => $assignedRequests,
                    'assignedCount' => $assignedRequests->count(),
                ]);
            })->name('dashboard');

            Route::post('/status-update', function (Request $request) {
                $validated = $request->validate([
                    'request_id' => 'required|exists:project_requests,id',
                    'status' => 'required|string',
                    'remarks' => 'required|string',
                ]);

                $projectRequest = ProjectRequest::findOrFail($validated['request_id']);
                if ($projectRequest->assigned_engineer_id !== Auth::id()) { abort(403); }

                $projectRequest->status = $validated['status'];
                $projectRequest->save();

                return redirect()->route('engineer.dashboard')->with('success', 'Status updated successfully!');
            })->name('status.update');

            Route::get('/estimates', [EstimateController::class, 'create'])->name('estimates');
            Route::post('/estimates/store', [EstimateController::class, 'store'])->name('estimates.store');
            Route::get('/estimates/create/{project_request_id}', [EstimateController::class, 'create'])->name('estimates.create');
            Route::get('/estimates/{id}/report', [EstimateController::class, 'generateReport'])->name('estimates.report');
            Route::get('/estimate/{id}/pdf', [EstimateController::class, 'downloadPDF'])->name('estimate.pdf');
            Route::get('/technical-report/{project_request_id}', [EstimateController::class, 'showReport'])->name('technicalreport.create');
            Route::post('/technical-report/store', [TechnicalReportController::class, 'storeTechnicalReport'])->name('technical_report.store');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Shared PDF Views
    |--------------------------------------------------------------------------
    */
    Route::get('/proposal/{id}/pdf', function ($id) {
        if (!in_array(Auth::user()->role, ['project_manager', 'client'])) { abort(403); }

        $proposal = Proposal::findOrFail($id);
        if (Auth::user()->role === 'client' && $proposal->client_id !== Auth::id()) { abort(403); }

        $projectRequest = ProjectRequest::findOrFail($proposal->project_request_id ?? $proposal->request_id);

        $technicalReport = TechnicalReport::where('req_id', $projectRequest->id)
            ->orderByDesc('report_id')
            ->first();

        if (!$technicalReport) { abort(404, 'Technical report not found.'); }

        $manager = User::find($proposal->manager_id) ?? Auth::user();
        $pdf = Pdf::loadView('pdf.proposal', compact('proposal', 'projectRequest', 'technicalReport', 'manager'));

        return $pdf->stream('proposal_' . $proposal->id . '.pdf');
    })->name('proposal.pdf');

    Route::get('/view-technical-report-pdf/{id}', [TechnicalReportController::class, 'generatePDF'])->name('view.technical_report.pdf');
});