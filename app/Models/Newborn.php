<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newborn extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [
        'newborn_name',
        'newborn_dob',
        'gender',
        'birth_weight',
        'blood_type',
        'health_conditions',
        'mother_id',  // Foreign key reference to the Mother
        'mother_name',
        'mother_religion',
        'father_name',
        'father_religion',
        'rfid_uid'
    ];

    // Define the relationship with the Mother model
    public function mother()
    {
        return $this->belongsTo(Mother::class);
    }
    public function medicationAdministrations()
    {
        return $this->hasMany(MedicationAdministration::class, 'newborn_id', "id");
    }
}