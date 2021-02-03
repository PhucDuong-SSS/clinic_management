<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sympton extends Model
{
    use HasFactory;
    protected $table = 'symptons';

    // protected $guared = [];

    protected $fillable = [
        'sympton_name'
    ];

}
