@extends('admin.layouts.app')

@section('content')

<style>
.preview-box {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}
.section-title {
    font-weight: bold;
    font-size: 20px;
    margin-top: 30px;
    color: #05355c;
}
.table { width:100%; border-collapse:collapse; margin-top:10px; }
.table th, .table td { border:1px solid #e6e6e6; padding:10px; vertical-align:middle; }
.table thead th { background:#f8f9fb; font-weight:600; }
.input-center {
    display:block;
    margin:0 auto;
    text-align:center;
    width:100%;
    box-sizing:border-box;
    padding:6px 8px;
    border:1px solid #ccc;
    border-radius:6px;
}
.parent-row { background:#f5f8fb; }
</style>

<div class="preview-box">

    <h2 class="text-center">Audit Report Preview</h2>
    <p class="text-center text-muted">Report Type: <b>{{ ucfirst($report_type) }}</b></p>

    <hr>

    <!-- ====== Export FORM 包含 checklist inputs ====== -->
    <form action="{{ route('admin.audit.export') }}" method="POST">
        @csrf

        <input type="hidden" name="report_type" value="{{ $report_type }}">
        <input type="hidden" name="year" value="{{ $year }}">
        <input type="hidden" name="month" value="{{ $month }}">

        <!-- ===================== Maintenance Checklist (NEW) ===================== -->
        <h3 class="section-title">Maintenance Checklist</h3>

        <table class="table">
            <thead>
                <tr>
                    <th style="width:60px;text-align:center;">No</th>
                    <th>Maintenance Checklist / Asset No.</th>
                    <th style="width:240px;text-align:center;">Result <br>(Enter PASS/FAIL or YES/NO)</th>
                </tr>
            </thead>

            <tbody>
                <!-- Physical Check -->
                <tr class="parent-row">
                    <td class="text-center"><strong>1</strong></td>
                    <td colspan="2"><strong>Physical Check</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td>1.1 Cleaning</td>
                    <td style="text-align:center;">
                        <input type="text" name="checklist[1.1]" class="input-center" placeholder="PASS / FAIL" value="{{ old('checklist.1.1', ($checklistResponses['1.1'] ?? '')) }}">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>1.2 Damage Check</td>
                    <td style="text-align:center;">
                        <input type="text" name="checklist[1.2]" class="input-center" placeholder="PASS / FAIL" value="{{ old('checklist.1.2', ($checklistResponses['1.2'] ?? '')) }}">
                    </td>
                </tr>

                <!-- Functional Test -->
                <tr class="parent-row">
                    <td class="text-center"><strong>2</strong></td>
                    <td colspan="2"><strong>Functional Test</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td>2.1 Power On Test</td>
                    <td style="text-align:center;">
                        <input type="text" name="checklist[2.1]" class="input-center" placeholder="YES / NO" value="{{ old('checklist.2.1', ($checklistResponses['2.1'] ?? '')) }}">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>2.2 Basic Operation Test</td>
                    <td style="text-align:center;">
                        <input type="text" name="checklist[2.2]" class="input-center" placeholder="YES / NO" value="{{ old('checklist.2.2', ($checklistResponses['2.2'] ?? '')) }}">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>2.3 Full Functionality Test</td>
                    <td style="text-align:center;">
                        <input type="text" name="checklist[2.3]" class="input-center" placeholder="YES / NO" value="{{ old('checklist.2.3', ($checklistResponses['2.3'] ?? '')) }}">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>2.4 Accessories Test</td>
                    <td style="text-align:center;">
                        <input type="text" name="checklist[2.4]" class="input-center" placeholder="YES / NO" value="{{ old('checklist.2.4', ($checklistResponses['2.4'] ?? '')) }}">
                    </td>
                </tr>

                <!-- Additional Task -->
                <tr class="parent-row">
                    <td class="text-center"><strong>3</strong></td>
                    <td colspan="2"><strong>Additional Task</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td>3.1 Required Repair</td>
                    <td style="text-align:center;">
                        <input type="text" name="checklist[3.1]" class="input-center" placeholder="YES / NO" value="{{ old('checklist.3.1', ($checklistResponses['3.1'] ?? '')) }}">
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- ===================== END Maintenance Checklist ===================== -->

        <!-- ===================== Inventory Summary ===================== -->
        <h3 class="section-title">1. Equipment Inventory Summary</h3>
        <p>Total Equipment: <b>{{ $totalEquipment }}</b></p>
        <p>Available: <b>{{ $available }}</b></p>
        <p>Borrowed: <b>{{ $borrowed }}</b></p>
        <p>Damaged: <b>{{ $damaged }}</b></p>
        <p>Maintenance: <b>{{ $maintenance }}</b></p>

        <!-- ===================== Borrowing Activity ===================== -->
        <h3 class="section-title">2. Borrowing Activity</h3>
        <p>Total Borrowings: <b>{{ is_countable($borrowings) ? count($borrowings) : (method_exists($borrowings,'count') ? $borrowings->count() : 0) }}</b></p>

        <!-- ===================== Utilization ===================== -->
        <h3 class="section-title">3. Top Equipment Utilization</h3>
        <ul>
            @foreach($utilization as $item)
                <li>{{ $item['equipment'] }} — {{ $item['count'] }} times</li>
            @endforeach
        </ul>

        <!-- ===================== Damaged ===================== -->
        <h3 class="section-title">4. Damage & Loss Incidents</h3>
        <p>Total Reports: <b>{{ is_countable($damageIncidents) ? count($damageIncidents) : (method_exists($damageIncidents,'count') ? $damageIncidents->count() : 0) }}</b></p>

        <!-- ===================== Expiring Soon ===================== -->
        <h3 class="section-title">5. Expiring Soon (Within 1 Year)</h3>
        <ul>
            @foreach($expiring as $e)
                <li>{{ $e['name'] }} — Expires {{ $e['expired_date'] }} ({{ $e['days_left'] }} days left)</li>
            @endforeach
        </ul>

        <hr>

        <!-- Export buttons -->
        <div style="display:flex; gap:12px; margin-top:10px;">
            <button type="submit" class="btn btn-success">Export PDF</button>
            <a href="{{ route('admin.audit.report') }}" class="btn btn-secondary">Back</a>
        </div>

    </form>
    <!-- END form -->

</div>

@endsection
