<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function issueTicket($booking_id)
    {
        // Ambil data booking
        $booking = Booking::with(['seats', 'schedule.bus', 'schedule.route'])->findOrFail($booking_id);

        if ($booking->seats->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada kursi yang dipilih untuk booking ini.');
        }

        // Buat tiket untuk setiap kursi yang sudah dipesan
        foreach ($booking->seats as $seat) {
            Ticket::firstOrCreate(
                [
                    'booking_id' => $booking->id,
                    'bus_seat_id' => $seat->id,
                ],
                [
                    'price' => $booking->total_price / max(1, $booking->seats->count()),
                    'status' => 'booked',
                ]
            );

            // Ubah status kursi menjadi tidak tersedia
            $seat->update(['is_available' => false]);
        }

        return view('user.ticket', compact('booking'));
    }
}
