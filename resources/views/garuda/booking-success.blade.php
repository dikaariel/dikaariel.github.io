<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/garuda/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <style>
        .accordion-body {
            overflow: hidden;
            max-height: 1300px;
            opacity: 1;
            transition: all 0.35s ease;
        }

        .accordion-body.closed {
            max-height: 0;
            opacity: 0;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .accordion-arrow {
            transition: all 0.3s ease;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
            }

            #Background {
                display: none !important;
            }

            main {
                margin-top: 20px !important;
            }

            .accordion-body {
                max-height: none !important;
                opacity: 1 !important;
                padding-top: 0 !important;
                padding-bottom: 20px !important;
            }
        }
    </style>
</head>

@php
    $flight = $booking->flight;

    $tier = $meta['tier'] ?? 'economy';
    $selectedSeats = $meta['selected_seats'] ?? '-';
    $pricePerTicket = $meta['price_per_ticket'] ?? $flight->price;
    $passengers = $meta['passengers'] ?? [];

    $selectedDate = $meta['selected_date'] ?? $flight->departure_date;
    $selectedDeparture = $meta['selected_departure'] ?? $flight->origin;
    $selectedArrival = $meta['selected_arrival'] ?? $flight->destination;

    $selectedDeparture = trim(preg_replace('/\s*\(.*?\)\s*/', '', $selectedDeparture));
    $selectedArrival = trim(preg_replace('/\s*\(.*?\)\s*/', '', $selectedArrival));

    if ($selectedDeparture === '' || $selectedDeparture === 'Select Departure') {
        $selectedDeparture = $flight->origin;
    }

    if ($selectedArrival === '' || $selectedArrival === 'Pilih Tujuan' || $selectedArrival === 'Select Arrival') {
        $selectedArrival = $flight->destination;
    }

    $quantity = $booking->quantity ?? 1;
    $className = $tier === 'business' ? 'Business Class' : 'Economy Class';
    $seatImage = $tier === 'business' ? 'business-seat.png' : 'economy-seat.png';

    $subTotal = $booking->total_price;
    $tax = round($subTotal * 0.11);
    $grandTotal = $subTotal + $tax;

    $displayDate = \Carbon\Carbon::parse($selectedDate)->format('d M Y');
    $originCode = strtoupper(substr($selectedDeparture, 0, 3));
    $destinationCode = strtoupper(substr($selectedArrival, 0, 3));

    $paymentStatus = strtolower($booking->status ?? 'pending');
    $isPaid = $paymentStatus === 'confirmed' || $paymentStatus === 'success';
@endphp

<body class="font-[Poppins] bg-[#F3F6FD]">
    <div id="Background"
        class="absolute top-0 w-full h-[810px] bg-[linear-gradient(180deg,#85C8FF_0%,#D4D1FE_47.05%,#F3F6FD_100%)]">
        <img src="/garuda/assets/images/backgrounds/Jumbo Jet Sky (1) 1.png"
            class="absolute right-0 top-[147px] object-contain max-h-[481px]" alt="background image">
    </div>

    <nav class="no-print relative flex justify-center px-[75px] mt-[30px]">
        <div class="flex items-center w-full max-w-[1130px] rounded-[20px] justify-between py-4 px-5 bg-white">
            <a href="/garuda/index.html">
                <img src="/garuda/assets/images/logos/logo.svg" class="flex shrink-0 h-10" alt="logo">
            </a>

            <ul class="flex items-center gap-[30px] flex-wrap">
                <li>
                    <a href="/available-flights" class="hover:font-bold transition-all duration-300 font-bold">
                        Flights
                    </a>
                </li>

                <li>
                    <a href="/available-flights" class="hover:font-bold transition-all duration-300">
                        Schedule
                    </a>
                </li>

                <li>
                    <a href="/garuda/index.html#Testimonials" class="hover:font-bold transition-all duration-300">
                        Testimonials
                    </a>
                </li>
            </ul>

            <div class="flex items-center gap-3">
                <a href="/garuda/call-us.html"
                    class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px]">
                    <img src="/garuda/assets/images/icons/call-calling-black.svg" class="w-5 h-5 flex shrink-0" alt="icon">
                    <span class="font-semibold">Call Us</span>
                </a>

                <a href="/my-booking"
                    class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] bg-garuda-black">
                    <img src="/garuda/assets/images/icons/note-favorite-white.svg" class="w-5 h-5 flex shrink-0" alt="icon">
                    <span class="font-semibold text-white">My Booking</span>
                </a>
            </div>
        </div>
    </nav>

    <main class="relative flex flex-col w-full max-w-[1130px] mx-auto mt-[80px] mb-[80px] px-5">
        <h1 class="font-extrabold text-[50px] leading-[75px] mb-[30px]">
            Booking Details
        </h1>

        @if (session('success'))
            <div class="no-print rounded-[20px] bg-[#D1FADF] text-[#027A48] font-semibold px-5 py-4 mb-5">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex gap-[30px] items-start">
            <div id="Left-Content" class="flex flex-col gap-[30px] w-[470px] shrink-0">

                <!-- YOUR FLIGHT -->
                <div class="flex flex-col h-fit rounded-[20px] bg-white overflow-hidden">
                    <button type="button"
                        class="accordion-toggle flex items-center justify-between p-5 text-left"
                        data-target="flight-body">
                        <h2 class="font-bold text-xl leading-[30px]">Your Flight</h2>
                        <span class="accordion-arrow w-9 h-9 rounded-full border border-garuda-black flex items-center justify-center font-bold">
                            ↑
                        </span>
                    </button>

                    <div id="flight-body" class="accordion-body px-5 pb-5 flex flex-col gap-5">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-garuda-grey">Departure</p>
                                <p class="font-semibold text-lg">{{ $selectedDeparture }}</p>
                            </div>

                            <div class="text-end">
                                <p class="text-sm text-garuda-grey">Arrival</p>
                                <p class="font-semibold text-lg">{{ $selectedArrival }}</p>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-garuda-grey">Date</p>
                                <p class="font-semibold text-lg">{{ $displayDate }}</p>
                            </div>

                            <div class="text-end">
                                <p class="text-sm text-garuda-grey">Quantity</p>
                                <p class="font-semibold text-lg">{{ $quantity }} people</p>
                            </div>
                        </div>

                        <div class="flex flex-col rounded-[20px] border border-[#E8EFF7] p-5 gap-5">
                            <div class="flex items-center justify-between">
                                <img src="/garuda/assets/images/logos/ana.svg" class="w-[95px] flex shrink-0" alt="logo">

                                <a href="#" class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
                                    <p class="font-semibold text-white">Details</p>
                                </a>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold">{{ $flight->airline }}</p>
                                    <p class="text-sm text-garuda-grey mt-[2px]">
                                        {{ $flight->departure_time }} - {{ $flight->arrival_time }}
                                    </p>
                                </div>

                                <div class="flex flex-col gap-[2px] items-center justify-center">
                                    <p class="text-sm text-garuda-grey">Direct Flight</p>

                                    <div class="flex items-center gap-[6px]">
                                        <p class="font-semibold">{{ $originCode }}</p>
                                        <img src="/garuda/assets/images/icons/direct-black.svg" alt="icon">
                                        <p class="font-semibold">{{ $destinationCode }}</p>
                                    </div>

                                    <p class="text-sm text-garuda-grey">{{ $flight->flight_number }}</p>
                                </div>

                                <p class="font-semibold text-garuda-green text-center">
                                    Rp {{ number_format($pricePerTicket, 0, ',', '.') }}
                                </p>
                            </div>

                            <hr class="border-[#E8EFF7]">

                            <div class="flex items-center rounded-[20px] gap-[14px]">
                                <div class="flex w-[120px] h-[100px] shrink-0 rounded-[20px] overflow-hidden">
                                    <img src="/garuda/assets/images/thumbnails/{{ $seatImage }}"
                                        class="w-full h-full object-cover" alt="seat">
                                </div>

                                <div>
                                    <p class="font-bold text-xl leading-[30px]">{{ $className }}</p>
                                    <p class="text-garuda-grey mt-1">
                                        Rp {{ number_format($pricePerTicket, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TRANSACTION DETAILS -->
                <div class="flex flex-col h-fit rounded-[20px] bg-white overflow-hidden">
                    <button type="button"
                        class="accordion-toggle flex items-center justify-between p-5 text-left"
                        data-target="transaction-body">
                        <h2 class="font-bold text-xl leading-[30px]">Transaction Details</h2>
                        <span class="accordion-arrow w-9 h-9 rounded-full border border-garuda-black flex items-center justify-center font-bold">
                            ↑
                        </span>
                    </button>

                    <div id="transaction-body" class="accordion-body px-5 pb-5 flex flex-col gap-5">
                        <div>
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-garuda-grey">Booking Transaction ID</p>
                                <p class="text-sm text-garuda-grey">Payment Status</p>
                            </div>

                            <div class="flex items-center justify-between mt-1">
                                <p class="font-bold text-lg leading-[27px] text-garuda-blue">
                                    {{ $booking->booking_code }}
                                </p>

                                @if ($isPaid)
                                    <span class="rounded-full bg-[#079455] text-white px-3 py-1 text-xs font-bold">
                                        CONFIRMED
                                    </span>
                                @else
                                    <span class="rounded-full bg-[#FFA44B] text-garuda-black px-3 py-1 text-xs font-bold">
                                        PENDING
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-5">
                            <div>
                                <p class="text-sm text-garuda-grey">Quantity</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                    {{ $quantity }} People
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-garuda-grey">Tiers</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                    {{ ucfirst($tier) }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-garuda-grey">Seats</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                    {{ $selectedSeats ?: '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-5">
                            <div>
                                <p class="text-sm text-garuda-grey">Price</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                    Rp {{ number_format($pricePerTicket, 0, ',', '.') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-garuda-grey">Govt. Tax</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                    11%
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-garuda-grey">Sub Total</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                    Rp {{ number_format($subTotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-5 items-end">
                            <div>
                                <p class="text-sm text-garuda-grey">Total Tax</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                    Rp {{ number_format($tax, 0, ',', '.') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-garuda-grey">Grand Total</p>
                                <p class="font-bold text-2xl leading-9 text-garuda-blue mt-[2px]">
                                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="Right-Content" class="flex flex-col gap-[30px] w-[470px] shrink-0">

                <!-- CUSTOMER INFORMATION -->
                <div class="flex flex-col rounded-[20px] bg-white overflow-hidden">
                    <button type="button"
                        class="accordion-toggle flex items-center justify-between p-5 text-left"
                        data-target="customer-body">
                        <h2 class="font-bold text-xl leading-[30px]">Customer Information</h2>
                        <span class="accordion-arrow w-9 h-9 rounded-full border border-garuda-black flex items-center justify-center font-bold">
                            ↑
                        </span>
                    </button>

                    <div id="customer-body" class="accordion-body px-5 pb-5 flex flex-col gap-5">
                        <div>
                            <p class="font-semibold text-sm mb-2">Complete Name</p>
                            <div class="flex items-center gap-3 rounded-full bg-[#F5F6FB] px-5 py-3 font-semibold">
                                <span class="text-lg">👤</span>
                                {{ $booking->passenger_name }}
                            </div>
                        </div>

                        <div>
                            <p class="font-semibold text-sm mb-2">Email Address</p>
                            <div class="flex items-center gap-3 rounded-full bg-[#F5F6FB] px-5 py-3 font-semibold">
                                <span class="text-lg">✉️</span>
                                {{ $booking->passenger_email }}
                            </div>
                        </div>

                        <div>
                            <p class="font-semibold text-sm mb-2">Phone No.</p>
                            <div class="flex items-center gap-3 rounded-full bg-[#F5F6FB] px-5 py-3 font-semibold">
                                <span class="text-lg">☎️</span>
                                {{ $booking->phone_number }}
                            </div>
                        </div>
                    </div>
                </div>

                @foreach ($passengers as $index => $passenger)
                    @php
                        $birthDate = $passenger['birth_date'] ?? null;

                        if ($birthDate) {
                            $birthDay = \Carbon\Carbon::parse($birthDate)->format('d');
                            $birthMonth = \Carbon\Carbon::parse($birthDate)->format('m');
                            $birthYear = \Carbon\Carbon::parse($birthDate)->format('Y');
                        } else {
                            $birthDay = '-';
                            $birthMonth = '-';
                            $birthYear = '-';
                        }
                    @endphp

                    <!-- PASSENGER -->
                    <div class="flex flex-col rounded-[20px] bg-white overflow-hidden">
                        <button type="button"
                            class="accordion-toggle flex items-center justify-between p-5 text-left"
                            data-target="passenger-body-{{ $index }}">
                            <h2 class="font-bold text-xl leading-[30px]">
                                Passenger {{ $index + 1 }}
                            </h2>

                            <span class="accordion-arrow w-9 h-9 rounded-full border border-garuda-black flex items-center justify-center font-bold">
                                ↑
                            </span>
                        </button>

                        <div id="passenger-body-{{ $index }}" class="accordion-body px-5 pb-5 flex flex-col gap-5">
                            <div>
                                <p class="font-semibold text-sm mb-2">Complete Name</p>
                                <div class="flex items-center gap-3 rounded-full bg-[#F5F6FB] px-5 py-3 font-semibold">
                                    <span class="text-lg">👤</span>
                                    {{ $passenger['name'] }}
                                </div>
                            </div>

                            <div>
                                <p class="font-semibold text-sm mb-2">Date of Birth</p>
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="flex items-center justify-center gap-2 rounded-full bg-[#F5F6FB] px-4 py-3 font-semibold">
                                        <span>📅</span>
                                        {{ $birthDay }}
                                    </div>

                                    <div class="flex items-center justify-center gap-2 rounded-full bg-[#F5F6FB] px-4 py-3 font-semibold">
                                        <span>📅</span>
                                        {{ $birthMonth }}
                                    </div>

                                    <div class="flex items-center justify-center gap-2 rounded-full bg-[#F5F6FB] px-4 py-3 font-semibold">
                                        <span>📅</span>
                                        {{ $birthYear }}
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="font-semibold text-sm mb-2">Nationality</p>
                                <div class="flex items-center gap-3 rounded-full bg-[#F5F6FB] px-5 py-3 font-semibold">
                                    <span class="text-lg">🌐</span>
                                    {{ $passenger['nationality'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="no-print flex flex-col gap-3">
                    @if (!$isPaid)
                        <form action="{{ route('booking.pay', $booking->id) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit"
                                class="w-full rounded-full py-4 px-5 text-center bg-[#079455] hover:opacity-90 transition-all duration-300">
                                <span class="font-semibold text-white">Pay Now</span>
                            </button>
                        </form>
                    @else
                        <div class="w-full rounded-full py-4 px-5 text-center bg-[#D1FADF] text-[#027A48] font-semibold">
                            Payment Confirmed
                        </div>
                    @endif

                    <button onclick="window.print()"
                        class="w-full rounded-full py-4 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                        <span class="font-semibold text-white">Download PDF Version</span>
                    </button>

                    <a href="/my-booking"
                        class="w-full rounded-full py-4 px-5 text-center bg-garuda-black transition-all duration-300">
                        <span class="font-semibold text-white">My Booking</span>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <script>
        const toggles = document.querySelectorAll('.accordion-toggle');

        toggles.forEach((toggle) => {
            toggle.addEventListener('click', function () {
                const targetId = this.dataset.target;
                const body = document.getElementById(targetId);
                const arrow = this.querySelector('.accordion-arrow');

                body.classList.toggle('closed');

                if (body.classList.contains('closed')) {
                    arrow.textContent = '↓';
                } else {
                    arrow.textContent = '↑';
                }
            });
        });
    </script>
</body>

</html>