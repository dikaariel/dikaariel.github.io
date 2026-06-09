<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/garuda/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
</head>

@php
    $quantity = (int) request('quantity', 1);

    if ($quantity < 1) {
        $quantity = 1;
    }

    $selectedDeparture = request('departure') ?: request('origin') ?: $flight->origin;
    $selectedArrival = request('arrival') ?: request('destination') ?: $flight->destination;

    $selectedDeparture = trim(preg_replace('/\s*\(.*?\)\s*/', '', $selectedDeparture));
    $selectedArrival = trim(preg_replace('/\s*\(.*?\)\s*/', '', $selectedArrival));

    if ($selectedDeparture === '' || $selectedDeparture === 'Select Departure') {
        $selectedDeparture = $flight->origin;
    }

    if ($selectedArrival === '' || $selectedArrival === 'Pilih Tujuan' || $selectedArrival === 'Select Arrival') {
        $selectedArrival = $flight->destination;
    }

    $displayDate = request('date')
        ? \Carbon\Carbon::parse(request('date'))->format('d M Y')
        : \Carbon\Carbon::parse($flight->departure_date)->format('d M Y');

    $rawDate = request('date') ?: $flight->departure_date;

    $economyPrice = (int) $flight->price;
    $businessPrice = (int) $flight->price + 2000000;

    $originCode = strtoupper(substr($selectedDeparture, 0, 3));
    $destinationCode = strtoupper(substr($selectedArrival, 0, 3));

    $flightAirlineLower = strtolower($flight->airline);

    if (str_contains($flightAirlineLower, 'emirate')) {
        $flightLogo = 'emirates.svg';
    } elseif (str_contains($flightAirlineLower, 'singapore')) {
        $flightLogo = 'singapore-airlines.svg';
    } else {
        $flightLogo = 'ana.svg';
    }

    $flightTypeText = 'Direct Flight';

    if ($flight->flight_type === 'transit_1x') {
        $flightTypeText = 'Transit 1x';
    } elseif ($flight->flight_type === 'transit_2x') {
        $flightTypeText = 'Transit 2x';
    }

    $economyQuery = http_build_query([
        'tier' => 'economy',
        'class' => 'Economy',
        'price' => $economyPrice,
        'quantity' => $quantity,
        'date' => $rawDate,
        'departure' => $selectedDeparture,
        'arrival' => $selectedArrival,
    ]);

    $businessQuery = http_build_query([
        'tier' => 'business',
        'class' => 'Business',
        'price' => $businessPrice,
        'quantity' => $quantity,
        'date' => $rawDate,
        'departure' => $selectedDeparture,
        'arrival' => $selectedArrival,
    ]);
@endphp

<body>
    <div id="Background"
        class="absolute top-0 w-full h-[810px] bg-[linear-gradient(180deg,#85C8FF_0%,#D4D1FE_47.05%,#F3F6FD_100%)]">
        <img src="/garuda/assets/images/backgrounds/Jumbo Jet Sky (1) 1.png"
            class="absolute right-0 top-[147px] object-contain max-h-[481px]" alt="background image">
    </div>

    <nav class="relative flex justify-center px-[75px] mt-[30px]">
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

            <div class="flex items-center gap-3 shrink-0">
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

    <main class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto mt-[50px] mb-[62px]">
        <a href="/available-flights"
            class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
            <img src="/garuda/assets/images/icons/arrow-left-white.svg" class="w-6 h-6" alt="icon">
            <p class="font-semibold text-white">Back to Choose Flight</p>
        </a>

        <h1 class="font-extrabold text-[50px] leading-[75px] mt-[30px]">Choose Tiers</h1>

        <div class="flex gap-[30px] mt-[30px]">
            <div id="Flight-Info" class="flex flex-col w-[470px] shrink-0 h-fit rounded-[20px] bg-white p-5 gap-5">
                <h2 class="font-bold text-xl leading-[30px]">Your Flight</h2>

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
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-[10px]">
                                <img src="/garuda/assets/images/logos/{{ $flightLogo }}"
                                    class="w-[60px] h-[60px] flex shrink-0 object-contain" alt="logo">

                                <div>
                                    <p class="font-semibold">{{ $flight->airline }}</p>
                                    <p class="text-sm text-garuda-grey mt-[2px]">
                                        {{ $flight->departure_time }} - {{ $flight->arrival_time }}
                                    </p>
                                </div>
                            </div>

                            <a href="#"
                                class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
                                <p class="font-semibold text-white">Details</p>
                            </a>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex flex-col gap-[2px] items-center justify-center">
                                <p class="text-sm text-garuda-grey">{{ $flightTypeText }}</p>

                                <div class="flex items-center gap-[6px]">
                                    <p class="font-semibold">{{ $originCode }}</p>
                                    <img src="/garuda/assets/images/icons/direct-black.svg" alt="icon">
                                    <p class="font-semibold">{{ $destinationCode }}</p>
                                </div>

                                <p class="text-sm text-garuda-grey">{{ $flight->flight_number }}</p>
                            </div>

                            <p class="font-semibold text-garuda-green text-center">
                                Mulai Rp {{ number_format($economyPrice, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="Tiers" class="grid grid-cols-2 gap-x-[30px]">
                <div id="Economy" class="flex flex-col h-fit rounded-[20px] p-5 pb-[30px] gap-5 bg-white">
                    <div class="w-[260px] h-[180px] rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                        <img src="/garuda/assets/images/thumbnails/economy-seat.png"
                            class="w-full h-full object-cover" alt="thumbnails">
                    </div>

                    <div class="flex flex-col gap-1">
                        <p class="font-semibold text-lg">Economy Class</p>
                        <p class="font-extrabold text-[32px] leading-[48px]">
                            Rp {{ number_format($economyPrice, 0, ',', '.') }}
                        </p>
                    </div>

                    <hr class="border-[#E8EFF7]">

                    <div class="flex items-center gap-[10px]">
                        <img src="/garuda/assets/images/icons/box-black.svg" class="w-6 h-6 flex shrink-0" alt="icon">
                        <p class="font-semibold">Baggages 10kg</p>
                    </div>

                    <div class="flex items-center gap-[10px]">
                        <img src="/garuda/assets/images/icons/electricity-black.svg" class="w-6 h-6 flex shrink-0"
                            alt="icon">
                        <p class="font-semibold">USB C Port</p>
                    </div>

                    <div class="flex items-center gap-[10px]">
                        <img src="/garuda/assets/images/icons/security-user-black.svg" class="w-6 h-6 flex shrink-0"
                            alt="icon">
                        <p class="font-semibold">Safety Support</p>
                    </div>

                    <a href="{{ route('booking.seats', $flight->id) }}?{{ $economyQuery }}"
                        class="w-full rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                        <span class="font-semibold text-white">Choose</span>
                    </a>
                </div>

                <div id="Business" class="flex flex-col h-fit rounded-[20px] p-5 pb-[30px] gap-5 bg-white">
                    <div class="w-[260px] h-[180px] rounded-[30px] bg-[#D9D9D9] overflow-hidden">
                        <img src="/garuda/assets/images/thumbnails/business-seat.png"
                            class="w-full h-full object-cover" alt="thumbnails">
                    </div>

                    <div class="flex flex-col gap-1">
                        <p class="font-semibold text-lg">Business Class</p>
                        <p class="font-extrabold text-[32px] leading-[48px]">
                            Rp {{ number_format($businessPrice, 0, ',', '.') }}
                        </p>
                    </div>

                    <hr class="border-[#E8EFF7]">

                    <div class="flex items-center gap-[10px]">
                        <img src="/garuda/assets/images/icons/box-black.svg" class="w-6 h-6 flex shrink-0" alt="icon">
                        <p class="font-semibold">Baggages 10kg</p>
                    </div>

                    <div class="flex items-center gap-[10px]">
                        <img src="/garuda/assets/images/icons/coffee-black.svg" class="w-6 h-6 flex shrink-0"
                            alt="icon">
                        <p class="font-semibold">Heavy Meals</p>
                    </div>

                    <div class="flex items-center gap-[10px]">
                        <img src="/garuda/assets/images/icons/wifi-black.svg" class="w-6 h-6 flex shrink-0" alt="icon">
                        <p class="font-semibold">Wi-Fi Onboard</p>
                    </div>

                    <div class="flex items-center gap-[10px]">
                        <img src="/garuda/assets/images/icons/video-play-black.svg" class="w-6 h-6 flex shrink-0"
                            alt="icon">
                        <p class="font-semibold">Entertainment</p>
                    </div>

                    <div class="flex items-center gap-[10px]">
                        <img src="/garuda/assets/images/icons/electricity-black.svg" class="w-6 h-6 flex shrink-0"
                            alt="icon">
                        <p class="font-semibold">USB C Port</p>
                    </div>

                    <div class="flex items-center gap-[10px]">
                        <img src="/garuda/assets/images/icons/security-user-black.svg" class="w-6 h-6 flex shrink-0"
                            alt="icon">
                        <p class="font-semibold">Safety Support</p>
                    </div>

                    <a href="{{ route('booking.seats', $flight->id) }}?{{ $businessQuery }}"
                        class="w-full rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                        <span class="font-semibold text-white">Choose</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>