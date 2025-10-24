@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-blue-700">Manajemen Jadwal</h1>
        <a href="{{ route('admin.schedules.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
           + Tambah Jadwal
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-left">#</th>
                    <th class="py-3 px-4 text-left">Bus</th>
                    <th class="py-3 px-4 text-left">Rute</th>
                    <th class="py-3 px-4 text-left">Keberangkatan</th>
                    <th class="py-3 px-4 text-left">Harga</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="py-2 px-4">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4">{{ $schedule->bus->name ?? '-' }}</td>
                        <td class="py-2 px-4">
                            {{ $schedule->route->origin ?? '-' }} → {{ $schedule->route->destination ?? '-' }}
                        </td>
                        <td class="py-2 px-4">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('d M Y, H:i') }}</td>
                        <td class="py-2 px-4">Rp {{ number_format($schedule->price, 0, ',', '.') }}</td>
                        <td class="py-2 px-4 text-center">
                            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data jadwal.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $schedules->links() }}
    </div>
</div>
@endsection
