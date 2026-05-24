<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSMS Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, sans-serif;
        }

        body{
            background:#f3f4f6;
            height:100vh;
        }

        .container{
            display:flex;
            width:100%;
            height:100vh;
        }

        .left{
            width:50%;
            background:url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?auto=format&fit=crop&w=1200&q=80');
            background-size:cover;
            background-position:center;
            position:relative;
            color:white;
            padding:50px;
        }

        .left::before{
            content:'';
            position:absolute;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(3, 25, 70, 0.65);
        }

        .content{
            position:relative;
            z-index:2;
        }

        .logo{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .logo i{
            font-size:38px;
            color:#ff9800;
        }

        .logo h2{
            font-size:28px;
        }

        .logo p{
            font-size:12px;
        }

        .hero{
            margin-top:100px;
        }

        .hero h1{
            font-size:54px;
            line-height:1.2;
            font-weight:bold;
        }

        .hero h1 span{
            color:#ff9800;
        }

        .line{
            width:60px;
            height:4px;
            background:#ff9800;
            margin:20px 0;
        }

        .hero p{
            width:450px;
            line-height:1.8;
            font-size:17px;
        }

        .features{
            position:absolute;
            bottom:40px;
            left:50px;
            right:50px;
            background:#08285f;
            padding:22px;
            border-radius:12px;
            display:flex;
            justify-content:space-around;
            z-index:2;
        }

        .feature{
            display:flex;
            align-items:center;
            gap:12px;
            color:white;
        }

        .feature i{
            font-size:26px;
            color:#ff9800;
        }

        .right{
            width:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            background:#f7f7f7;
        }

        .login-box{
            width:450px;
            background:white;
            padding:40px;
            border-radius:18px;
            box-shadow:0 10px 30px rgba(0,0,0,0.12);
            text-align:center;
        }

        .circle{
            width:70px;
            height:70px;
            background:#08285f;
            border-radius:50%;
            margin:auto;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .circle i{
            color:#ff9800;
            font-size:28px;
        }

        .login-box h2{
            margin-top:18px;
            color:#08285f;
            font-size:30px;
        }

        .sub{
            color:#777;
            margin:12px 0 30px;
            font-size:15px;
        }

        form{
            text-align:left;
        }

        label{
            font-size:14px;
            font-weight:600;
            color:#333;
        }

        .input-group{
            border:1px solid #ddd;
            border-radius:8px;
            height:48px;
            display:flex;
            align-items:center;
            padding:0 15px;
            margin:8px 0 18px;
        }

        .input-group i{
            color:#aaa;
            margin-right:10px;
        }

        .input-group input,
        .input-group select{
            border:none;
            outline:none;
            width:100%;
            font-size:14px;
            background:transparent;
        }

        .options{
            display:flex;
            justify-content:space-between;
            margin-bottom:20px;
            font-size:14px;
        }

        .options a{
            text-decoration:none;
            color:#1d4ed8;
        }

        button{
            width:100%;
            height:48px;
            background:#ff9800;
            border:none;
            color:white;
            font-size:16px;
            font-weight:bold;
            border-radius:8px;
            cursor:pointer;
        }

        button:hover{
            background:#e68900;
        }

        .or{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            margin:25px 0;
            color:#999;
        }

        .or span{
            width:120px;
            height:1px;
            background:#ddd;
        }

        .register{
            text-align:center;
            font-size:14px;
        }

        .register a{
            text-decoration:none;
            color:#1d4ed8;
            font-weight:bold;
        }

        @media(max-width:900px){
            .container{
                flex-direction:column;
            }

            .left,
            .right{
                width:100%;
            }

            .left{
                height:50vh;
            }

            .right{
                height:auto;
                padding:30px;
            }

            .hero p{
                width:100%;
            }

            .features{
                position:relative;
                left:0;
                right:0;
                bottom:0;
                margin-top:30px;
            }
            .login-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: rgba(0, 0, 0, 0.55);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.login-modal-box {
    width: 480px;
    max-height: 90vh;
    overflow-y: auto;
    background: #ffffff;
    border-radius: 14px;
    padding: 28px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
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

.login-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.login-modal-header h2 {
    color: #08285f;
    font-size: 22px;
    font-weight: bold;
}

.close-login-modal {
    font-size: 28px;
    cursor: pointer;
    color: #555;
}

.close-login-modal:hover {
    color: #000;
}

.login-modal-box label {
    font-size: 14px;
    font-weight: 600;
    color: #333;
}

.modal-input-group {
    border: 1px solid #ddd;
    border-radius: 8px;
    height: 48px;
    display: flex;
    align-items: center;
    padding: 0 15px;
    margin: 8px 0 18px;
}

.modal-input-group i {
    color: #777;
    margin-right: 10px;
}

.modal-input-group input,
.modal-input-group select {
    border: none;
    outline: none;
    width: 100%;
    font-size: 14px;
    background: transparent;
}

.modal-options {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    font-size: 14px;
}

.modal-options a {
    text-decoration: none;
    color: #1d4ed8;
}

.modal-login-btn {
    width: 100%;
    height: 48px;
    background: #ff9800;
    border: none;
    color: white;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
}

.modal-login-btn:hover {
    background: #e68900;
}

.modal-register {
    text-align: center;
    margin-top: 22px;
    font-size: 14px;
}

.modal-register a {
    color: #1d4ed8;
    font-weight: bold;
    text-decoration: none;
}
        }
    </style>
</head>
<body>
    <script>
    const openLoginModal = document.getElementById('openLoginModal');
    const closeLoginModal = document.getElementById('closeLoginModal');
    const loginModal = document.getElementById('loginModal');

    openLoginModal.addEventListener('click', function(e) {
        e.preventDefault();
        loginModal.style.display = 'flex';
    });

    closeLoginModal.addEventListener('click', function() {
        loginModal.style.display = 'none';
    });

    window.addEventListener('click', function(e) {
        if (e.target === loginModal) {
            loginModal.style.display = 'none';
        }
    });
</script>

<div class="container">

    <div class="left">
        <div class="content">
            <div class="logo">
                <i class="fa-solid fa-building"></i>
                <div>
                    <h2>CSMS</h2>
                    <p>Construction Site Management System</p>
                </div>
            </div>

            <div class="hero">
                <h1>Build Better.<br><span>Manage Smarter.</span></h1>
                <div class="line"></div>
                <p>
                    Streamline construction projects, coordinate teams,
                    manage resources, and deliver exceptional results—
                    on time and within budget.
                </p>
            </div>
        </div>

        <div class="features">
            <div class="feature">
                <i class="fa-solid fa-users"></i>
                <div>Better<br>Collaboration</div>
            </div>

            <div class="feature">
                <i class="fa-solid fa-calendar-check"></i>
                <div>Real-time<br>Tracking</div>
            </div>

            <div class="feature">
                <i class="fa-solid fa-chart-column"></i>
                <div>Data-driven<br>Decisions</div>
            </div>
        </div>
    </div>

    <div class="right">
        <div class="login-box">

            <div class="circle">
                <i class="fa-solid fa-building"></i>
            </div>

            <h2>Construction Site<br>Management System</h2>
            <p class="sub">Welcome back! Please login to your account.</p>

            <form method="POST" action="{{ route('login') }}">

    @if(session('success'))
        <p style="color:green;text-align:center;margin-bottom:15px;">
            {{ session('success') }}
        </p>
    @endif

    @csrf

    <label>Email</label>
    <div class="input-group">
        <i class="fa-regular fa-envelope"></i>
        <input type="email" name="email" placeholder="Enter your email address">
    </div>

              

    

                <label>Password</label>
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" placeholder="Enter your password">
                </div>

                <label>Select Role</label>
                <div class="input-group">
                    <i class="fa-regular fa-user"></i>
                   <select name="role" required>
    <option value="">Select your role</option>
    <option value="client">Client</option>
    <option value="project_manager">Project Manager</option>
    <option value="engineer">Engineer</option>
</select>
                </div>

                <div class="options">
                    <label><input type="checkbox"> Remember me</label>
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit">Login</button>

                <div class="or">
                    <span></span> or <span></span>
                </div>

                <div class="register">
                    Don't have an account? <a href="/register">Register</a>
                </div>

            </form>
        </div>
    </div>

</div>

</body>
</html>