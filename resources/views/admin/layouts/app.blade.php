<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Panel</title>

<style>
    body {
        margin: 0;
        font-family: "Segoe UI", Arial, sans-serif;
        background:#f6f7fb;
    }

    /* --- TOPBAR --- */
    .topbar {
        background: linear-gradient(90deg, #000000, #1a1a1a);
        padding: 12px 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .topbar-left {
        font-size: 20px;
        font-weight: bold;
        color: #fff;
        letter-spacing: .5px;
    }

    .topbar-links a {
        color: #ddd;
        margin: 0 12px;
        text-decoration: none;
        font-size: 15px;
        padding: 6px 10px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .topbar-links a:hover {
        background: #007bff;
        color:#fff;
        transform: translateY(-2px);
    }

    .logout-link {
        background:#ff4d4d;
        padding: 7px 12px;
        border-radius: 6px;
        font-weight: bold;
        color: #fff !important;
    }
    .logout-link:hover {
        background:#cc0000;
    }

    /* --- CONTAINER --- */
    .container {
        padding: 25px 30px;
    }

    /* --- TABLE STYLE --- */
    table { width: 100%; border-collapse: collapse; }
    th, td {
        padding: 10px;
        border-bottom: 1px solid #ccc;
        background: #fff;
    }
    th {
        background:#e8eaf0;
        font-weight:bold;
    }

    /* --- PAGINATION FULL CENTER FIX --- */
nav[role="navigation"] {
    width: 100%;
    display: flex !important;
    flex-direction: column;         /* 让页码和描述垂直堆叠 */
    justify-content: center !important;
    align-items: center !important; /* 居中所有内容 */
    gap: 10px;                      /* 页码与“Showing x to x”之间距离 */
    margin-top: 20px;
}

/* 页码按钮区域本身居中 */
nav[role="navigation"] > div:first-child {
    display: flex !important;
    justify-content: center !important;
    width: 100%;
}

/* “Showing 1–10 of 105 results” 也居中 */
nav[role="navigation"] > p {
    text-align: center;
    width: 100%;
    margin: 0;
}



    svg.w-5.h-5 {
        width: 16px !important;
        height: 16px !important;
    }

</style>
</head>

<body>

<div class="topbar">
    <div class="topbar-left">Admin Panel</div>

    @if(session('admin_logged_in'))
    <div class="topbar-links">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.manageEquipment') }}">Manage Equipment</a>
        <a href="{{ route('admin.manageUser') }}">Manage Users</a>
        <a href="{{ route('admin.bookingList') }}">Booking List</a>
        <a href="{{ route('admin.lostReports') }}">Lost Reports</a>
        <a href="{{ route('admin.audit.report') }}">Audit Reports</a>
        <a href="{{ route('admin.logout') }}" class="logout-link">Logout</a>
    </div>
    @endif
</div>

<div class="container">
    @yield('content')
</div>

</body>
</html>
