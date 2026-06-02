<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PrayerController extends Controller
{
    public function index()
    {
        // Rawang, Selangor code in JAKIM API = SG01 (commonly used)
        $response = Http::get('https://api.waktusolat.app/v2/solat/SG01');

        if ($response->successful()) {
            $data = $response->json();

            return view('dashboard', [
                'prayer' => $data['data'] ?? null
            ]);
        }

        return view('dashboard', [
            'prayer' => null
        ]);
    }
}
