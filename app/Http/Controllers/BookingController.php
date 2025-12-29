<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Equipment;
use App\Models\BookingHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class BookingController extends Controller
{
    // 用户自己的 booking 列表（db3 当前申请）
    public function index()
    {
        $userId = session('user_id');
        $bookings = Booking::where('user_id', $userId)->with('equipment')->orderBy('created_at','desc')->paginate(10);
        return view('user.booking.index', compact('bookings'));
    }

    // 创建申请表单
    public function create(Request $request)
    {
        // 如果有 equipment_id GET 参数，则预选
        $selectedEquipmentId = $request->query('equipment_id', null);

        // 显示所有设备供选择（可按 available 筛选）
        $equipments = Equipment::orderBy('name')->get();

        // 当前登录 user
        $user = User::find(session('user_id'));

        return view('user.booking.create', compact('equipments','selectedEquipmentId','user'));
    }

    // 提交申请 — 写入 db3 bookings
    public function store(Request $request)
    {
        $userId = session('user_id');
        $user = User::findOrFail($userId);

        $request->validate([
            'equipment_id'=>'required|exists:equipment,id',
            'start_date'=>'required|date|after_or_equal:today',
            'end_date'=>'required|date|after:start_date',
        ], [
            'equipment_id.required'=>'Please select the equipment.',
            'start_date.required'=>'Please select a start date.',
            'end_date.required'=>'Please select an end date.',
            'end_date.after'=>'The end date must be later than the start date.',
        ]);

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end);

        if ($days > 1) {
        return back()
        ->with('error', 'You can only borrow equipment for 1 day.')
        ->withInput();
}

        $equipment = Equipment::findOrFail($request->equipment_id);

        // 设备状态检查
        if(in_array($equipment->status, ['borrowed','damaged','maintenance'])){
            return back()->with('error','This equipment is on borrowed / damaged / maintenance, please try it later.')->withInput();
        }

        // 学生限制：价值>500 不允许
        if($user->identity === 'student' && $equipment->value > 500){
            return back()->with('error','Student is limited to the value of the borrowed device cannot exceed RM500, please borrow other equipment')->withInput();
        }

        // 创建 booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'equipment_id' => $equipment->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);

        return redirect()->route('booking.index')->with('success','You have already sent your booking request, please wait for review.');
    }

    // 用户查看合并的 history（db3 + db4）
    public function history()
    {
        $userId = session('user_id');

        // 当前 bookings
        $bookings = Booking::where('user_id',$userId)->with('equipment')->get();

        // 历史归档（booking_history）
        $histories = BookingHistory::where('user_id',$userId)->with('equipment')->orderBy('created_at','desc')->get();

        // 为了方便前端显示，我们可以合并并排序
        $combined = collect();

        foreach($bookings as $b){
            $combined->push([
                'id' => $b->id,
                'equipment_name' => $b->equipment ? $b->equipment->name : '-',
                'start_date' => $b->start_date,
                'end_date' => $b->end_date,
                'status' => $b->status,
                'is_history' => false,
            ]);
        }

        foreach($histories as $h){
            $combined->push([
                'id' => $h->id,
                'equipment_name' => $h->equipment ? $h->equipment->name : '-',
                'start_date' => $h->start_date,
                'end_date' => $h->end_date,
                'status' => $h->status,
                'is_history' => true,
            ]);
        }

        // 按开始日期或创建时间排序（这里按 start_date desc）
        $combined = $combined->sortByDesc('start_date')->values();

        return view('user.history.index', compact('combined'));
    }
}
