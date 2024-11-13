<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationAdministration extends Model
{
    use HasFactory;

    protected $fillable = [
        'newborn_id',          // Foreign key linking to the newborns table
        'medication_type',     // Name/type of the medication
        'administration_time', // Time of administration
        'dose',                // Dosage of the medication
    ];

    public function newborn()
    {
        return $this->belongsTo(Newborn::class, 'newborn_id'); // Ensure the foreign key name matches
    }
}