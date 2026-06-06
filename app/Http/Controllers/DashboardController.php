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
        // LOGIK B & C: AMBIL SENARAI DARI DATABASE SECARA TERUS (FIXED)
        // ------------------------------------------------------------
        
        // Ambil jumlah qada yang BELUM diselesaikan dari database (is_completed = false)
        $pendingLogsSummary = QadaLog::where('user_id', $userId)
            ->where('is_completed', false)
            ->selectRaw('prayer_name, count(*) as total')
            ->groupBy('prayer_name')
            ->pluck('total', 'prayer_name')
            ->toArray();

        // Tetapkan nilai paparan untuk ringkasan di kotak kiri menggunakan lowercase keys dari database
        $finalFajrOwed    = $pendingLogsSummary['fajr'] ?? 0;
        $finalZuhrOwed    = $pendingLogsSummary['zuhr'] ?? 0;
        $finalAsrOwed     = $pendingLogsSummary['asr'] ?? 0;
        $finalMaghribOwed = $pendingLogsSummary['maghrib'] ?? 0;
        $finalIshaOwed    = $pendingLogsSummary['isha'] ?? 0;

        // Ambil senarai tugasan interaktif yang belum diselesaikan (Kotak Kanan)
        $pendingQadaItems = QadaLog::where('user_id', $userId)
            ->where('is_completed', false)
            ->orderBy('missed_date', 'asc')
            ->get();

        $pendingQadaCount = $pendingQadaItems->count();

        // Ambil maklumat semua rekod untuk kalendar / js
        $allRecords = MenstrualRecords::where('user_id', $userId)->get();

        // Cari waktu solat seterusnya untuk widget dashboard
        $prayer = [
            'Fajr' => '05:41', 'Dhuhr' => '13:12', 'Asr' => '16:38', 'Maghrib' => '19:24', 'Isha' => '20:39'
        ];

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