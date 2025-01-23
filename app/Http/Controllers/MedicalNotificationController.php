<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicationAdministration;
use Carbon\Carbon;

class MedicalNotificationController extends Controller
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
    
        // Fetch `newborn_id` of pending medications to exclude them
        $pendingMedicationIds = $pendingMedications->pluck('newborn_id');
    
        // Fetch medications due in the next 10 minutes (alerts)
        $medicationAlerts = MedicationAdministration::with('newborn')
            ->where('done', false)
            ->whereBetween('administration_time', [$now, $tenMinutesLater])
            ->whereNotIn('newborn_id', $pendingMedicationIds) // Exclude pending
            ->orderBy('administration_time', 'asc')
            ->get();
    
        // Fetch upcoming medications (future medications not in pending or alerts)
        // the one just posted was: 10:11PM
        // 10:15PM
        // refreshed at 10:12PM
        // 10 minutes later is 10:22PM

        $upcomingMedications = MedicationAdministration::with('newborn')
            ->where('done', false)
            // ->where('administration_time', '>=', $tenMinutesLater) // Future meds
            ->whereNotIn('newborn_id', $pendingMedicationIds) // Exclude pending
            ->orderBy('administration_time', 'asc')
            ->get();
    
        // Debugging the data
       
    
        // Return the view
        return view('auth.alertandnoti.mednotiandalert', [
            'medicationAlerts' => $medicationAlerts,
            'pendingMedications' => $pendingMedications,
            'upcomingMedications' => $upcomingMedications,
        ]);
    }
}