<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Equipment;
use App\Models\Booking;
use App\Models\BookingHistory;
use App\Models\LostReport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // 简单管理员登录（单一账号）
    public function loginPage() {
        return view('admin.login');
    }

    public function login(Request $request) {
        $request->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        // 固定初始管理员账号
        $adminUsername = 'admin';
        $adminPassword = 'admin123'; // 可在 .env 配置

        if($request->username === $adminUsername && $request->password === $adminPassword){
            session(['admin_logged_in'=>true]);
            return redirect()->route('admin.dashboard');
        } else {
            return back()->with('error','Invalid admin credentials.');
        }
    }

    public function logout() {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    // ----------------- Dashboard -----------------
    public function dashboard(){
        $equipmentCount = Equipment::count();
        $userCount = User::count();
        $bookingCount = Booking::count();
        $reportCount = LostReport::count();
        return view('admin.dashboard', compact('equipmentCount','userCount','bookingCount','reportCount'));
    }

    // ----------------- Manage Equipment -----------------
public function manageEquipment(Request $request)
{
        // $equipments = Equipment::orderBy('id','desc')->paginate(10);
        $search = $request->input('search');

    $equipments = Equipment::when($search, function ($query, $search) {
        return $query->where('name', 'LIKE', '%' . $search . '%');
    })
    ->orderBy('id', 'desc')
    ->paginate(10);
        return view('admin.manage_equipment', compact('equipments'));
    }



    public function addEquipment(Request $request){
    $request->validate([
        'name'=>'required',
        'information'=>'required',
        'value'=>'required|numeric',
        'expired_date' => 'nullable|date',
        'image'=>'nullable|image|max:2048'
    ]);

    $path = $request->file('image') ? $request->file('image')->store('equipment','public') : null;

    Equipment::create([
        'name'=>$request->name,
        'information'=>$request->information,
        'value'=>$request->value,
        'status'=>'available',
        'expired_date' => $request->expired_date,
        'image'=>$path
    ]);

    return back()->with('success','Equipment added.');
}


    public function editEquipment($id) {
        $equipment = Equipment::findOrFail($id);
        return view('admin.equipment.edit', compact('equipment'));
    }

    public function updateEquipment(Request $request, $id){
    $equipment = Equipment::findOrFail($id);

    $request->validate([
        'name'=>'required',
        'information'=>'required',
        'value'=>'required|numeric',
        'status'=>'required',
        'expired_date' => 'nullable|date',
        'image'=>'nullable|image|max:2048'
    ]);

    if($request->hasFile('image')){
        if($equipment->image) Storage::disk('public')->delete($equipment->image);
        $equipment->image = $request->file('image')->store('equipment','public');
    }

    $equipment->update([
        'name'=>$request->name,
        'information'=>$request->information,
        'value'=>$request->value,
        'status'=>$request->status,
        'expired_date' => $request->expired_date,
        'image'=>$equipment->image
    ]);

    return redirect()->route('admin.manageEquipment')
                 ->with('success', 'Equipment updated successfully.');
}


    public function deleteEquipment($id){
        $equipment = Equipment::findOrFail($id);
        if($equipment->image) Storage::disk('public')->delete($equipment->image);
        $equipment->delete();
        return back()->with('success','Equipment deleted.');
    }

    // ----------------- Manage Users -----------------
    public function manageUser(Request $request)
{
    $search = $request->search;  // 取得搜索关键字

    $users = User::when($search, function ($query, $search) {
                        return $query->where('name', 'LIKE', "%$search%")
                                     ->orWhere('email', 'LIKE', "%$search%")
                                     ->orWhere('student_id', 'LIKE', "%$search%");
                    })
                    ->orderBy('id','asc')
                    ->paginate(10);

    return view('admin.manage_user', compact('users'));
}

    public function createUser(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8',
        'student_id' => 'required|unique:users',
        'phone' => 'required',
        'batch' => 'required',
        'identity' => 'required',
        'id_photo' => 'required|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $path = $request->file('id_photo')->store('id_photos', 'public');

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'student_id' => $request->student_id,
        'phone' => $request->phone,
        'batch' => $request->batch,
        'identity' => $request->identity,
        'id_photo' => $path,
    ]);

    return back()->with('success', 'User created successfully!');
}


    public function deleteUser($id){
        User::findOrFail($id)->delete();
        return back()->with('success','User deleted.');
    }

    // ----------------- Booking List -----------------
    public function bookingList(){
        $bookings = Booking::with(['user','equipment'])->orderBy('created_at','desc')->paginate(10);
        return view('admin.booking_list', compact('bookings'));
    }

    public function approveBooking($id){
        $booking = Booking::findOrFail($id);
        $booking->status = 'approved';
        $booking->save();

        // 更新设备状态为 borrowed
        $booking->equipment->status = 'borrowed';
        $booking->equipment->save();

        return back()->with('success','Booking approved.');
    }

    public function rejectBooking($id){
        $booking = Booking::findOrFail($id);
        $booking->status = 'rejected';
        $booking->save();

        return back()->with('success','Booking rejected.');
    }

    public function markReturned($id){
        $booking = Booking::findOrFail($id);
        $equipment = $booking->equipment;

        // 创建历史记录
        BookingHistory::create([
            'user_id'=>$booking->user_id,
            'equipment_id'=>$booking->equipment_id,
            'start_date'=>$booking->start_date,
            'end_date'=>$booking->end_date,
            'status'=>'returned',
            'original_booking_id'=>$booking->id,
        ]);

        // 删除原记录
        $booking->delete();

        // 设备状态改为 available
        $equipment->status = 'available';
        $equipment->save();

        return back()->with('success','Marked as returned.');
    }

    public function viewLostReports()
{
    $reports = LostReport::with('user', 'equipment')->orderBy('id','desc')->paginate(10);

    return view('admin.lost_reports', compact('reports'));
}

public function replyLostReport(Request $request, $id)
{
    $request->validate([
        'admin_reply' => 'required'
    ]);

    $report = LostReport::findOrFail($id);
    $report->admin_reply = $request->admin_reply;
    $report->status = 'reviewed';
    $report->save();

    return back()->with('success', 'Reply sent successfully.');
}
}
