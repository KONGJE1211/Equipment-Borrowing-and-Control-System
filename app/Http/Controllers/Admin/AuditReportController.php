<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\BookingHistory;
use App\Models\LostReport;
use Carbon\Carbon;
use PDF;

class AuditReportController extends Controller
{
    public function index()
    {
        return view('admin.audit_report');
    }

    /**
     * Preview page: create data for preview, including a fixed maintenance checklist template.
     * The preview blade should render input fields for each checklist item (name checklist[...] ).
     */
    public function preview(Request $request)
    {
        $type = $request->report_type;
        $year = $request->year ?? Carbon::now()->year;
        $month = $request->month;

        // 1. Inventory summary
        $totalEquipment = Equipment::count();
        $available = Equipment::where('status', 'active')->orWhere('status', 'available')->count();
        $borrowed = Equipment::where('status', 'borrowed')->count();
        $damaged = Equipment::where('status', 'damaged')->count();
        $maintenance = Equipment::where('status', 'maintenance')->count();

        // 2. Borrowing activity
        if ($type === 'monthly' && $month) {
            $borrowings = BookingHistory::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();
        } else {
            $borrowings = BookingHistory::whereYear('created_at', $year)->get();
        }

        // 3. Utilization (top)
        $utilization = BookingHistory::selectRaw('equipment_id, COUNT(*) as count')
            ->groupBy('equipment_id')
            ->take(10)
            ->get()
            ->map(function ($row) {
                return [
                    'equipment' => optional(Equipment::find($row->equipment_id))->name ?? 'Unknown',
                    'count' => $row->count,
                ];
            });

        // 4. Damage & Loss
        $damageIncidents = LostReport::when($type === 'monthly', function ($q) use ($year, $month) {
                return $q->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month);
            })
            ->when($type === 'annual', function ($q) use ($year) {
                return $q->whereYear('created_at', $year);
            })
            ->get();

        // 5. Expiring (<1 year)
        $today = Carbon::now();
        $expiring = Equipment::whereDate('expired_date', '<=', $today->copy()->addYear())
            ->orderBy('expired_date')
            ->get()
            ->map(function ($e) use ($today) {
                return [
                    'name' => $e->name,
                    'expired_date' => $e->expired_date,
                    'days_left' => (int)$today->diffInDays(Carbon::parse($e->expired_date)),
                ];
            });

        // ======= Maintenance Checklist TEMPLATE (固定条目) =======
        // 每一项的 key 用作 input 名称 checklist[<key>]
        $checklistTemplate = [
            '1' => ['label' => 'Physical Check'],
            '1.1' => ['label' => 'Cleaning (PASS / FAIL)'],
            '1.2' => ['label' => 'Damage Check (PASS / FAIL)'],
            '2' => ['label' => 'Functional Test'],
            '2.1' => ['label' => 'Power On Test (YES / NO)'],
            '2.2' => ['label' => 'Basic Operation Test (YES / NO)'],
            '2.3' => ['label' => 'Full Functionality Test (YES / NO)'],
            '2.4' => ['label' => 'Accessories Test (YES / NO)'],
            '3' => ['label' => 'Additional Task'],
            '3.1' => ['label' => 'Required Repair (YES / NO)'],
        ];

        // Pass everything to preview view
        return view('admin.audit_report_preview', [
            'report_type' => $type,
            'year' => $year,
            'month' => $month,
            'totalEquipment' => $totalEquipment,
            'available' => $available,
            'borrowed' => $borrowed,
            'damaged' => $damaged,
            'maintenance' => $maintenance,
            'borrowings' => $borrowings,
            'utilization' => $utilization,
            'damageIncidents' => $damageIncidents,
            'expiring' => $expiring,
            'generatedDate' => Carbon::now()->format('d M Y'),
            'checklistTemplate' => $checklistTemplate, // 模板传给 preview
        ]);
    }

    /**
     * Export PDF.
     * Accepts posted checklist responses (checkboxes / selects / text) in request->input('checklist', []).
     * Passes checklistResponses into PDF view so the checklist and admin answers appear in the PDF.
     */
    public function export(Request $request)
    {
        $type = $request->report_type;
        $year = $request->year ?? Carbon::now()->year;
        $month = $request->month;

        // =============== Inventory Summary ===============
        $totalEquipment = Equipment::count();
        $available = Equipment::where('status', 'active')->orWhere('status', 'available')->count();
        $borrowed = Equipment::where('status', 'borrowed')->count();
        $damaged = Equipment::where('status', 'damaged')->count();
        $maintenance = Equipment::where('status', 'maintenance')->count();

        // =============== Borrowing Activity ===============
        if ($type === 'monthly' && $month) {
            $borrowings = BookingHistory::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->get();
        } else {
            $borrowings = BookingHistory::whereYear('created_at', $year)->get();
        }

        // =============== Utilization ===============
        $utilization = BookingHistory::selectRaw('equipment_id, COUNT(*) as count')
            ->groupBy('equipment_id')
            ->take(10)
            ->get()
            ->map(function ($row) {
                return [
                    'equipment' => optional(Equipment::find($row->equipment_id))->name ?? 'Unknown',
                    'count' => $row->count,
                ];
            });

        // =============== Damage & Loss ===============
        $damageIncidents = LostReport::when($type === 'monthly', function ($q) use ($year, $month) {
                return $q->whereYear('created_at', $year)->whereMonth('created_at', $month);
            })
            ->when($type === 'annual', function ($q) use ($year) {
                return $q->whereYear('created_at', $year);
            })
            ->get();

        // =============== Expiring Soon ===============
        $today = Carbon::now();
        $expiring = Equipment::whereDate('expired_date', '<=', $today->copy()->addYear())
            ->orderBy('expired_date')
            ->get()
            ->map(function ($e) use ($today) {
                $daysLeft = (int)$today->diffInDays(Carbon::parse($e->expired_date));
                return [
                    'name' => $e->name,
                    'expired_date' => $e->expired_date,
                    'days_left' => $daysLeft,
                ];
            });

        // ======= Receive checklist responses from preview form (if any) =======
        // Expecting request input like: checklist[ "1.1" ] = "PASS", checklist["2.1"] = "YES", etc.
        $checklistResponses = $request->input('checklist', []); // array

        // If preview didn't send responses, still create an empty structure of keys so PDF can iterate
        $checklistTemplate = [
            '1' => ['label' => 'Physical Check'],
            '1.1' => ['label' => 'Cleaning'],
            '1.2' => ['label' => 'Damage Check'],
            '2' => ['label' => 'Functional Test'],
            '2.1' => ['label' => 'Power On Test'],
            '2.2' => ['label' => 'Basic Operation Test'],
            '2.3' => ['label' => 'Full Functionality Test'],
            '2.4' => ['label' => 'Accessories Test'],
            '3' => ['label' => 'Additional Task'],
            '3.1' => ['label' => 'Required Repair'],
        ];

        // Ensure every key exists in responses (default to null or dash)
        foreach (array_keys($checklistTemplate) as $k) {
            if (!array_key_exists($k, $checklistResponses)) {
                $checklistResponses[$k] = null;
            }
        }

        // =============== Generate PDF ===============
        $pdf = PDF::loadView('admin.audit_report_pdf', [
            'report_type' => $type,
            'year' => $year,
            'month' => $month,
            'totalEquipment' => $totalEquipment,
            'available' => $available,
            'borrowed' => $borrowed,
            'damaged' => $damaged,
            'maintenance' => $maintenance,
            'borrowings' => $borrowings,
            'utilization' => $utilization,
            'damageIncidents' => $damageIncidents,
            'expiring' => $expiring,
            'generatedDate' => Carbon::now()->format('d M Y'),

            // checklist data for PDF
            'checklistTemplate' => $checklistTemplate,
            'checklistResponses' => $checklistResponses,
        ]);

        return $pdf->download("audit_report_{$type}_{$year}.pdf");
    }
}
