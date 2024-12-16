<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationLog extends Model
{
    use HasFactory;

    protected $table = 'location_log';

    // The attributes that are mass assignable
    protected $fillable = [
        'uid',
        'location',
        'logged_at',
    ];

    // Optional: Adding a custom timestamp format (if needed)
    protected $dates = [
        'logged_at',
    ];
}