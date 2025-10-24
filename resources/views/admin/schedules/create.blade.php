@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-blue-700 mb-6">Tambah Jadwal Baru</h1>

    <form action="{{ route('admin.schedules.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700 mb-2">Pilih Bus</label>
            <select name="bus_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
                <option value="">-- Pilih Bus --</option>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}">{{ $bus->name }} ({{ $bus->no_license }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700 mb-2">Pilih Rute</label>
            <select name="route_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
                <option value="">-- Pilih Rute --</option>
                @foreach($routes as $route)
                    <option value="{{ $route->id }}">{{ $route->origin }} → {{ $route->destination }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700 mb-2">Waktu Keberangkatan</label>
            <input type="datetime-local" name="departure_time" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-2">Harga Tiket (Rp)</label>
            <input type="number" name="price" min="0" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.schedules.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection
