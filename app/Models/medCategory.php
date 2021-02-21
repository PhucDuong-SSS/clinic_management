<?php

namespace App\Models;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class medCategory extends Model
{
    use HasFactory;
    // protected $guarded = [];

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
