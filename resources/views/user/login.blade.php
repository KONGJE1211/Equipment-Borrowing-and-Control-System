<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <meta charset="utf-8">
    <style>
        body {
            background-color: white;
            color: black;
            font-family: Arial, sans-serif;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            padding-top: 60px;
        }

        .card {
            width: 450px;
            background: #d7d0cf;
            padding: 34px 36px;
            border-radius: 20px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            text-align: center;
        }

        .title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: 13px;
            color: #333;
            margin-bottom: 18px;
        }

        .form-row {
            display: flex;
            gap: 14px;
            margin-bottom: 12px;
        }

        .form-row.single {
            display:block;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 11px;
            border-radius: 8px;
            border: 1px solid #cfcfcf;
            font-size: 14px;
            box-sizing: border-box;
        }

        .login-btn {
            margin-top: 18px;
            width: 100%;
            padding: 12px;
            background-color: #2b89e7;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }
        .login-btn:hover { background-color:#206fd0; }

        .msg {
            margin: 12px 0;
            font-size: 14px;
        }
        .msg.error { color: #b00020; }
        .msg.success { color: #0b7a3d; }

        .small-link {
            margin-top: 10px;
            font-size: 14px;
        }
        .small-link a { color: #0a66c2; text-decoration:none; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        <div class="title">Welcome Back</div>
        <div class="subtitle">Please sign in to continue</div>

        @if(session('error'))
            <div class="msg error">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="msg success">{{ session('success') }}</div>
        @endif

        <form action="{{ url('/login') }}" method="POST" style="margin-top:8px;">
            @csrf

            <div class="form-row single">
                <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
            </div>

            <div class="form-row single">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>

        <div class="small-link">
            Don't have an account? <a href="{{ url('/register') }}">Register here</a>
        </div>
    </div>
</div>
</body>
</html>
