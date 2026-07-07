<?php

namespace App\Http\Controllers\Engineer; 

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\ProjectRequest;
use App\Models\UnitRate;
use App\Models\Estimate; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TechnicalReport;
use Barryvdh\DomPDF\Facade\Pdf;



class EstimateController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assignedRequests = ProjectRequest::where('assigned_engineer_id', Auth::id())
            ->where(function($query) {
                $query->where('status', 'Assigned')
                      ->orWhere('status', 'Approved');
            })
            ->get();

        $rates = UnitRate::pluck('rate', 'item_key')->toArray();

        return view('engineer.estimates', compact('assignedRequests', 'rates'));
       
{
    // 💡 estimate එක වගේම technicalReport එකත් එක පාරම ලෝඩ් කරනවා
    $assignedRequests = ProjectRequest::with(['estimate', 'technicalReport'])
        ->where('assigned_engineer_id', Auth::id())
        ->where(function($query) {
            $query->where('status', 'Assigned')
                  ->orWhere('status', 'Approved');
        })
        ->get();

    $rates = UnitRate::pluck('rate', 'item_key')->toArray();

    return view('engineer.estimates', compact('assignedRequests', 'rates'));
}
    }

    /**
     * Store a newly created estimate in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'project_request_id' => 'required|exists:project_requests,id',
            
            // Material Qtys & Costs
            'cement_qty' => 'required|numeric|min:0',
            'cement_cost' => 'required|numeric|min:0',
            'sand_qty' => 'required|numeric|min:0',
            'sand_cost' => 'required|numeric|min:0',
            'steel_qty' => 'required|numeric|min:0',
            'steel_cost' => 'required|numeric|min:0',
            'brick_qty' => 'required|numeric|min:0',
            'brick_cost' => 'required|numeric|min:0',

            // Labor Qtys & Costs
            'mason_qty' => 'required|numeric|min:0',
            'mason_cost' => 'required|numeric|min:0',
            'carpenter_qty' => 'required|numeric|min:0',
            'carpenter_cost' => 'required|numeric|min:0',
            'helper_qty' => 'required|numeric|min:0',
            'helper_cost' => 'required|numeric|min:0',

            // Equipment Qtys & Costs
            'mixer_qty' => 'required|numeric|min:0',
            'mixer_cost' => 'required|numeric|min:0',
            'excavator_qty' => 'required|numeric|min:0',
            'excavator_cost' => 'required|numeric|min:0',
            'truck_qty' => 'required|numeric|min:0',
            'truck_cost' => 'required|numeric|min:0',

            // Other details
            'estimated_duration' => 'required|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // මුළු එකතුව (Grand Total) Backend එකෙන්ම ගණනය කිරීම
            // ... (කලින් තිබුණු කෝඩ් එක)
$grandTotal = ($request->cement_cost ?? 0) + ($request->sand_cost ?? 0) + 
              ($request->steel_cost ?? 0) + ($request->brick_cost ?? 0) +
              ($request->mason_cost ?? 0) + ($request->carpenter_cost ?? 0) + 
              ($request->helper_cost ?? 0) + ($request->mixer_cost ?? 0) + 
              ($request->excavator_cost ?? 0) + ($request->truck_cost ?? 0);

$dataToSave = array_merge($validatedData, [
    // 💡 මෙතන තිබුණු 'status' => 'Pending' කියන පේළියත් අයින් කළා!
    'grand_total' => $grandTotal
]);

Estimate::create($dataToSave);

            Estimate::create($dataToSave);

            DB::commit();

            return redirect()->back()->with('success', 'Cost estimate saved successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();

            // 💡 දැනට තියෙන return redirect... පේළිය අයින් කරලා, මේ පේළිය විතරක් මෙතනට දාන්න
            dd($e->getMessage()); 
        }
    
    }

    /**
     * Show technical report form.
     */
    public function showReport($project_request_id = null)
    {
        // දැනට ලොග් වෙලා ඉන්න Engineer ගේ ඉල්ලීම් ටික අරන් එනවා (Dropdown එකට)
        $assignedRequests = ProjectRequest::with('estimate')
            ->where('assigned_engineer_id', Auth::id())
            ->get();

        $projectRequest = null;
        if ($project_request_id) {
            $projectRequest = ProjectRequest::find($project_request_id);
        }

        return view('engineer.technical_report', compact('project_request_id', 'projectRequest', 'assignedRequests'));
    }

    /**
     * Store technical report submission data.
     */
    public function storeReportData(Request $request)
    {
        $validated = $request->validate([
            'req_id' => 'required|exists:project_requests,id',
            'length' => 'required|numeric',
            'width' => 'required|numeric',
            'area' => 'required|numeric',
            'material_cost' => 'required|numeric',
            'labor_cost' => 'required|numeric',
            'equipment_cost' => 'required|numeric',
            'total_budget' => 'required|numeric',
            'estimated_duration' => 'required|string',
            'recommendations' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        try {
            // Technical Report එකට අදාළ දත්ත ඇතුළත් කිරීම
            TechnicalReport::create([
                'req_id' => $request->req_id,
                'length' => $request->length,
                'width' => $request->width,
                'area' => $request->area,
                'material_cost' => $request->material_cost,
                'labor_cost' => $request->labor_cost,
                'equipment_cost' => $request->equipment_cost,
                'total_estimated_cost' => $request->total_budget, 
                'estimated_duration' => $request->estimated_duration,
                'recommendations' => $request->recommendations,
                'remarks' => $request->remarks,
                'prepared_by' => Auth::id(), 
                'date' => now()->format('Y-m-d'),
            ]);

            return redirect()->back()->with('success', 'Technical Report added successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to save the report. Please try again.'])->withInput();
        }
    }

    /**
     * Generate PDF Report for the estimate.
     */
    public function generateReport($requestId) 
    {
        // Request එක සහ Estimate එක ඩේටාබේස් එකෙන් ගැනීම
        $projectRequest = ProjectRequest::with('estimate')->findOrFail($requestId);

        if (!$projectRequest->estimate) {
            return redirect()->back()->with('error', 'No estimate found for this request.');
        }

        // pdf/estimate_pdf.blade.php එක load කිරීම
        $pdf = Pdf::loadView('pdf.estimate_pdf', compact('projectRequest'));

        // බ්‍රවුසර් එකේම PDF එක ඕපන් කිරීම
        return $pdf->stream('Estimate_Report_R-' . $projectRequest->id . '.pdf');
    }
    public function generateTechnicalReportPDF($reportId)
{
    // Technical Report එකයි ඒකට අදාළ Project Request එකයි ඩේටාබේස් එකෙන් ගන්නවා
    $report = TechnicalReport::with('projectRequest')->findOrFail($reportId);

    // උඩ හදපු බ්ලේඩ් එක ලෝඩ් කරනවා
    $pdf = Pdf::loadView('pdf.technical_report_pdf', compact('report'));

    // බ්‍රවුසර් එකෙන්ම ඕපන් කරනවා
    return $pdf->stream('Technical_Report_' . $report->req_id . '.pdf');
    $report = TechnicalReport::with('projectRequest')
        ->where('req_id', $requestId)
        ->firstOrFail();

   
        $pdf = Pdf::loadView('pdf.technical_report_pdf', compact('report'));
}
public function storeTechnicalReport(Request $request)
{
    // 1. Validation (බ්ලේඩ් ෆෝම් එකේ නම 'measurement_details' වෙන්න ඕනේ)
    $request->validate([
        'req_id'              => 'required|exists:project_requests,id',
        'measurement_details' => 'required',
    ]);

    // 2. Database එකට අලුතින්ම ඩේටා සේව් කිරීම
    $report = new TechnicalReport();
    $report->req_id              = $request->req_id; 
    $report->measurement_details = $request->measurement_details; 
    $report->total_budget        = $request->total_budget ?? 0;   
    $report->duration            = $request->duration ?? '1 month';  
    $report->date                = now()->toDateString();            
    $report->save(); // 🚀 දැන් කිසිම බ්ලොක් එකක් නැතුව ඩේටාබේස් එකට කෙළින්ම සේව් වෙනවා!

    return redirect()->route('engineer.dashboard')->with('success', 'Report submitted successfully!');

}
}

