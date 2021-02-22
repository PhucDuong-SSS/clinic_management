<?php

namespace App\Models;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lot extends Model
{
    use HasFactory;

    protected $table = 'lots';

    // public function medicines()
    // {
    //     return $this->hasMany(Medicine::class);
    // }
}
