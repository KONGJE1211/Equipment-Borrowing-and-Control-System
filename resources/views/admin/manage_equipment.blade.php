@extends('admin.layouts.app')
@section('content')

<style>
    /* 🔍 SEARCH + BUTTON WRAPPER */
    .top-actions {
        display:flex;
        justify-content: space-between;
        align-items:center;
        margin-bottom:20px;
    }

    /* 🔍 SEARCH BAR */
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

    /* ➕ ADD BUTTON */
    .btn-add {
        background:#007bff;
        color:white;
        padding:9px 14px;
        border:none;
        border-radius:6px;
        font-weight:bold;
        cursor:pointer;
    }

    /* 📦 ADD CARD STYLE */
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

    /* 📋 TABLE STYLE */
    table { 
      width:100%; 
      border-collapse:collapse; 
      background:white; 
      border-radius:10px; 
      overflow:hidden; 
      box-shadow:0 2px 8px rgba(0,0,0,0.08);
      text-align:center; 
    }
    
    th, td { 
      padding:12px; 
      border-bottom:1px solid #e5e5e5; 
      vertical-align: middle;
      text-align:center;
    }
    
    th { 
        background:#f0f2f5; 
        font-weight:600; 
        font-size:14px;
    }

    /* 🏷️ STATUS COLORS */
    .status {
        padding:4px 10px;
        border-radius:6px;
        font-size:13px;
        font-weight:600;
        color:white;
        text-transform:capitalize;
    }
    .available { background:#28a745; }
    .borrowed { background:#007bff; }
    .damaged { background:#d62828; }
    .maintenance { background:#ff9f1c; }

    td img {
        display:block; 
        margin:auto; 
        border-radius:6px; 
        border:1px solid #ddd;
    }

    /* 🛠️ ACTION BUTTONS */
    .btn-update {
        background:#17a2b8;
        border:none;
        padding:6px 10px;
        color:white;
        border-radius:6px;
        cursor:pointer;
        font-weight:600;
        text-decoration:none;
        display:inline-block;
    }
    .btn-delete {
        background:#dc3545;
        border:none;
        padding:6px 10px;
        color:white;
        border-radius:6px;
        cursor:pointer;
        font-weight:600;
        display:inline-block;
        margin-top:6px;
    }
</style>

<h2 style="margin-bottom:15px; color:#12263a;">📚 Manage Equipment</h2>

@if(session('success')) 
    <div style="color:green; margin-bottom:10px; font-weight:bold;">
        {{ session('success') }}
    </div> 
@endif

{{-- 🔍 Search + ➕ Add --}}
<div class="top-actions">

    <button onclick="document.getElementById('addEquipmentForm').style.display='block'" 
        class="btn-add">
        + Add New Equipment
    </button>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('admin.manageEquipment') }}" class="search-box">
        <input type="text" name="search" placeholder="Search equipment..." 
               value="{{ request('search') }}">
        <button type="submit" class="btn-search">Search</button>

        @if(request('search'))
            <a href="{{ route('admin.manageEquipment') }}" class="btn-reset">Reset</a>
        @endif
    </form>

</div>

{{-- Add Equipment (Hidden) --}}
<div id="addEquipmentForm" 
     style="display:none;background:#f8f8f8;padding:20px;border-radius:10px;margin-bottom:25px;border:1px solid #ccc;">

    <h3>Add Equipment</h3>

    <form method="POST" action="{{ route('admin.addEquipment') }}" enctype="multipart/form-data">
        @csrf

        <p><label>Name:</label>
        <input type="text" name="name" required></p>

        <p><label>Information:</label>
        <textarea name="information" required style="height:80px;"></textarea></p>

        <p><label>Value (RM):</label>
        <input type="number" step="0.01" name="value" required></p>

        <p><label>Expired Date:</label>
        <input type="date" name="expired_date" required></p>

        <p><label>Image:</label>
        <input type="file" name="image" accept="image/*" required></p>

        <button type="submit" 
            style="background:green;color:white;padding:8px 20px;border:none;border-radius:5px;cursor:pointer;">
            Save Equipment
        </button>

        <button type="button" 
            onclick="document.getElementById('addEquipmentForm').style.display='none'"
            style="margin-left:10px;background:red;color:white;padding:8px 20px;border:none;border-radius:5px;cursor:pointer;">
            Cancel
        </button>
    </form>
</div>

{{-- 📋 Equipment List --}}
<h3 style="margin-bottom:10px; color:#05355c;">📌 Equipment List</h3>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Information</th>
            <th>Value (RM)</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($equipments as $eq)
        <tr>
            <td>{{ ($equipments->currentPage()-1) * $equipments->perPage() + $loop->iteration }}</td>

            <td>{{ $eq->id }}</td>

            <td>
                @if($eq->image)
                    <img src="{{ asset('/'.$eq->image) }}" width="70">
                @endif
            </td>


            <td style="font-weight:600;">{{ $eq->name }}</td>

            <td>{{ $eq->information }}</td>

            <td><strong>RM {{ number_format($eq->value,2) }}</strong></td>

            <td><span class="status {{ $eq->status }}">{{ $eq->status }}</span></td>

            <td>
                <a href="{{ route('admin.editEquipment', $eq->id) }}" class="btn-update">Edit</a>

                <form method="POST" action="{{ route('admin.deleteEquipment',$eq->id) }}" 
                      style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-delete"
                            onclick="return confirm('Delete equipment?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="color:red;font-weight:bold;">No equipment found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<br>

{{-- Pagination --}}
{{ $equipments->appends(['search' => request('search')])->links() }}

@endsection
