<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Project Request | CSMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            background:
                linear-gradient(rgba(0, 50, 35, 0.82), rgba(0, 50, 35, 0.70)),
                url("{{ asset('home-bg.jpg') }}");
            background-size: cover;
            background-position: center;
            color: #111827;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px 20px;
        }

        .request-modal-box {
            width: 680px;
            max-width: 96%;
            max-height: 92vh;
            overflow-y: auto;
            background: #ffffff;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 20px 45px rgba(0,0,0,0.25);
            animation: modalFade 0.25s ease-in-out;
        }

        @keyframes modalFade {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .request-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 16px;
        }

        .request-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .request-title-icon {
            width: 42px;
            height: 42px;
            background: #ecfdf5;
            color: #047857;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .request-header h2 {
            font-size: 23px;
            color: #003f35;
            margin-bottom: 4px;
        }

        .request-header p {
            font-size: 13px;
            color: #6b7280;
        }

        .close-link {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #555;
            font-size: 22px;
        }

        .close-link:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: bold;
            border: 1px solid #bbf7d0;
            display: flex;
            align-items: center;
            gap: 10px;
            line-height: 1.5;
        }

        .success-message i {
            color: #15803d;
            font-size: 16px;
        }

        .error-message {
            background: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #111827;
        }

        .input-group {
            border: 1px solid #d1d5db;
            border-radius: 7px;
            height: 48px;
            display: flex;
            align-items: center;
            padding: 0 14px;
            margin: 8px 0 18px;
            background: #ffffff;
        }

        .input-group i {
            color: #047857;
            margin-right: 10px;
            width: 18px;
        }

        .input-group input,
        .input-group select {
            border: none;
            outline: none;
            width: 100%;
            font-size: 14px;
            background: transparent;
            color: #111827;
        }

        .textarea-group {
            border: 1px solid #d1d5db;
            border-radius: 7px;
            display: flex;
            align-items: flex-start;
            padding: 13px 14px;
            margin: 8px 0 18px;
            background: #ffffff;
        }

        .textarea-group i {
            color: #047857;
            margin-right: 10px;
            margin-top: 3px;
            width: 18px;
        }

        .textarea-group textarea {
            border: none;
            outline: none;
            width: 100%;
            min-height: 105px;
            resize: vertical;
            font-size: 14px;
            background: transparent;
            color: #111827;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-actions {
            display: flex;
            gap: 14px;
            margin-top: 8px;
        }

        .submit-btn {
            flex: 1;
            height: 48px;
            border: none;
            border-radius: 7px;
            background: #003f35;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
        }

        .submit-btn:hover {
            background: #047857;
        }

        .cancel-btn {
            height: 48px;
            min-width: 130px;
            border-radius: 7px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
            text-decoration: none;
            font-weight: bold;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cancel-btn:hover {
            background: #f3f4f6;
        }

        .note {
            margin-top: 18px;
            font-size: 13px;
            color: #6b7280;
            text-align: center;
            line-height: 1.6;
        }

        .note i {
            color: #047857;
            margin-right: 5px;
        }

        @media (max-width: 700px) {
            .request-modal-box {
                padding: 22px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .form-actions {
                flex-direction: column;
            }

            .cancel-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="request-modal-box">

        <div class="request-header">
            <div class="request-title">
                <div class="request-title-icon">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>

                <div>
                    <h2>Submit Project Request</h2>
                    <p>Fill in your project details and submit your construction request.</p>
                </div>
            </div>

            <a href="{{ url('/') }}" class="close-link">
                &times;
            </a>
        </div>

        @if(session('request_success'))
            <div class="success-message">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('request_success') }}
            </div>

            <script>
                setTimeout(function () {
                    window.location.href = "{{ url('/client/dashboard') }}";
                }, 2500);
            </script>
        @endif

        @if($errors->any())
            <div class="error-message">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('project.request.store') }}">
            @csrf

            <div class="form-row">
                <div>
                    <label>Client Name</label>
                    <div class="input-group">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="name" placeholder="Enter client name" value="{{ old('name') }}" required>
                    </div>
                </div>

                <div>
                    <label>Phone Number</label>
                    <div class="input-group">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}" required>
                    </div>
                </div>
            </div>

            <label>Email</label>
            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter email address" value="{{ old('email') }}" required>
            </div>

            <div class="form-row">
                <div>
                    <label>Project Type</label>
                    <div class="input-group">
                        <i class="fa-solid fa-list-check"></i>
                        <select name="project_type" required>
                            <option value="">-- Select Project Type --</option>
                            <option value="Road Construction" {{ old('project_type') == 'Road Construction' ? 'selected' : '' }}>Road Construction</option>
                            <!-- <option value="Building Construction" {{ old('project_type') == 'Building Construction' ? 'selected' : '' }}>Building Construction</option>
                            <option value="Bridge Construction" {{ old('project_type') == 'Bridge Construction' ? 'selected' : '' }}>Bridge Construction</option>
                            <option value="Drainage System" {{ old('project_type') == 'Drainage System' ? 'selected' : '' }}>Drainage System</option>
                            <option value="Other" {{ old('project_type') == 'Other' ? 'selected' : '' }}>Other</option> -->
                        </select>
                    </div>
                </div>

                <div>
                    <label>Project Location</label>
                    <div class="input-group">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" name="location" placeholder="Enter project location" value="{{ old('location') }}" required>
                    </div>
                </div>
            </div>
            <div class="form-row">
    <div>
        <label>Width (m)</label>
        <div class="input-group">
            <i class="fa-solid fa-ruler-horizontal"></i>
            <input type="number" name="width" step="0.01" placeholder="Enter width" required>
        </div>
    </div>

    <div>
        <label>Height (m)</label>
        <div class="input-group">
            <i class="fa-solid fa-ruler-vertical"></i>
            <input type="number" name="height" step="0.01" placeholder="Enter height" required>
        </div>
    </div>
</div>

            <div class="form-row">
                <div>
                    <label>Expected Budget (LKR)</label>
                    <div class="input-group">
                        <i class="fa-solid fa-money-bill-wave"></i>
                        <input type="number" name="budget" placeholder="Enter expected budget" value="{{ old('budget') }}" required>
                    </div>
                </div>

                <div>
                    <label>Expected Timeline</label>
                    <div class="input-group">
                        <i class="fa-solid fa-calendar-days"></i>
                        <input type="text" name="timeline" placeholder="e.g. 6 Months" value="{{ old('timeline') }}" required>
                    </div>
                </div>
            </div>

            <label>Project Description / Requirements</label>
            <div class="textarea-group">
                <i class="fa-solid fa-align-left"></i>
                <textarea name="requirements" placeholder="Describe your project requirements" required>{{ old('requirements') }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-paper-plane"></i>
                    Submit Request
                </button>

                <a href="{{ url('/') }}" class="cancel-btn">
                    Cancel
                </a>
            </div>

            <div class="note">
                <i class="fa-solid fa-circle-info"></i>
                Your request will be reviewed by the Project Manager after submission.
            </div>
        </form>

    </div>
</div>

</body>
</html>