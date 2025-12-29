@extends('guest.layouts.app')

@section('content')

<style>
    .guest-container {
        max-width: 1000px;
        margin: auto;
        padding: 30px;
        text-align: center;
        font-family: Poppins, sans-serif;
    }

    .guest-title {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #05355c;
    }

    .guest-desc {
        font-size: 18px;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .guest-image {
        width: 100%;
        max-width: 680px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        margin-top: 20px;
        text-align: center;
    }
</style>

<div class="guest-container">
    <h1 class="guest-title">Welcome to Equipment Borrowing System</h1>

    <p class="guest-desc">
        This platform allows students and staff to borrow campus equipment  
        in a fast, organized and efficient way.  
        Please login to start using the system.
    </p>
    <div style="display: flex; justify-content: center;">
         <img src="{{ asset('images/guest_welcome.png') }}" class="guest-image">
    </div>
   

</div>

@endsection
