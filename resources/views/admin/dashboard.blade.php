@extends('admin.layouts.app')

@section('content')

<style>
    .dashboard-container {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .dashboard-title {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px; 
        color: #333;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        grid-gap: 20px;
    }

    .stat-card {
        padding: 25px;
        border-radius: 14px;
        color: white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        text-align: center;
        transition: 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.25);
    }

    .stat-title {
        font-size: 18px;
        margin-bottom: 12px;
        opacity: 0.9;
    }

    .stat-value {
        font-size: 32px;
        font-weight: bold;
    }

    /* 卡片颜色系列 */
    .card-blue { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .card-green { background: linear-gradient(135deg, #10b981, #059669); }
    .card-orange { background: linear-gradient(135deg, #fb923c, #f97316); }
    .card-red { background: linear-gradient(135deg, #ef4444, #dc2626); }
</style>

<div class="dashboard-container">

    <div class="dashboard-title">Admin Dashboard</div>

    <div class="stats-grid">

        <div class="stat-card card-blue">
            <div class="stat-title">Total Equipment</div>
            <div class="stat-value">{{ $equipmentCount }}</div>
        </div>

        <div class="stat-card card-green">
            <div class="stat-title">Total Users</div>
            <div class="stat-value">{{ $userCount }}</div>
        </div>

        <div class="stat-card card-orange">
            <div class="stat-title">Total Bookings</div>
            <div class="stat-value">{{ $bookingCount }}</div>
        </div>

        <div class="stat-card card-red">
            <div class="stat-title">Total Lost Reports</div>
            <div class="stat-value">{{ $reportCount }}</div>
        </div>

    </div>

</div>

@endsection
