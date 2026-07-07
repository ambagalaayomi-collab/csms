<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectRequest;
use App\Models\UnitRate;
use App\Models\Estimate; 
use App\Models\TechnicalReport; 
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; 

class TechnicalReportController extends Controller
{
    /**
     * Estimates Form එක සහ Database Rates පෙන්වීම.
     */
    public function create()
    {
        if (Auth::user()->role !== 'engineer') {
            abort(403);
        }

        $assignedRequests = ProjectRequest::where('assigned_engineer_id', Auth::id())
            ->latest()
            ->get();

        // unit_rates ටේබල් එකේ තියෙන ගණන් ටික array එකක් විදිහට ගන්නවා
        $rates = UnitRate::pluck('rate', 'item_key')->toArray();

        return view('engineer.estimates', compact('assignedRequests', 'rates'));
    }

    /**
     * Form එකෙන් එන Quantities අරන්, Backend එකෙන් ගණන් හදලා Save කිරීම.
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'engineer') {
            abort(403);
        }

        // 1. Blade Form එකේ Input Fields වල නම් (Names) අනුව Validate කිරීම
        $request->validate([
            'project_request_id'   => 'required|exists:project_requests,id',
            'cement_qty'           => 'required|numeric|min:0',
            'sand_qty'             => 'required|numeric|min:0',
            'steel_qty'            => 'required|numeric|min:0',
            'brick_qty'            => 'required|numeric|min:0',
            'other_material_cost'  => 'required|numeric|min:0',

            'mason_qty'            => 'required|numeric|min:0',
            'carpenter_qty'        => 'required|numeric|min:0',
            'helper_qty'           => 'required|numeric|min:0',
            'other_labor_cost'     => 'required|numeric|min:0',

            'mixer_qty'            => 'required|numeric|min:0',
            'excavator_qty'        => 'required|numeric|min:0',
            'truck_qty'            => 'required|numeric|min:0',
            'other_equipment_cost' => 'required|numeric|min:0',

            'estimated_duration'   => 'required|string',
            'remarks'              => 'nullable|string',
        ]);

        // 2. Database එකෙන් ආරක්ෂිතව Rates Array එක ලබාගැනීම
        $rates = UnitRate::pluck('rate', 'item_key')->toArray();

        // 3. --- AUTOMATIC COST CALCULATION (Qty * Rate) ---
        // Materials Cost
        $cementCost    = $request->cement_qty * ($rates['cement'] ?? 0);
        $sandCost      = $request->sand_qty * ($rates['sand'] ?? 0);
        $steelCost     = $request->steel_qty * ($rates['steel'] ?? 0);
        $brickCost     = $request->brick_qty * ($rates['brick'] ?? 0);
        $materialCost  = $cementCost + $sandCost + $steelCost + $brickCost + $request->other_material_cost;

        // Labor Cost
        $masonCost     = $request->mason_qty * ($rates['mason'] ?? 0);
        $carpenterCost = $request->carpenter_qty * ($rates['carpenter'] ?? 0);
        $helperCost    = $request->helper_qty * ($rates['helper'] ?? 0);
        $laborCost     = $masonCost + $carpenterCost + $helperCost + $request->other_labor_cost;

        // Equipment Cost
        $mixerCost     = $request->mixer_qty * ($rates['mixer'] ?? 0);
        $excavatorCost = $request->excavator_qty * ($rates['excavator'] ?? 0);
        $truckCost     = $request->truck_qty * ($rates['truck'] ?? 0);
        $equipmentCost = $mixerCost + $excavatorCost + $truckCost + $request->other_equipment_cost;

        // මුළු එකතුව (Grand Total)
        $totalCost     = $materialCost + $laborCost + $equipmentCost;

        // 4. Estimate ටේබල් එකට දත්ත සේව් කිරීම
        Estimate::create([
            'project_request_id'   => $request->project_request_id,
            'engineer_id'          => Auth::id(),
            'cement_cost'          => $cementCost,
            'sand_cost'            => $sandCost,
            'steel_cost'           => $steelCost,
            'brick_cost'           => $brickCost,
            'other_material_cost'  => $request->other_material_cost,
            'mason_cost'           => $masonCost,
            'carpenter_cost'       => $carpenterCost,
            'helper_cost'          => $helperCost,
            'other_labor_cost'     => $request->other_labor_cost,
            'mixer_cost'           => $mixerCost,
            'excavator_cost'       => $excavatorCost,
            'truck_cost'           => $truckCost,
            'other_equipment_cost' => $request->other_equipment_cost,
            'material_cost'        => $materialCost,
            'labor_cost'           => $laborCost,
            'equipment_cost'       => $equipmentCost,
            'total_cost'           => $totalCost,
            'estimated_duration'   => $request->estimated_duration,
            'remarks'              => $request->remarks,
        ]);

        return back()->with('success', 'Estimate calculated and saved successfully.');
    }

    /**
     * Technical Report එක ඩේටාබේස් එකට සේව් කර සැනින් PDF එකක් ලෙස පෙන්වීම.
     */
    public function storeTechnicalReport(Request $request)
    {
        // 1. Form Validation
        $request->validate([
            'req_id'             => 'required',
            'length'             => 'required|numeric',
            'width'              => 'required|numeric',
            'area'               => 'required|numeric',
            'material_cost'      => 'required|numeric',
            'labor_cost'         => 'required|numeric',
            'equipment_cost'     => 'required|numeric',
            'total_budget'       => 'required|numeric',
            'estimated_duration' => 'required|string',
            'recommendations'    => 'nullable|string',
            'remarks'            => 'nullable|string',
        ]);

        // 2. Database එකේ තියෙන ඇත්තම Column නම් වලට අනුව නව Report එකක් සෑදීම
        $report = new TechnicalReport();
        $report->req_id = $request->req_id; 
        
        // මිනුම් විස්තර සහ සටහන් එකතු කර string එකක් ලෙස සකසා සේව් කිරීම
        $report->measurement_details = "Length: " . $request->length . " ft, Width: " . $request->width . " ft, Area: " . $request->area . " sq.ft. \nRecommendations: " . $request->recommendations . " \nRemarks: " . $request->remarks; 
        
        $report->total_budget = $request->total_budget ?? 0;
        $report->duration     = $request->estimated_duration; 
        $report->date         = now()->toDateString(); 
        $report->material_cost = $request->material_cost;
            $report->labor_cost = $request->labor_cost;
             $report->equipment_cost = $request->equipment_cost;
            $report->estimated_duration = $request->estimated_duration;
             $report->length = $request->length;
           $report->width = $request->width;
           $report->area = $request->area;
           $report->recommendations = $request->recommendations;
           $report->remarks = $request->remarks;
        
        $report->save(); // 💾 Database එකට සුපිරියටම සේව් වුණා!

        // 3. බ්ලේඩ් (Blade) එකට අවශ්‍ය Relationship ඩේටා ටික එකතු කරගැනීම
        $report->load('projectRequest'); 
        $requestData = ProjectRequest::find($request->req_id);

        // 4. PDF එක සාදා සැනින් බ්‍රවුසර් එකට Stream කිරීම
        $pdf = Pdf::loadView('pdf.technical_report_pdf', compact('report', 'requestData'));
        
        return $pdf->stream('technical_report_R-' . $request->req_id . '.pdf');
    }

    /**
     * දැනටමත් සේව් කර ඇති Report එකක් Dashboard එකෙන් ක්ලික් කර නැවත PDF එක බැලීම.
     */
   /**
     * දැනටමත් සේව් කර ඇති Report එකක් Dashboard එකෙන් ක්ලික් කර නැවත PDF එක බැලීම.
     */
    public function generatePDF($id)
    {
        // 1. Request එක සහ ඒකට අදාළ technical report එක Fetch කරගැනීම
        $requestData = ProjectRequest::with('technicalReport')->findOrFail($id);

        // 2. Report එක වේරියබල් එකට ගැනීම
        $report = $requestData->technicalReport;

        // 3. Technical Report එකක් නැත්නම් ආපහු හරවා යැවීම
        if (!$report) {
            return back()->with('error', 'Technical report not found for this request.');
        }

        // 4. PDF එක සාදා බ්‍රවුසර් එකට Stream කිරීම (පෙන්වීම)
        // (මෙන්න මේ line එකෙන් කෙලින්ම PDF එක load වෙන්න ඕනේ!)
        $pdf = Pdf::loadView('pdf.technical_report_pdf', compact('report', 'requestData'));
        return $pdf->stream('technical_report_R-' . $id . '.pdf');
    }
}