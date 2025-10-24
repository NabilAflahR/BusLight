@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-blue-700 mb-6">Edit Rute</h1>

    <form action="{{ route('admin.routes.update', $route->id) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700 mb-2">Asal</label>
            <input type="text" name="origin" value="{{ old('origin', $route->origin) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-2">Tujuan</label>
            <input type="text" name="destination" value="{{ old('destination', $route->destination) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-2">Jarak (KM)</label>
            <input type="number" name="distance_km" value="{{ old('distance_km', $route->distance_km) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
        </div>

        <div>
            <label class="block text-gray-700 mb-2">Durasi</label>
            <input type="text" name="duration" value="{{ old('duration', $route->duration) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200" required>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.routes.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
        </div>
    </form>
</div>
@endsection
