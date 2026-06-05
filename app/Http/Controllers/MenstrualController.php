<?php

namespace App\Http\Controllers;

use App\Models\MenstrualRecords; // Corrected plural model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        MenstrualRecords::create([
            'user_id' => Auth::id(),
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
        ]);

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

        return redirect()->route('menstrual_records.index')->with('success', 'Record updated successfully.');
    }

    public function destroy($id)
    {
        $record = MenstrualRecords::where('user_id', Auth::id())->findOrFail($id);
        $record->delete();

        return redirect()->route('menstrual_records.index')->with('success', 'Record deleted successfully.');
    }
}