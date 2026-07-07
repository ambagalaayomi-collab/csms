<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProjectRequest;
use App\Models\Proposal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Engineer\TechnicalReportController;
use App\Http\Controllers\Engineer\EstimateController;

// 🏠 HOME
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'client') {
            return redirect()->route('client.dashboard');
        }
        if (Auth::user()->role === 'project_manager') {
            return redirect()->route('project.manager.dashboard');
        }
        if (Auth::user()->role === 'engineer') {
            return redirect()->route('engineer.dashboard');
        }
    }
    return view('welcome');
})->name('home');

// 🔒 LOGIN / REGISTER REDIRECTS
Route::get('/login', function () { return redirect('/'); });
Route::get('/register', function () { return redirect('/'); });

// 📝 REGISTER STORE
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'role' => 'required|in:client,project_manager,engineer',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect('/')
        ->with('register_success', 'Registration successful. Please login.')
        ->with('open_login_modal', true);
})->name('register');

// 🔑 LOGIN STORE
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'role' => 'required|in:client,project_manager,engineer',
    ]);

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => $request->role])) {
        $request->session()->regenerate();
        if (Auth::user()->role === 'client') return redirect()->route('client.dashboard')->with('login_success', 'Login successful.');
        if (Auth::user()->role === 'project_manager') return redirect()->route('project.manager.dashboard')->with('login_success', 'Login successful.');
        if (Auth::user()->role === 'engineer') return redirect()->route('engineer.dashboard')->with('login_success', 'Login successful.');
    }

    return back()->withErrors(['login_error' => 'Invalid email, password, or role.'])->withInput()->with('open_login_modal', true);
})->name('login');

// 🚪 LOGOUT
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');


// ==========================================
// 🔒 AUTH MIDDLEWARE GROUP (DASHBOARDS & ACTIONS)
// ==========================================
Route::middleware('auth')->group(function () {

    // 🧑‍Group A: CLIENT ROUTES
    Route::get('/client/request-project', function () {
        if (Auth::user()->role !== 'client') abort(403);
        return view('client.request_project');
    })->name('client.request.project');

    Route::post('/project-request/store', function (Request $request) {
        if (Auth::user()->role !== 'client') abort(403);
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

    Route::get('/client/dashboard', function () {
        if (Auth::user()->role !== 'client') abort(403);
        $myRequests = ProjectRequest::where('client_id', Auth::id())->latest()->get();
        $myProposals = Proposal::where('client_id', Auth::id())->latest()->get();
        return view('client.dashboard', [
            'myRequests' => $myRequests, 'myProposals' => $myProposals,
            'totalRequests' => $myRequests->count(), 'pendingRequests' => $myRequests->where('status', 'Pending')->count(),
            'approvedRequests' => $myRequests->where('status', 'Approved')->count(), 'completedRequests' => $myRequests->where('status', 'Completed')->count(),
            'proposalCount' => $myProposals->count()
        ]);
    })->name('client.dashboard');

    Route::post('/proposal/{id}/respond', function (Request $request, $id) {
        if (Auth::user()->role !== 'client') abort(403);
        $request->validate(['response' => 'required|in:Approved,Rejected,Changes Requested', 'response_comment' => 'nullable|string|max:1000']);
        $proposal = Proposal::findOrFail($id);
        if ($proposal->client_id !== Auth::id()) abort(403);
        $proposal->update(['status' => $request->response, 'response_comment' => $request->response_comment]);
        $projectRequest = ProjectRequest::find($proposal->project_request_id);
        if ($projectRequest) { $projectRequest->status = $request->response; $projectRequest->save(); }
        return redirect()->route('client.dashboard')->with('proposal_response_success', 'Your response was sent successfully.');
    })->name('proposal.respond');


    // 👔 Group B: PROJECT MANAGER ROUTES
    Route::get('/project-manager/dashboard', function () {
        if (Auth::user()->role !== 'project_manager') abort(403);
        $clientRequests = ProjectRequest::latest()->get();
        $proposals = Proposal::latest()->get();
        return view('project_manager.dashboard', [
            'clientRequests' => $clientRequests, 'proposals' => $proposals,
            'totalRequests' => $clientRequests->count(), 'pendingRequests' => $clientRequests->where('status', 'Pending')->count(),
            'inReviewRequests' => $clientRequests->where('status', 'In Review')->count(), 'approvedRequests' => $clientRequests->where('status', 'Approved')->count(),
            'rejectedRequests' => $clientRequests->where('status', 'Rejected')->count(), 'changesRequested' => $clientRequests->where('status', 'Changes Requested')->count(),
            'proposalSentRequests' => $clientRequests->where('status', 'Proposal Sent')->count(), 'proposalCount' => $proposals->count(),
            'sentProposals' => $proposals->where('status', 'Sent')->count(), 'approvedProposals' => $proposals->where('status', 'Approved')->count(),
            'rejectedProposals' => $proposals->where('status', 'Rejected')->count(), 'changedProposals' => $proposals->where('status', 'Changes Requested')->count()
        ]);
    })->name('project.manager.dashboard');

    Route::post('/project-request/{id}/status', function (Request $request, $id) {
        if (Auth::user()->role !== 'project_manager') abort(403);
        $request->validate(['status' => 'required|in:Pending,In Review,Approved,Rejected,Changes Requested,Completed,Proposal Sent']);
        $projectRequest = ProjectRequest::findOrFail($id);
        $projectRequest->status = $request->status;
        $projectRequest->save();
        return redirect()->route('project.manager.dashboard')->with('status_success', 'Request status updated successfully.');
    })->name('project.request.status.update');

    Route::post('/project-request/{id}/proposal', function (Request $request, $id) {
        if (Auth::user()->role !== 'project_manager') abort(403);
        $request->validate(['proposal_details' => 'required|string', 'total_budget' => 'required|numeric|min:0', 'estimated_duration' => 'required|string|max:100']);
        $projectRequest = ProjectRequest::findOrFail($id);
        $proposal = Proposal::create([
            'project_request_id' => $projectRequest->id, 'client_id' => $projectRequest->client_id, 'manager_id' => Auth::id(),
            'proposal_details' => $request->proposal_details, 'total_budget' => $request->total_budget, 'estimated_duration' => $request->estimated_duration, 'status' => 'Sent'
        ]);
        $pdf = Pdf::loadView('pdf.proposal', ['proposal' => $proposal, 'projectRequest' => $projectRequest, 'manager' => Auth::user()]);
        $fileName = 'proposal_' . $proposal->id . '.pdf';
        $pdfPath = 'proposals/' . $fileName;
        Storage::disk('public')->put($pdfPath, $pdf->output());
        $proposal->update(['pdf_path' => $pdfPath]);
        $projectRequest->status = 'Proposal Sent';
        $projectRequest->save();
        return redirect()->route('project.manager.dashboard')->with('proposal_success', 'Proposal PDF created and sent successfully.');
    })->name('proposal.store');

    Route::post('/proposal/{id}/status', function (Request $request, $id) {
        if (Auth::user()->role !== 'project_manager') abort(403);
        $request->validate(['status' => 'required|in:Sent,In Review,Approved,Rejected,Changes Requested']);
        $proposal = Proposal::findOrFail($id);
        $proposal->status = $request->status;
        $proposal->save();
        $projectRequest = ProjectRequest::find($proposal->project_request_id);
        if ($projectRequest) { $projectRequest->status = ($request->status === 'Sent') ? 'Proposal Sent' : $request->status; $projectRequest->save(); }
        return redirect()->route('project.manager.dashboard')->with('proposal_status_success', 'Proposal status updated.');
    })->name('proposal.status.update');

    Route::post('/manager/requests/{id}/assign', function ($id) {
        if (Auth::user()->role !== 'project_manager') abort(403);
        $engineer = User::where('role', 'engineer')->first();
        if (!$engineer) return back()->with('error', 'No engineer found.');
        $projectRequest = ProjectRequest::findOrFail($id);
        $projectRequest->assigned_engineer_id = $engineer->id;
        $projectRequest->due_date = now()->addDays(7);
        $projectRequest->status = 'Assigned';
        $projectRequest->save();
        return back()->with('success', 'Request sent to engineer successfully.');
    })->name('manager.requests.assign');


    // 👷 Group C: ENGINEER PREFIX GROUP
    Route::prefix('engineer')->name('engineer.')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', function () {
            if (Auth::user()->role !== 'engineer') abort(403);
            $assignedRequests = ProjectRequest::with(['technicalReport', 'estimate'])->where('assigned_engineer_id', Auth::id())->latest()->get();
            return view('engineer.dashboard', ['assignedRequests' => $assignedRequests, 'assignedCount' => $assignedRequests->count()]);
        })->name('dashboard');

        // Status Update
        Route::post('/status-update', function (Request $request) {
            $request->validate(['request_id' => 'required|exists:project_requests,id', 'status' => 'required|string', 'remarks' => 'required|string']);
            $projectRequest = ProjectRequest::findOrFail($request->request_id);
            if ($projectRequest->assigned_engineer_id !== Auth::id()) abort(403);
            $projectRequest->status = $request->status;
            $projectRequest->save();
            return redirect()->route('engineer.dashboard')->with('success', 'Status updated successfully!');
        })->name('status.update');

        // Estimates Routes
        Route::get('/estimates', [EstimateController::class, 'create'])->name('estimates');
        Route::post('/estimates/store', [EstimateController::class, 'store'])->name('estimates.store');
        Route::get('/estimates/create/{project_request_id}', [EstimateController::class, 'create'])->name('estimates.create');
        Route::get('/estimates/{id}/report', [EstimateController::class, 'generateReport'])->name('estimates.report');
        Route::get('/estimate/{id}/pdf', [EstimateController::class, 'downloadPDF'])->name('estimate.pdf');

        // Technical Reports View/Create
        Route::get('/technical-report/{project_request_id}', [EstimateController::class, 'showReport'])->name('technicalreport.create');
        
        // 💾 FORM SUBMIT කරන සහ එවලේම PDF පෙන්වන ප්‍රධාන මෙතඩ් එක!
        Route::post('/technical-report/store', [TechnicalReportController::class, 'storeTechnicalReport'])->name('technical_report.store');
    });

    // 📄 💡 ඩෑෂ්බෝඩ් එකේ බටන් එක ක්ලික් කරාම පී.ඩී.එෆ් එක බලන්න මෙන්න මේ රවුට් එක විතරයි දැන් පාවිච්චි වෙන්නේ!
    Route::get('/view-technical-report-pdf/{id}', [TechnicalReportController::class, 'generatePDF'])->name('view.technical_report.pdf');
    Route::get('/technical-report/pdf/{id}', [TechnicalReportController::class, 'generatePDF'])->name('view.technical_report.pdf');
    Route::get('/view-technical-report-pdf/{id}',
    [TechnicalReportController::class, 'generatePDF']
)->name('view.technical_report.pdf');

});