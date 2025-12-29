@extends('guest.layouts.app')

@section('content')

<style>
.page-box {
    max-width: 1100px; margin: auto; background: white; padding: 40px;
    border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    font-family: Poppins, sans-serif;
}
.page-title {
    font-size: 28px; font-weight: bold; color: #05355c; text-align: center; margin-bottom: 30px;
}
.feature-card {
    background: #f4f7fc; padding: 20px; border-radius: 12px; margin-bottom: 20px;
}
.feature-card i { font-size: 28px; color: #05355c; margin-bottom: 10px; }
</style>

<div class="page-box">
    <div class="page-title">System Features</div>

    <div class="feature-card">
        <i class="fas fa-shield-alt"></i>
        <b>Secure User Verification</b>
        <p>All users go through a verification process to maintain transparency and accountability.</p>
    </div>

    <div class="feature-card">
        <i class="fas fa-check-circle"></i>
        <b>Real-Time Equipment Availability</b>
        <p>Check which equipment is available or borrowed.</p>
    </div>

    <div class="feature-card">
        <i class="fas fa-calendar-check"></i>
        <b>Smart Borrowing Scheduler</b>
        <p>Borrowers can plan equipment usage more effectively with an intelligent borrowing timeline.</p>
    </div>

    <div class="feature-card">
        <i class="fas fa-history"></i>
        <b>Borrowing History</b>
        <p>View all past and current borrowings.</p>
    </div>

    <div class="feature-card">
        <i class="fas fa-tools"></i>
        <b>Lost & Damage Report</b>
        <p>Submit reports directly through the system.</p>
    </div>
</div>

@endsection
