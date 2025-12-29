@extends('user.layouts.app')
@section('content')

<style>
    .table-card{
        max-width:900px;margin:auto;background:#fff;padding:20px;border-radius:12px;
        box-shadow:0 4px 12px rgba(0,0,0,0.1);font-family:Poppins,sans-serif;
    }
    table{width:100%;border-collapse:collapse;}
    th,td{padding:12px;text-align:center;border-bottom:1px solid #ddd;}
    th{background:#007bff;color:#fff;}
</style>

<div class="table-card">
<h2 style="margin-bottom:15px">📦 Your Current Bookings</h2>

@if(session('success')) <div style="color:green">{{ session('success') }}</div> @endif
@if(session('error')) <div style="color:red">{{ session('error') }}</div> @endif

<table>
  <thead>
    <tr><th>No</th><th>Equipment</th><th>Start</th><th>End</th><th>Status</th></tr>
  </thead>
  <tbody>
    @forelse($bookings as $b)
      <tr>
        <td>{{ $b->id }}</td>
        <td>{{ $b->equipment ? $b->equipment->name : 'Deleted' }}</td>
        <td>{{ $b->start_date }}</td>
        <td>{{ $b->end_date }}</td>
        <td><b>{{ ucfirst($b->status) }}</b></td>
      </tr>
    @empty
      <tr><td colspan="5">No bookings found.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $bookings->links() }}
</div>
@endsection
