<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Bus;
use Carbon\Carbon;

class LandingController extends Controller
{
    public function index()
    {
        $busTypes = Bus::select('type')->distinct()->pluck('type');
        return view('landing', compact('busTypes'));
    }

    public function filter(Request $request)
    {
        $busType = $request->get('bus_type');
        $origin = $request->get('origin');
        $destination = $request->get('destination');
        $date = $request->get('date', Carbon::now()->format('Y-m-d'));

        // Cegah booking masa lalu
        if (Carbon::parse($date)->isPast() && $date !== Carbon::now()->format('Y-m-d')) {
            return response()->json(['error' => 'Tidak dapat memesan untuk tanggal yang sudah lewat.'], 400);
        }

        // Ambil daftar asal & tujuan untuk dropdown
        $stops = Route::whereHas('schedules.bus', fn($b) => $b->where('type', $busType))
            ->select('origin', 'destination')
            ->get();

        // Ambil jadwal
        $schedules = Schedule::with(['bus', 'route'])
            ->whereHas('bus', fn($b) => $b->where('type', $busType))
            ->when($origin, fn($q) => $q->whereHas('route', fn($r) => $r->where('origin', $origin)))
            ->when($destination, fn($q) => $q->whereHas('route', fn($r) => $r->where('destination', $destination)))
            ->when($date, fn($q) => $q->whereDate('departure_time', '>=', $date))
            ->get()
            ->map(function ($s) {
                // simulasi data tambahan
                if ($s->bus->type === 'Busway') {
                    $s->stops = ['Halte A', 'Halte B', 'Halte C', 'Halte D'];
                } elseif ($s->bus->type === 'Antar Pulau') {
                    $s->class = ['Ekonomi', 'Bisnis', 'Eksekutif'][rand(0, 2)];
                    $s->long_route = $s->route->origin . ' → ' . 'Kota Transit' . ' → ' . $s->route->destination;
                }
                return $s;
            });

        return response()->json([
            'stops' => $stops->unique('origin')->values(),
            'schedules' => $schedules,
        ]);
    }
}
