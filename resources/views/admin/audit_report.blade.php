@extends('admin.layouts.app')

@section('content')

<div class="container mt-4">
    <h2 class="mb-4">Audit Report Generator</h2>

    <form action="{{ route('admin.audit.preview') }}" method="POST">
    @csrf

    <label><b>Select Report Type:</b></label>
    <select name="report_type" class="form-control" required>
        <option value="monthly">Monthly Report</option>
        <option value="annual">Annual Report</option>
    </select>

    <label class="mt-3"><b>Select Year:</b></label>
    <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>

    <label class="mt-3"><b>Select Month (if monthly):</b></label>
    <input type="number" name="month" class="form-control" min="1" max="12">

    <button type="submit" class="btn btn-primary mt-3">Preview Report</button>
</form>

</div>

@endsection
