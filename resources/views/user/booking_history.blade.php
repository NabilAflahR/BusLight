@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">🧾 Riwayat Pemesanan Anda</h1>

    @if($bookings->isEmpty())
        <div class="bg-yellow-50 text-yellow-700 border-l-4 border-yellow-400 p-4 rounded-lg text-center">
            <p>Anda belum memiliki riwayat pemesanan.</p>
            <a href="{{ route('landing') }}" class="text-blue-600 font-semibold hover:underline">
                Pesan tiket sekarang →
            </a>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-xl shadow-lg border border-gray-100">
            <table class="min-w-full text-left text-gray-700 border-collapse">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Bus</th>
                        <th class="px-6 py-3">Rute</th>
                        <th class="px-6 py-3">Berangkat</th>
                        <th class="px-6 py-3">Kursi</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-3 font-semibold text-gray-800">
                                #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-3">{{ $booking->schedule->bus->name }}</td>
                            <td class="px-6 py-3">
                                {{ $booking->schedule->route->origin }} → {{ $booking->schedule->route->destination }}
                            </td>
                            <td class="px-6 py-3">
                                {{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('d M Y, H:i') }}
                            </td>
                            <td class="px-6 py-3">
                                @foreach($booking->seats as $seat)
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">
                                        {{ $seat->seat_number }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-3">
                                @if($booking->status === 'paid')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                        Sudah Bayar
                                    </span>
                                @elseif($booking->status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">
                                        Menunggu Pembayaran
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                                        Dibatalkan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center space-x-3">
                                <a href="{{ route('user.tickets.show', $booking->id) }}"
                                   class="text-blue-600 hover:text-blue-800 font-medium underline">
                                   🎟️ Lihat Tiket
                                </a>

                                @if($booking->status === 'pending')
                                    <form action="{{ route('user.bookings.cancel', $booking->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 font-medium underline"
                                            onclick="return confirm('Batalkan tiket ini?')">
                                            ❌ Batalkan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
