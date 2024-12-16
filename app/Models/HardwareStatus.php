<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'device',
        'ip_address',
        'reader_status',
        'last_heartbeat',
    ];
}