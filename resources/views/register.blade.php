<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSMS Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial,sans-serif;
        }

        body{
            background:#f3f4f6;
            min-height:100vh;
        }

        .container{
            display:flex;
            min-height:100vh;
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
            inset:0;
            background:rgba(3,25,70,0.65);
        }

        .content{
            position:relative;
            z-index:2;
        }

        .logo{
            display:flex;
            gap:12px;
            align-items:center;
        }

        .logo i{
            font-size:38px;
            color:#ff9800;
        }

        .hero{
            margin-top:120px;
        }

        .hero h1{
            font-size:52px;
            line-height:1.2;
        }

        .hero span{
            color:#ff9800;
        }

        .hero p{
            margin-top:20px;
            width:420px;
            line-height:1.7;
        }

        .right{
            width:50%;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .box{
            width:460px;
            background:white;
            padding:35px;
            border-radius:16px;
            box-shadow:0 10px 30px rgba(0,0,0,0.1);
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

        h2{
            text-align:center;
            margin-top:15px;
            color:#08285f;
        }

        .sub{
            text-align:center;
            color:#777;
            margin-bottom:25px;
        }

        label{
            font-weight:600;
            font-size:14px;
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

        input, select{
            border:none;
            outline:none;
            width:100%;
            font-size:14px;
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

        .login-link{
            text-align:center;
            margin-top:20px;
        }

        .login-link a{
            color:#1d4ed8;
            text-decoration:none;
            font-weight:bold;
        }

        .error{
            color:red;
            text-align:center;
            margin-bottom:15px;
        }
    </style>
</head>
<body>

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
                <h1>Join Us.<br><span>Start Building.</span></h1>
                <p>Create your account to manage construction projects efficiently.</p>
            </div>
        </div>
    </div>

    <div class="right">
        <div class="box">

            <div class="circle">
                <i class="fa-solid fa-user-plus"></i>
            </div>

            <h2>Create Account</h2>
            <p class="sub">Register your account</p>

            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <label>Full Name</label>
                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="name" required>
                </div>

                <label>Email</label>
                <div class="input-group">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" required>
                </div>

                <label>Password</label>
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" required>
                </div>

                <label>Confirm Password</label>
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password_confirmation" required>
                </div>

                <label>Select Role</label>
                <div class="input-group">
                    <i class="fa-solid fa-user-tag"></i>
                    <select name="role" required>
                        <option value="">Select role</option>
                        <option value="client">Client</option>
                        <option value="project_manager">Project Manager</option>
                        <option value="engineer">Engineer</option>
                    </select>
                </div>

                <button type="submit">Register</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="/login">Login</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>