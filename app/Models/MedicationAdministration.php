<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicationAdministration extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $fillable = [
        'newborn_id',
        'medication_name',
        'frequency',
        'route',
        'administration_time',
        'diagnosis',
        'instructions',
        'administered_by',
        'dose',
        'birth_weight',
        'gestational_age',
    ];

    public function newborn()
    {
        return $this->belongsTo(Newborn::class, 'newborn_id', "id"); // Ensure the foreign key name matches
    }
}