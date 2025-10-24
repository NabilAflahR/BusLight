@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-blue-700">Manajemen Rute</h1>
        <a href="{{ route('admin.routes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">+ Tambah Rute</a>
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
                    <th class="py-3 px-4 text-left">Asal</th>
                    <th class="py-3 px-4 text-left">Tujuan</th>
                    <th class="py-3 px-4 text-left">Jarak (KM)</th>
                    <th class="py-3 px-4 text-left">Durasi</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($routes as $route)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="py-2 px-4">{{ $loop->iteration }}</td>
                        <td class="py-2 px-4">{{ $route->origin }}</td>
                        <td class="py-2 px-4">{{ $route->destination }}</td>
                        <td class="py-2 px-4">{{ $route->distance_km }} km</td>
                        <td class="py-2 px-4">{{ $route->duration }}</td>
                        <td class="py-2 px-4 text-center">
                            <a href="{{ route('admin.routes.edit', $route->id) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                            <form action="{{ route('admin.routes.destroy', $route->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus rute ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Belum ada data rute.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $routes->links() }}
    </div>
</div>
@endsection
