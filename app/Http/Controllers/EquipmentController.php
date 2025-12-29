<?php
namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    // 列表页 + 搜索
    public function index(Request $request)
    {
        $q = Equipment::query();

        if ($request->filled('search')) {
            $q->where('name', 'like', '%' . $request->search . '%');
        }

        // 分页 12 条
        $equipments = $q->orderBy('id','desc')->paginate(12)->withQueryString();

        return view('user.equipment.index', compact('equipments'));
    }

    // 设备详情页（可选）
    public function show($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('user.equipment.show', compact('equipment'));
    }
}
