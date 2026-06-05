<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class PrayerController extends Controller
{
    public function index()
    {
        $response = Http::get('https://api.aladhan.com/v1/timingsByCity', [
            'city' => 'Rawang',
            'country' => 'Malaysia',
            'method' => 2
        ]);

        $timings = $response->json()['data']['timings'];

        // keep UI simple
        $prayer = [
            'Fajr' => $timings['Fajr'],
            'Dhuhr' => $timings['Dhuhr'],
            'Asr' => $timings['Asr'],
            'Maghrib' => $timings['Maghrib'],
            'Isha' => $timings['Isha'],
        ];

        // FORCE Malaysia timezone
        $now = Carbon::now('Asia/Kuala_Lumpur');

        // convert prayer times into real Carbon objects today
        $times = [
            'Fajr' => Carbon::createFromFormat('H:i', $timings['Fajr'], 'Asia/Kuala_Lumpur'),
            'Dhuhr' => Carbon::createFromFormat('H:i', $timings['Dhuhr'], 'Asia/Kuala_Lumpur'),
            'Asr' => Carbon::createFromFormat('H:i', $timings['Asr'], 'Asia/Kuala_Lumpur'),
            'Maghrib' => Carbon::createFromFormat('H:i', $timings['Maghrib'], 'Asia/Kuala_Lumpur'),
            'Isha' => Carbon::createFromFormat('H:i', $timings['Isha'], 'Asia/Kuala_Lumpur'),
        ];

        $nextPrayer = 'Fajr';

        foreach ($times as $name => $time) {
            if ($now->lt($time)) {
                $nextPrayer = $name;
                break;
            }
        }

        $labels = [
            'Fajr' => 'Subuh',
            'Dhuhr' => 'Zohor',
            'Asr' => 'Asar',
            'Maghrib' => 'Maghrib',
            'Isha' => 'Isyak',
        ];

        return view('dashboard', compact('prayer', 'nextPrayer', 'labels'));
    }
}