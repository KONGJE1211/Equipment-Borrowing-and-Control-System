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
        text-align:center;
    }
    th, td {
        padding:12px;
        border-bottom:1px solid #eee;
        vertical-align:middle;
        text-align:center;
    }
    th {
        background:#f1f4f9;
        font-weight:600;
        color:#1b1b1b;
    }

    /* Status Badge */
    .badge {
        padding:6px 10px;
        border-radius:6px;
        font-size:13px;
        font-weight:600;
        text-transform:capitalize;
        display:inline-block;
    }
    .reviewed { background:#28a745; color:white; }
    .pending { background:#EEC94A; color:#7a5c00; }

    /* Reply Area */
    .reply-box textarea {
        width:100%;
        height:60px;
        padding:6px;
        border:1px solid #ccc;
        border-radius:6px;
        resize:vertical;
    }

    /* Button Style */
    .btn-reply {
        background:#007bff;
        color:white;
        padding:7px 13px;
        border:none;
        border-radius:6px;
        cursor:pointer;
        font-weight:600;
        margin-top:5px;
    }
    .btn-reply:hover { background:#0062cc; }
</style>

<h2>📢 Lost Equipment Reports</h2>

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
            <th>Description</th>
            <th>Admin Reply</th>
            <th>Status</th>
            <th>Reply</th>
        </tr>
    </thead>

    <tbody>
        @foreach($reports as $report)
        <tr>
            <td>{{ $report->id }}</td>
            <td style="font-weight:600;">{{ $report->user->name }}</td>
            <td>{{ $report->equipment->name }}</td>
            <td style="max-width:200px; text-align:left;">{{ $report->description }}</td>

            <td style="max-width:200px; text-align:left;">
                {{ $report->admin_reply ?? '—' }}
            </td>

            <td>
                <span class="badge {{ $report->status == 'reviewed' ? 'reviewed' : 'pending' }}">
                    {{ $report->status }}
                </span>
            </td>

            <td class="reply-box">
                <form method="POST" action="{{ route('admin.replyLostReport', $report->id) }}">
                    @csrf
                    <textarea name="admin_reply" required placeholder="Type reply..."></textarea>
                    <button type="submit" class="btn-reply">Send Reply</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>
{{ $reports->links() }}

@endsection
