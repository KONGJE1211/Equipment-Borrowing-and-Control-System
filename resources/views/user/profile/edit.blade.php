@extends('user.layouts.app')

@section('content')
<div style="max-width:850px; margin:auto; background:white; padding:25px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">

    <h2 style="font-weight:bold; margin-bottom:15px; color:#0a2a43;">
        <i class="fas fa-user-edit"></i> Update Profile
    </h2>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <label style="font-weight:600;">Name:</label>
        <input name="name" value="{{ old('name',$user->name) }}" 
               style="width:100%; padding:10px; margin-bottom:12px; border:1px solid #ccc; border-radius:6px;">

        <label style="font-weight:600;">Email:</label>
        <input name="email" value="{{ old('email',$user->email) }}" 
               style="width:100%; padding:10px; margin-bottom:12px; border:1px solid #ccc; border-radius:6px;">

        <label style="font-weight:600;">Student ID:</label>
        <input name="student_id" value="{{ old('student_id',$user->student_id) }}" 
               style="width:100%; padding:10px; margin-bottom:12px; border:1px solid #ccc; border-radius:6px;">

        <label style="font-weight:600;">Phone:</label>
        <input name="phone" value="{{ old('phone',$user->phone) }}" 
               style="width:100%; padding:10px; margin-bottom:12px; border:1px solid #ccc; border-radius:6px;">

        <label style="font-weight:600;">Batch:</label>
        <input name="batch" value="{{ old('batch',$user->batch) }}" 
               style="width:100%; padding:10px; margin-bottom:12px; border:1px solid #ccc; border-radius:6px;">

        <label style="font-weight:600;">Identity:</label>
        <input value="{{ $user->identity }}" readonly
               style="width:100%; padding:10px; background:#eee; margin-bottom:12px; border:1px solid #ccc; border-radius:6px;">

        <label style="font-weight:600;">ID Photo:</label><br>
        @if($user->id_photo)
            <img src="{{ asset('storage/'.$user->id_photo) }}" style="width:150px;margin-bottom:10px;border-radius:10px;border:1px solid #ccc;">
        @endif
        <input type="file" name="id_photo" style="margin-bottom:15px;">

        <div style="text-align:right;">
            <button type="submit" 
                style="background-color:#007bff; color:white; padding:10px 20px; border:none; border-radius:6px; font-weight:bold;">
                Save Changes
            </button>
        </div>
    </form>

    @if($errors->any())
        <div style="margin-top:15px; padding:12px; background:#ffe0e0; color:#a30000; border-radius:8px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>
@endsection
