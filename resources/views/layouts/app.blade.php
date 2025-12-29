<!-- <!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Equipment Borrowing System</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <div style="background:#000;color:#fff;padding:12px;">
    <span style="font-weight:bold;">Equipment Borrowing and Control System</span>
    @if(session('user_id'))
      <span style="margin-left:20px;">
        <a href="{{ route('home') }}" style="color:#fff;margin-right:8px;">Home</a>
        <a href="{{ route('equipment') }}" style="color:#fff;margin-right:8px;">Equipment list</a>
        <a href="{{ route('booking') }}" style="color:#fff;margin-right:8px;">Booking</a>
        <a href="{{ route('profile') }}" style="color:#fff;margin-right:8px;">Profile</a>
        <a href="{{ route('history') }}" style="color:#fff;margin-right:8px;">History</a>
        <a href="{{ route('logout') }}" style="color:#fff;margin-right:8px;">Logout</a>
      </span>
    @else
      <span style="margin-left:20px;">
        <a href="{{ route('login') }}" style="color:#fff;margin-right:8px;">Login</a>
        <a href="{{ route('register') }}" style="color:#fff;margin-right:8px;">Register</a>
      </span>
    @endif
  </div>

  <div style="padding:20px;">
    @yield('content')
  </div>
</body>
</html>
 -->

 //SHIFT+ALT+A to ban all
