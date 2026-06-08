<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function tiers(Flight $flight)
    {
        return view('garuda.choose-tiers', compact('flight'));
    }

    public function seats(Request $request, Flight $flight)
    {
        $tier = $request->query('tier', 'economy');
        $quantity = (int) $request->query('quantity', 1);

        if ($quantity < 1) {
            $quantity = 1;
        }

        return view('garuda.choose-seats', compact('flight', 'tier', 'quantity'));
    }

    public function create(Request $request, Flight $flight)
    {
        $tier = $request->query('tier', 'economy');
        $quantity = (int) $request->query('quantity', 1);
        $selectedSeats = $request->query('seats', '');

        if ($quantity < 1) {
            $quantity = 1;
        }

        return view('garuda.booking-create', compact('flight', 'tier', 'quantity', 'selectedSeats'));
    }

    public function store(Request $request, Flight $flight)
    {
        $request->validate([
            'passenger_name' => 'required|string|max:255',
            'passenger_email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:30',
            'quantity' => 'required|integer|min:1',
            'tier' => 'nullable|string',
            'selected_seats' => 'nullable|string',
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
            $tier = $request->tier ?? 'economy';

            if ($tier === 'business') {
                $pricePerTicket = $flight->price + 2000000;
            } else {
                $pricePerTicket = $flight->price;
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
                'status' => 'Confirmed',
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
                'selected_seats' => $request->selected_seats,
                'price_per_ticket' => $pricePerTicket,
                'passengers' => $passengers,
            ]);

            return $booking;
        });

        return redirect()->route('booking.success', $booking->id);
    }

    public function success(Booking $booking)
    {
        $booking->load('flight');

        $meta = session('booking_meta_' . $booking->id, [
            'tier' => 'economy',
            'selected_seats' => '-',
            'price_per_ticket' => $booking->flight->price,
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

    public function index()
    {
        $bookings = Booking::with('flight')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('garuda.my-booking', compact('bookings'));
    }
}