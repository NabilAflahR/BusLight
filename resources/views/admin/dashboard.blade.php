@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-6">

    <h1 class="text-4xl font-bold text-blue-700 mb-8 text-center">Dashboard Admin</h1>

    {{-- Statistik Utama --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-3xl font-extrabold text-blue-700">{{ \App\Models\Bus::count() }}</h2>
            <p class="text-gray-600">Total Bus</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-3xl font-extrabold text-blue-700">{{ \App\Models\Schedule::count() }}</h2>
            <p class="text-gray-600">Total Jadwal</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-3xl font-extrabold text-blue-700">{{ \App\Models\User::count() }}</h2>
            <p class="text-gray-600">Total Pengguna</p>
        </div>
    </div>

    {{-- Daftar Bus --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Daftar Bus</h2>
            <a href="{{ route('admin.buses.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + Tambah Bus
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-blue-100 text-blue-800">
                    <tr>
                        <th class="py-3 px-4 text-left">No</th>
                        <th class="py-3 px-4 text-left">Nama Bus</th>
                        <th class="py-3 px-4 text-left">Nomor Lisensi</th>
                        <th class="py-3 px-4 text-left">Kapasitas</th>
                        <th class="py-3 px-4 text-left">Tipe</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($buses as $bus)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4">{{ $bus->name }}</td>
                            <td class="py-3 px-4">{{ $bus->no_license }}</td>
                            <td class="py-3 px-4">{{ $bus->capacity }}</td>
                            <td class="py-3 px-4">{{ $bus->type }}</td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('admin.buses.edit', $bus->id) }}" class="text-blue-600 hover:underline">Edit</a> |
                                <form action="{{ route('admin.buses.destroy', $bus->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Jadwal Bus --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Daftar Jadwal</h2>
            <a href="{{ route('admin.schedules.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                + Tambah Jadwal
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-blue-100 text-blue-800">
                    <tr>
                        <th class="py-3 px-4 text-left">Bus</th>
                        <th class="py-3 px-4 text-left">Rute</th>
                        <th class="py-3 px-4 text-left">Waktu Berangkat</th>
                        <th class="py-3 px-4 text-left">Harga</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $schedule->bus->name }}</td>
                            <td class="py-3 px-4">{{ $schedule->route->origin }} → {{ $schedule->route->destination }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('d M Y H:i') }}</td>
                            <td class="py-3 px-4">Rp{{ number_format($schedule->price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="text-blue-600 hover:underline">Edit</a> |
                                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
