@extends('user.layouts.app')

@section('content')

<style>
.equipment-title {
    text-align: center;
    font-size: 30px;
    font-weight: bold;
    color: #003366;
    margin-bottom: 20px;
}

/* Search Bar */
.search-box {
    max-width: 500px;
    margin: 0 auto 25px auto;
    display: flex;
    gap: 10px;
}
.search-box input {
    flex: 1;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
.search-box button {
    padding: 10px 15px;
    background-color: #0066cc;
    border: none;
    color: white;
    border-radius: 8px;
    cursor: pointer;
}

/* Card Grid */
.equipment-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}

.equipment-card {
    background: #fff;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 6px 14px rgba(0,0,0,0.10);
    transition: 0.2s;
}
.equipment-card:hover {
    transform: translateY(-5px);
}

/* Image */
.equipment-card img {
    width: 100%;
    height: 170px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 12px;
}

/* Status Badge */
.badge {
    padding: 5px 10px;
    border-radius: 6px;
    color: #fff;
    font-size: 12px;
}
.badge.available { background: #28a745; }
.badge.borrowed { background: #dc3545; }
.badge.maintenance { background: #ffc107; }
.badge.damaged { background: #6c757d; }

/* Buttons */
.card-btn {
    display: inline-block;
    padding: 8px 10px;
    margin-top: 8px;
    background-color: #0066cc;
    color: white;
    border-radius: 8px;
    text-decoration: none;
}
.card-btn:hover {
    background-color: #004c99;
}

</style>


<h2 class="equipment-title">📦 Equipment List</h2>

<form method="GET" action="{{ route('equipment') }}" class="search-box">
    <input type="text" name="search" placeholder="Search equipment..." value="{{ request('search') }}">
    <button type="submit">Search</button>
</form>

<div class="equipment-grid">

    @forelse($equipments as $e)
    <div class="equipment-card">

        {{-- Image --}}
        @if($e->image)
            <img src="{{ asset('/'.$e->image) }}">
        @else
            <img src="https://via.placeholder.com/200x150?text=No+Image">
        @endif

        <h3 style="margin-bottom:5px; color:#003366;">{{ $e->name }}</h3>

        <p style="font-size:14px; color:#555;">
            {{ Str::limit($e->information, 80) }}
        </p>

        <p><strong>Value:</strong> RM {{ number_format($e->value,2) }}</p>

        <span class="badge {{ strtolower($e->status) }}">{{ ucfirst($e->status) }}</span>

        <div style="margin-top:10px;">
            <a class="card-btn" href="{{ route('equipment.show', $e->id) }}">Details</a>
            <a class="card-btn" href="{{ route('booking') }}?equipment_id={{ $e->id }}">Borrow</a>
        </div>
    </div>
    @empty
        <p>No equipment found.</p>
    @endforelse

</div>

<div style="margin-top:25px; text-align:center;">
    {{ $equipments->links() }}
</div>

@endsection
