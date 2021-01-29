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

    public function medCategory()
    {
        return $this->belongsTo(medCategory::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }
    public function prescription()
    {
        return $this->belongsToMany(Medicine::class,'prescription_medicine','id_medicine','id_prescrition');
    }

}
