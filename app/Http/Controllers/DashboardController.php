<?php

namespace App\Http\Controllers;
use App\Models\MenstrualRecord;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1. Get the current logged-in user
        $user = auth()->user();

        // 2. Fetch the latest record for this user to check their status
        $activeRecord = MenstrualRecord::where('user_id', $user->id)
        ->orderBy('start_datetime', 'desc')
        ->first();

        // 3. Status Calculations 
        // If there is an active record and no end_datetime, they are currently in 'Haid' state
        $isClean = true; 
        if ($activeRecord && is_null($activeRecord->end_datetime)) {
            $isClean = false;
        }

        // Calculate days of purity or default to 0
        $daysOfPurity = 0;
        if ($isClean && $activeRecord && $activeRecord->end_datetime) {
            $daysOfPurity = now()->diffInDays(\Carbon\Carbon::parse($activeRecord->end_datetime));
        }

        // Mock counter for pending Qada' prayers (Update with your table logic when ready!)
        $pendingQadaCount = 0; 

    
        return view('menstrual_records.dashboard', compact (
             'isClean', 
            'daysOfPurity', 
            'pendingQadaCount', 
            'activeRecord'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
