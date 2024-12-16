<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocationLog;
use Illuminate\Support\Facades\Log;

class LocationLogController extends Controller
{
    // Show location logs on the Blade view
    public function showLocationLogs()
    {
        // Retrieve all logs ordered by the most recent first
        // $logs = LocationLog::orderBy('logged_at', 'desc')->get();

        // Return the Blade view with the logs
        return view('auth.location.location-log');
    }

    // Store RFID log
    public function storeLocationLog(Request $request)
    {
        // Log the incoming request data for debugging
        Log::info('Incoming RFID request', ['uid' => $request->input('uid')]);

        // Validate incoming request for UID
        $validated = $request->validate([
            'uid' => 'required|string',
        ]);

        // Add the location name ("Main Door") and the timestamp
        LocationLog::create([
            'uid' => $validated['uid'],
            'location' => 'Main Door',  // Location name
            'logged_at' => now(),       // Current timestamp
        ]);

        return response()->json(['message' => 'Location logged successfully']);

        // // Fake the response with a 200 OK without performing any database operations
        // return response()->json([
        //     'message' => 'Location logged successfully (Fake response)',
        //     'status' => 200  // You can include any custom field to signify success
        // ], 200);
    }

    // Get all RFID logs for the location as JSON (API use)
    public function getLocationLogs()
    {
        // Retrieve all logs ordered by the most recent first
        $logs = LocationLog::orderBy('logged_at', 'desc')->get();

        // Return logs as a JSON response for API use
        return response()->json(['logs' => $logs]);
    }
}