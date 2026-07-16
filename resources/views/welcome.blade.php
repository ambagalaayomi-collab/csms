<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Construction Site Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f6faf8;
            color: #111827;
        }

        .navbar {
            height: 78px;
            background: #003f35;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 65px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: bold;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            background: rgba(255, 193, 7, 0.16);
            color: #ffc107;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .logo-text {
            font-size: 20px;
            line-height: 1.3;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
            font-size: 15px;
        }

        .nav-links a.active {
            color: #ffc107;
            border-bottom: 3px solid #ffc107;
            padding-bottom: 8px;
        }

        .nav-buttons a {
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            margin-left: 10px;
            font-weight: bold;
        }

        .login-btn {
            color: white;
            border: 1px solid white;
        }

        .register-btn {
            background: #ffc107;
            color: black;
        }

        .hero {
            min-height: 600px;
            background:
                linear-gradient(rgba(0, 50, 35, 0.8), rgba(0, 50, 35, 0.6)),
                url("{{ asset('home-bg.jpg') }}");
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 60px;
        }

        .hero-content {
            max-width: 650px;
        }

        .hero h1 {
            font-size: 54px;
            line-height: 1.15;
            margin-bottom: 22px;
        }

        .hero h1 span {
            color: #ffc107;
        }

        .hero p {
            font-size: 20px;
            line-height: 1.7;
            margin-bottom: 35px;
        }

        .hero-actions a {
            display: inline-block;
            text-decoration: none;
            padding: 17px 28px;
            border-radius: 7px;
            margin-right: 15px;
            font-weight: bold;
        }

        .dashboard-btn {
            background: #059669;
            color: white;
        }

        .dashboard-btn:hover {
            background: #047857;
        }

        .hero-features {
            display: flex;
            gap: 35px;
            margin-top: 58px;
            flex-wrap: wrap;
        }

        .hero-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: bold;
        }

        .feature-small-icon {
            width: 38px;
            height: 38px;
            background: rgba(255, 193, 7, 0.16);
            color: #ffc107;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section {
            padding: 65px;
        }

        .about {
            background: white;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 45px;
            align-items: center;
        }

        .small-title {
            color: #047857;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 14px;
        }

        .about h2,
        .section-title {
            font-size: 32px;
            margin-bottom: 22px;
        }

        .about p {
            color: #374151;
            line-height: 1.8;
            font-size: 16px;
        }

        .about button {
            margin-top: 22px;
            background: #003f35;
            color: white;
            border: none;
            padding: 13px 24px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .about-graphic {
            text-align: center;
            font-size: 130px;
            color: #047857;
        }

        .center-title {
            text-align: center;
            margin-bottom: 35px;
            font-size: 17px;
            font-weight: bold;
        }

        .center-title::after {
            content: "";
            width: 35px;
            height: 3px;
            background: #047857;
            display: block;
            margin: 10px auto 0;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
        }

        .feature-card {
            background: white;
            padding: 28px 16px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .feature-card .icon {
            width: 66px;
            height: 66px;
            background: #ecfdf5;
            color: #047857;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 18px;
        }

        .feature-card h3 {
            font-size: 15px;
            margin-bottom: 12px;
        }

        .feature-card p {
            font-size: 13px;
            line-height: 1.6;
            color: #4b5563;
        }

        .roles-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .role-card {
            background: white;
            padding: 28px;
            display: flex;
            gap: 22px;
            align-items: center;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .role-icon {
            width: 78px;
            height: 78px;
            background: #d1fae5;
            color: #047857;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
        }

        .role-card h3 {
            margin-bottom: 9px;
        }

        .role-card p {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.6;
        }

        .role-card a {
            display: inline-block;
            margin-top: 10px;
            color: #047857;
            text-decoration: none;
            font-weight: bold;
        }

        .footer {
            background: #003f35;
            color: white;
            padding: 55px 65px 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr 1.8fr;
            gap: 35px;
        }

        .footer h3 {
            color: #ffc107;
            margin-bottom: 15px;
        }

        .footer p,
        .footer a {
            color: #e5e7eb;
            display: block;
            text-decoration: none;
            margin-bottom: 9px;
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-icon {
            color: #ffc107;
            margin-right: 8px;
            width: 18px;
        }

        .newsletter input {
            padding: 13px;
            width: 65%;
            border: none;
            border-radius: 5px 0 0 5px;
        }

        .newsletter button {
            padding: 13px;
            border: none;
            background: #059669;
            color: white;
            font-weight: bold;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .copyright {
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.15);
            margin-top: 35px;
            padding-top: 18px;
            font-size: 14px;
        }

        .login-modal-overlay,
        .register-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.55);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 99999;
        }

        .login-modal-box,
        .register-modal-box {
            width: 480px;
            max-width: 92%;
            max-height: 90vh;
            overflow-y: auto;
            background: white;
            border-radius: 12px;
            padding: 28px;
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

        .login-modal-header,
        .register-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }

        .login-modal-header h2,
        .register-modal-header h2 {
            font-size: 22px;
            color: #003f35;
        }

        .close-login-modal,
        .close-register-modal {
            font-size: 28px;
            cursor: pointer;
            color: #555;
        }

        .close-login-modal:hover,
        .close-register-modal:hover {
            color: #000;
        }

        .login-modal-box label,
        .register-modal-box label {
            font-size: 14px;
            font-weight: bold;
            color: #111827;
        }

        .modal-input-group {
            border: 1px solid #d1d5db;
            border-radius: 7px;
            height: 48px;
            display: flex;
            align-items: center;
            padding: 0 14px;
            margin: 8px 0 18px;
        }

        .modal-input-group input,
        .modal-input-group select {
            border: none;
            outline: none;
            width: 100%;
            font-size: 14px;
            background: transparent;
        }

        .modal-input-group i {
            color: #047857;
            margin-right: 10px;
        }

        .modal-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .modal-options a {
            color: #047857;
            text-decoration: none;
            font-weight: bold;
        }

        .modal-login-btn,
        .modal-register-btn {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal-login-btn {
            background: #003f35;
            color: white;
        }

        .modal-login-btn:hover {
            background: #047857;
        }

        .modal-register-btn {
            background: #ffc107;
            color: #111827;
        }

        .modal-register-btn:hover {
            background: #eab308;
        }

        .modal-register,
        .modal-login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .modal-register a,
        .modal-login-link a {
            color: #047857;
            font-weight: bold;
            text-decoration: none;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: bold;
        }

        .error-message {
            background: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: bold;
        }

        @media (max-width: 1000px) {
            .navbar {
                flex-direction: column;
                height: auto;
                padding: 20px;
                gap: 18px;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .about,
            .roles-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .hero {
                padding: 60px 25px;
            }

            .hero h1 {
                font-size: 38px;
            }

            .section {
                padding: 45px 25px;
            }
        }

        @media (max-width: 600px) {
            .features-grid {
                grid-template-columns: 1fr;
            }

            .nav-links a {
                display: inline-block;
                margin: 8px;
            }
        }
    </style>
</head>
<body>

<!-- LOGIN MODAL -->
<div class="login-modal-overlay" id="loginModal">
    <div class="login-modal-box">

        <div class="login-modal-header">
            <h2>Sign-in to System</h2>
            <span class="close-login-modal" id="closeLoginModal">&times;</span>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            @if(session('error_msg'))
                <div class="error-message">
                    {{ session('error_msg') }}
                </div>
            @endif

            @if(session('register_success'))
                <div class="success-message">
                    {{ session('register_success') }}
                </div>
            @endif

            @if($errors->has('login_error'))
                <div class="error-message">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            <label>Email</label>
            <div class="modal-input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required>
            </div>

            <label>Password</label>
            <div class="modal-input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <label>Select Role</label>
            <div class="modal-input-group">
                <i class="fa-solid fa-user-shield"></i>
                <select name="role" required>
                    <option value="">Select your role</option>
                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                    <option value="project_manager" {{ old('role') == 'project_manager' ? 'selected' : '' }}>Project Manager</option>
                    <option value="engineer" {{ old('role') == 'engineer' ? 'selected' : '' }}>Engineer</option>
                </select>
            </div>

            <div class="modal-options">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
                <a href="#">Forgot password?</a>
            </div>

            <button type="submit" class="modal-login-btn"> Sign-in</button>

            <div class="modal-register">
                Don’t have an account?
                <a href="#" id="switchToRegister">Sign-up</a>
            </div>
        </form>

    </div>
</div>

<!-- REGISTER MODAL -->
<div class="register-modal-overlay" id="registerModal">
    <div class="register-modal-box">

        <div class="register-modal-header">
            <h2>Create Account</h2>
            <span class="close-register-modal" id="closeRegisterModal">&times;</span>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            @if($errors->any() && !$errors->has('login_error') && !session('open_login_modal'))
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <label>Full Name</label>
            <div class="modal-input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="name" placeholder="Enter your full name" value="{{ old('name') }}" required>
            </div>

            <label>Email</label>
            <div class="modal-input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
            </div>

            <label>Password</label>
            <div class="modal-input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Create a password" required>
            </div>

            <label>Confirm Password</label>
            <div class="modal-input-group">
                <i class="fa-solid fa-key"></i>
                <input type="password" name="password_confirmation" placeholder="Confirm your password" required>
            </div>

            <label>Select Role</label>
            <div class="modal-input-group">
                <i class="fa-solid fa-user-shield"></i>
                <select name="role" required>
                    <option value="">Select role</option>
                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                    <option value="project_manager" {{ old('role') == 'project_manager' ? 'selected' : '' }}>Project Manager</option>
                    <option value="engineer" {{ old('role') == 'engineer' ? 'selected' : '' }}>Engineer</option>
                </select>
            </div>

            <button type="submit" class="modal-register-btn">Sign-up</button>

            <div class="modal-login-link">
                Already have an account?
                <a href="#" id="switchToLogin">🔑Sign-in</a>
            </div>
        </form>

    </div>
</div>

<!-- NAVBAR -->
<header class="navbar">
    <div class="logo">
        <div class="logo-icon">
            <i class="fa-solid fa-helmet-safety"></i>
        </div>
        <div class="logo-text">
            Construction Site<br>Management System
        </div>
    </div>

    <nav class="nav-links">
        <a href="/" class="active">Home</a>
        <a href="#about">About</a>
        <a href="#features">Features</a>
        <a href="#roles">User Roles</a>
        <a href="#contact">Contact</a>
    </nav>

    <div class="nav-buttons">
        <a href="#" class="login-btn" id="openLoginModal">Sign-in</a>
        <a href="#" class="register-btn" id="openRegisterModal">Sign-up</a>
    </div>
</header>

 <!-- */HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h1>
            Smart Management for<br>
            <span>Construction Projects</span>
        </h1>

        <p>
            Manage client requests, engineer estimations, proposal preparation,
            and client approval in one efficient web-based platform.
        </p>

      <div class="hero-actions">
        
            <a href="{{ route('client.request.project') }}" class="dashboard-btn">
                <i class="fa-solid fa-paper-plane"></i>
               Submit Request
               
            </a>
        </div>
    </div>

    <div class="hero-features">
        <div class="hero-feature">
            <span class="feature-small-icon"><i class="fa-solid fa-shield-halved"></i></span>
            Secure & Reliable
        </div>

        <div class="hero-feature">
            <span class="feature-small-icon"><i class="fa-solid fa-clock"></i></span>
            Save Time
        </div>

        <div class="hero-feature">
            <span class="feature-small-icon"><i class="fa-solid fa-chart-line"></i></span>
            Status Tracking
        </div>

        <div class="hero-feature">
            <span class="feature-small-icon"><i class="fa-solid fa-file-lines"></i></span>
            Detailed Reports
        </div>
    </div>
</section>

<!-- ABOUT SECTION -->
<section class="section about" id="about">
    <div>
        <div class="small-title">ABOUT THE SYSTEM</div>
        <h2>Built for Road Construction<br>Proposal Management</h2>
        <p>
            The Construction Site Management System is designed to support the early
            stages of road construction projects. It helps clients submit project requests,
            project managers assign engineers, and engineers prepare technical reports
            for accurate proposal preparation.
        </p>
        <button>Learn More →</button>
    </div>

    <div class="about-graphic">
        <i class="fa-solid fa-building-user"></i>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="section" id="features">
    <div class="center-title">MAIN FEATURES</div>

    <div class="features-grid">
        <div class="feature-card">
            <div class="icon"><i class="fa-solid fa-clipboard-list"></i></div>
            <h3>Client Request</h3>
            <p>Clients can submit road construction requests with location, measurements, and basic requirements.</p>
        </div>

        <div class="feature-card">
            <div class="icon"><i class="fa-solid fa-user-gear"></i></div>
            <h3>Engineer Estimation</h3>
            <p>Engineers verify measurements, check materials, and estimate cost, budget, and duration.</p>
        </div>

        <div class="feature-card">
            <div class="icon"><i class="fa-solid fa-file-signature"></i></div>
            <h3>Proposal Management</h3>
            <p>Project Managers prepare final proposals using the engineer’s technical report.</p>
        </div>

        <div class="feature-card">
            <div class="icon"><i class="fa-solid fa-handshake"></i></div>
            <h3>Client Approval</h3>
            <p>Clients can approve, reject, or request changes to the submitted proposal.</p>
        </div>

        <div class="feature-card">
            <div class="icon"><i class="fa-solid fa-chart-pie"></i></div>
            <h3>Reports</h3>
            <p>Generate proposal and technical estimation reports for documentation and decision making.</p>
        </div>
    </div>
</section>

<!-- USER ROLES -->
<section class="section" id="roles">
    <div class="center-title">USER ROLES</div>

    <div class="roles-grid">
        <div class="role-card">
            <div class="role-icon"><i class="fa-solid fa-user"></i></div>
            <div>
                <h3>Client</h3>
                <p>Submit project requests, review proposals, and approve, reject, or request changes.</p>
                <a href="#">Learn More →</a>
            </div>
        </div>

        <div class="role-card">
            <div class="role-icon"><i class="fa-solid fa-user-tie"></i></div>
            <div>
                <h3>Project Manager</h3>
                <p>View client requests, assign engineers, prepare proposals, and manage proposal status.</p>
                <a href="#">Learn More →</a>
            </div>
        </div>

        <div class="role-card">
            <div class="role-icon"><i class="fa-solid fa-user-gear"></i></div>
            <div>
                <h3>Engineer</h3>
                <p>Verify measurements, check materials, estimate cost and duration, and submit technical reports.</p>
                <a href="#">Learn More →</a>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer" id="contact">
    <div class="footer-grid">
        <div>
            <h3><i class="fa-solid fa-helmet-safety footer-icon"></i> Construction Site Management System</h3>
            <p>
                A web-based system for managing road construction requests,
                technical estimations, proposal preparation, and client approval.
            </p>
        </div>

        <div>
            <h3>Quick Links</h3>
            <a href="/">Home</a>
            <a href="#about">About</a>
            <a href="#features">Features</a>
            <a href="#roles">User Roles</a>
            <a href="#contact">Contact</a>
        </div>

        <div>
            <h3>Support</h3>
            <a href="#">Help & FAQ</a>
            <a href="#">User Guide</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Privacy Policy</a>
        </div>

        <div>
            <h3>Contact Us</h3>
            <p><i class="fa-solid fa-location-dot footer-icon"></i> Kurunegala, Sri Lanka</p>
            <p><i class="fa-solid fa-phone footer-icon"></i> +94 77 123 4567</p>
            <p><i class="fa-solid fa-envelope footer-icon"></i> info@csms.com</p>
        </div>

        <div class="newsletter">
            <h3>Newsletter</h3>
            <p>Subscribe to get the latest project updates and system news.</p>
            <input type="email" placeholder="Enter your email">
            <button>Subscribe</button>
        </div>
    </div>

    <div class="copyright">
        © 2024 Construction Site Management System. All Rights Reserved.
    </div>
</footer>

<script>
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');

    const openLoginModal = document.getElementById('openLoginModal');
    const openRegisterModal = document.getElementById('openRegisterModal');

    const closeLoginModal = document.getElementById('closeLoginModal');
    const closeRegisterModal = document.getElementById('closeRegisterModal');

    const switchToRegister = document.getElementById('switchToRegister');
    const switchToLogin = document.getElementById('switchToLogin');

    function showLoginModal() {
        if (loginModal) loginModal.style.display = 'flex';
        if (registerModal) registerModal.style.display = 'none';
    }

    function showRegisterModal() {
        if (registerModal) registerModal.style.display = 'flex';
        if (loginModal) loginModal.style.display = 'none';
    }

    function closeAllModals() {
        if (loginModal) loginModal.style.display = 'none';
        if (registerModal) registerModal.style.display = 'none';
    }

    if (openLoginModal) {
        openLoginModal.addEventListener('click', function(e) {
            e.preventDefault();
            showLoginModal();
        });
    }

    if (openRegisterModal) {
        openRegisterModal.addEventListener('click', function(e) {
            e.preventDefault();
            showRegisterModal();
        });
    }

    if (closeLoginModal) {
        closeLoginModal.addEventListener('click', closeAllModals);
    }

    if (closeRegisterModal) {
        closeRegisterModal.addEventListener('click', closeAllModals);
    }

    if (switchToRegister) {
        switchToRegister.addEventListener('click', function(e) {
            e.preventDefault();
            showRegisterModal();
        });
    }

    if (switchToLogin) {
        switchToLogin.addEventListener('click', function(e) {
            e.preventDefault();
            showLoginModal();
        });
    }

    window.addEventListener('click', function(e) {
        if (e.target === loginModal || e.target === registerModal) {
            closeAllModals();
        }
    });

    @if(session('open_login_modal') || session('register_success') || session('error_msg') || $errors->has('login_error'))
        window.addEventListener('load', function() {
            showLoginModal();
        });
    @endif

    @if($errors->any() && !$errors->has('login_error') && !session('open_login_modal') && !session('register_success') && !session('error_msg'))
        window.addEventListener('load', function() {
            showRegisterModal();
        });
    @endif
</script>

</body>
</html>