<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>

  <style>
    body {
        background: #f4f4f4;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-container {
        background: white;
        width: 350px;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0px 0px 12px rgba(0,0,0,0.15);
        text-align: center;
    }

    .login-container h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .login-container input {
        width: 90%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
    }

    .login-container button {
        width: 100%;
        padding: 10px;
        background: #007BFF;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
    }

    .login-container button:hover {
        background: #0056d2;
    }

    .error-msg {
        color: red;
        margin-bottom: 10px;
        font-size: 14px;
    }
  </style>

</head>
<body>

<div class="login-container">

    <h2>Admin Login</h2>

    @if(session('error'))
      <div class="error-msg">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
      @csrf

      <input type="text" name="username" placeholder="Username" required>

      <input type="password" name="password" placeholder="Password" required>

      <button type="submit">Login</button>

    </form>
</div>

</body>
</html>
