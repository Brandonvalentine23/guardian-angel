<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newborn extends Model
{
    use HasFactory;

    protected $fillable = [
        'newborn_name',
        'newborn_dob',
        'gender',
        'birth_weight',
        'blood_type',
        'health_conditions',
        'mother_name',
        'mother_religion',
        'father_name',
        'father_religion',
    ];
}