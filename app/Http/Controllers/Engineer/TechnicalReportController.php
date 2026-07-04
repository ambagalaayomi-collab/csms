<?php

namespace App\Http\Controllers\Engineer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectRequest;
use App\Models\UnitRate;
use App\Models\Estimate; // ⚠️ Estimate Model එක මෙතන තියෙන්නම ඕනේ
use Illuminate\Support\Facades\Auth;

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

        // unit_rates ටේබල් එකේ තියෙන ගණන් ටික array එකක් විදිහට ගන්නවා ['cement' => 2300, 'sand' => 1800]
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

        // 4. ඔයාගේ පැරණි Estimate ටේබල් එකටම දත්ත සේව් කිරීම
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
}