<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';


    public function user()
    {
        return $this->belongsToMany(Permission::class, 'user_permission', 'permission_key', 'id_user');
    }
}
