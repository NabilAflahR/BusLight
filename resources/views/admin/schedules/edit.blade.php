@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-blue-700 mb-6">Edit Jadwal</h1>

    <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 mb-2">Pilih Bus</label>
            <select name="bus_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}" {{ $schedule->bus_id == $bus->id ? 'selected' : '' }}>
                        {{ $bus->name }} ({{ $bus->no_license }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700 mb-2">Pilih Rute</label>
            <select name="route_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
                @foreach($routes as $route)
                    <option value="{{ $route->id }}" {{ $schedule->route_id == $route->id ? 'selected' : '' }}>
                        {{ $route->origin }} → {{ $route->destination }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700 mb-2">Waktu Keberangkatan</label>
            <input type="datetime-local" name="departure_time" 
                   value="{{ \Carbon\Carbon::parse($schedule->departure_time)->format('Y-m-d\TH:i') }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-2">Harga Tiket (Rp)</label>
            <input type="number" name="price" value="{{ $schedule->price }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.schedules.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
        </div>
    </form>
</div>
@endsection
