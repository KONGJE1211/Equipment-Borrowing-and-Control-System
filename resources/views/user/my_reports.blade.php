@extends('user.layouts.app')

@section('content')
<style>
.report-container {
    max-width: 1100px;
    margin: 0 auto;
}

.report-title {
    text-align: center;
    font-weight: bold;
    margin-bottom: 20px;
    font-size: 28px;
    color: #003366;
}

/* Card Styling */
.report-card {
    display: flex;
    align-items: center;
    background: #fff;
    margin-bottom: 15px;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.2s;
}

.report-card:hover {
    transform: scale(1.02);
}

/* Image */
.report-img {
    width: 100px;
    height: 100px;
    border-radius: 10px;
    border: 2px solid #555;
    object-fit: cover;
    margin-right: 15px;
}

/* Report Details */
.report-info {
    flex: 1;
    font-size: 14px;
}

/* Status Styling */
.status-badge {
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: bold;
    color: #fff;
}

.status-pending { background-color: #f0ad4e; }
.status-approved { background-color: #28a745; }
.status-rejected { background-color: #dc3545; }

/* Admin Reply Section */
.reply-box {
    margin-top: 8px;
    padding: 6px 8px;
    background: #f8f9fa;
    border-left: 4px solid #007bff;
    border-radius: 8px;
    font-style: italic;
    font-size: 13px;
}

.pagination{ margin-top:20px; justify-content:center; }
</style>

<h2 class="report-title">📋 My Lost Item Reports</h2>

<div class="report-container">

    @foreach($reports as $r)
    <div class="report-card">
        <img src="{{ asset('/'.$r->equipment->image) }}" class="report-img">

        <div class="report-info">
            <strong>🔧 Equipment:</strong> {{ $r->equipment->name }} <br>
            <strong>📝 Your Report:</strong> {{ $r->description }}<br>
            <strong>📅 Updated:</strong> {{ $r->updated_at->format('Y-m-d H:i') }}

            @if($r->admin_reply)
                <div class="reply-box">
                    💬 <strong>Admin Reply:</strong> {{ $r->admin_reply }}
                </div>
            @endif
        </div>

        <div>
            @php
                $status = $r->status;
                $class = ($status=='pending')?'status-pending':(($status=='approved')?'status-approved':'status-rejected');
            @endphp
            <span class="status-badge {{ $class }}">{{ ucfirst($status) }}</span>
        </div>
    </div>
    @endforeach

    <div style="text-align:center;">
        {{ $reports->links() }}
    </div>
</div>

@endsection
