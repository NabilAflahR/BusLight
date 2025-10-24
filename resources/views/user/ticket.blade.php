@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-6">
    <div class="bg-white shadow-xl rounded-2xl p-8 border-t-4 border-blue-600 relative overflow-hidden">
        <div class="absolute right-6 top-6 text-sm text-gray-500">
            Status:
            <span class="font-semibold {{ $booking->status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                {{ ucfirst($booking->status) }}
            </span>
        </div>

        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">🎟️ Tiket Bus Anda</h1>
            <p class="text-gray-500">Tunjukkan tiket ini saat naik ke bus</p>
        </div>

        <div class="border-b pb-4 mb-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-3">Detail Penumpang</h2>
            <p><strong>Nama Penumpang:</strong> {{ $booking->passenger_name }}</p>
            <p><strong>Kontak:</strong> {{ $booking->passenger_contact }}</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Informasi Bus</h2>
                <p><strong>Nama Bus:</strong> {{ $booking->schedule->bus->name }}</p>
                <p>
                    @foreach ($booking->seats as $seat)
                        <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded-md mr-1">
                            {{ $seat->seat_number }}
                        </span>
                    @endforeach
                </p>
                <p><strong>Kelas:</strong> {{ $booking->schedule->bus->class ?? 'Reguler' }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Rute & Jadwal</h2>
                <p><strong>Asal:</strong> {{ $booking->schedule->route->origin }}</p>
                <p><strong>Tujuan:</strong> {{ $booking->schedule->route->destination }}</p>
                <p><strong>Berangkat:</strong> {{ \Carbon\Carbon::parse($booking->schedule->departure_time)->format('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="mt-6 border-t pt-4 flex justify-between items-center">
            <span class="text-lg font-semibold text-gray-800">Harga Tiket</span>
            <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
        </div>

        <div class="mt-8 text-center">
            @if ($booking->status === 'paid')
                <p class="text-gray-600 mb-2">Kode Tiket</p>
                {!! QrCode::size(120)->generate('BOOKING-'.$booking->id) !!}
                <p class="mt-2 text-sm text-gray-500">BOOKING-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
            @elseif ($booking->status === 'used')
                <p class="text-red-500 font-semibold">⚠️ Tiket ini sudah digunakan</p>
            @else
                <p class="text-gray-500 italic">QR Code akan muncul setelah pembayaran berhasil.</p>
            @endif
        </div>


        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('user.booking_history') }}"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-6 rounded-lg transition">
               🔙 Kembali
            </a>
        </div>
    </div>
</div>
@endsection
