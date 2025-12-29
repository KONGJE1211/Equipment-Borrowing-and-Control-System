<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Equipment Borrowing System</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <style>
    /* === Topbar Style === */
    .topbar {
      background: linear-gradient(90deg, #2563eb, #1e40af);
      color: white;
      padding: 14px 24px;
      font-family: Arial, sans-serif;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0px 3px 10px rgba(0,0,0,0.25);
    }

    .topbar-title {
      font-size: 20px;
      font-weight: bold;
      letter-spacing: 0.5px;
    }

    .nav-links {
      display:flex;
      align-items:center;
      gap:10px;
    }

    .nav-links > a, .dropdown-toggle {
      color: #e0e7ff;
      text-decoration: none;
      font-weight: 500;
      padding: 6px 8px;
      border-radius: 4px;
      cursor:pointer;
      transition:0.25s;
    }

    .nav-links > a:hover,
    .dropdown-toggle:hover {
      color: #fff;
      background: rgba(255,255,255,0.1);
    }

    /* === DROPDOWN MENU (CLICK SHOW) === */
    .dropdown-menu {
      display:none;
      position:absolute;
      background:white;
      top: 40px;
      min-width:160px;
      box-shadow:0 5px 14px rgba(0,0,0,0.2);
      border-radius:8px;
      overflow:hidden;
      z-index:1000;
    }
    .dropdown-menu a {
      display:block;
      padding:10px 14px;
      color:#153b75;
      font-weight:600;
      text-decoration:none;
      transition:0.2s;
    }
    .dropdown-menu a:hover { background:#e8f1ff; }

    .dropdown { position: relative; }

    /* === User Menu === */
    .user-menu span {
      margin-right: 8px;
      font-weight: bold;
      opacity: 0.9;
    }
    .user-menu a {
      background: #ef4444;
      padding: 6px 14px;
      border-radius: 6px;
      font-size: 13px;
      font-weight: bold;
      color: white !important;
      text-decoration: none;
      transition: 0.25s;
    }
    .user-menu a:hover { background: #dc2626; }

    /* Force pagination arrow size */
svg.w-5.h-5 {
    width: 16px !important;
    height: 16px !important;
}

  </style>
</head>
<body>

  <!-- === Top Bar === -->
  <div class="topbar">
    
    <div class="topbar-title">Equipment Borrowing & Control System</div>

    @if(session('user_id'))
      <div class="nav-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('equipment') }}">Equipment</a>
        <a href="{{ route('booking') }}">Booking</a>
        <a href="{{ route('profile.index') }}">Profile</a>
        <a href="{{ route('history') }}">History</a>

        <!-- Dropdown Report (Click) -->
        <div class="dropdown">
          <span class="dropdown-toggle" id="reportToggle">Report ▾</span>

          <div class="dropdown-menu" id="reportMenu">
            <a href="{{ route('user.reportLostForm') }}">Create Report</a>
            <a href="{{ route('user.myReports') }}">Report Status</a>
          </div>
        </div>
      </div>

      <div class="user-menu">
          <span>{{ session('user_name') ?? 'User' }}</span>
          <a href="{{ route('logout') }}">Logout</a>
      </div>

    @else
      <div class="nav-links">
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
      </div>
    @endif

  </div>

  <!-- PAGE CONTENT -->
  <div style="padding:20px;">
    @yield('content')
  </div>

  <!-- CLICK DROPDOWN SCRIPT -->
  <script>
    const toggle = document.getElementById("reportToggle");
    const menu = document.getElementById("reportMenu");

    toggle.addEventListener("click", function (e) {
      e.stopPropagation();
      menu.style.display = menu.style.display === "block" ? "none" : "block";
    });

    // close menu if click outside
    window.addEventListener("click", function () {
      if(menu.style.display === "block") menu.style.display = "none";
    });
  </script>

  @yield('scripts')

</body>
</html>
