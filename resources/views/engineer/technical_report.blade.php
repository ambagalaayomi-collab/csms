<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technical Report Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #0f766e;
            --primary-light: #f0fdfa;
            --text-main: #1e293b;
            --text-muted: #475569;
            --border: #cbd5e1;
            --bg-readonly: #f1f5f9;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: var(--text-main);
            margin: 0;
            padding: 30px;
        }

        .report-container {
            max-width: 900px;
            margin: 20px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            border-top: 6px solid var(--primary);
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .report-title-main {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-muted);
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
            margin-top: 25px;
            margin-bottom: 16px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            color: #334155;
            background-color: #f8fafc;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.15);
            background-color: #ffffff;
        }

        .form-control[readonly] {
            background-color: var(--bg-readonly);
            cursor: not-allowed;
        }

        .textarea-control {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            box-sizing: border-box;
            resize: vertical;
            transition: all 0.2s;
        }

        .textarea-control:focus {
            outline: none;
            border-color: var(--primary);
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.15);
        }

        .cost-highlight {
            background-color: var(--primary-light) !important;
            border-color: var(--primary) !important;
            font-weight: 700;
            color: var(--primary) !important;
        }

        .grid-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .grid-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        .report-footer {
            padding: 24px 0 0 0;
            margin-top: 10px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .meta-info {
            font-size: 14px;
            color: var(--text-muted);
            margin: 0;
        }

        .submit-btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 6px -1px rgba(15, 118, 110, 0.2);
            font-family: 'Inter', sans-serif;
        }

        .submit-btn:hover {
            background-color: #115e59;
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        .alert-success-custom {
            background-color: var(--primary-light);
            border-left: 4px solid var(--primary);
            color: #115e59;
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .grid-row, .grid-row-3 {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>
<body>

    <div class="report-container">
        <div class="report-header">
            <div class="report-title-main"><i class="fas fa-file-contract"></i> Technical Report Submission</div>
            <div style="font-size: 13px; color: var(--text-muted); font-weight: 500;"><strong>Date:</strong> {{ now()->format('Y-m-d') }}</div>
        </div>

        @if(session('success'))
            <div class="alert-success-custom">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST"
      action="{{ route('engineer.technical_report.store') }}"
      enctype="multipart/form-data">
            @csrf

            <div class="form-group" style="max-width: 400px;">
                <label class="form-label">Project Request</label>
                <select name="req_id" class="form-select" id="requestSelect" required onchange="loadMeasurements()">
                    <option value="" disabled selected>Select Request ID</option>
                    @foreach($assignedRequests as $req)
                        <option value="{{ $req->id }}" 
                                data-length="{{ $req->width }}"
                                data-width="{{ $req->height }}"
                                data-material="{{ ($req->estimate->cement_cost ?? 0) + ($req->estimate->sand_cost ?? 0) + ($req->estimate->steel_cost ?? 0) + ($req->estimate->brick_cost ?? 0) }}"
                                data-labor="{{ ($req->estimate->mason_cost ?? 0) + ($req->estimate->carpenter_cost ?? 0) + ($req->estimate->helper_cost ?? 0) }}"
                                data-equipment="{{ ($req->estimate->mixer_cost ?? 0) + ($req->estimate->excavator_cost ?? 0) + ($req->estimate->truck_cost ?? 0) }}"
                                data-total="{{ ($req->estimate->cement_cost ?? 0) + ($req->estimate->sand_cost ?? 0) + ($req->estimate->steel_cost ?? 0) + ($req->estimate->brick_cost ?? 0) + ($req->estimate->mason_cost ?? 0) + ($req->estimate->carpenter_cost ?? 0) + ($req->estimate->helper_cost ?? 0) + ($req->estimate->mixer_cost ?? 0) + ($req->estimate->excavator_cost ?? 0) + ($req->estimate->truck_cost ?? 0) }}">
                            R-{{ $req->id }} - {{ $req->name }} ({{ $req->project_type }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="section-title">
                <i class="fa-solid fa-ruler-combined"></i> SITE MEASUREMENTS
            </div>
            <div class="grid-row-3">
                <div class="form-group">
                    <label class="form-label">Length (ft)</label>
                    <input
    type="number"
    id="length"
    name="length"
    class="form-control"
    placeholder="e.g. 50"
    readonly
    required>
                </div>
                <div class="form-group">
                    <label class="form-label">Width (ft)</label>
                    <input type="number" id="width"name="width" class="form-control" placeholder="e.g. 40" readonly required>
                </div>
                <div class="form-group">
                    <label class="form-label">Area (sq.ft)</label>
                    <input
    type="number"
    id="area"
    name="area"
    class="form-control"
    placeholder="e.g. 2000"
    readonly
    required>
                </div>
            </div>

           <div class="section-title">
    <i class="fa-solid fa-file-excel"></i>
    COST ESTIMATE EXCEL
</div>

<div class="form-group">
    <label class="form-label">
        Upload Cost Estimate Excel
    </label>

    <input
        type="file"
        name="cost_estimate_file"
        class="form-control"
        accept=".xlsx,.xls"
        required
    >

    <small style="color:#64748b;">
        Upload the provided Unit Rate Estimate Excel template.
    </small>

    @error('cost_estimate_file')
        <div style="color:#dc2626; margin-top:8px;">
            {{ $message }}
        </div>
    @enderror
</div>
@if($errors->any())
    <div style="
        background:#fef2f2;
        border-left:4px solid #dc2626;
        color:#991b1b;
        padding:14px 20px;
        border-radius:8px;
        margin-bottom:25px;
    ">
        <strong>Please correct the following errors:</strong>

        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            <div class="section-title">
                <i class="fa-solid fa-clock"></i> ESTIMATED DURATION
            </div>
            <div class="form-group" style="max-width: 400px;">
                <label class="form-label">Estimated Duration</label>
                <input type="text" name="estimated_duration" class="form-control" placeholder="e.g. 4 Months" required>
            </div>

            <div class="section-title">
                <i class="fa-solid fa-clipboard-user"></i> ENGINEER RECOMMENDATIONS
            </div>
            <div class="form-group">
                <textarea name="recommendations" class="textarea-control" rows="3" placeholder="Foundation reinforcement is recommended due to soil conditions..."></textarea>
            </div>

            <div class="section-title">
                <i class="fa-solid fa-comment-dots"></i> REMARKS
            </div>
            <div class="form-group">
                <textarea name="remarks" class="textarea-control" rows="2" placeholder="The site is suitable for construction..."></textarea>
            </div>

            <div class="grid-row" style="align-items: center; margin-top: 25px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                <p class="meta-info"><strong>Prepared By:</strong> Engineer</p>
                <p class="meta-info" style="text-align: right;"><strong>Date:</strong> {{ now()->format('Y-m-d') }}</p>
            </div>

            <div class="report-footer">
                <p class="meta-info" style="font-size: 13px; color: #94a3b8;">Ensure all details are accurate before submitting.</p>
                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-save"></i> Submit Report
                </button>
            </div>

        </form>
    </div>

    <script>
    function loadMeasurements() {
        const select =
            document.getElementById('requestSelect');

        const option =
            select.options[select.selectedIndex];

        if (!option || !option.value) {
            document.getElementById('length').value = '';
            document.getElementById('width').value = '';
            document.getElementById('area').value = '';
            return;
        }

        const length =
            parseFloat(option.dataset.length) || 0;

        const width =
            parseFloat(option.dataset.width) || 0;

        const area = length * width;

        document.getElementById('length').value =
            length;

        document.getElementById('width').value =
            width;

        document.getElementById('area').value =
            area.toFixed(2);
    }
</script>
</body>
</html>