<?php

namespace App\Http\Controllers;

use App\Models\Newborn;
use App\Models\MedicationAdministration;
use App\Models\LocationLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Function to load the dashboard view
    public function index()
    {
        $newbornRegistrations = $this->getNewbornRegistrations();
        $medicationsScheduled = $this->getMedicationsScheduled();
        $upcomingAlerts = $this->getUpcomingAlerts();
        $medicationAlerts = $this->getMedicationAlerts(); // Fetch medication alerts
        $latestLocationLog = $this->getLatestLocationLog(); // Fetch the latest location log

        return view('auth.welcomeMP', compact(
            'newbornRegistrations',
            'medicationsScheduled',
            'upcomingAlerts',
            'medicationAlerts',
            'latestLocationLog'
        ));
    }

    // Fetch newborn registrations grouped by date
    public function getNewbornRegistrations()
    {
        return Newborn::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    // Count medications scheduled for today
    public function getMedicationsScheduled()
    {
        $today = now()->toDateString();
        return MedicationAdministration::whereDate('administration_time', $today)->count();
    }

    // Fetch upcoming alerts (medications due in the next 10 minutes)
    public function getUpcomingAlerts()
    {
        $now = Carbon::now();
        $tenMinutesLater = $now->addMinutes(10);

        return MedicationAdministration::where('done', false)
            ->whereBetween('administration_time', [$now, $tenMinutesLater])
            ->count();
    }

    // Fetch medication alerts (due in the next 10 minutes)
    public function getMedicationAlerts()
    {
        $now = Carbon::now();
        $tenMinutesLater = $now->addMinutes(10);

        return MedicationAdministration::with('newborn')
            ->where('done', false)
            ->whereBetween('administration_time', [$now, $tenMinutesLater])
            ->get();
    }

    // Fetch the latest location log
    public function getLatestLocationLog()
    {
        return LocationLog::orderBy('logged_at', 'desc')->first();
    }

    // Fetch newborn, mother, and medication details based on RFID UID
    public function fetchInfo(Request $request)
    {
        $request->validate([
            'rfid_uid' => 'required|string',
        ]);

        $newborn = Newborn::with(['mother', 'medicationAdministrations'])
            ->where('rfid_uid', $request->rfid_uid)
            ->first();

        if (!$newborn) {
            return redirect()->back()->with('error', 'No data found for the provided RFID UID.');
        }

        return view('auth.info', compact('newborn'));
    }
}