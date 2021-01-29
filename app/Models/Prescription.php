<?php

namespace App\Models;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;

    public function medicine()
    {
        return $this->belongsToMany(Prescription::class,'prescription_medicine','id_prescrition','id_medicine');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
