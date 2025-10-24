@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <h1 class="text-2xl font-bold text-blue-700 mb-4">Tambah Bus</h1>

    <form action="{{ route('admin.buses.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        <div>
            <label class="block text-gray-700">Nama Bus</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>
        <div>
            <label class="block text-gray-700">Nomor Polisi</label>
            <input type="text" name="no_license" class="w-full border rounded p-2" required>
        </div>
        <div>
            <label class="block text-gray-700">Kapasitas</label>
            <input type="number" name="capacity" class="w-full border rounded p-2" required>
        </div>
        <div>
            <label class="block text-gray-700">Tipe</label>
            <input type="text" name="type" class="w-full border rounded p-2" required>
        </div>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </form>
</div>
@endsection
