<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicationAdministration;
use App\Models\LocationLog;
use Carbon\Carbon;

class AlertAndNotificationController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $tenMinutesLater = (clone $now)->addMinutes(10);

        // Fetch pending medications (past time, not done)
        $pendingMedications = MedicationAdministration::with('newborn')
            ->where('done', false)
            ->where('administration_time', '<', $now)
            ->orderBy('administration_time', 'asc')
            ->get();

        // Extract `newborn_id` of pending medications to exclude them
        $pendingMedicationIds = $pendingMedications->pluck('newborn_id');

        // Fetch medications due in the next 10 minutes (alerts)
        $medicationAlerts = MedicationAdministration::with('newborn')
            ->where('done', false)
            ->whereBetween('administration_time', [$now, $tenMinutesLater])
            ->whereNotIn('newborn_id', $pendingMedicationIds) // Exclude pending
            ->orderBy('administration_time', 'asc')
            ->get();

        // Fetch upcoming medications (future medications not in pending or alerts)
        $upcomingMedications = MedicationAdministration::with('newborn')
            ->where('done', false)
          
            ->whereNotIn('newborn_id', $pendingMedicationIds) // Exclude pending
            ->whereNotIn('newborn_id', $medicationAlerts->pluck('newborn_id')) // Exclude alerts
            ->orderBy('administration_time', 'asc')
            ->get();

        // Debugging the data
        logger('Pending Medications:', $pendingMedications->toArray());
        logger('Medication Alerts:', $medicationAlerts->toArray());
        logger('Upcoming Medications:', $upcomingMedications->toArray());

        // Return the view
        return view('auth.alertandnoti.alert-noti', [
            'pendingMedications' => $pendingMedications,
            'medicationAlerts' => $medicationAlerts,
            'upcomingMedications' => $upcomingMedications,
        ]);
    }

    public function welcomeMP()
    {
        $now = Carbon::now();
        $tenMinutesLater = (clone $now)->addMinutes(10);
    
        // Fetch medication alerts (already working)
        $medicationAlerts = MedicationAdministration::with('newborn')
            ->where('done', false)
            ->whereBetween('administration_time', [$now, $tenMinutesLater])
            ->orderBy('administration_time', 'asc')
            ->get();
    
        // Fetch the latest location log
        $latestLocationLog = LocationLog::orderBy('logged_at', 'desc')->first();
    
        return view('auth.welcomeMP', [
            'medicationAlerts' => $medicationAlerts, // Keeps existing functionality
            'latestLocationLog' => $latestLocationLog, // Add this for the location alert
        ]);
    }
}