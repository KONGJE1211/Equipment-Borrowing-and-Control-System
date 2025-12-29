<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LostReport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // ===== Register Functions =====
    public function showRegister() {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required|min:8',
            'student_id' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'batch' => 'required',
            'identity' => 'required',
            'id_photo' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $path = $request->file('id_photo')->store('id_photos', 'public');

        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'student_id' => $request->student_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'batch' => $request->batch,
            'identity' => $request->identity,
            'id_photo' => $path,
        ]);

        return redirect()->route('register')->with('success', 'You already Register Successful');
    }

    // ===== Login Functions =====
    public function showLogin() {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session([
                'user_id' => $user->id,
                'user_name' => $user->name
            ]);
            return redirect()->route('home');
        } else {
            return back()->with('error', 'Invalid email or password');
        }
    }

    public function home() {
        return view('user.home');
    }

    public function logout() {
        session()->forget(['user_id', 'user_name']);
        return redirect()->route('guest.guest');
    }

    // ===== Lost Report Functions =====
    public function showLostReportForm()
    {
        $userId = session('user_id');

        // 获取用户正在借用中的设备
        $equipments = DB::table('bookings')
            ->join('equipment', 'bookings.equipment_id', '=', 'equipment.id')
            ->where('bookings.user_id', $userId)
            ->where('bookings.status', 'approved')
            ->select('equipment.*')
            ->get();

        // 查询已报失但未结案的设备 ID
        $reportedEquipmentIds = LostReport::where('user_id', $userId)
            ->whereIn('status', ['pending', 'in review', 'reviewed'])
            ->pluck('equipment_id')
            ->toArray();

        return view('user.report_lost', compact('equipments', 'reportedEquipmentIds'));
    }

    public function submitLostReport(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipment,id',
            'description' => 'required'
        ]);

        $userId = session('user_id');

        // 检查是否已报失（避免重复报失）
        $alreadyReported = LostReport::where('user_id', $userId)
            ->where('equipment_id', $request->equipment_id)
            ->whereIn('status', ['pending', 'in review', 'reviewed'])
            ->exists();

        if ($alreadyReported) {
            return back()->with('error', 'This equipment has already been reported as lost. You cannot submit another report.');
        }

        LostReport::create([
            'user_id' => $userId,
            'equipment_id' => $request->equipment_id,
            'description' => $request->description,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Report submitted successfully. Admin will review your report.');
    }

    public function myReports()
    {
        $userId = session('user_id');

        $reports = LostReport::where('user_id', $userId)
            ->with('equipment')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.my_reports', compact('reports'));
    }
}
