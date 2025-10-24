<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Route;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['bus', 'route'])->paginate(10);
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $buses = Bus::all();
        $routes = Route::all();
        return view('admin.schedules.create', compact('buses', 'routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bus_id' => 'required',
            'route_id' => 'required',
            'departure_time' => 'required|date',
            'price' => 'required|numeric',
        ]);
        Schedule::create($request->all());
        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        $buses = Bus::all();
        $routes = Route::all();
        return view('admin.schedules.edit', compact('schedule', 'buses', 'routes'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $schedule->update($request->all());
        return redirect()->route('schedules.index')->with('success', 'Jadwal diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Jadwal dihapus.');
    }
}
