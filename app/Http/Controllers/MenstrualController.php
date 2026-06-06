<?php

namespace App\Http\Controllers;

use App\Models\MenstrualRecords; 
use App\Models\QadaLog; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MenstrualController extends Controller
{
    public function index()
    {
        $records = MenstrualRecords::where('user_id', Auth::id())
            ->orderBy('start_datetime', 'desc')
            ->get();
            
        return view('menstrual_records.index', compact('records'));
    }

    public function create()
    {
        return view('menstrual_records.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_datetime' => 'required|date',
            'end_datetime' => 'nullable|date|after:start_datetime',
        ]);

        $record = MenstrualRecords::create([
            'user_id' => Auth::id(),
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
        ]);

        if ($record->end_datetime) {
            $this->generateQadaLogs($record);
        }

        return redirect()->route('menstrual_records.index')->with('success', 'Record created successfully.');
    }

    public function edit($id)
    {
        $menstrualRecord = MenstrualRecords::where('user_id', Auth::id())->findOrFail($id);
        return view('menstrual_records.edit', compact('menstrualRecord'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'start_datetime' => 'required|date',
            'end_datetime' => 'nullable|date|after:start_datetime',
        ]);

        $record = MenstrualRecords::where('user_id', Auth::id())->findOrFail($id);
        $record->update([
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
        ]);

        if ($record->end_datetime) {
            $this->generateQadaLogs($record);
        }

        return redirect()->route('menstrual_records.index')->with('success', 'Record updated successfully.');
    }

    public function destroy($id)
    {
        $record = MenstrualRecords::where('user_id', Auth::id())->findOrFail($id);
        
        // Padam log qada berkait jika rekod kitaran ini dipadam
        QadaLog::where('user_id', Auth::id())
            ->whereBetween('missed_date', [
                Carbon::parse($record->start_datetime)->startOfDay(), 
                Carbon::parse($record->end_datetime ?? now())->endOfDay()
            ])->delete();

        $record->delete();

        return redirect()->route('menstrual_records.index')->with('success', 'Record deleted successfully.');
    }

    public function logEndDate(Request $request, $id)
    {
        $request->validate([
            'end_datetime' => 'required|date|after:start_datetime',
        ]);

        $record = MenstrualRecords::where('user_id', Auth::id())->findOrFail($id);
        
        $record->update([
            'end_datetime' => $request->end_datetime,
        ]);

        $this->generateQadaLogs($record);

        return redirect()->route('menstrual_records.index')->with('success', 'Cycle recovery timestamp recorded.');
    }

    /**
     * PRIVATE ENGINE: Menjana tugasan qada' berdasarkan Fiqh Shafi'i
     */
    private function generateQadaLogs($record)
    {
        // Bersihkan log tidak selesai yang lama menggunakan missed_date untuk elak duplikasi jika dikemaskini
        QadaLog::where('user_id', $record->user_id)
            ->where('is_completed', false)
            ->whereBetween('missed_date', [
                Carbon::parse($record->start_datetime)->startOfDay(), 
                Carbon::parse($record->end_datetime)->endOfDay()
            ])->delete();

        $prayer = [
            'Fajr' => '05:41', 'Dhuhr' => '13:12', 'Asr' => '16:38', 'Maghrib' => '19:24', 'Isha' => '20:39'
        ];

        $start = Carbon::parse($record->start_datetime);
        $end = Carbon::parse($record->end_datetime);

        // 1. SEMAK WAKTU MULA (Hutang waktu mula keluar darah)
        $fajrStart    = Carbon::parse($start->format('Y-m-d') . ' ' . $prayer['Fajr']);
        $dhuhrStart   = Carbon::parse($start->format('Y-m-d') . ' ' . $prayer['Dhuhr']);
        $asrStart     = Carbon::parse($start->format('Y-m-d') . ' ' . $prayer['Asr']);
        $maghribStart = Carbon::parse($start->format('Y-m-d') . ' ' . $prayer['Maghrib']);
        $ishaStart    = Carbon::parse($start->format('Y-m-d') . ' ' . $prayer['Isha']);

        if ($start->between($fajrStart, $dhuhrStart)) {
            $this->createLog($record->user_id, 'fajr', $start);
        } elseif ($start->between($dhuhrStart, $asrStart)) {
            $this->createLog($record->user_id, 'zuhr', $start);
        } elseif ($start->between($asrStart, $maghribStart)) {
            $this->createLog($record->user_id, 'asr', $start); 
        } elseif ($start->between($maghribStart, $ishaStart)) {
            $this->createLog($record->user_id, 'maghrib', $start);
        } else {
            $this->createLog($record->user_id, 'isha', $start);
        }

        // 2. SEMAK WAKTU TAMAT / SUCI (Kebolehan Jamak Shafi'i)
        $fajrEnd    = Carbon::parse($end->format('Y-m-d') . ' ' . $prayer['Fajr']);
        $dhuhrEnd   = Carbon::parse($end->format('Y-m-d') . ' ' . $prayer['Dhuhr']);
        $asrEnd     = Carbon::parse($end->format('Y-m-d') . ' ' . $prayer['Asr']);
        $maghribEnd = Carbon::parse($end->format('Y-m-d') . ' ' . $prayer['Maghrib']);
        $ishaEnd    = Carbon::parse($end->format('Y-m-d') . ' ' . $prayer['Isha']);

        if ($end->between($fajrEnd, $dhuhrEnd)) {
            $this->createLog($record->user_id, 'fajr', $end);
        } elseif ($end->between($dhuhrEnd, $asrEnd)) {
            $this->createLog($record->user_id, 'zuhr', $end);
        } elseif ($end->between($asrEnd, $maghribEnd)) {
            $this->createLog($record->user_id, 'asr', $end);
            $this->createLog($record->user_id, 'zuhr', $end); 
        } elseif ($end->between($maghribEnd, $ishaEnd)) {
            $this->createLog($record->user_id, 'maghrib', $end);
        } else {
            $this->createLog($record->user_id, 'isha', $end);
            $this->createLog($record->user_id, 'maghrib', $end); 
        }
    }

    /**
     * PEMBETULAN: Memasukkan medan missed_date ke dalam pangkalan data
     */
    private function createLog($userId, $prayerName, $timestamp)
    {
        QadaLog::create([
            'user_id'      => $userId,
            'prayer_name'  => $prayerName,
            'is_completed' => false,
            'missed_date'  => $timestamp->format('Y-m-d'), // Memenuhi keperluan struktur DB anda
            'created_at'   => $timestamp, 
        ]);
    }
}