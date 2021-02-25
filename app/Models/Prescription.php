<?php

namespace App\Models;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;

    public function medicines()
    {
        return $this->belongsToMany(Prescription::class,'prescription_medicine','id_prescrition','id_medicine')
        ->withPivot('sell_price')
        ->withTimestamps();
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class,'id_patient','id');
    }
}
