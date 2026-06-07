<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QadaLog;

class QadaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $qadaLogs = QadaLog::where('user_id', auth()->id())
            ->orderBy('qada_date', 'desc')
            ->get();

        $pendingQadaCount = QadaLog::where('user_id', auth()->id())
            ->where('is_completed', false)
            ->count();

        $completedQadaCount = QadaLog::where('user_id', auth()->id())
            ->where('is_completed', true)
            ->count();

        return view('indexqada', compact('qadaLogs', 'pendingQadaCount', 'completedQadaCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('createqada');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prayer_type' => 'required|string',
            'qada_date' => 'required|date',
        ]);

        QadaLog::create([
            'user_id' => 1,
            'qada_date' => $request->qada_date,
            'prayer_type' => $request->prayer_type,
            'is_completed' => false,
            'notes' => $request->notes ?? null,
        ]);

        return redirect()->route('qada.index')
            ->with('success', 'Qada log created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $qada = QadaLog::findOrFail($id);

        return view('showqada', compact('qada'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $qada = QadaLog::findOrFail($id);

        return view('editqada', compact('qada'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $qada = QadaLog::findOrFail($id);

        $qada->update([
            'prayer_type' => $request->prayer_type,
            'qada_date' => $request->qada_date,
            'is_completed' => $request->is_completed ?? false,
            'notes' => $request->notes,
        ]);

        return redirect()->route('qada.index')
            ->with('success', 'Qada updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        QadaLog::findOrFail($id)->delete();

        return redirect()->route('qada.index')
            ->with('success', 'Qada deleted successfully');
    }
}