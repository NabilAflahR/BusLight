<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BusSeat;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;

class PaymentController extends Controller
{
    public function createPayment($booking_id)
    {
        Configuration::setXenditKey(env('XENDIT_SECRET_KEY'));

        $booking = Booking::with(['user', 'schedule.bus', 'seats'])->findOrFail($booking_id);

        $params = [
            'external_id' => $booking->booking_code,
            'payer_email' => $booking->user->email,
            'description' => 'Pembayaran tiket bus ' . $booking->booking_code,
            'amount' => (int) $booking->total_price,
            'success_redirect_url' => route('user.tickets.show', $booking->id),
            'failure_redirect_url' => route('user.booking_history'),
            'payment_methods' => ['QRIS', 'DANA', 'OVO', 'LINKAJA', 'CREDIT_CARD', 'BANK_TRANSFER'],
        ];

        $invoiceApi = new InvoiceApi();
        $invoice = $invoiceApi->createInvoice($params);

        $booking->update([
            'external_id' => $booking->booking_code,
            'invoice_id' => $invoice['id'],
            'invoice_url' => $invoice['invoice_url'],
        ]);

        return redirect($invoice['invoice_url']);
    }

    public function handleCallback(Request $request)
    {
        Log::info('💳 Xendit Callback:', $request->all());
        $data = $request->all();
        $externalId = $data['external_id'] ?? null;
        $status = $data['status'] ?? null;

        if (!$externalId) {
            return response()->json(['error' => 'no external id'], 400);
        }

        $booking = Booking::with('seats')->where('booking_code', $externalId)->first();
        if (!$booking) {
            Log::warning('❌ Booking not found: ' . $externalId);
            return response()->json(['error' => 'booking not found'], 404);
        }

        if (in_array($status, ['PAID', 'SUCCEEDED'])) {
            $booking->update(['status' => 'paid']);

            foreach ($booking->seats as $seat) {
                $seat->update(['is_available' => false]);

                Ticket::firstOrCreate([
                    'booking_id' => $booking->id,
                    'bus_seat_id' => $seat->id,
                ], [
                    'price' => $booking->total_price / max(1, $booking->seats->count()),
                    'status' => 'booked',
                ]);
            }

            Log::info('✅ Booking marked as PAID: ' . $externalId);
        }

        if ($status === 'EXPIRED') {
            $booking->update(['status' => 'cancelled']);
            foreach ($booking->seats as $seat) {
                $seat->update(['is_available' => true]);
            }
        }

        return response()->json(['success' => true]);
    }
}
