<?php

namespace App\Http\Controllers;
use App\Models\MenstrualRecord;
use Illuminate\Http\Request;

class MenstrualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menstrual_records = MenstrualRecord::all();
       /* $menstrual_records = MenstrualRecord::where('user_id', auth()->id())
            ->orderBy('started_at', 'desc'); */

        return view('menstrual_records.index', compact('menstrual_records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menstrual_records.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'started_at' => 'required|date|before_or_equal:now',
            'zone_code'  => 'required|string|max:10',
        ]);

        //Ensure user cannot log parallel active cycles
        $activeRecord = menstrual_records::where('user_id', auth()->id())
            ->whereNull('ended_at')
            ->first();

        if ($activeRecord) {
            return redirect()->back()->with('error', 'An ongoing menstrual cycle is already active.');
        }

        menstrual_records::create([
            'user_id'    => auth()->id(),
            'started_at' => Carbon::parse($request->started_at),
            'zone_code'  => $request->zone_code,
        ]);

        return redirect()->route('menstrual_records.index')->with('status', 'New cycle successfully logged.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = menstrual_records::where('user_id', auth()->id())->findOrFail($id);
        return view('menstrual_records.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = menstrual_records::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'started_at' => 'required|date',
            'ended_at'   => 'nullable|date|after:started_at|before_or_equal:now',
        ]);

        $record->started_at = Carbon::parse($request->started_at);
        
        // Execute dynamic API lookup if ending cycle
        if ($request->filled('ended_at')) {
            $endTime = Carbon::parse($request->ended_at);
            $record->ended_at = $endTime;

            $prayerTimes = $this->fetchJakimPrayerTimes($record->zone_code, $endTime->toDateString());
            
            if ($prayerTimes) {
                $parsedTimes = $this->parsePrayerTimestamps($endTime->toDateString(), $prayerTimes);
                $evaluation = $this->evaluateQadaRequirements($endTime, $parsedTimes);

                // Commit outstanding requirements to Qada logs table
                foreach ($evaluation['prayers_to_perform'] as $prayer) {
                    QadaLog::firstOrCreate([
                        'user_id'            => auth()->id(),
                        'menstrual_record_id'=> $record->id, // Adjusted matching key
                        'prayer_name'        => $prayer,
                        'is_completed'       => false,
                        'missed_date'        => $endTime->toDateString()
                    ]);
                }
                $record->qada_calculated = true;
                session()->flash('evaluation', $evaluation);
            }
        }

        $record->save();

        return redirect()->route('menstrual_records.index')->with('status', 'Record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = menstrual_records::where('user_id', auth()->id())->findOrFail($id);
        
        // Safety step: clear dependent records first if foreign constraint isn't cascading
        QadaLog::where('menstrual_record_id', $record->id)->delete();
        $record->delete();

        return redirect()->route('menstrual_records.index')->with('status', 'Log record successfully deleted.');
    }

    // ==========================================
    // JAKIM API INTEGRATION & JURISPRUDENCE LOGIC
    // ==========================================

    private function fetchJakimPrayerTimes($zone, $date)
    {
        $response = Http::get("https://solatapi.fajarhac.com/v2/solat/{$zone}");
        if ($response->successful()) {
            $data = $response->json();
            foreach ($data['prayerTime'] as $timeSlot) {
                if (Carbon::parse($timeSlot['date'])->toDateString() === $date) {
                    return $timeSlot;
                }
            }
        }
        return null;
    }

    private function parsePrayerTimestamps($dateString, $times)
    {
        return [
            'fajr'    => Carbon::parse($dateString . ' ' . $times['fajr']),
            'dhuhr'   => Carbon::parse($dateString . ' ' . $times['dhuhr']),
            'asr'     => Carbon::parse($dateString . ' ' . $times['asr']),
            'maghrib' => Carbon::parse($dateString . ' ' . $times['maghrib']),
            'isha'    => Carbon::parse($dateString . ' ' . $times['isha']),
        ];
    }

    private function evaluateQadaRequirements(Carbon $endTime, array $prayers)
    {
        $prayersToPerform = [];
        $message = "";

        if ($endTime->between($prayers['fajr'], $prayers['dhuhr'])) {
            $prayersToPerform[] = 'Fajr';
            $message = "Your period ended during the Fajr window. You must perform Fajr immediately.";
        } elseif ($endTime->between($prayers['dhuhr'], $prayers['asr'])) {
            $prayersToPerform[] = 'Dhuhr';
            $message = "Your period ended during the Dhuhr window. You must perform Dhuhr immediately.";
        } elseif ($endTime->between($prayers['asr'], $prayers['maghrib'])) {
            $prayersToPerform[] = 'Asr';
            $prayersToPerform[] = 'Dhuhr'; 
            $message = "Your period ended during Asr. You must perform Asr and make up (Qada') Zuhr.";
        } elseif ($endTime->between($prayers['maghrib'], $prayers['isha'])) {
            $prayersToPerform[] = 'Maghrib';
            $message = "Your period ended during the Maghrib window. You must perform Maghrib immediately.";
        } else {
            $prayersToPerform[] = 'Isha';
            $prayersToPerform[] = 'Maghrib'; 
            $message = "Your period ended during Isha. You must perform Isha and make up (Qada') Maghrib.";
        }

        return [
            'prayers_to_perform' => $prayersToPerform,
            'message' => $message,
            'purified_at' => $endTime->toDayDateTimeString()
        ];
    }
}
