<?php

namespace App\Http\Controllers;
use App\Models\MenstrualRecord;
use App\Models\QadaLog;
use Illuminate\Http\Request;

class MenstrualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // Fetch all records from db sorted by newest first
        $menstrual_records = MenstrualRecord::orderBy('start_datetime', 'desc')->get();

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
        'start_datetime' => 'required|date',
    ]);

    // Create and save the new record in your database
    MenstrualRecord::create([
        'start_datetime' => $request->start_datetime,
        
        // ✨ THE FIX: Tries to grab the logged-in user ID. 
        // If you aren't logged in yet during development, it falls back to User ID 1!
        'user_id'        => auth()->id() ?? 1, 
    ]);

        return redirect()->route('dashboard')->with('success', 'Period record logged successfully!');

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
        // Find the record belonging to this user
    $record = MenstrualRecord::where('user_id', auth()->id())->find($id);
    
    // If no active record exists for this ID, redirect to dashboard with a helper message
     if (!$record) {
        return redirect()->route('dashboard')->with('info', 'No active cycle found to end. Please start a period first!');
    }
    
        return view('edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
      
    $record = MenstrualRecord::where('user_id', auth()->id())->findOrFail($id);

    $request->validate([
        'end_datetime' => 'required|date|before_or_equal:now',
    ]);

    $record->update([
        'end_datetime' => $request->end_datetime,
    ]);

    return redirect()->route('dashboard')->with('success', 'Period end logged successfully. You are now clean!');
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
    // JAKIM API INTEGRATION & LOGIC
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
    public function dashboard()
{
    $userId = auth()->id();

    // 1. Check if there is an active ongoing period
    $activeRecord = MenstrualRecord::where('user_id', $userId)
        ->whereNull('end_datetime')
        ->first();

    // 2. Calculate Days of Purity (Hari Suci) since the last period ended
    $daysOfPurity = 0;
    $isClean = true;

    if ($activeRecord) {
        $isClean = false;
    } else {
        $lastEndedRecord = MenstrualRecord::where('user_id', $userId)
            ->whereNotNull('end_datetime')
            ->orderBy('end_datetime', 'desc')
            ->first();

        if ($lastEndedRecord) {
            // Count days between the last end_datetime and right now
            $daysOfPurity = now()->diffInDays(\Carbon\Carbon::parse($lastEndedRecord->end_datetime));
        }
    }

    // 3. Count unresolved Qada' prayers from the database logs
    $pendingQadaCount = QadaLog::where('user_id', $userId)
        ->where('is_completed', false);

    return view('dashboard', compact('activeRecord', 'daysOfPurity', 'isClean', 'pendingQadaCount'));
}
}
