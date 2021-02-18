<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';


    public function role()
    {
        return $this->belongsToMany(Roles::class, 'role_permission', 'permission_key', 'role_key');
    }
}
