@extends('admin.layouts.app')
@section('content')

<style>
    h2 {
        margin-bottom:15px;
        color:#06283D;
    }

    /* Table Style */
    table {
        width:100%;
        border-collapse:collapse;
        background:white;
        border-radius:10px;
        overflow:hidden;
        box-shadow:0 2px 8px rgba(0,0,0,0.12);
    }
    th, td {
        padding:12px;
        border-bottom:1px solid #eee;
        text-align:center;
        vertical-align:middle;
    }
    th {
        background:#f1f4f9;
        font-weight:600;
        color:#1b1b1b;
    }

    /* Status Badge */
    .badge {
        padding:5px 10px;
        border-radius:6px;
        font-size:13px;
        font-weight:600;
        text-transform:capitalize;
        display:inline-block;
    }
    .pending { background:#FFE15D; color:#725200; }
    .approved { background:#56C596; color:#00351a;}
    .returned { background:#A0A0A0; color:#fff; }
    .rejected { background:#D62828; color:white; }

    /* Buttons */
    .action-btn {
        padding:7px 13px;
        border:none;
        border-radius:6px;
        cursor:pointer;
        color:white;
        font-size:13px;
        font-weight:600;
    }
    .approve { background:#28a745; }
    .approve:hover { background:#218838; }

    .reject { background:#dc3545; }
    .reject:hover { background:#b02a37; }

    .return { background:#007bff; }
    .return:hover { background:#0062cc; }
</style>

<h2>📋 Booking List</h2>

@if(session('success')) 
    <div style="color:green; font-weight:bold; margin-bottom:10px;">
        {{ session('success') }}
    </div> 
@endif

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>User</th>
      <th>Equipment</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>

  <tbody>
    @foreach($bookings as $b)
      <tr>
        <td>{{ $b->id }}</td>
        <td style="font-weight:600;">{{ $b->user->name ?? '-' }}</td>
        <td>{{ $b->equipment->name ?? '-' }}</td>
        <td>{{ $b->start_date }}</td>
        <td>{{ $b->end_date }}</td>

        <td>
          <span class="badge 
            {{ $b->status=='pending' ? 'pending' : '' }}
            {{ $b->status=='approved' ? 'approved' : '' }}
            {{ $b->status=='returned' ? 'returned' : '' }}
            {{ $b->status=='rejected' ? 'rejected' : '' }}">
            {{ $b->status }}
          </span>
        </td>

        <td>
            {{-- Center actions --}}
            <div style="display:flex; justify-content:center; gap:6px;">

                @if($b->status=='pending')
                    <form method="POST" action="{{ route('admin.approveBooking',$b->id) }}">
                        @csrf
                        <button type="submit" class="action-btn approve">Approve</button>
                    </form>

                    <form method="POST" action="{{ route('admin.rejectBooking',$b->id) }}">
                        @csrf
                        <button type="submit" class="action-btn reject">Reject</button>
                    </form>

                @elseif($b->status=='approved')
                    <form method="POST" action="{{ route('admin.markReturned',$b->id) }}">
                        @csrf
                        <button type="submit" class="action-btn return">Mark Returned</button>
                    </form>
                @else
                    <span style="color:#777;">-</span>
                @endif
            </div>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<br>
{{ $bookings->links() }}

@endsection
