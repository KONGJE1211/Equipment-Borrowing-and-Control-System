@extends('user.layouts.app')
@section('content')

<style>
    .profile-container{
        max-width:900px; 
        margin:auto; 
        background:white; 
        padding:35px; 
        border-radius:18px; 
        box-shadow:0 5px 18px rgba(0,0,0,0.08);
        border-top:6px solid #007bff;
    }
    .profile-title{
        font-weight:bold; 
        margin-bottom:25px; 
        color:#0a2a43;
        font-size:26px;
    }
    .profile-row{
        display:flex; 
        gap:40px; 
        flex-wrap:wrap;
    }
    .profile-info-box{
        flex:1; 
        background:#f8fbff; 
        padding:20px; 
        border-radius:12px;
        border:1px solid #e2ecf5;
    }
    .profile-info-box p{
        margin-bottom:12px; 
        font-size:16px;
        color:#223b52;
    }
    .profile-info-box strong{
        width:130px; 
        display:inline-block; 
        color:#0a2a43;
    }
    .profile-image-box{
        flex:0.6; 
        text-align:center;
        background: #f3f6fa;
        padding:20px; 
        border-radius:12px;
        border:1px solid #dde5ee;
    }
    .profile-image-box img{
        width:200px; 
        border-radius:12px; 
        margin-top:15px; 
        border:2px solid #c8d6e4;
    }
    .profile-image-box p{
        color:#777;
    }
    .update-btn{
        background-color:#007bff; 
        color:white; 
        text-decoration:none; 
        padding:12px 25px; 
        border-radius:8px; 
        font-weight:600;
        font-size:15px;
        transition:0.3s;
    }
    .update-btn:hover{
        background-color:#0056b3;
    }
</style>

<div class="profile-container">

    <h2 class="profile-title">
        <i class="fas fa-id-card"></i> My Profile
    </h2>

    <div class="profile-row">

        {{-- Left Info --}}
        <div class="profile-info-box">
            <p><strong><i class="fas fa-user"></i> Name:</strong> {{ $user->name }}</p>
            <p><strong><i class="fas fa-envelope"></i> Email:</strong> {{ $user->email }}</p>
            <p><strong><i class="fas fa-id-badge"></i> Student ID:</strong> {{ $user->student_id }}</p>
            <p><strong><i class="fas fa-phone"></i> Phone:</strong> {{ $user->phone ?? '-' }}</p>
            <p><strong><i class="fas fa-users"></i> Batch:</strong> {{ $user->batch ?? '-' }}</p>
            <p><strong><i class="fas fa-user-tag"></i> Identity:</strong> {{ ucfirst($user->identity) }}</p>
        </div>

        {{-- Right Image --}}
        <div class="profile-image-box">
            <strong><i class="fas fa-image"></i> ID Photo:</strong><br>

            @if($user->id_photo)
                <img src="{{ asset('storage/'.$user->id_photo) }}">
            @else
                <p>No image uploaded.</p>
            @endif
        </div>

    </div>

    <div style="text-align:right; margin-top:30px;">
        <a href="{{ route('profile.edit') }}" class="update-btn">
            <i class="fas fa-edit"></i> Update Profile
        </a>
    </div>

</div>

@endsection
