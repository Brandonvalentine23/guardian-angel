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

    // Validate the incoming request
    $validated = $request->validate([
        'uid' => 'required|string',
    ]);

    try {
        // Add the location name and timestamp
        $log = LocationLog::create([
            'uid' => $validated['uid'],
            'location' => 'Main Door', // Example location
            'logged_at' => now(),      // Current timestamp
        ]);

         // Log the created entry
         Log::info('Location Log Created:', $log->toArray());
        // Store the new log in the session to pass to welcomeMP
        session()->flash('latestLocationLog', $log);

        return response()->json(['message' => 'Location logged successfully']);
    } catch (\Exception $e) {
        // Log the error if the creation fails
        Log::error('Error creating location log:', ['error' => $e->getMessage()]);

        return response()->json(['message' => 'Failed to log location'], 500);
    }
}

    // Get all RFID logs for the location as JSON (API use)
    public function getLocationLogs()
    {
        // Retrieve all logs ordered by the most recent first
        $logs = LocationLog::orderBy('logged_at', 'desc')->get();

        // Return logs as a JSON response for API use
        return response()->json(['logs' => $logs]);
    }
    public function showDashboard()
{
    // Example of fetching the latest location log
    $latestLog = LocationLog::latest()->first();

    $locationAlert = $latestLog ? [
        'uid' => $latestLog->uid,
        'location' => $latestLog->location,
    ] : null;

    return view('welcomeMP', compact('locationAlert'));
}
}