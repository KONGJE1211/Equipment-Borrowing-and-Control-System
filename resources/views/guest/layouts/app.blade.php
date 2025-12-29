<!DOCTYPE html>
<html>
<head>
    <title>Guest - Equipment Borrowing System</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <style>
        /* Prevent horizontal scrolling */
        html, body {
            margin: 0;
            padding: 0;
            overflow-x: hidden; /* Disable horizontal scroll */
            width: 100%;
            background: #f3f6fa;
            font-family: Poppins, sans-serif;
        }

        /* ===== TOP BAR ===== */
        .guest-topbar {
            width: 100%;
            max-width: 1400px;         /* Prevent extra wide layout */
            margin: 0 auto;            /* Center the whole topbar */
            background: #05355c;
            padding: 15px 40px;
            box-sizing: border-box;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
        }

        .guest-topbar .logo-text {
            font-size: 22px;
            font-weight: bold;
            white-space: nowrap;
        }

        .guest-topbar .menu {
            display: flex;
            gap: 25px;
            flex-wrap: nowrap;
        }

        .guest-topbar .menu a {
            color: white;
            font-size: 14px;
            text-decoration: none;
            font-weight: 500;
            white-space: nowrap;
        }

        .guest-topbar .menu a:hover {
            text-decoration: underline;
        }

        .login-icon {
            width: 50px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-icon:hover {
            transform: scale(1.1);
        }

        /* ===== PAGE CONTENT AREA ===== */
        .guest-container {
            width: 100%;
            max-width: 1400px;      /* Same width as topbar */
            margin: 0 auto;
            padding: 20px 40px;
            box-sizing: border-box;
        }

        /* Ensure images never overflow */
        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .login-icon {
    font-size: 30px;       /* icon size */
    color: white;          /* white to match your top bar */
    transition: 0.3s;
}

.login-icon:hover {
    transform: scale(1.1);
    color: #cce6ff;        /* optional light-blue hover */
    cursor: pointer;
}

    </style>
</head>
<body>

    {{-- TOP BAR --}}
    <div class="guest-topbar">
        <div class="logo-text">Equipment Borrowing System</div>

        <div class="menu">
            <a href="{{ route('guest.guest') }}">Home</a>
            <a href="{{ route('guest.borrowing_process') }}">Borrowing Process</a>
            <a href="{{ route('guest.system_features') }}">System Features</a>
            <a href="{{ route('guest.contact_us') }}">Contact Us</a>
        </div>

        <!-- <a href="{{ route('login') }}">
            <i class="fas fa-user-circle"></i>
            <img src="{{ asset('images/login_icon.png') }}" class="login-icon" alt="Login"> -->
        <!-- </a>  -->

        <a href="{{ route('login') }}" class="login-icon-wrapper">
        <i class="fas fa-user-circle login-icon"></i></a>

    </div>

    {{-- PAGE CONTENT --}}
    <div class="guest-container">
        @yield('content')
    </div>

</body>
</html>
