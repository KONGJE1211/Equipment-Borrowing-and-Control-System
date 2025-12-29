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
.step-box {
    display: flex; gap: 20px; background: #f4f7fc; padding: 18px;
    border-radius: 10px; margin-bottom: 20px;
}
.step-box i { font-size: 32px; color: #05355c; }
</style>

<div class="page-box">
    <div class="page-title">Borrowing Process</div>

    <div class="step-box">
        <i class="fas fa-user-check"></i>
        <div><b>1. Login</b><br>Access your student or staff account.</div>
    </div>

    <div class="step-box">
        <i class="fas fa-box-open"></i>
        <div><b>2. Browse Equipment</b><br>Check availability and details.</div>
    </div>

    <div class="step-box">
        <i class="fas fa-calendar-plus"></i>
        <div><b>3. Submit Booking</b><br>Select date & submit for approval.</div>
    </div>

    <div class="step-box">
        <i class="fas fa-clipboard-check"></i>
        <div><b>4. Admin Approval</b><br>Admin reviews your booking.</div>
    </div>

    <div class="step-box">
        <i class="fas fa-hand-holding"></i>
        <div><b>5. Collect Equipment</b><br>Collect after approval.</div>
    </div>

    <div class="step-box">
        <i class="fas fa-undo"></i>
        <div><b>6. Return Equipment</b><br>Return on time to avoid penalty.</div>
    </div>
</div>

@endsection
