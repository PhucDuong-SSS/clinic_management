<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormChangePasswordRequest;
use App\Http\Requests\FormEditUserRequest;
use App\Http\Requests\FormUserRequest;
use App\Http\Services\UserService;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $userService;

    function __construct(UserService $userService, Permission $permission)
    {
        $this->userService = $userService;
        $this->permission = $permission;
    }
    function index()
    {
        $users = User::all();
        return view('users.list', compact('users'));
    }
    function create()
    {
        $permissions = $this->permission->all();
        return view('users.addUser', compact('permissions'));
    }
    function store(FormUserRequest $request)
    {
        $user = new User();
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->user_name = $request->user_name;
        $user->password = bcrypt($request->password);
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->image   = $request->image->store('public/images');
        $user->save();

        $permission = $request->permission;
        if (!empty($permission)) {
            foreach ($permission as $permissionId) {
                DB::table('user_permission')->insert([
                    'id_user' => $user->id,
                    'permission_key' => $permissionId
                ]);
            }
        }
        Session::flash('success', 'Thêm thành viên thành công');

        return redirect()->route('user.index');
    }
    function edit($id)
    {
        $user = User::findOrFail($id);
        $permissions = $this->permission->all();
        // dd($permissions);
        $getAllPermissionUser = DB::table('user_permission')->where('id_user', $id)->pluck('permission_key');
        // dd($getAllPermissionUser);
        return view('users.edit', compact('user', 'permissions', 'getAllPermissionUser'));
    }
    function update($id, FormEditUserRequest $request)
    {
        $user = User::findOrFail($id);
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->user_name = $request->user_name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->image = $this->UpdateUpload($id, $request);
        $user->save();

        $permission = $request->permission;

        if (!empty($permission)) {
            DB::table('user_permission')->where('id_user', $id)->delete();
            foreach ($permission as $permissionId) {
                DB::table('user_permission')->insert([
                    'id_user' => $id,
                    'permission_key' => $permissionId
                ]);
            }
        }
        Session::flash('success', 'Chỉnh sửa thành viên thành công');

        return redirect()->route('user.index');
    }
    public function UpdateUpload($id, $request)
    {
        $user = User::findOrFail($id);
        if ($request->hasFile('image')) {
            $img = $request->image;
            $path = $img->store('public/images');
            return $path;
        } else {
            return $user->image;
        }
    }
    function destroy($id)
    {
        DB::table('user_permission')->where('id_user', $id)->delete();
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(["success" => "Record has been delete"]);
        // Session::flash('success', 'Xóa thành viên thành công');
        // return redirect()->route('user.index');
    }

    function changepasswordform()
    {
        $user = Auth::user();
        return view('users.changePassWordForm', compact('user'));
    }

    function changepassword($id, FormChangePasswordRequest $request)
    {
        $user = User::find($id);
        if (Hash::check($request->oldpassword, Auth::user()->password)) {
            $user->password = bcrypt($request->newpassword);
            $user->save();
            return redirect()->route('user.changepasswordform')->with('changepassword-success', "Đổi mật khẩu thành công");
        } else {
            return redirect()->route('user.changepasswordform')->with('changepassword-error', 'Mật khẩu cũ không đúng!');
        }
    }
    function changeprofileform()
    {
        $user = Auth::user();
        return view('users.changeProfileForm', compact('user'));
    }

    function changeprofile($id, FormEditUserRequest $request)
    {
        $user = User::findOrFail($id);
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->user_name = $request->user_name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->image = $this->UpdateUpload($id, $request);
        $user->save();
        Session::flash('success', 'Cập nhật profile thành công');
        return redirect()->route('user.index');
    }
}
