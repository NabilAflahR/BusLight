<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BusSeat;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function CreateBooking(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'seat_numbers' => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $scheduleId = $request->input('schedule_id');
            $selectedSeats = $request->input('seat_numbers');

            $schedule = Schedule::with('bus')->findOrFail($scheduleId);
            $bus = $schedule->bus;

            if (!$bus) {
                throw new \Exception('Bus tidak ditemukan untuk jadwal ini.');
            }

            $seats = BusSeat::whereIn('seat_number', $selectedSeats)
                ->where('bus_id', $bus->id)
                ->lockForUpdate()
                ->get();

            if ($seats->count() === 0) {
                throw new \Exception('Kursi tidak ditemukan.');
            }

            foreach ($seats as $seat) {
                if (!$seat->is_available) {
                    throw new \Exception("Kursi {$seat->seat_number} sudah dipesan.");
                }
            }

            $pricePerSeat = (int) $schedule->price;
            $totalPrice = $pricePerSeat * count($selectedSeats);

            if ($totalPrice <= 0) {
                throw new \Exception('Harga jadwal belum diatur (0). Tambahkan harga di tabel schedules.');
            }

            $booking = Booking::create([
                'user_id' => $user->id,
                'schedule_id' => $scheduleId,
                'total_price' => $totalPrice,
                'booking_code' => 'BOOK-' . strtoupper(Str::random(6)),
                'status' => 'pending',
            ]);

            foreach ($seats as $seat) {
                DB::table('booking_seats')->insert([
                    'booking_id' => $booking->id,
                    'bus_seat_id' => $seat->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $seat->update(['is_available' => false]);
            }

            DB::commit();

            return redirect()->route('user.payment.create', ['booking_id' => $booking->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal membuat booking: ' . $e->getMessage()]);
        }
    }

    // 🟢 Auto update status jadi USED setelah lewat 1 hari dari keberangkatan
    private function updateExpiredBookings($userId)
    {
        $bookings = Booking::with('schedule')
            ->where('user_id', $userId)
            ->where('status', 'paid')
            ->get();

        foreach ($bookings as $booking) {
            $departure = Carbon::parse($booking->schedule->departure_time);
            if (now()->greaterThan($departure->addDay())) {
                $booking->update(['status' => 'used']);
            }
        }
    }

    public function history(Request $request)
    {
        $this->updateExpiredBookings($request->user()->id);

        $bookings = Booking::with(['schedule.bus', 'schedule.route', 'seats'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.booking_history', compact('bookings'));
    }

    public function cancel($id, Request $request)
    {
        $booking = Booking::with(['schedule', 'seats'])
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Tiket tidak dapat dibatalkan karena sudah diproses atau dibayar.');
        }

        $booking->update(['status' => 'cancelled']);

        foreach ($booking->seats as $seat) {
            $seat->update(['is_available' => true]);
        }

        return back()->with('success', 'Tiket berhasil dibatalkan.');
    }

    public function showTicket($booking_id)
    {
        $booking = Booking::with(['schedule.bus', 'schedule.route', 'seats'])
            ->where('id', $booking_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Hanya tampilkan tiket kalau sudah dibayar
        if ($booking->status !== 'paid') {
            return redirect()->route('user.booking_history')->with('error', 'Tiket belum tersedia. Selesaikan pembayaran terlebih dahulu.');
        }

        // Safety net — kalau webhook belum jalan tapi sudah masuk halaman tiket
        if ($booking->status === 'pending') {
            $booking->update(['status' => 'paid']);
        }

        return view('user.ticket', compact('booking'));
    }

}
