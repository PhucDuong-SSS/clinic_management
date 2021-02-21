<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRolesRequest;
use App\Models\Permission;
use App\Models\Roles;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    function index()
    {
        $roles = Roles::all();
        return view('roles.list', compact('roles'));
    }
    function create()
    {
        $permissions = Permission::all();
        return view(('roles.addRole'), compact('permissions'));
    }
    function store(FormRolesRequest $request)
    {
        $role = new Roles();
        $role->role_name = $request->role_name;
        $role->display_name = $request->display_name;
        $role->save();
        $role->permission()->attach($request->permission);
        Session::flash('success', 'Thêm chức vụ thành công');
        return redirect()->route('role.index');
    }
    function edit($id)
    {
        $role = Roles::findOrFail($id);
        $permissions = Permission::all();
        $permissionOfRole = DB::table('role_permission')->where('role_key', $id)->pluck('permission_key');
        return view('roles.editRole', compact('role', 'permissions', 'permissionOfRole'));
    }
    function update($id, FormRolesRequest $request)
    {
        $role = Roles::findOrFail($id);
        $role->role_name = $request->role_name;
        $role->display_name = $request->display_name;
        $role->save();
        DB::table('role_permission')->where('role_key', $id)->delete();
        $role->permission()->attach($request->permission);
        Session::flash('success', 'Chỉnh sửa chức vụ thành công');
        return redirect()->route('role.index');
    }
    function destroy($id)
    {
        DB::table('role_permission')->where('role_key', $id)->delete();
        $role = Roles::findOrFail($id);
        $role->delete();
        return response()->json(["success" => "Record has been delete"]);
    }
}
