@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">
    <div class="bg-white rounded-2xl shadow-lg p-8"
         x-data="seatBooking({{ $schedule->price }})"
         x-init="initSeats()">

        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            🚌 Form Pemesanan Tiket Bus
        </h1>

        <form action="{{ route('user.booking.create') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
            {{-- Hidden input kursi (multiple) --}}
            <template x-for="seat in selectedSeats" :key="seat">
                <input type="hidden" name="seat_numbers[]" :value="seat">
            </template>

            {{-- Informasi Bus --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Nama Bus</label>
                    <input type="text" value="{{ $schedule->bus->name }}" readonly
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Kelas</label>
                    <input type="text" value="{{ $schedule->bus->class ?? 'Reguler' }}" readonly
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            {{-- Informasi Rute --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Asal</label>
                    <input type="text" value="{{ $schedule->route->origin }}" readonly
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Tujuan</label>
                    <input type="text" value="{{ $schedule->route->destination }}" readonly
                        class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>
            </div>

            {{-- Pilih Kursi --}}
            <div>
                <label class="block text-gray-700 font-medium mb-3">Pilih Nomor Kursi</label>

                <div class="flex justify-center">
                    <div class="inline-grid grid-cols-5 gap-4 p-4 border rounded-xl bg-gray-50 shadow-inner">

                        @php
                            $columns = [0, 1, 'aisle', 2, 3];
                            $seats = $schedule->bus->seats;
                            $seatIndex = 0;
                        @endphp

                        @while($seatIndex < count($seats))
                            @foreach($columns as $col)
                                @if($col === 'aisle')
                                    <div class="w-6"></div>
                                @else
                                    @php $seat = $seats[$seatIndex] ?? null; @endphp
                                    @if($seat)
                                        <button type="button"
                                            @click="toggleSeat('{{ $seat->seat_number }}')"
                                            @if(!$seat->is_available) disabled @endif
                                            class="w-12 h-12 flex items-center justify-center rounded-md border text-sm font-semibold transition duration-200
                                                @if(!$seat->is_available)
                                                    bg-gray-300 text-gray-500 cursor-not-allowed
                                                @else
                                                    bg-white hover:bg-blue-100 text-gray-700 border-gray-400 cursor-pointer
                                                @endif"
                                            :class="selectedSeats.includes('{{ $seat->seat_number }}') ? 'bg-blue-600 text-white border-blue-600' : ''">
                                            {{ $seat->seat_number }}
                                        </button>
                                        @php $seatIndex++; @endphp
                                    @else
                                        <div class="w-12 h-12"></div>
                                    @endif
                                @endif
                            @endforeach
                        @endwhile
                    </div>
                </div>

                {{-- Keterangan warna --}}
                <div class="flex justify-center space-x-4 mt-4 text-sm text-gray-600">
                    <div class="flex items-center space-x-2">
                        <div class="w-5 h-5 rounded bg-white border border-gray-400"></div>
                        <span>Tersedia</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-5 h-5 rounded bg-blue-600"></div>
                        <span>Dipilih</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-5 h-5 rounded bg-gray-300"></div>
                        <span>Tidak Tersedia</span>
                    </div>
                </div>
            </div>

            {{-- Data Penumpang (otomatis dari user login) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Nama Penumpang</label>
                    <input type="text"  value="{{ Auth::user()->name }}" readonly
                        class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-700">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Email / Kontak</label>
                    <input type="text"value="{{ Auth::user()->email }}" readonly
                        class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-700">
                </div>
            </div>

            {{-- Jadwal & Total Harga --}}
            <div class="flex justify-between items-center border-t pt-4 mt-6">
                <div>
                    <p class="text-gray-600">Tanggal Keberangkatan:</p>
                    <p class="font-semibold">
                        {{ \Carbon\Carbon::parse($schedule->departure_time)->format('d M Y, H:i') }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-gray-600">Total Harga:</p>
                    <p class="text-2xl font-bold text-blue-600">
                        Rp <span x-text="totalPrice.toLocaleString('id-ID')"></span>
                    </p>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <div class="text-center mt-8">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow transition"
                    :disabled="selectedSeats.length === 0">
                    Konfirmasi Pesanan (<span x-text="selectedSeats.length"></span> kursi)
                </button>
            </div>
        </form>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>

<script>
function seatBooking(pricePerSeat) {
    return {
        selectedSeats: [],
        totalPrice: 0,

        initSeats() {
            this.totalPrice = 0;
        },

        toggleSeat(seat) {
            if (this.selectedSeats.includes(seat)) {
                this.selectedSeats = this.selectedSeats.filter(s => s !== seat);
            } else {
                this.selectedSeats.push(seat);
            }
            this.updateTotal();
        },

        updateTotal() {
            this.totalPrice = this.selectedSeats.length * pricePerSeat;
        }
    }
}
</script>
@endsection
