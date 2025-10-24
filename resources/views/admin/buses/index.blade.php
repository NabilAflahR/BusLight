@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10">
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold text-blue-700">Daftar Bus</h1>
        <a href="{{ route('admin.buses.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">+ Tambah Bus</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                    <th class="p-3">#</th>
                    <th class="p-3">Nama Bus</th>
                    <th class="p-3">Nomor Polisi</th>
                    <th class="p-3">Kapasitas</th>
                    <th class="p-3">Tipe</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buses as $bus)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $loop->iteration }}</td>
                    <td class="p-3 font-semibold">{{ $bus->name }}</td>
                    <td class="p-3">{{ $bus->no_license }}</td>
                    <td class="p-3">{{ $bus->capacity }}</td>
                    <td class="p-3">{{ $bus->type }}</td>
                    <td class="p-3 text-center">
                        <a href="{{ route('admin.buses.edit', $bus->id) }}" class="text-blue-600 hover:underline">Edit</a> |
                        <form action="{{ route('admin.buses.destroy', $bus->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline" onclick="return confirm('Yakin hapus bus ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
