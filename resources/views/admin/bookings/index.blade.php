@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 px-6">

    <h1 class="text-4xl font-bold text-blue-700 mb-8 text-center">Manajemen Booking</h1>

    {{-- Statistik Singkat --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-2xl font-bold text-blue-700">{{ \App\Models\Booking::count() }}</h2>
            <p class="text-gray-600">Total Booking</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-2xl font-bold text-green-600">{{ \App\Models\Booking::where('status','paid')->count() }}</h2>
            <p class="text-gray-600">Selesai Dibayar</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-2xl font-bold text-yellow-500">{{ \App\Models\Booking::where('status','pending')->count() }}</h2>
            <p class="text-gray-600">Menunggu Pembayaran</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow text-center">
            <h2 class="text-2xl font-bold text-red-600">{{ \App\Models\Booking::where('status','cancelled')->count() }}</h2>
            <p class="text-gray-600">Dibatalkan</p>
        </div>
    </div>

    {{-- Tabel Booking --}}
    <div class="bg-white rounded-2xl shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Daftar Booking</h2>
            <form method="GET" action="{{ route('admin.bookings.index') }}" class="flex space-x-2">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-200"
                    placeholder="Cari nama pengguna atau kode booking...">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-blue-100 text-blue-800">
                    <tr>
                        <th class="py-3 px-4 text-left">Kode</th>
                        <th class="py-3 px-4 text-left">Nama Pengguna</th>
                        <th class="py-3 px-4 text-left">Rute</th>
                        <th class="py-3 px-4 text-left">Tanggal</th>
                        <th class="py-3 px-4 text-right">Total Harga</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-3 px-4 font-mono text-sm">{{ $booking->booking_code }}</td>
                            <td class="py-3 px-4">{{ $booking->user->name }}</td>
                            <td class="py-3 px-4">
                                {{ $booking->schedule->route->origin }} → {{ $booking->schedule->route->destination }}
                            </td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('d M Y H:i') }}</td>
                            <td class="py-3 px-4 text-right">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-center">
                                @if ($booking->status == 'paid')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Dibayar</span>
                                @elseif ($booking->status == 'pending')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm">Menunggu</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Dibatalkan</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center space-x-2">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                    class="text-blue-600 hover:underline">Detail</a> |
                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline"
                                        onclick="return confirm('Yakin ingin menghapus booking ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
