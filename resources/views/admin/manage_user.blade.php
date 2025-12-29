@extends('admin.layouts.app')
@section('content')

<style>
    .top-actions {
        display:flex;
        justify-content: space-between;
        align-items:center;
        margin-bottom:20px;
    }

    /* Search Bar */
    .search-box input {
        padding:8px 12px;
        width:240px;
        border:1px solid #ccc;
        border-radius:6px;
    }
    .btn-search {
        background:#28a745;
        color:white;
        padding:8px 12px;
        border:none;
        border-radius:6px;
        cursor:pointer;
        font-weight:600;
    }
    .btn-reset {
        color:#d62828;
        margin-left:12px;
        font-weight:bold;
        text-decoration:none;
    }

    /* Add Button */
    .btn-add {
        background:#007bff;
        color:white;
        padding:9px 14px;
        border:none;
        border-radius:6px;
        font-weight:bold;
        cursor:pointer;
    }

    /* Add Form Card Style */
    .card {
        background:white;
        padding:20px;
        border-radius:10px;
        box-shadow:0 3px 10px rgba(0,0,0,0.1);
        margin-bottom:25px;
    }
    .card h3 { margin-top:0; font-size:20px; color:#05355c; }

    .card input, .card textarea, .card select {
        width:100%;
        padding:8px;
        border:1px solid #ccc;
        border-radius:6px;
        margin-bottom:10px;
    }

    /* Table Style */
    table { width:100%; border-collapse:collapse; background:white; border-radius:10px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.08); }
    th, td { padding:12px; border-bottom:1px solid #e5e5e5; vertical-align: middle; text-align:center; }
    th { background:#f0f2f5; font-weight:600; font-size:14px; }

    /* Action Button */
    .btn-delete {
        background:#dc3545;
        border:none;
        padding:7px 12px;
        color:white;
        border-radius:6px;
        cursor:pointer;
        font-weight:600;
    }
    .btn-delete:hover { background:#a30e1b; }
</style>

<h2 style="margin-bottom:15px; color:#12263a;">👥 Manage Users</h2>

{{-- Success Message --}}
@if(session('success')) 
    <div style="color:green; margin-bottom:12px; font-weight:bold;">{{ session('success') }}</div> 
@endif

{{-- Search + Add --}}
<div class="top-actions">

    {{-- Add User Button --}}
    <button 
        onclick="document.getElementById('addUserForm').style.display='block'" 
        class="btn-add">
        + Add New User
    </button>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('admin.manageUser') }}" class="search-box">
        <input type="text" name="search" placeholder="Search user..." value="{{ request('search') }}">
        <button type="submit" class="btn-search">Search</button>

        @if(request('search'))
            <a href="{{ route('admin.manageUser') }}" class="btn-reset">Reset</a>
        @endif
    </form>

</div>

{{-- Add User Form --}}
<div id="addUserForm" class="card" style="display:none;">

    <h3>➕ Add User</h3>

    <form action="{{ route('admin.createUser') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label><strong>Name:</strong></label>
        <input type="text" name="name" required>

        <label><strong>Email:</strong></label>
        <input type="email" name="email" required>

        <label><strong>Password (min 8 chars):</strong></label>
        <input type="password" name="password" minlength="8" required>

        <label><strong>Student ID:</strong></label>
        <input type="text" name="student_id" required>

        <label><strong>Phone:</strong></label>
        <input type="text" name="phone" required>

        <label><strong>Batch:</strong></label>
        <input type="text" name="batch" required>

        <label><strong>Identity:</strong></label>
        <select name="identity" required>
            <option value="student">Student</option>
            <option value="lecturer">Lecturer</option>
        </select>

        <label><strong>ID Photo:</strong></label>
        <input type="file" name="id_photo" accept="image/*" required>

        <button type="submit" style="background:green;color:white;padding:10px 20px;border:none;border-radius:6px;font-weight:bold;cursor:pointer;">
            Create User
        </button>

        <button type="button" 
            onclick="document.getElementById('addUserForm').style.display='none'"
            style="margin-left:10px;background:red;color:white;padding:10px 20px;border:none;border-radius:6px;font-weight:bold;cursor:pointer;">
            Cancel
        </button>

    </form>
</div>

<h3 style="margin-bottom:10px; color:#05355c;">📌 User List</h3>

{{-- User Table --}}
<table>
  <thead>
      <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Student ID</th>
          <th>Phone</th>
          <th>Identity</th>
          <th style="text-align:center;">Actions</th>
      </tr>
  </thead>

  <tbody>
    @forelse($users as $u)
      <tr>
        <td>{{ $u->id }}</td>
        <td style="font-weight:600;">{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->student_id }}</td>
        <td>{{ $u->phone }}</td>
        <td style="text-transform:capitalize;">{{ $u->identity }}</td>

        <td>
            <form method="POST" action="{{ route('admin.deleteUser',$u->id) }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-delete" onclick="return confirm('Delete user?')">Delete</button>
            </form>
        </td>
      </tr>
    @empty
      <tr>
          <td colspan="7" style="text-align:center;color:red;font-weight:bold;">No user found.</td>
      </tr>
    @endforelse
  </tbody>
</table>

<br>

{{-- Pagination (📌 已加入 search 保留功能) --}}
<div style="margin-top:15px;">
    {{ $users->appends(['search' => request('search')])->links() }}
</div>

@endsection
