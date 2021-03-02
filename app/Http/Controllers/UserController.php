<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormChangePasswordRequest;
use App\Http\Requests\FormEditUserRequest;
use App\Http\Requests\FormUserRequest;
use App\Http\Services\UserService;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Permission;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    protected $userService;

    function __construct(UserService $userService, Roles $role)
    {
        $this->userService = $userService;
        $this->role = $role;
    }
    function index()
    {
        $users = User::all();
        $roles = Roles::all();
        return view('users.list', compact('users', 'roles'));
    }
    function create()
    {
        $roles = Roles::all();
        return view('users.addUser', compact('roles'));
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
        $pathImage = Storage::disk('s3')->put('clinicImages',$request->image,'public');
        $user->image   = $pathImage;
//        $user->image   = $request->image->store('public/images');
        $user->save();
        $user->role()->attach($request->role_key);
        return redirect()->route('user.index')->with('success', "Thêm thành viên thành công");
    }
    function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = $this->role->all();
        $roleOfUser = DB::table('user_role')->where('id_user', $id)->pluck('role_key');
        return view('users.edit', compact('user', 'roles', 'roleOfUser'));
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
        DB::table('user_role')->where('id_user', $id)->delete();
        $user->role()->attach($request->role_key);
        Session::flash('success', 'Chỉnh sửa thành viên thành công');

        return redirect()->route('user.index');
    }
    public function UpdateUpload($id, $request)
    {
        $user = User::findOrFail($id);
        $oldImage = $user->image;
        if ($request->hasFile('image')) {
//            $img = $request->image;//
//            $path = $img->store('public/images');
            $path= Storage::disk('s3')->put('clinicImages',$request->image,'public');
            Storage::delete($oldImage);

            return $path;
        } else {
            return $user->image;
        }
    }
    function destroy($id)
    {
        DB::table('user_role')->where('id_user', $id)->delete();
        $user = User::findOrFail($id);
        $oldImage = $user->image;
        $user->delete();
        Storage::delete($oldImage);
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

    function home()
    {
        $medicines1 = Medicine::where('medicine_amount', '<', 50)->get();
        $patient = Patient::all();
        $users = User::all();
        $medicines = Medicine::all();
        return view('layout.home', compact('medicines1', 'patient', 'users', 'medicines'));
    }
}
