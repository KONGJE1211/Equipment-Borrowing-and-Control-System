@extends('user.layouts.app')
@section('content')

<style>
    .history-container{
        max-width:1000px; 
        margin:auto; 
        background:white; 
        padding:25px; 
        border-radius:12px; 
        box-shadow:0 4px 15px rgba(0,0,0,0.08);
        border-left:6px solid #007bff;
    }
    .history-title{
        font-weight:bold; 
        font-size:24px; 
        margin-bottom:20px; 
        color:#0a2a43;
    }
    .history-table{
        width:100%; 
        border-collapse:collapse; 
        margin-top:10px;
    }
    .history-table th{
        background:#007bff;
        color:white;
        padding:12px;
        text-align:center;
        font-weight:600;
        font-size:15px;
    }
    .history-table td{
        padding:10px; 
        text-align:center; 
        font-size:14px; 
        border-bottom:1px solid #e5e9f2;
    }
    .row-active{ background:#eafff1; }
    .row-archived{ background:#f4f6fa; }

    .badge{
        padding:6px 10px; 
        border-radius:6px; 
        font-size:13px; 
        font-weight:bold; 
        color:white;
    }
    .badge-pending{ background:#ffc107; }
    .badge-approved{ background:#28a745; }
    .badge-rejected{ background:#dc3545; }
    .badge-returned{ background:#17a2b8; }
    .badge-active-type{ background:#007bff; }
    .badge-archived-type{ background:#6c757d; }
</style>

<div class="history-container">
    <h2 class="history-title"><i class="fas fa-history"></i> Your Booking History</h2>

    <table class="history-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Equipment</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Record Type</th>
            </tr>
        </thead>

        <tbody>
        @forelse($combined as $item)
            @php
                $statusClass = [
                    'pending' => 'badge-pending',
                    'approved' => 'badge-approved',
                    'rejected' => 'badge-rejected',
                    'returned' => 'badge-returned'
                ][$item['status']] ?? 'badge-pending';

                $rowClass = $item['is_history'] ? 'row-archived' : 'row-active';
                $typeBadge = $item['is_history'] ? 'badge-archived-type' : 'badge-active-type';
            @endphp
            
            <tr class="{{ $rowClass }}">
                <td>{{ $item['id'] }}</td>
                <td>{{ $item['equipment_name'] }}</td>
                <td>{{ $item['start_date'] }}</td>
                <td>{{ $item['end_date'] }}</td>
                <td><span class="badge {{ $statusClass }}">{{ ucfirst($item['status']) }}</span></td>
                <td><span class="badge {{ $typeBadge }}">{{ $item['is_history'] ? 'Archived' : 'Active' }}</span></td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="padding:15px; color:#777;">No records found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
