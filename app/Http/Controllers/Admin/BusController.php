<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\BusSeat;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::withCount('seats')->get();
        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        return view('admin.buses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_license' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1|max:100',
            'type' => 'nullable|string|max:50',
        ]);

        $bus = Bus::create($request->only('name', 'no_license', 'capacity', 'type'));

        // 🪑 Buat kursi otomatis berdasarkan kapasitas
        for ($i = 1; $i <= $bus->capacity; $i++) {
            BusSeat::create([
                'bus_id' => $bus->id,
                'seat_number' => 'A' . $i,
                'is_available' => true,
            ]);
        }

        return redirect()->route('admin.buses.index')->with('success', 'Bus dan kursi berhasil dibuat!');
    }

    public function edit(Bus $bus)
    {
        return view('admin.buses.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_license' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1|max:100',
            'type' => 'nullable|string|max:50',
        ]);

        $bus->update($request->only('name', 'no_license', 'capacity', 'type'));

        return redirect()->route('admin.buses.index')->with('success', 'Bus berhasil diperbarui!');
    }

    public function destroy(Bus $bus)
    {
        $bus->seats()->delete();
        $bus->delete();

        return redirect()->route('admin.buses.index')->with('success', 'Bus berhasil dihapus!');
    }
}
