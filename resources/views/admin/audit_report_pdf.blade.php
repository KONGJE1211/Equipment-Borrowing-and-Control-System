<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Audit Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        h2 { text-align: center; margin-bottom:6px; }
        p.meta { text-align:center; color:#555; margin-top:0; margin-bottom:12px; }
        .section { margin-bottom: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        table, th, td { border: 1px solid #999; }
        th, td { padding: 8px; text-align: left; vertical-align: middle; }
        th.center, td.center { text-align: center; }
        .small { font-size:11px; color:#444; }
        .note { text-align:center; font-size:11px; margin-top:12px; color:#666; }
    </style>
</head>
<body>

<h2><strong>Equipment Borrowing and Control System</strong><br>Audit Report</h2>
<p class="meta">Report generated on: {{ $generatedDate }} — Report Type: <strong>{{ ucfirst($report_type) }}</strong></p>

{{-- ============================= 0. Maintenance Checklist (admin inputs shown) ============================= --}}
<div class="section">
    <h3>Maintenance Checklist / Asset No.</h3>

    <table>
        <thead>
            <tr>
                <th style="width:10%;" class="center">No.</th>
                <th style="width:65%;">Maintenance Checklist / Asset No.</th>
                <th style="width:25%;" class="center">Result <br>(PASS / FAIL or YES / NO)</th>
            </tr>
        </thead>
        <tbody>
            @php
                // checklistTemplate and checklistResponses provided by controller
                // They are associative arrays keyed by '1','1.1','1.2',...
            @endphp

            @foreach($checklistTemplate as $key => $item)
                {{-- render parent items slightly bold --}}
                <tr>
                    <td class="center">{{ $key }}</td>
                    <td>
                        @if(in_array($key, ['1','2','3']))
                            <strong>{{ $item['label'] }}</strong>
                        @else
                            {{ $item['label'] }}
                        @endif
                    </td>
                    <td class="center">
                        {{ $checklistResponses[$key] ?? '—' }}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>

{{-- ============================= 1. Equipment Inventory ============================= --}}
<div class="section">
    <h3>1. Equipment Inventory Summary</h3>

    <table>
        <tr><th style="width:40%">Total Equipment</th><td>{{ $totalEquipment }}</td></tr>
        <tr><th>Available</th><td>{{ $available }}</td></tr>
        <tr><th>Borrowed</th><td>{{ $borrowed }}</td></tr>
        <tr><th>Damaged</th><td>{{ $damaged }}</td></tr>
        <tr><th>Maintenance</th><td>{{ $maintenance }}</td></tr>
    </table>

    @if(isset($inventoryChart) && $inventoryChart)
        <p style="margin-top:8px;"><img src="{{ $inventoryChart }}" style="width:300px;"></p>
    @endif
</div>

{{-- ============================= 2. Borrowing Activity ============================= --}}
<div class="section">
    <h3>2. Borrowing Activity Overview</h3>
    <p>Total Borrowings: <strong>{{ is_countable($borrowings) ? count($borrowings) : (method_exists($borrowings,'count') ? $borrowings->count() : 0) }}</strong></p>

    @if(isset($borrowingChart) && $borrowingChart)
        <p><img src="{{ $borrowingChart }}" style="width:350px;"></p>
    @endif
</div>

{{-- ============================= 3. Utilization ============================= --}}
<div class="section">
    <h3>3. Equipment Utilization Rate (Top 10)</h3>

    <table>
        <thead>
            <tr><th>Equipment</th><th class="center">Times Borrowed</th></tr>
        </thead>
        <tbody>
            @foreach ($utilization as $item)
                <tr>
                    <td>{{ $item['equipment'] }}</td>
                    <td class="center">{{ $item['count'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(isset($utilizationChart) && $utilizationChart)
        <p style="margin-top:8px;"><img src="{{ $utilizationChart }}" style="width:350px;"></p>
    @endif
</div>

{{-- ============================= 4. Damage & Loss ============================= --}}
<div class="section">
    <h3>4. Damage & Loss Incidents</h3>

    <table>
        <thead>
            <tr><th>Equipment</th><th>Reported By</th><th class="center">Date</th><th class="center">Status</th></tr>
        </thead>
        <tbody>
            @foreach ($damageIncidents as $incident)
                <tr>
                    <td>{{ optional($incident->equipment)->name ?? 'Unknown' }}</td>
                    <td>{{ optional($incident->user)->name ?? 'Unknown' }}</td>
                    <td class="center">{{ optional($incident->created_at)->format('d M Y') ?? '—' }}</td>
                    <td class="center">{{ $incident->status ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- ============================= 5. Expiring Soon ============================= --}}
<div class="section">
    <h3>5. Equipment Expiring Within 1 Year</h3>

    <table>
        <thead><tr><th>Equipment</th><th class="center">Expired Date</th><th class="center">Days Left</th></tr></thead>
        <tbody>
            @foreach ($expiring as $e)
                <tr>
                    <td>{{ $e['name'] }}</td>
                    <td class="center">{{ \Carbon\Carbon::parse($e['expired_date'])->format('d M Y') }}</td>
                    <td class="center">{{ (int) $e['days_left'] }} days</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<hr>
<p class="note">Report generated by Equipment Borrowing and Control System</p>

</body>
</html>
