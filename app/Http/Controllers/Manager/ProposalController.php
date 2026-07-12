<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Proposal;
use App\Models\TechnicalReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProjectRequest;
use Illuminate\Support\Facades\DB;

class ProposalController extends Controller
{
    public function create($technicalReportId)
    {
        $technicalReport = TechnicalReport::with('projectRequest')
            ->findOrFail($technicalReportId);

        return view(
            'manager.proposals.create',
            compact('technicalReport')
        );
    }

    /*
     * Modal එකෙන් proposal එක create කරන method එක
     */
    public function store(Request $request, $requestId)
    {
        $validated = $request->validate([
            'proposal_details' => ['required', 'string'],
        ]);

        $technicalReport = TechnicalReport::where('request_id', $requestId)
            ->latest()
            ->firstOrFail();

        // 💡 වෙනස් කරන ලදී: 'request_id' වෙනුවට 'project_request_id' යොදා ඇත
        $existingProposal = Proposal::where('project_request_id', $requestId)
            ->latest()
            ->first();

        if ($existingProposal) {
            return back()->with(
                'error',
                'A proposal has already been created for this request.'
            );
        }

        // 💡 වෙනස් කරන ලදී: 'request_id' වෙනුවට 'project_request_id' ලෙස ඩේටාබේස් එකට සේව් වේ
        $proposal = Proposal::create([
    'project_request_id' => $requestId,
    'technical_report_id' => $technicalReport->id,
    'proposal_details' => $validated['proposal_details'],
    'total_budget' => $technicalReport->total_estimated_cost
        ?? $technicalReport->total_budget
        ?? 0,
    'estimated_duration' => $technicalReport->estimated_duration
        ?? $technicalReport->duration
        ?? null,
    'status' => 'Draft',
]);
        

        return redirect()
            ->route('proposal.pdf', $proposal->id)
            ->with('proposal_success', 'Proposal created successfully.');
    }

    public function show($id)
    {
        $proposal = Proposal::with([
            'projectRequest',
            'technicalReport'
        ])->findOrFail($id);

        return view(
            'manager.proposals.show',
            compact('proposal')
        );
    }

    public function generatePdf($id)
    {
        $proposal = Proposal::with([
            'projectRequest',
            'technicalReport'
        ])->findOrFail($id);

        $projectRequest = $proposal->projectRequest;
        $technicalReport = $proposal->technicalReport;
        $manager = Auth::user();

        $pdf = Pdf::loadView(
            'manager.proposals.pdf',
            compact(
                'proposal',
                'projectRequest',
                'technicalReport',
                'manager'
            )
        );

        // Browser එකේ PDF view කරනවා
        return $pdf->stream(
            'proposal-' . $proposal->id . '.pdf'
        );
    }

    /**
     * ⚡ නිවැරදි කරන ලද Send To Client Method එක
     */
    public function sendToClient($id)
{
    try {
        $proposal = Proposal::findOrFail($id);

        DB::transaction(function () use ($proposal) {
            $proposal->status = 'Sent';
            $proposal->save();

            ProjectRequest::where(
                'id',
                $proposal->project_request_id
            )->update([
                'status' => 'Proposal Sent',
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Proposal sent to client successfully.',
        ]);

    } catch (\Throwable $exception) {
        report($exception);

        return response()->json([
            'success' => false,
            'message' => 'Unable to send the proposal.',
        ], 500);
    }
}
}
