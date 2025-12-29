@extends('user.layouts.app')

@section('content')

<div class="welcome-box">
    <h2>Welcome to the Equipment Borrowing & Control System 🎉</h2>
    <p style="font-size:15px;color:#334155;">
        This platform allows students and staff to easily borrow, manage, and return equipment securely within the university.
        It ensures a smooth borrowing process with transparent tracking and reporting features.
    </p>

    <div class="system-cards">
        <div class="feature-card">
            <h3>📌 Borrow Equipment</h3>
            <p>Request and borrow available items such as cameras, laptops, projectors, and more.</p>
        </div>

        <div class="feature-card">
            <h3>🔐 Secure Tracking</h3>
            <p>Track booking status, history, and return deadlines clearly and safely.</p>
        </div>

        <div class="feature-card">
            <h3>📢 Lost & Report</h3>
            <p>Report lost equipment and receive admin guidance quickly and efficiently.</p>
        </div>
    </div>
</div>

@endsection

<style>
    .welcome-box {
    background: white;
    padding: 25px;
    font-family: Arial, sans-serif;
    border-radius: 10px;
    margin: 25px auto;
    max-width: 850px;
    box-shadow: 0px 5px 15px rgba(0,0,0,0.15);
}

.system-cards {
    display: flex;
    gap: 20px;
    margin-top: 25px;
    justify-content: center;
}

.feature-card {
    width: 240px;
    padding: 20px;
    background: #f8fafc;
    border-radius: 12px;
    text-align: center;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    transition: 0.3s;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

.feature-card h3 {
    color: #1e40af;
    margin-bottom: 8px;
}

.feature-card p {
    color: #475569;
    font-size: 14px;
}

</style>