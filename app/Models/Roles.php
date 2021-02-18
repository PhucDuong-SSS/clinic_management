<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsToMany(Roles::class, 'user_role', 'role_key', 'id_user');
    }
    public function permission()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_key', 'permission_key');
    }
}
