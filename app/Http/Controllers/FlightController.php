<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Home Garuda Dinamis
    |--------------------------------------------------------------------------
    | Data departure, arrival, dan popular destination diambil dari database.
    */
    public function home()
    {
        $departureOptions = Flight::select('origin')
            ->distinct()
            ->orderBy('origin', 'asc')
            ->pluck('origin');

        $arrivalOptions = Flight::select('destination')
            ->distinct()
            ->orderBy('destination', 'asc')
            ->pluck('destination');

        $popularDestinations = Flight::select('destination')
            ->distinct()
            ->orderBy('destination', 'asc')
            ->limit(8)
            ->pluck('destination');

        return view('garuda.home', compact(
            'departureOptions',
            'arrivalOptions',
            'popularDestinations'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Available Flights User
    |--------------------------------------------------------------------------
    | Menampilkan data penerbangan.
    |
    | Catatan:
    | - Departure bebas dipilih user.
    | - Arrival bebas dipilih user.
    | - Date bebas dipilih user.
    | - Departure, Arrival, dan Date TIDAK dipakai untuk filter database.
    | - Jadi penerbangan tetap muncul walaupun user memilih tanggal/tujuan bebas.
    | - Filter yang tetap aktif: Airlines, Flight Type, dan Facilities.
    */
    public function available(Request $request)
    {
        $query = Flight::query();

        /*
        |--------------------------------------------------------------------------
        | Filter Maskapai
        |--------------------------------------------------------------------------
        */
        if ($request->filled('airlines')) {
            $selectedAirlines = $request->airlines;

            if (!is_array($selectedAirlines)) {
                $selectedAirlines = [$selectedAirlines];
            }

            $query->whereIn('airline', $selectedAirlines);
        }

        /*
        |--------------------------------------------------------------------------
        | Departure, Arrival, dan Date sengaja tidak difilter
        |--------------------------------------------------------------------------
        | Bagian ini dibuat supaya user bebas memilih:
        | - Kota asal
        | - Kota tujuan
        | - Tanggal penerbangan
        |
        | Data penerbangan tetap muncul dari database.
        | Tanggal dan tujuan pilihan user nanti hanya ditampilkan di halaman berikutnya.
        */

        /*
        |--------------------------------------------------------------------------
        | Filter Jenis Penerbangan
        |--------------------------------------------------------------------------
        */
        if ($request->filled('flight_type')) {
            $query->where('flight_type', $request->flight_type);
        }

        /*
        |--------------------------------------------------------------------------
        | Filter Fasilitas
        |--------------------------------------------------------------------------
        */
        if ($request->filled('facilities')) {
            $facilities = $request->facilities;

            if (!is_array($facilities)) {
                $facilities = [$facilities];
            }

            foreach ($facilities as $facility) {
                if ($facility === 'baggage') {
                    $query->where('has_baggage', true);
                }

                if ($facility === 'entertainment') {
                    $query->where('has_entertainment', true);
                }

                if ($facility === 'usb') {
                    $query->where('has_usb', true);
                }

                if ($facility === 'wifi') {
                    $query->where('has_wifi', true);
                }

                if ($facility === 'meals') {
                    $query->where('has_meals', true);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Data Penerbangan
        |--------------------------------------------------------------------------
        */
        $flights = $query
            ->orderBy('departure_time', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Data Pilihan Maskapai untuk Filter
        |--------------------------------------------------------------------------
        */
        $airlineOptions = Flight::select('airline')
            ->distinct()
            ->orderBy('airline', 'asc')
            ->pluck('airline');

        return view('garuda.available-flights', compact('flights', 'airlineOptions'));
    }

    /*
    |--------------------------------------------------------------------------
    | Admin - List Data Penerbangan
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $flights = Flight::latest()->paginate(10);

        return view('flights.index', compact('flights'));
    }

    /*
    |--------------------------------------------------------------------------
    | Admin - Form Tambah Data
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('flights.create');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin - Simpan Data Penerbangan
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'airline' => 'required|string|max:255',
            'flight_number' => 'required|string|max:50|unique:flights,flight_number',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'seats' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'flight_type' => 'required|in:direct,transit_1x,transit_2x',
        ]);

        Flight::create([
            'airline' => $request->airline,
            'flight_number' => $request->flight_number,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'departure_date' => $request->departure_date,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'seats' => $request->seats,
            'price' => $request->price,
            'flight_type' => $request->flight_type,
            'has_baggage' => $request->has('has_baggage'),
            'has_entertainment' => $request->has('has_entertainment'),
            'has_usb' => $request->has('has_usb'),
            'has_wifi' => $request->has('has_wifi'),
            'has_meals' => $request->has('has_meals'),
        ]);

        return redirect()
            ->route('flights.index')
            ->with('success', 'Data penerbangan berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin - Detail Data
    |--------------------------------------------------------------------------
    */
    public function show(Flight $flight)
    {
        return view('flights.show', compact('flight'));
    }

    /*
    |--------------------------------------------------------------------------
    | Admin - Form Edit Data
    |--------------------------------------------------------------------------
    */
    public function edit(Flight $flight)
    {
        return view('flights.edit');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin - Update Data Penerbangan
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Flight $flight)
    {
        $request->validate([
            'airline' => 'required|string|max:255',
            'flight_number' => 'required|string|max:50|unique:flights,flight_number,' . $flight->id,
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'seats' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'flight_type' => 'required|in:direct,transit_1x,transit_2x',
        ]);

        $flight->update([
            'airline' => $request->airline,
            'flight_number' => $request->flight_number,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'departure_date' => $request->departure_date,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'seats' => $request->seats,
            'price' => $request->price,
            'flight_type' => $request->flight_type,
            'has_baggage' => $request->has('has_baggage'),
            'has_entertainment' => $request->has('has_entertainment'),
            'has_usb' => $request->has('has_usb'),
            'has_wifi' => $request->has('has_wifi'),
            'has_meals' => $request->has('has_meals'),
        ]);

        return redirect()
            ->route('flights.index')
            ->with('success', 'Data penerbangan berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | Admin - Hapus Data Penerbangan
    |--------------------------------------------------------------------------
    */
    public function destroy(Flight $flight)
    {
        $flight->delete();

        return redirect()
            ->route('flights.index')
            ->with('success', 'Data penerbangan berhasil dihapus.');
    }
}