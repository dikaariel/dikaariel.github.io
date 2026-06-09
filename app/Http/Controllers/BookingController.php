<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Pilih Class / Tiers
    |--------------------------------------------------------------------------
    */
    public function tiers(Request $request, Flight $flight)
    {
        return view('garuda.choose-tiers', compact('flight'));
    }

    /*
    |--------------------------------------------------------------------------
    | Pilih Kursi
    |--------------------------------------------------------------------------
    */
    public function seats(Request $request, Flight $flight)
    {
        $tier = strtolower($request->query('tier', 'economy'));
        $quantity = (int) $request->query('quantity', 1);

        if ($quantity < 1) {
            $quantity = 1;
        }

        return view('garuda.choose-seats', compact('flight', 'tier', 'quantity'));
    }

    /*
    |--------------------------------------------------------------------------
    | Form Data Penumpang
    |--------------------------------------------------------------------------
    */
    public function create(Request $request, Flight $flight)
    {
        $tier = strtolower($request->query('tier', 'economy'));
        $quantity = (int) $request->query('quantity', 1);
        $selectedSeats = $request->query('seats', '');

        if ($quantity < 1) {
            $quantity = 1;
        }

        return view('garuda.booking-create', compact(
            'flight',
            'tier',
            'quantity',
            'selectedSeats'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Booking
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, Flight $flight)
    {
        $request->validate([
            'passenger_name' => 'required|string|max:255',
            'passenger_email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:30',
            'quantity' => 'required|integer|min:1',
            'tier' => 'nullable|string',
            'class' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'selected_seats' => 'nullable|string',
            'date' => 'nullable|string',
            'departure' => 'nullable|string|max:255',
            'arrival' => 'nullable|string|max:255',
            'passenger_detail_name' => 'nullable|array',
            'birth_date' => 'nullable|array',
            'nationality' => 'nullable|array',
        ]);

        if ($request->quantity > $flight->seats) {
            return back()->withErrors([
                'quantity' => 'Jumlah tiket melebihi kursi yang tersedia.'
            ])->withInput();
        }

        $booking = DB::transaction(function () use ($request, $flight) {
            $tier = strtolower($request->tier ?? 'economy');

            $selectedDeparture = $request->departure ?: $flight->origin;
            $selectedArrival = $request->arrival ?: $flight->destination;
            $selectedDate = $request->date ?: $flight->departure_date;

            $selectedDeparture = trim(preg_replace('/\s*\(.*?\)\s*/', '', $selectedDeparture));
            $selectedArrival = trim(preg_replace('/\s*\(.*?\)\s*/', '', $selectedArrival));

            if ($selectedDeparture === '' || $selectedDeparture === 'Select Departure') {
                $selectedDeparture = $flight->origin;
            }

            if ($selectedArrival === '' || $selectedArrival === 'Pilih Tujuan' || $selectedArrival === 'Select Arrival') {
                $selectedArrival = $flight->destination;
            }

            if ($request->filled('price')) {
                $pricePerTicket = (int) $request->price;
            } else {
                $pricePerTicket = $tier === 'business'
                    ? (int) $flight->price + 2000000
                    : (int) $flight->price;
            }

            $totalPrice = $pricePerTicket * $request->quantity;

            $booking = Booking::create([
                'booking_code' => 'GB-' . strtoupper(Str::random(8)),
                'user_id' => auth()->id(),
                'flight_id' => $flight->id,
                'passenger_name' => $request->passenger_name,
                'passenger_email' => $request->passenger_email,
                'phone_number' => $request->phone_number,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
                'status' => 'Pending',
            ]);

            $flight->decrement('seats', $request->quantity);

            $passengers = [];

            for ($i = 0; $i < $request->quantity; $i++) {
                $passengers[] = [
                    'name' => $request->passenger_detail_name[$i] ?? $request->passenger_name,
                    'birth_date' => $request->birth_date[$i] ?? null,
                    'nationality' => $request->nationality[$i] ?? 'Indonesia',
                ];
            }

            session()->put('booking_meta_' . $booking->id, [
                'tier' => $tier,
                'class' => $request->class ?: ucfirst($tier),
                'selected_seats' => $request->selected_seats ?: '-',
                'price_per_ticket' => $pricePerTicket,
                'selected_date' => $selectedDate,
                'selected_departure' => $selectedDeparture,
                'selected_arrival' => $selectedArrival,
                'passengers' => $passengers,
            ]);

            return $booking;
        });

        return redirect()->route('booking.success', $booking->id);
    }

    /*
    |--------------------------------------------------------------------------
    | Halaman Booking Success
    |--------------------------------------------------------------------------
    */
    public function success(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load('flight');

        $meta = session('booking_meta_' . $booking->id, [
            'tier' => 'economy',
            'class' => 'Economy',
            'selected_seats' => '-',
            'price_per_ticket' => $booking->total_price / max($booking->quantity, 1),
            'selected_date' => $booking->flight->departure_date,
            'selected_departure' => $booking->flight->origin,
            'selected_arrival' => $booking->flight->destination,
            'passengers' => [
                [
                    'name' => $booking->passenger_name,
                    'birth_date' => null,
                    'nationality' => 'Indonesia',
                ]
            ],
        ]);

        return view('garuda.booking-success', compact('booking', 'meta'));
    }

    /*
    |--------------------------------------------------------------------------
    | Konfirmasi Pembayaran
    |--------------------------------------------------------------------------
    */
    public function pay(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->update([
            'status' => 'Confirmed',
        ]);

        return redirect()
            ->route('booking.success', $booking->id)
            ->with('success', 'Payment berhasil dikonfirmasi.');
    }

    /*
    |--------------------------------------------------------------------------
    | Riwayat Booking User
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $bookings = Booking::with('flight')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('garuda.my-booking', compact('bookings'));
    }
}