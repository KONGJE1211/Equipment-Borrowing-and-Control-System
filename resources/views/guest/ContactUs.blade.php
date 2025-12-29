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
.contact-box {
    background: #f4f7fc; padding: 20px; border-radius: 12px; margin-bottom: 15px;
}
.contact-box i { font-size: 22px; margin-right: 10px; color: #05355c; }
</style>

<div class="page-box">
    <div class="page-title">Contact Us</div>

    <div class="contact-box">
        <i class="fas fa-phone"></i>
        <b>Phone:</b> +6012-3456789
    </div>

    <div class="contact-box">
        <i class="fas fa-envelope"></i>
        <b>Email:</b> support@equipment-system.com
    </div>

    <div class="contact-box">
        <i class="fas fa-map-marker-alt"></i>
        <b>Location:</b> Southern University College, Skudai, Johor
    </div>

    <div class="contact-box">
        <i class="fas fa-clock"></i>
        <b>Business Hours:</b> Monday – Friday | 9 AM – 5 PM
    </div>
</div>

@endsection
