<?php

namespace App\Http\Controllers;

use App\Models\MenstrualRecords;
use App\Models\QadaLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // ------------------------------------------------------------
        // LOGIK A: MENGIRA HARI SUCI (DAYS OF PURITY) KRONOLOGI BETUL
        // ------------------------------------------------------------
        $latestRecords = MenstrualRecords::where('user_id', $userId)
            ->orderBy('start_datetime', 'desc')
            ->take(2)
            ->get();

        $daysOfPurity = 0;
        $isClean = true;

        if ($latestRecords->count() > 0) {
            $currentRecord = $latestRecords->first();

            // Jika rekod terbaharu tiada end_datetime, maksudnya user sedang haid sekarang
            if (is_null($currentRecord->end_datetime)) {
                $isClean = false;
                $daysOfPurity = 0; 
            } else {
                // Sempurna: Kira jarak antara kitaran (Start Baru - End Lama)
                if ($latestRecords->count() == 2) {
                    $previousRecord = $latestRecords->skip(1)->first();
                    
                    $startOfNewPeriod = Carbon::parse($currentRecord->start_datetime);
                    $endOfLastPeriod  = Carbon::parse($previousRecord->end_datetime);
                    
                    $daysOfPurity = (int) $endOfLastPeriod->diffInDays($startOfNewPeriod);
                } else {
                    // Fallback: Jika baru ada 1 rekod sahaja dalam sistem, kira dari tarikh tamat hingga sekarang
                    $endOfPeriod = Carbon::parse($currentRecord->end_datetime);
                    $daysOfPurity = (int) $endOfPeriod->diffInDays(now());
                }
            }
        }

        // ------------------------------------------------------------
        // LOGIK B: KIRAAN TEORITIKAL FIQH DI KOTAK KIRI (SUMMARY)
        // ------------------------------------------------------------
        $calculatedFajrCount = 0;
        $calculatedZuhrCount = 0;
        $calculatedAsrCount = 0;
        $calculatedMaghribCount = 0;
        $calculatedIshaCount = 0;

        $prayer = [
            'Fajr' => '05:41', 'Dhuhr' => '13:12', 'Asr' => '16:38', 'Maghrib' => '19:24', 'Isha' => '20:39'
        ];

        $allRecords = MenstrualRecords::where('user_id', $userId)->get();

        foreach ($allRecords as $record) {
            if (!$record->end_datetime) {
                continue;
            }

            $start = Carbon::parse($record->start_datetime);
            $end = Carbon::parse($record->end_datetime);

            // Semakan waktu mula haid
            $fajrStart    = Carbon::parse($start->format('Y-m-d') . ' ' . $prayer['Fajr']);
            $dhuhrStart   = Carbon::parse($start->format('Y-m-d') . ' ' . $prayer['Dhuhr']);
            $asrStart     = Carbon::parse($start->format('Y-m-d') . ' ' . $prayer['Asr']);
            $maghribStart = Carbon::parse($start->format('Y-m-d') . ' ' . $prayer['Maghrib']);
            $ishaStart    = Carbon::parse($start->format('Y-m-d') . ' ' . $prayer['Isha']);

            if ($start->between($fajrStart, $dhuhrStart)) {
                $calculatedFajrCount++;
            } elseif ($start->between($dhuhrStart, $asrStart)) {
                $calculatedZuhrCount++;
            } elseif ($start->between($asrStart, $maghribStart)) {
                $calculatedAsrCount++;
            } elseif ($start->between($maghribStart, $ishaStart)) {
                $calculatedMaghribCount++;
            } else {
                $calculatedIshaCount++;
            }

            // Semakan waktu tamat haid (Kebolehan Jamak Shafi'i)
            $fajrEnd    = Carbon::parse($end->format('Y-m-d') . ' ' . $prayer['Fajr']);
            $dhuhrEnd   = Carbon::parse($end->format('Y-m-d') . ' ' . $prayer['Dhuhr']);
            $asrEnd     = Carbon::parse($end->format('Y-m-d') . ' ' . $prayer['Asr']);
            $maghribEnd = Carbon::parse($end->format('Y-m-d') . ' ' . $prayer['Maghrib']);
            $ishaEnd    = Carbon::parse($end->format('Y-m-d') . ' ' . $prayer['Isha']);

            if ($end->between($fajrEnd, $dhuhrEnd)) {
                $calculatedFajrCount++;
            } elseif ($end->between($dhuhrEnd, $asrEnd)) {
                $calculatedZuhrCount++;
            } elseif ($end->between($asrEnd, $maghribEnd)) {
                $calculatedAsrCount++;
                $calculatedZuhrCount++; 
            } elseif ($end->between($maghribEnd, $ishaEnd)) {
                $calculatedMaghribCount++;
            } else {
                $calculatedIshaCount++;
                $calculatedMaghribCount++; 
            }
        }

        // ------------------------------------------------------------
        // LOGIK C: AMBIL DATA SELESAI & TOLAK (KONSISTEN LOWERCASE)
        // ------------------------------------------------------------
        $completedLogs = QadaLog::where('user_id', $userId)
            ->where('is_completed', true)
            ->selectRaw('prayer_name, count(*) as total')
            ->groupBy('prayer_name')
            ->pluck('total', 'prayer_name')
            ->toArray();

        // Paksa guna lowercase key untuk menyamai standard input baru database
        $finalFajrOwed    = max(0, $calculatedFajrCount - ($completedLogs['fajr'] ?? 0));
        $finalZuhrOwed    = max(0, $calculatedZuhrCount - ($completedLogs['zuhr'] ?? 0));
        $finalAsrOwed     = max(0, $calculatedAsrCount - ($completedLogs['asr'] ?? 0));
        $finalMaghribOwed = max(0, $calculatedMaghribCount - ($completedLogs['maghrib'] ?? 0));
        $finalIshaOwed    = max(0, $calculatedIshaCount - ($completedLogs['isha'] ?? 0));

        // Ambil senarai tugasan interaktif yang belum diselesaikan (Kotak Kanan)
        $pendingQadaItems = QadaLog::where('user_id', $userId)
            ->where('is_completed', false)
            ->orderBy('missed_date', 'asc')
            ->get();

        $pendingQadaCount = $pendingQadaItems->count();

        // Cari waktu solat seterusnya untuk widget dashboard
        $nextPrayer = 'Fajr';
        $currentTime = now()->format('H:i');
        foreach ($prayer as $name => $time) {
            if ($currentTime < $time) {
                $nextPrayer = $name;
                break;
            }
        }

        $labels = [
            'Fajr' => 'Subuh', 'Dhuhr' => 'Zohor', 'Asr' => 'Asar', 'Maghrib' => 'Maghrib', 'Isha' => 'Isyak'
        ];

        return view('menstrual_records.dashboard', compact(
            'daysOfPurity', 'isClean', 'pendingQadaCount', 'nextPrayer', 'prayer', 'labels',
            'finalFajrOwed', 'finalZuhrOwed', 'finalAsrOwed', 'finalMaghribOwed', 'finalIshaOwed',
            'pendingQadaItems', 'allRecords'
        ));
    }

    /**
     * Menyelesaikan tugasan qada' individu apabila butang "Done" ditekan
     */
    public function completeQada($id)
    {
        $log = QadaLog::where('user_id', Auth::id())->findOrFail($id);
        $log->update(['is_completed' => true]);

        return redirect()->route('dashboard')->with('success', 'Qada prayer marked as completed!');
    }
}