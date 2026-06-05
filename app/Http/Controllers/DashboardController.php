<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\MenstrualRecords;
use App\Models\QadaLog;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the main integrated tracking dashboard.
     */
    public function index()
    {
        $userId = Auth::id();

        // 1. Get active ongoing period entry
        $activeRecord = MenstrualRecords::where('user_id', $userId)
            ->whereNull('end_datetime')
            ->orderBy('start_datetime', 'desc')
            ->first();

        // 2. Count purity days
        $daysOfPurity = 0;
        $isClean = true;

        if ($activeRecord) {
            $isClean = false;
        } else {
            $lastEndedRecord = MenstrualRecords::where('user_id', $userId)
                ->whereNotNull('end_datetime')
                ->orderBy('end_datetime', 'desc')
                ->first();

            if ($lastEndedRecord) {
                $daysOfPurity = now()->diffInDays(Carbon::parse($lastEndedRecord->end_datetime));
            }
        }

        // 3. Outstanding Qada obligations counter
        $pendingQadaCount = QadaLog::where('user_id', $userId)
            ->where('is_completed', false)
            ->count();

        // 4. Gather ALL historic rows as a clean collection array to send to JS
       // New Line 43 
$allRecords = MenstrualRecords::where('user_id', $userId)
    ->get(['start_datetime as start', 'end_datetime as end', 'start_datetime', 'end_datetime']);

        // 5. API Prayer Timings Fetch (Rawang / Malaysia default setup)
        $prayer = [
            'Fajr' => '05:41', 'Dhuhr' => '13:12', 'Asr' => '16:38', 'Maghrib' => '19:24', 'Isha' => '20:39'
        ];
        $nextPrayer = 'Fajr';

        try {
            $response = Http::timeout(3)->get('https://api.aladhan.com/v1/timingsByCity', [
                'city' => 'Rawang',
                'country' => 'Malaysia',
                'method' => 2
            ]);

            if ($response->successful()) {
                $timings = $response->json()['data']['timings'];
                $prayer = [
                    'Fajr'    => $timings['Fajr'],
                    'Dhuhr'   => $timings['Dhuhr'],
                    'Asr'     => $timings['Asr'],
                    'Maghrib' => $timings['Maghrib'],
                    'Isha'    => $timings['Isha'],
                ];
            }
        } catch (\Exception $e) {
            // Reverts safely if network times out
        }

        $now = Carbon::now('Asia/Kuala_Lumpur');
        $times = [
            'Fajr'    => Carbon::createFromFormat('H:i', $prayer['Fajr'], 'Asia/Kuala_Lumpur'),
            'Dhuhr'   => Carbon::createFromFormat('H:i', $prayer['Dhuhr'], 'Asia/Kuala_Lumpur'),
            'Asr'     => Carbon::createFromFormat('H:i', $prayer['Asr'], 'Asia/Kuala_Lumpur'),
            'Maghrib' => Carbon::createFromFormat('H:i', $prayer['Maghrib'], 'Asia/Kuala_Lumpur'),
            'Isha'    => Carbon::createFromFormat('H:i', $prayer['Isha'], 'Asia/Kuala_Lumpur'),
        ];

        foreach ($times as $name => $time) {
            if ($now->lt($time)) {
                $nextPrayer = $name;
                break;
            }
        }

        $labels = [
            'Fajr' => 'Subuh', 'Dhuhr' => 'Zohor', 'Asr' => 'Asar', 'Maghrib' => 'Maghrib', 'Isha' => 'Isyak'
        ];

        // Directs Laravel to locate the template within the subfolder layout
        return view('menstrual_records.dashboard', compact(
            'activeRecord', 
            'daysOfPurity', 
            'isClean', 
            'pendingQadaCount', 
            'allRecords',
            'prayer', 
            'nextPrayer', 
            'labels'
        ));
    }
}