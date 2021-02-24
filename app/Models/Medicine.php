<?php

namespace App\Models;

use App\Models\Lot;
use App\Models\Unit;
use App\Models\medCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medicine extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function medCategory()
    {
        return $this->belongsTo(medCategory::class, 'id_category', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'id');
    }

    public function lot()
    {
        return $this->hasMany(Lot::class, 'id_med', 'id');
    }

    public function prescription()
    {
        return $this->belongsToMany(Medicine::class, 'prescription_medicine', 'id_medicine', 'id_prescrition');
    }
}
