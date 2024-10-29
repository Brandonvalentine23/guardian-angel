<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mother extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_datetime',
        'identity_card_number',
        'mother_name',
        'sex',
        'mother_dob',
        'phone_number',
        'email',
        'emergency_phone',
        'emergency_email',
        'address',
        'city',
        'state',
        'postal_code',
        'marital_status',
        'minor_status',
        'blood_type',
        'allergies',
        'pregnancy_history',
    ];
}