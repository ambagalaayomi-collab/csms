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
    }

    /**
     * Store a newly created resource in storage.
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

            $dataToSave = array_merge($validatedData, [
                'engineer_id' => Auth::id(),
                'status' => 'Pending' 
            ]);

            Estimate::create($dataToSave);

            DB::commit();

            return redirect()->back()->with('success', 'Cost estimate saved successfully!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()->withErrors(['error' => 'Failed to save the estimate. Please try again.'])->withInput();
        }
    }

    /**
     * Show technical report form.
     */
    public function showReport($project_request_id = null)
    {
        // 💡 1. දැනට ලොග් වෙලා ඉන්න Engineer ගේ ඉල්ලීම් ටික අරන් එනවා (Dropdown එකට)
        $assignedRequests = ProjectRequest::with('estimate')
            ->where('assigned_engineer_id', Auth::id())
            ->get();

        $projectRequest = null;
        if ($project_request_id) {
            $projectRequest = ProjectRequest::find($project_request_id);
        }

        // View එකට assignedRequests යැවීම හරහා Dropdown එකේ රিকোවෙස්ට් populate කරගත හැක.
        return view('engineer.technical_report', compact('project_request_id', 'projectRequest', 'assignedRequests'));
    }

    /**
     * Store technical report submission data.
     */
    public function storeReportData(Request $request)
    {
        // තාක්ෂණික වාර්තාවේ දත්ත සුරැකීමේ කේතය මෙහි ලියන්න
       
        return redirect()->back()->with('success', 'Technical Report submitted successfully!');
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
        // 2. Technical Report එකට අදාළ ඩේටාබේස් ටේබල් එකට අලුත් රෙකෝඩ් එකක් දානවා (Insert)
        TechnicalReport::create([
            'req_id' => $request->req_id,
            'length' => $request->length,
            'width' => $request->width,
            'area' => $request->area,
            'material_cost' => $request->material_cost,
            'labor_cost' => $request->labor_cost,
            'equipment_cost' => $request->equipment_cost,
            'total_estimated_cost' => $request->total_budget, // DB col name එකට හරවගන්න
            'estimated_duration' => $request->estimated_duration,
            'recommendations' => $request->recommendations,
            'remarks' => $request->remarks,
            'prepared_by' => Auth::id(), // නැත්තම් Engineer නම
            'date' => now()->format('Y-m-d'),
        ]);

        return redirect()->back()->with('success', 'Technical Report added successfully!');
        
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Failed to save the report. Please try again.'])->withInput();
    }
    }
}