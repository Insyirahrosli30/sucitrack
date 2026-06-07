<?php

namespace App\Http\Controllers;

use App\Models\MenstrualRecord;
use App\Models\QadaLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $activeRecord = MenstrualRecord::where('user_id', $userId)
            ->orderBy('start_datetime', 'desc')
            ->first();

        // ------------------------------------------------------------
        // LOGIK A: HARI SUCI
        // ------------------------------------------------------------
        $latestRecords = MenstrualRecord::where('user_id', $userId)
            ->orderBy('start_datetime', 'desc')
            ->take(2)
            ->get();

        $daysOfPurity = 0;
        $isClean = true;

        if ($latestRecords->count() > 0) {

            $currentRecord = $latestRecords->first();

            if (is_null($currentRecord->end_datetime)) {

                $isClean = false;
                $daysOfPurity = 0;

            } else {

                if ($latestRecords->count() == 2) {

                    $previousRecord = $latestRecords->skip(1)->first();

                    if ($previousRecord && $previousRecord->end_datetime) {

                        $startOfNew = Carbon::parse($currentRecord->start_datetime);
                        $endOfLast = Carbon::parse($previousRecord->end_datetime);

                        $daysOfPurity = $endOfLast->diffInDays($startOfNew);
                    }

                } else {

                    $daysOfPurity = Carbon::parse($currentRecord->end_datetime)
                        ->diffInDays(now());
                }
            }
        }

        // ------------------------------------------------------------
        // PRAYER TIMES
        // ------------------------------------------------------------
        $prayer = $this->getTodayPrayerTimes();

        if (!$prayer) {
            $prayer = [
                'Subuh'   => '05:41',
                'Zohor'   => '13:12',
                'Asar'    => '16:38',
                'Maghrib' => '19:24',
                'Isya'    => '20:39',
            ];
        }

        // ------------------------------------------------------------
        // QADA CALCULATION
        // ------------------------------------------------------------
        $calculated = [
            'Subuh' => 0,
            'Zohor' => 0,
            'Asar' => 0,
            'Maghrib' => 0,
            'Isya' => 0,
        ];

        $allRecords = MenstrualRecord::where('user_id', $userId)->get();

        foreach ($allRecords as $record) {

            if (!$record->end_datetime) continue;

            $start = Carbon::parse($record->start_datetime);
            $end = Carbon::parse($record->end_datetime);

            foreach ($prayer as $name => $time) {

                if (!$time) continue;

                $startTime = Carbon::parse($start->toDateString() . ' ' . $time);
                $endTime = Carbon::parse($end->toDateString() . ' ' . $time);

                if ($start->lte($endTime) && $end->gte($startTime)) {
                    $calculated[$name]++;
                }
            }
        }

        // ------------------------------------------------------------
        // COMPLETED QADA
        // ------------------------------------------------------------
        $completedLogs = QadaLog::where('user_id', $userId)
            ->where('is_completed', true)
            ->selectRaw('prayer_type, count(*) as total')
            ->groupBy('prayer_type')
            ->pluck('total', 'prayer_type')
            ->toArray();

        $final = [];

        foreach ($calculated as $key => $value) {
            $final[$key] = max(0, $value - ($completedLogs[$key] ?? 0));
        }

        // ------------------------------------------------------------
        // PENDING QADA
        // ------------------------------------------------------------
        $pendingQadaItems = QadaLog::where('user_id', $userId)
            ->where('is_completed', false)
            ->orderBy('qada_date', 'asc')
            ->get();

        $pendingQadaCount = $pendingQadaItems->count();

        // ------------------------------------------------------------
        // NEXT PRAYER (FIXED REAL TIME)
        // ------------------------------------------------------------
        $now = Carbon::now();

        $nextPrayer = null;
        $smallestDiff = null;

        foreach ($prayer as $name => $time) {

            if (!$time) continue;

            // IMPORTANT FIX: bind prayer time to TODAY date
            $prayerTime = Carbon::createFromFormat(
                'Y-m-d H:i',
                now()->format('Y-m-d') . ' ' . $time
            );

            if ($prayerTime->lt($now)) continue;

            $diff = $now->diffInMinutes($prayerTime, false);

            if ($smallestDiff === null || $diff < $smallestDiff) {
                $smallestDiff = $diff;
                $nextPrayer = $name;
            }
        }

        // fallback (important for midnight case)
        if (!$nextPrayer) {
            $nextPrayer = 'Subuh';
        }

        $labels = [
            'Subuh' => 'Subuh',
            'Zohor' => 'Zohor',
            'Asar' => 'Asar',
            'Maghrib' => 'Maghrib',
            'Isya' => 'Isyak',
        ];

        return view('dashboard', compact(
            'activeRecord',
            'daysOfPurity',
            'isClean',
            'pendingQadaCount',
            'pendingQadaItems',
            'allRecords',
            'prayer',
            'nextPrayer',
            'labels',
            'final'
        ));
    }

    public function completeQada($id)
    {
        $log = QadaLog::where('user_id', Auth::id())
            ->findOrFail($id);

        $log->update([
            'is_completed' => true
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Qada prayer marked as completed!');
    }

    private function getTodayPrayerTimes()
    {
        $response = Http::timeout(10)
            ->get("https://api.waktusolat.app/v2/solat/KUL");

        if (!$response->successful()) return null;

        $data = $response->json();

        $today = now()->toDateString();

        foreach ($data['prayerTime'] ?? [] as $day) {

            if (($day['date'] ?? null) === $today) {

                return [
                    'Subuh'   => substr($day['fajr'], 0, 5),
                    'Zohor'   => substr($day['dhuhr'], 0, 5),
                    'Asar'    => substr($day['asr'], 0, 5),
                    'Maghrib' => substr($day['maghrib'], 0, 5),
                    'Isya'    => substr($day['isha'], 0, 5),
                ];
            }
        }

        return null;
    }
}