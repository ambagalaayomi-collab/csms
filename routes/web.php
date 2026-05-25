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

//  HOME
Route::get('/', function () {

    if (Auth::check()) {
        if (Auth::user()->role === 'client') {
            return redirect()->route('client.dashboard');
        }

        if (Auth::user()->role === 'project_manager') {
            return redirect()->route('project_manager.dashboard');
        }

        if (Auth::user()->role === 'engineer') {
            return redirect()->route('engineer.dashboard');
        }
    }

    return view('welcome');

})->name('home');


//  LOGIN / REGISTER PAGE REDIRECT


Route::get('/login', function () {
    return redirect('/');
});

Route::get('/register', function () {
    return redirect('/');
});


//  REGISTER

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

//  LOGIN
Route::post('/login', function (Request $request) {

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'role' => 'required|in:client,project_manager,engineer',
    ]);

    if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password,
        'role' => $request->role,
    ])) {
        $request->session()->regenerate();

        if (Auth::user()->role === 'client') {
            return redirect()->route('client.dashboard')
                ->with('login_success', 'Login successful.');
        }

        if (Auth::user()->role === 'project_manager') {
            return redirect()->route('project_manager.dashboard')
                ->with('login_success', 'Login successful.');
        }

        if (Auth::user()->role === 'engineer') {
            return redirect()->route('engineer.dashboard')
                ->with('login_success', 'Login successful.');
        }
    }

    return back()
        ->withErrors(['login_error' => 'Invalid email, password, or role.'])
        ->withInput()
        ->with('open_login_modal', true);

})->name('login');

//  LOGOUT

Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');

})->name('logout');



// CLIENT PROJECT REQUEST PAGE


Route::get('/client/request-project', function () {

    if (!Auth::check() || Auth::user()->role !== 'client') {
        return redirect('/')
            ->with('error_msg', 'Please login as a client.')
            ->with('open_login_modal', true);
    }

    return view('client.request_project');

})->name('client.request.project');


//  CLIENT PROJECT REQUEST STORE

Route::post('/project-request/store', function (Request $request) {

    if (!Auth::check() || Auth::user()->role !== 'client') {
        return redirect('/')
            ->with('error_msg', 'Please login as a client to submit your project request.')
            ->with('open_login_modal', true);
    }

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

    return redirect()->route('client.dashboard')
        ->with('request_success', 'Project request submitted successfully.');

})->name('project.request.store');



//  PROJECT MANAGER: REQUEST STATUS UPDATE

Route::post('/project-request/{id}/status', function (Request $request, $id) {

    if (!Auth::check() || Auth::user()->role !== 'project_manager') {
        abort(403);
    }

    $request->validate([
        'status' => 'required|in:Pending,In Review,Approved,Rejected,Changes Requested,Completed,Proposal Sent',
    ]);

    $projectRequest = ProjectRequest::findOrFail($id);
    $projectRequest->status = $request->status;
    $projectRequest->save();

    return redirect()->route('project_manager.dashboard')
        ->with('status_success', 'Request status updated successfully.');

})->name('project.request.status.update');


//  PROJECT MANAGER: CREATE PROPOSAL PDF


Route::post('/project-request/{id}/proposal', function (Request $request, $id) {

    if (!Auth::check() || Auth::user()->role !== 'project_manager') {
        abort(403);
    }

    $request->validate([
        'proposal_details' => 'required|string',
        'total_budget' => 'required|numeric|min:0',
        'estimated_duration' => 'required|string|max:100',
    ]);

    $projectRequest = ProjectRequest::findOrFail($id);

    $proposal = Proposal::create([
        'project_request_id' => $projectRequest->id,
        'client_id' => $projectRequest->client_id,
        'manager_id' => Auth::id(),
        'proposal_details' => $request->proposal_details,
        'total_budget' => $request->total_budget,
        'estimated_duration' => $request->estimated_duration,
        'status' => 'Sent',
    ]);

    $pdf = Pdf::loadView('pdf.proposal', [
        'proposal' => $proposal,
        'projectRequest' => $projectRequest,
        'manager' => Auth::user(),
    ]);

    $fileName = 'proposal_' . $proposal->id . '.pdf';
    $pdfPath = 'proposals/' . $fileName;

    Storage::disk('public')->put($pdfPath, $pdf->output());

    $proposal->update([
        'pdf_path' => $pdfPath,
    ]);

    $projectRequest->status = 'Proposal Sent';
    $projectRequest->save();

    return redirect()->route('project_manager.dashboard')
        ->with('proposal_success', 'Proposal PDF created and sent to client successfully.');

})->name('proposal.store');

//  CLIENT: PROPOSAL RESPONSE


Route::post('/proposal/{id}/respond', function (Request $request, $id) {

    if (!Auth::check() || Auth::user()->role !== 'client') {
        abort(403);
    }

    $request->validate([
        'response' => 'required|in:Approved,Rejected,Changes Requested',
        'response_comment' => 'nullable|string|max:1000',
    ]);

    $proposal = Proposal::findOrFail($id);

    if ($proposal->client_id !== Auth::id()) {
        abort(403);
    }

    $proposal->update([
        'status' => $request->response,
        'response_comment' => $request->response_comment,
    ]);

    $projectRequest = ProjectRequest::find($proposal->project_request_id);

    if ($projectRequest) {
        $projectRequest->status = $request->response;
        $projectRequest->save();
    }

    return redirect()->route('client.dashboard')
        ->with('proposal_response_success', 'Your response was sent to the Project Manager successfully.');

})->name('proposal.respond');



//  PROJECT MANAGER: PROPOSAL STATUS UPDATE

Route::post('/proposal/{id}/status', function (Request $request, $id) {

    if (!Auth::check() || Auth::user()->role !== 'project_manager') {
        abort(403);
    }

    $request->validate([
        'status' => 'required|in:Sent,In Review,Approved,Rejected,Changes Requested',
    ]);

    $proposal = Proposal::findOrFail($id);
    $proposal->status = $request->status;
    $proposal->save();

    $projectRequest = ProjectRequest::find($proposal->project_request_id);

    if ($projectRequest) {
        if ($request->status === 'Sent') {
            $projectRequest->status = 'Proposal Sent';
        } else {
            $projectRequest->status = $request->status;
        }

        $projectRequest->save();
    }

    return redirect()->route('project_manager.dashboard')
        ->with('proposal_status_success', 'Proposal status updated successfully.');

})->name('proposal.status.update');


//  DASHBOARDS

Route::middleware('auth')->group(function () {

    Route::get('/client/dashboard', function () {

        if (Auth::user()->role !== 'client') {
            abort(403);
        }

        $myRequests = ProjectRequest::where('client_id', Auth::id())
            ->latest()
            ->get();

        $myProposals = Proposal::where('client_id', Auth::id())
            ->latest()
            ->get();

        $totalRequests = $myRequests->count();
        $pendingRequests = $myRequests->where('status', 'Pending')->count();
        $approvedRequests = $myRequests->where('status', 'Approved')->count();
        $completedRequests = $myRequests->where('status', 'Completed')->count();
        $proposalCount = $myProposals->count();

        return view('client.dashboard', compact(
            'myRequests',
            'myProposals',
            'totalRequests',
            'pendingRequests',
            'approvedRequests',
            'completedRequests',
            'proposalCount'
        ));

    })->name('client.dashboard');

    Route::get('/project-manager/dashboard', function () {

        if (Auth::user()->role !== 'project_manager') {
            abort(403);
        }

        $clientRequests = ProjectRequest::latest()->get();
        $proposals = Proposal::latest()->get();

        $totalRequests = $clientRequests->count();
        $pendingRequests = $clientRequests->where('status', 'Pending')->count();
        $inReviewRequests = $clientRequests->where('status', 'In Review')->count();
        $approvedRequests = $clientRequests->where('status', 'Approved')->count();
        $rejectedRequests = $clientRequests->where('status', 'Rejected')->count();
        $changesRequested = $clientRequests->where('status', 'Changes Requested')->count();
        $proposalSentRequests = $clientRequests->where('status', 'Proposal Sent')->count();

        $proposalCount = $proposals->count();
        $sentProposals = $proposals->where('status', 'Sent')->count();
        $approvedProposals = $proposals->where('status', 'Approved')->count();
        $rejectedProposals = $proposals->where('status', 'Rejected')->count();
        $changedProposals = $proposals->where('status', 'Changes Requested')->count();

        return view('project_manager.dashboard', compact(
            'clientRequests',
            'proposals',
            'totalRequests',
            'pendingRequests',
            'inReviewRequests',
            'approvedRequests',
            'rejectedRequests',
            'changesRequested',
            'proposalSentRequests',
            'proposalCount',
            'sentProposals',
            'approvedProposals',
            'rejectedProposals',
            'changedProposals'
        ));

    })->name('project_manager.dashboard');

    Route::get('/engineer/dashboard', function () {

        if (Auth::user()->role !== 'engineer') {
            abort(403);
        }

        return view('engineer.dashboard');

    })->name('engineer.dashboard');

});