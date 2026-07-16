<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use App\Models\ProjectRequest;
use App\Models\TechnicalReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TechnicalReportController extends Controller
{
    public function create()
    {
        if (Auth::user()->role !== 'engineer') {
            abort(403);
        }

        $assignedRequests = ProjectRequest::where(
            'assigned_engineer_id',
            Auth::id()
        )
            ->latest()
            ->get();

        return view(
            'engineer.estimates',
            compact('assignedRequests')
        );
    }

    public function storeTechnicalReport(Request $request)
    {
        if (Auth::user()->role !== 'engineer') {
            abort(403);
        }

        $validated = $request->validate([
            'req_id' => [
                'required',
                'exists:project_requests,id',
            ],

            'length' => [
                'required',
                'numeric',
                'min:0',
            ],

            'width' => [
                'required',
                'numeric',
                'min:0',
            ],

            'cost_estimate_file' => [
                'required',
                'file',
                'mimes:xlsx,xls',
                'max:5120',
            ],

            'estimated_duration' => [
                'required',
                'string',
                'max:255',
            ],

            'recommendations' => [
                'nullable',
                'string',
            ],

            'remarks' => [
                'nullable',
                'string',
            ],
        ]);

        $projectRequest = ProjectRequest::where(
            'id',
            $validated['req_id']
        )
            ->where(
                'assigned_engineer_id',
                Auth::id()
            )
            ->firstOrFail();

        $existingReport = TechnicalReport::where(
            'req_id',
            $validated['req_id']
        )->exists();

        if ($existingReport) {
            return back()
                ->withInput()
                ->withErrors([
                    'req_id' =>
                        'Technical report already exists for this request.',
                ]);
        }

        $excelFile = $request->file(
            'cost_estimate_file'
        );

        try {
            $spreadsheet = IOFactory::load(
                $excelFile->getRealPath()
            );

            $sheet = $spreadsheet->getSheetByName(
                'Unit Rate Estimate'
            );

            if (!$sheet) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'cost_estimate_file' =>
                            'Invalid Excel file. Sheet name must be Unit Rate Estimate.',
                    ]);
            }

            $materialCost = (float) $sheet
                ->getCell('G16')
                ->getCalculatedValue();

            $laborCost = (float) $sheet
                ->getCell('G17')
                ->getCalculatedValue();

            $equipmentCost = (float) $sheet
                ->getCell('G18')
                ->getCalculatedValue();

            $totalBudget = (float) $sheet
                ->getCell('G19')
                ->getCalculatedValue();

        } catch (\Throwable $exception) {
            return back()
                ->withInput()
                ->withErrors([
                    'cost_estimate_file' =>
                        'Excel file could not be read. Please use the provided Excel template.',
                ]);
        }

        $calculatedTotal =
            $materialCost +
            $laborCost +
            $equipmentCost;

        if (abs($calculatedTotal - $totalBudget) > 0.01) {
            return back()
                ->withInput()
                ->withErrors([
                    'cost_estimate_file' =>
                        'Excel Grand Total does not match category totals.',
                ]);
        }

        $excelPath = $excelFile->store(
            'cost-estimates',
            'public'
        );

        try {
            $report = new TechnicalReport();

            $report->req_id =
                $validated['req_id'];

            $report->date =
                now()->toDateString();

            $report->length =
                $validated['length'];

            $report->width =
                $validated['width'];

            $report->area =
                $validated['length'] *
                $validated['width'];

            $report->cost_estimate_file =
                $excelPath;

            $report->material_cost =
                $materialCost;

            $report->labor_cost =
                $laborCost;

            $report->equipment_cost =
                $equipmentCost;

            $report->total_budget =
                $totalBudget;

            $report->estimated_duration =
                $validated['estimated_duration'];

            /*
             * duration column එක database එකේ NOT NULL නිසා
             * save කිරීමට කලින් value එක set කරනවා.
             */
            $report->duration =
                $validated['estimated_duration'];

            $report->recommendations =
                $validated['recommendations'] ?? null;

            $report->remarks =
                $validated['remarks'] ?? null;

            $report->save();

        } catch (\Throwable $exception) {
            Storage::disk('public')->delete(
                $excelPath
            );

            throw $exception;
        }

        $report->load('projectRequest');

        $requestData = $projectRequest;

        $pdf = Pdf::loadView(
            'pdf.technical_report_pdf',
            compact('report', 'requestData')
        );

        return $pdf->stream(
            'technical_report_R-' .
            $report->req_id .
            '.pdf'
        );
    }

    public function generatePDF($id)
    {
        $requestData = ProjectRequest::with(
            'technicalReport'
        )->findOrFail($id);

        $report = $requestData->technicalReport;

        if (!$report) {
            return back()->with(
                'error',
                'Technical report not found for this request.'
            );
        }

        $pdf = Pdf::loadView(
            'pdf.technical_report_pdf',
            compact('report', 'requestData')
        );

        return $pdf->stream(
            'technical_report_R-' . $id . '.pdf'
        );
    }

    public function downloadExcel($id)
    {
        $report = TechnicalReport::findOrFail($id);

        if (
            !$report->cost_estimate_file ||
            !Storage::disk('public')->exists(
                $report->cost_estimate_file
            )
        ) {
            return back()->with(
                'error',
                'Cost estimate Excel file not found.'
            );
        }

        return Storage::disk('public')->download(
            $report->cost_estimate_file,
            'cost_estimate_R-' .
            $report->req_id .
            '.xlsx'
        );
    }
}