<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cost Estimation</title>
    <style>
        body {
            background-color: #eef2f3;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #00695c;
        }

        .page-title {
            font-size: 28px;
            color: #00695c;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 700;
        }

        .section-title {
            font-size: 18px;
            color: #00695c;
            margin-top: 30px;
            margin-bottom: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            font-size: 14px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            box-sizing: border-box;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .form-control:focus {
            border-color: #00695c;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 105, 92, 0.15);
        }

        /* TABLE INPUT STYLES */
        .cost-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .cost-table th {
            background-color: #00695c;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            padding: 10px 12px;
            text-align: left;
        }

        .cost-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
            color: #333;
        }

        .cost-table tr:last-child td {
            border-bottom: none;
        }

        .table-input {
            width: 100%;
            padding: 6px 10px;
            font-size: 14px;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .table-input:focus {
            border-color: #00695c;
            outline: none;
        }

        .subtotal-row {
            background-color: #f8fafc;
            font-weight: 700;
            color: #00695c;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* GRAND SUMMARY */
        .grand-summary {
            margin-top: 35px;
            padding: 20px;
            background: #e0f2f1;
            border-radius: 10px;
            border-left: 6px solid #00695c;
        }

        .grand-summary h3 {
            margin-top: 0;
            color: #004d40;
            font-size: 18px;
        }

        .grand-summary p {
            margin: 8px 0;
            font-size: 15px;
            font-weight: 600;
            color: #374151;
        }

        .total-cost {
            font-size: 22px !important;
            color: #004d40;
            font-weight: 800 !important;
            margin-top: 15px !important;
        }

        .btn-save {
            width: 100%;
            padding: 14px;
            background: #00695c;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 25px;
        }

        .btn-save:hover {
            background: #004d40;
        }

        .success-msg {
            background-color: #d1fae5;
            color: #065f46;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid #10b981;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid #ef4444;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2 class="page-title">Cost Estimation</h2>

    @if(session('success'))
        <div class="success-msg">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('engineer.estimates.store') }}">
        @csrf

        <div class="form-group" style="max-width: 400px;">
            <label>Project Request</label>
            <!-- <select name="project_request_id" class="form-control" required>
                <option value="">Select Request</option>
                @foreach($assignedRequests as $request)
                    <option value="{{ $request->id }}" {{ old('project_request_id') == $request->id ? 'selected' : '' }}>
                        R-{{ $request->id }} - {{ $request->project_type }} - {{ $request->name }}
                    </option>
                @endforeach
            </select> -->
            <div class="form-group" style="max-width: 400px;">
    
    <select name="project_request_id" class="form-control" required>
        <option value="">Select Request</option>
        @foreach($assignedRequests as $request)
            <option value="{{ $request->id }}">
                {{-- 💡 මෙතන project_name සහ project_type දෙකම චෙක් කරනවා --}}
                R-{{ $request->id }} - {{ $request->project_name ?? $request->name }} ({{ $request->project_type }})
            </option>
        @endforeach
    </select>
</div>
        </div>

        <h3 class="section-title">Material Costs</h3>
        <table class="cost-table">
            <thead>
                <tr>
                    <th style="width: 40%;">Item Description</th>
                    <th style="width: 15%;">Unit</th>
                    <th style="width: 20%;">Qty</th>
                    <th style="width: 25%; text-align: right;">Total Price (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Cement</td>
                    <td><input type="text" name="cement_unit" class="table-input" readonly value="Bags"></td>
                    <td>
                        <input type="number" name="cement_qty" class="table-input qty-input" data-item="cement" data-rate="{{ $rates['cement'] ?? 0 }}" placeholder="Qty" value="{{ old('cement_qty', 0) }}" min="0" step="any" required>
                    </td>
                    <td>
                        <input type="number" name="cement_cost" class="table-input price-input material-item" id="cement_cost" placeholder="0.00" value="{{ old('cement_cost', 0) }}" readonly required min="0" step="0.01">
                    </td>
                </tr>

                <tr>
                    <td>Sand</td>
                    <td><input type="text" name="sand_unit" class="table-input" readonly value="Cubes"></td>
                    <td>
                        <input type="number" name="sand_qty" class="table-input qty-input" data-item="sand" data-rate="{{ $rates['sand'] ?? 0 }}" placeholder="Qty" value="{{ old('sand_qty', 0) }}" min="0" step="any" required>
                    </td>
                    <td>
                        <input type="number" name="sand_cost" class="table-input price-input material-item" id="sand_cost" placeholder="0.00" value="{{ old('sand_cost', 0) }}" readonly required min="0" step="0.01">
                    </td>
                </tr>

                <tr>
                    <td>Steel</td>
                    <td><input type="text" name="steel_unit" class="table-input" readonly value="Kg"></td>
                    <td>
                        <input type="number" name="steel_qty" class="table-input qty-input" data-item="steel" data-rate="{{ $rates['steel'] ?? 0 }}" placeholder="Qty" value="{{ old('steel_qty', 0) }}" min="0" step="any" required>
                    </td>
                    <td>
                        <input type="number" name="steel_cost" class="table-input price-input material-item" id="steel_cost" placeholder="0.00" value="{{ old('steel_cost', 0) }}" readonly required min="0" step="0.01">
                    </td>
                </tr>

                <tr>
                    <td>Bricks</td>
                    <td><input type="text" name="brick_unit" class="table-input" readonly value="Nos"></td>
                    <td>
                        <input type="number" name="brick_qty" class="table-input qty-input" data-item="brick" data-rate="{{ $rates['brick'] ?? 0 }}" placeholder="Qty" value="{{ old('brick_qty', 0) }}" min="0" step="any" required>
                    </td>
                    <td>
                        <input type="number" name="brick_cost" class="table-input price-input material-item" id="brick_cost" placeholder="0.00" value="{{ old('brick_cost', 0) }}" readonly required min="0" step="0.01">
                    </td>
                </tr>
                <!-- <tr>
                    <td>Other Materials</td>
                    <td><input type="text" name="other_material_unit" class="table-input" readonly value="Lump-sum"></td>
                    <td><input type="number" name="other_material_qty" class="table-input" readonly value="1"></td>
                    <td><input type="number" name="other_material_cost" class="table-input price-input custom-price-item material-item" placeholder="0.00" value="{{ old('other_material_cost', 0) }}" required min="0" step="0.01"></td>
                </tr> -->
                <tr class="subtotal-row">
                    <td colspan="3" class="text-right">Material Sub Total:</td>
                    <td class="text-right">Rs. <span id="sub-material">0.00</span></td>
                </tr>
            </tbody>
        </table>

        <h3 class="section-title">Labor Costs</h3>
        <table class="cost-table">
            <thead>
                <tr>
                    <th style="width: 40%;">Labor Type</th>
                    <th style="width: 15%;">Unit</th>
                    <th style="width: 20%;">Qty (Days/Hours)</th>
                    <th style="width: 25%; text-align: right;">Total Price (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mason</td>
                    <td><input type="text" name="mason_unit" class="table-input" readonly value="Days"></td>
                    <td><input type="number" name="mason_qty" class="table-input qty-input" data-item="mason" data-rate="{{ $rates['mason'] ?? 0 }}" placeholder="Qty" value="{{ old('mason_qty', 0) }}" min="0" step="any" required></td>
                    <td><input type="number" name="mason_cost" class="table-input price-input labor-item" id="mason_cost" placeholder="0.00" value="{{ old('mason_cost', 0) }}" readonly required min="0" step="0.01"></td>
                </tr>
                <tr>
                    <td>Carpenter</td>
                    <td><input type="text" name="carpenter_unit" class="table-input" readonly value="Days"></td>
                    <td><input type="number" name="carpenter_qty" class="table-input qty-input" data-item="carpenter" data-rate="{{ $rates['carpenter'] ?? 0 }}" placeholder="Qty" value="{{ old('carpenter_qty', 0) }}" min="0" step="any" required></td>
                    <td><input type="number" name="carpenter_cost" class="table-input price-input labor-item" id="carpenter_cost" placeholder="0.00" value="{{ old('carpenter_cost', 0) }}" readonly required min="0" step="0.01"></td>
                </tr>
                <tr>
                    <td>Helper</td>
                    <td><input type="text" name="helper_unit" class="table-input" readonly value="Days"></td>
                    <td><input type="number" name="helper_qty" class="table-input qty-input" data-item="helper" data-rate="{{ $rates['helper'] ?? 0 }}" placeholder="Qty" value="{{ old('helper_qty', 0) }}" min="0" step="any" required></td>
                    <td><input type="number" name="helper_cost" class="table-input price-input labor-item" id="helper_cost" placeholder="0.00" value="{{ old('helper_cost', 0) }}" readonly required min="0" step="0.01"></td>
                </tr>
                <!-- <tr>
                    <td>Other Labor</td>
                    <td><input type="text" name="other_labor_unit" class="table-input" readonly value="Lump-sum"></td>
                    <td><input type="number" name="other_labor_qty" class="table-input" readonly value="1"></td>
                    <td><input type="number" name="other_labor_cost" class="table-input price-input custom-price-item labor-item" placeholder="0.00" value="{{ old('other_labor_cost', 0) }}" required min="0" step="0.01"></td>
                </tr> -->
                <tr class="subtotal-row">
                    <td colspan="3" class="text-right">Labor Sub Total:</td>
                    <td class="text-right">Rs. <span id="sub-labor">0.00</span></td>
                </tr>
            </tbody>
        </table>

        <h3 class="section-title">Equipment Costs</h3>
        <table class="cost-table">
            <thead>
                <tr>
                    <th style="width: 40%;">Equipment Description</th>
                    <th style="width: 15%;">Unit</th>
                    <th style="width: 20%;">Qty</th>
                    <th style="width: 25%; text-align: right;">Total Price (Rs.)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Mixer Machine</td>
                    <td><input type="text" name="mixer_unit" class="table-input" readonly value="Days"></td>
                    <td><input type="number" name="mixer_qty" class="table-input qty-input" data-item="mixer" data-rate="{{ $rates['mixer'] ?? 0 }}" placeholder="Qty" value="{{ old('mixer_qty', 0) }}" min="0" step="any" required></td>
                    <td><input type="number" name="mixer_cost" class="table-input price-input equipment-item" id="mixer_cost" placeholder="0.00" value="{{ old('mixer_cost', 0) }}" readonly required min="0" step="0.01"></td>
                </tr>
                <tr>
                    <td>Excavator</td>
                    <td><input type="text" name="excavator_unit" class="table-input" readonly value="Hours"></td>
                    <td><input type="number" name="excavator_qty" class="table-input qty-input" data-item="excavator" data-rate="{{ $rates['excavator'] ?? 0 }}" placeholder="Qty" value="{{ old('excavator_qty', 0) }}" min="0" step="any" required></td>
                    <td><input type="number" name="excavator_cost" class="table-input price-input equipment-item" id="excavator_cost" placeholder="0.00" value="{{ old('excavator_cost', 0) }}" readonly required min="0" step="0.01"></td>
                </tr>
                <tr>
                    <td>Truck</td>
                    <td><input type="text" name="truck_unit" class="table-input" readonly value="Trips"></td>
                    <td><input type="number" name="truck_qty" class="table-input qty-input" data-item="truck" data-rate="{{ $rates['truck'] ?? 0 }}" placeholder="Qty" value="{{ old('truck_qty', 0) }}" min="0" step="any" required></td>
                    <td><input type="number" name="truck_cost" class="table-input price-input equipment-item" id="truck_cost" placeholder="0.00" value="{{ old('truck_cost', 0) }}" readonly required min="0" step="0.01"></td>
                </tr>
                <!-- <tr>
                    <td>Other Equipment</td>
                    <td><input type="text" name="other_equipment_unit" class="table-input" readonly value="Lump-sum"></td>
                    <td><input type="number" name="other_equipment_qty" class="table-input" readonly value="1"></td>
                    <td><input type="number" name="other_equipment_cost" class="table-input price-input custom-price-item equipment-item" placeholder="0.00" value="{{ old('other_equipment_cost', 0) }}" required min="0" step="0.01"></td>
                </tr> -->
                <tr class="subtotal-row">
                    <td colspan="3" class="text-right">Equipment Sub Total:</td>
                    <td class="text-right">Rs. <span id="sub-equipment">0.00</span></td>
                </tr>
            </tbody>
        </table>

        <h3 class="section-title">Other Details</h3>
        <div class="form-group">
            <label>Estimated Duration</label>
            <input type="text" name="estimated_duration" class="form-control" placeholder="e.g. 2 Months, 15 Days" value="{{ old('estimated_duration') }}" required>
        </div>

        <div class="form-group">
            <label>Remarks</label>
            <textarea name="remarks" class="form-control" rows="4" placeholder="Any additional details...">{{ old('remarks') }}</textarea>
        </div>

        <div class="grand-summary">
            <h3>Grand Summary</h3>
            <p>Total Material Cost : Rs. <span id="summary-material">0.00</span></p>
            <p>Total Labor Cost : Rs. <span id="summary-labor">0.00</span></p>
            <p>Total Equipment Cost : Rs. <span id="summary-equipment">0.00</span></p>
            <hr style="border: 0; border-top: 1px solid #b2dfdb;">
            <p class="total-cost">
                Grand Total Estimated Cost : Rs. <span id="grand-total">0.00</span>
            </p>
        </div>

        <button type="submit" class="btn-save">
            Save Estimate
        </button>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const qtyInputs = document.querySelectorAll('.qty-input');
    const customPriceInputs = document.querySelectorAll('.custom-price-item');
    
    const materialPrices = document.querySelectorAll('.material-item');
    const laborPrices = document.querySelectorAll('.labor-item');
    const equipmentPrices = document.querySelectorAll('.equipment-item');
    
    const subMaterial = document.getElementById('sub-material');
    const subLabor = document.getElementById('sub-labor');
    const subEquipment = document.getElementById('sub-equipment');

    const sumMaterial = document.getElementById('summary-material');
    const sumLabor = document.getElementById('summary-labor');
    const sumEquipment = document.getElementById('summary-equipment');
    const grandTotalLabel = document.getElementById('grand-total');

    function formatCurrency(amount) {
        return amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // 1. Qty ගුණ වෙලා Row එකේ Total Cost එක හැදෙන Logic එක
    qtyInputs.forEach(input => {
        input.addEventListener('input', function() {
            const row = this.closest('tr');
            const priceInput = row.querySelector('.price-input');
            
            const qty = parseFloat(this.value) || 0;
            const rate = parseFloat(this.getAttribute('data-rate')) || 0;
            
            const totalRowCost = qty * rate;
            if(priceInput) {
                priceInput.value = totalRowCost.toFixed(2);
            }
            
            calculateEstimates();
        });
    });

    // 2. Other/Custom Prices අතින් ටයිප් කරද්දී මුළු එකතුව වෙනස් වෙන එක
    customPriceInputs.forEach(input => {
        input.addEventListener('input', function() {
            calculateEstimates();
        });
    });

    // 3. මුළු එකතුව (Sub Totals & Grand Total) හදන ප්‍රධාන Function එක
    function calculateEstimates() {
        let materialSum = 0;
        let laborSum = 0;
        let equipmentSum = 0;

        materialPrices.forEach(input => {
            let val = parseFloat(input.value);
            if (!isNaN(val)) materialSum += val;
        });

        laborPrices.forEach(input => {
            let val = parseFloat(input.value);
            if (!isNaN(val)) laborSum += val;
        });

        equipmentPrices.forEach(input => {
            let val = parseFloat(input.value);
            if (!isNaN(val)) equipmentSum += val;
        });

        let totalCost = materialSum + laborSum + equipmentSum;

        // UI Labels ටික අප්ඩේට් කිරීම
        subMaterial.textContent = formatCurrency(materialSum);
        subLabor.textContent = formatCurrency(laborSum);
        subEquipment.textContent = formatCurrency(equipmentSum);

        sumMaterial.textContent = formatCurrency(materialSum);
        sumLabor.textContent = formatCurrency(laborSum);
        sumEquipment.textContent = formatCurrency(equipmentSum);
        grandTotalLabel.textContent = formatCurrency(totalCost);
    }

    // මුලින්ම Load වෙද්දිම කැල්කියුලේට් කරන්න
    calculateEstimates();
});
</script>

</body>
</html>