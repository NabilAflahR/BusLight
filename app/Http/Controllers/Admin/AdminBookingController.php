<?php

namespace App\Http\Controllers\Admin;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $bookings = Booking::with(['user', 'schedule.route'])
            ->when($search, function ($query, $search) {
                $query->where('booking_code', 'like', "%{$search}%")
                    ->orWhereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'schedule.bus', 'schedule.route', 'bookingSeats.busSeat'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }
}
