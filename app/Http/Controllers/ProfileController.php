<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(session('user_id'));
        return view('user.profile.index', compact('user'));
    }

    public function edit() 
    {
        $user = User::find(session('user_id'));
        return view('user.profile.edit', compact('user'));
    }


    public function update(Request $request)
    {
        $user = User::findOrFail(session('user_id'));

        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'student_id'=>'required|unique:users,student_id,'.$user->id,
            'phone'=>'nullable',
            'batch'=>'nullable',
            'id_photo'=>'nullable|image|max:2048',
            // 如果想支持密码修改可以加入 password fields
        ], [
            'email.unique'=>'The email has already been registered.',
            'student_id.unique'=>'The ID has been registered.',
        ]);

        if($request->hasFile('id_photo')){
            if($user->id_photo) Storage::disk('public')->delete($user->id_photo);
            $path = $request->file('id_photo')->store('id_photos','public');
            $user->id_photo = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->student_id = $request->student_id;
        $user->phone = $request->phone;
        $user->batch = $request->batch;
        // identity 不允许更改
        $user->save();

        return redirect()->route('profile.index')->with('success','Profile updated.');

    }
}
