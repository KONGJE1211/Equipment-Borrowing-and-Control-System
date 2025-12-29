@extends('user.layouts.app')

@section('content')

<style>
.details-container {
    max-width: 900px;
    margin: 0 auto;
    display: flex;
    gap: 25px;
}

.details-image {
    flex: 1;
}
.details-image img {
    width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}

.details-info {
    flex: 1;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.12);
}

.details-info h2 {
    color: #003366;
    margin-bottom: 15px;
}

.status-badge {
    padding: 8px 12px;
    border-radius: 6px;
    color: white;
    font-weight: bold;
}
.status-available { background: #28a745; }
.status-borrowed { background: #dc3545; }
.status-maintenance { background: #ffc107; }
.status-damaged { background: #6c757d; }

.borrow-btn {
    display: inline-block;
    background:#0066cc;
    padding: 10px 18px;
    color:white;
    border-radius:8px;
    margin-top:20px;
    text-decoration:none;
    font-size:16px;
}
.borrow-btn:hover {
    background:#004c99;
}
</style>

<h2 style="text-align:center; font-size:32px; color:#003366; margin-bottom:25px;">
    🔧 Equipment Details
</h2>

<div class="details-container">

    <div class="details-image">
        @if($equipment->image)
            <img src="{{ asset('storage/'.$equipment->image) }}">
        @else
            <img src="https://via.placeholder.com/400x300?text=No+Image">
        @endif
    </div>

    <div class="details-info">

        <h2>{{ $equipment->name }}</h2>

        <p><strong>ID:</strong> {{ $equipment->id }}</p>

        <p style="margin-top:10px;">
            <strong>Information:</strong><br>
            {{ $equipment->information }}
        </p>

        <p style="margin-top:10px;">
            <strong>Value:</strong> RM {{ number_format($equipment->value,2) }}
        </p>

        <p style="margin-top:10px;">
            <strong>Status:</strong>
            <span class="status-badge status-{{ strtolower($equipment->status) }}">
                {{ ucfirst($equipment->status) }}
            </span>
        </p>

        <a class="borrow-btn" href="{{ route('booking') }}?equipment_id={{ $equipment->id }}">
            Borrow This Equipment
        </a>
    </div>

</div>

@endsection
