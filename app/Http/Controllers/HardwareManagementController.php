<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HardwareStatus;

class HardwareManagementController extends Controller
{
    // Show the hardware management dashboard
    public function index()
    {
        $hardwareStatuses = HardwareStatus::all();
        return view('auth.hardware.hardware-manage', compact('hardwareStatuses'));
    }

    // Endpoint to update hardware status (for API integration with Pico)
    public function updateHardwareStatus(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'device' => 'required|string',
            'ip_address' => 'required|string',
            'rfid1_status' => 'required|string',
            'rfid2_status' => 'required|string',
            'timestamp' => 'required|numeric',
        ]);

        // Update or create a hardware status record
        HardwareStatus::updateOrCreate(
            ['device' => $request->device],
            [
                'ip_address' => $request->ip_address,
                'reader_status' => json_encode([
                    'rfid1' => $request->rfid1_status,
                    'rfid2' => $request->rfid2_status,
                ]),
                'last_heartbeat' => date('Y-m-d H:i:s', $request->timestamp),
            ]
        );

        return response()->json(['message' => 'Hardware status updated successfully'], 200);
    }
}