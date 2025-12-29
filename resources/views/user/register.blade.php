<!DOCTYPE html>
<html>
<head>
    <title>User Register</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: white;
            color: black;
            font-family: Arial, sans-serif;
        }

        .register-card {
            width: 450px;
            margin: 40px auto;
            background: #d7d0cf;
            padding: 35px 40px;
            border-radius: 25px;
            text-align: center;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
        }

        .subtitle {
            margin-top: -5px;
            font-size: 14px;
            color: #333;
        }

        .row {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .row input,
        .row select {
            width: 100%;
        }

        input, select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            width: 100%;
            font-size: 14px;
        }

        .upload-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .upload-btn {
            background: #a8a4a3;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
        }

        .register-btn {
            background-color: #2b89e7;
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 18px;
            margin-top: 25px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="register-card">

    <div class="title">Registration</div>
    <div class="subtitle">Sign Up To Continue</div>

    @if(session('success'))
        <p style="color:green; font-weight:bold; margin-bottom:10px;">
        {{ session('success') }}
    </p>

    <script>
        setTimeout(function(){
            window.location.href = "/login"; // 2 秒后跳转登录页面
        }, 2000);
    </script>
    @endif

    @if($errors->any())
        <div style="color:red; margin-top:10px;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="/register" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="row">
            <input type="text" name="student_id" placeholder="ID" required>
            <input type="text" name="phone" placeholder="Phone number" required>
        </div>

        <div class="row">
            <input type="text" name="batch" placeholder="Batch" required>
            <select name="identity" required>
                <option value="">Identity</option>
                <option value="student">Student</option>
                <!-- <option value="lecturer">Lecturer</option> -->
            </select>
        </div>

        <div class="row upload-box">
            <input type="password" name="password" placeholder="Password" minlength="8" required>

            <label class="upload-btn">
                Upload
                <input type="file" name="id_photo" accept="image/*" style="display:none;" required>
            </label>

            <span>ID Image</span>
        </div>

        <button type="submit" class="register-btn">Register</button>
    </form>

</div>

</body>
</html>
