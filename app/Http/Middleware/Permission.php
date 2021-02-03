<?php

namespace App\Http\Middleware;

use App\Models\Permission as ModelsPermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission = null)
    {
        $permission_user = DB::table('users')
            ->join('user_permission', 'users.id', '=', 'user_permission.id_user')
            ->join('permissions', 'user_permission.permission_key', '=', 'permissions.id')
            ->where('users.id', auth()->id())
            ->select('permissions.*')
            ->get()->pluck('id')->unique();

        $checkPermission = ModelsPermission::where('permission_name', $permission)->value('id');

        if ($permission_user->contains($checkPermission)) {
            return $next($request);
        }
        return abort(401);
    }
}
