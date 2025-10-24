@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-6">
    <div class="bg-white shadow-lg rounded-2xl p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            💳 Pembayaran Tiket Bus
        </h1>

        <div class="border-b pb-4 mb-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Detail Pemesanan</h2>
            <p><strong>Nama Bus:</strong> {{ $booking->schedule->bus->name ?? '-' }}</p>
            <p><strong>Asal:</strong> {{ $booking->schedule->route->origin ?? '-' }}</p>
            <p><strong>Tujuan:</strong> {{ $booking->schedule->route->destination ?? '-' }}</p>
            <p><strong>Nomor Kursi:</strong> {{ $booking->seat_number }}</p>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-lg font-semibold text-gray-800">Total Pembayaran</span>
            <span class="text-2xl font-bold text-blue-600">
                Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}
            </span>
        </div>
<form action="{{ route('user.payment.create', ['booking_id' => $booking->id]) }}" method="GET" class="mt-6">
    @csrf
    <div class="mb-4">
        <label for="method" class="block text-gray-700 font-semibold mb-2">Metode Pembayaran</label>
        <select name="method" id="method" class="w-full border rounded-xl p-3">
            <option value="ALL">Semua Metode</option>
            <option value="QRIS">QRIS</option>
            <option value="EWALLET">E-Wallet (OVO, DANA, ShopeePay, dll)</option>
            <option value="BANK_TRANSFER">Virtual Account (BCA, BNI, Mandiri, dll)</option>
        </select>
    </div>

    <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition">
        Bayar Sekarang
    </button>
</form>

    </div>
</div>
@endsection
