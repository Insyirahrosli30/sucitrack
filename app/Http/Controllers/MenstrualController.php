<?php

namespace App\Http\Controllers;

use App\Models\MenstrualRecord;
use App\Models\QadaLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class MenstrualController extends Controller
{
    public function index()
    {
        $menstrual_records = MenstrualRecord::where('user_id', auth()->id())
            ->orderBy('start_datetime', 'desc')
            ->get();

        return view('menstrual_records.index', compact('menstrual_records'));
    }

    public function create()
    {
        return view('menstrual_records.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_datetime' => 'required|date',
        ]);

        MenstrualRecord::create([
            'start_datetime' => $request->start_datetime,
            'user_id' => auth()->id(),
            'end_datetime' => null,
        ]);

        return redirect()->route('menstrual_records.index')
            ->with('success', 'Period started successfully.');
    }

    public function edit(string $id)
    {
        $record = MenstrualRecord::where('user_id', auth()->id())
            ->findOrFail($id);

        return view('menstrual_records.edit', compact('record'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
        ]);

        $record = MenstrualRecord::where('user_id', auth()->id())
            ->findOrFail($id);

        $record->update([
            'end_datetime' => $request->end_datetime,
        ]);

        QadaLog::where('menstrual_record_id', $record->id)->delete();

        $this->generateQada($record);

        return redirect()->route('menstrual_records.index')
            ->with('success', 'Cycle ended and Qada generated successfully.');
    }

    public function destroy(string $id)
    {
        $record = MenstrualRecord::where('user_id', auth()->id())
            ->findOrFail($id);

        QadaLog::where('menstrual_record_id', $record->id)->delete();

        $record->delete();

        return redirect()->route('menstrual_records.index')
            ->with('success', 'Record deleted successfully.');
    }

    public function dashboard()
    {
        $userId = auth()->id();

        $activeRecord = MenstrualRecord::where('user_id', $userId)
            ->whereNull('end_datetime')
            ->latest()
            ->first();

        $isClean = !$activeRecord;

        $lastEndedRecord = MenstrualRecord::where('user_id', $userId)
            ->whereNotNull('end_datetime')
            ->orderBy('end_datetime', 'desc')
            ->first();

        $daysOfPurity = $lastEndedRecord
            ? now()->diffInDays(Carbon::parse($lastEndedRecord->end_datetime))
            : 0;

        $pendingQadaCount = QadaLog::where('user_id', $userId)
            ->where('is_completed', false)
            ->count();

        $completedQadaCount = QadaLog::where('user_id', $userId)
            ->where('is_completed', true)
            ->count();

        return view('dashboard', compact(
            'activeRecord',
            'daysOfPurity',
            'isClean',
            'pendingQadaCount',
            'completedQadaCount'
        ));
    }

    // =========================
    // QADA ENGINE
    // =========================

    private function generateQada(MenstrualRecord $record)
    {
        $start = Carbon::parse($record->start_datetime);
        $end = Carbon::parse($record->end_datetime);

        $periodDays = [];
        $current = $start->copy();

        while ($current->lte($end)) {
            $periodDays[] = $current->toDateString();
            $current->addDay();
        }

        foreach ($periodDays as $date) {

            $prayerTimes = $this->getPrayerTimes($date);

            if (!$prayerTimes) {
                continue;
            }

            foreach ($prayerTimes as $prayerName => $time) {

                if (!$time) continue;

                $prayerDateTime = Carbon::parse($date . ' ' . $time);

                $diffMinutes = $prayerDateTime->diffInMinutes($start, false);

                if ($prayerDateTime->lessThan($start) && $diffMinutes >= 10) {

                    QadaLog::firstOrCreate([
                        'user_id' => auth()->id(),
                        'menstrual_record_id' => $record->id,
                        'qada_date' => $date,
                        'prayer_type' => $prayerName,
                    ], [
                        'is_completed' => false,
                        'notes' => 'Auto-generated from menstrual cycle'
                    ]);
                }
            }
        }
    }

    private function getPrayerTimes($date)
    {
        $response = Http::timeout(10)->get(
            "https://api.aladhan.com/v1/timingsByCity",
            [
                'city' => 'Kuala Lumpur',
                'country' => 'Malaysia',
                'method' => 2,
                'date' => Carbon::parse($date)->format('d-m-Y'),
            ]
        );

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        if (!isset($data['data']['timings'])) {
            return null;
        }

        $t = $data['data']['timings'];

        return [
            'Subuh'   => substr($t['Fajr'], 0, 5),
            'Zohor'   => substr($t['Dhuhr'], 0, 5),
            'Asar'    => substr($t['Asr'], 0, 5),
            'Maghrib' => substr($t['Maghrib'], 0, 5),
            'Isyak'   => substr($t['Isha'], 0, 5),
        ];
    }

    public function endCycle()
    {
        $record = MenstrualRecord::where('user_id', auth()->id())
            ->whereNull('end_datetime')
            ->latest()
            ->first();

        if (!$record) {
            return redirect()->route('menstrual_records.index')
                ->with('error', 'No active cycle. Please start a cycle first.');
        }

        return redirect()->route('menstrual_records.edit', $record->id);
    }
}