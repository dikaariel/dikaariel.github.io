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
    $departureText = request('departure') ?: (request('origin') ? request('origin') : 'Jakarta (CGK)');
    $arrivalText = request('arrival') ?: (request('destination') ? request('destination') : 'Pilih Tujuan');
    $dateText = request('date') ? \Carbon\Carbon::parse(request('date'))->format('d M Y') : 'Select Date';
    $quantity = (int) request('quantity', 1);

    if ($quantity < 1) {
        $quantity = 1;
    }

    $selectedAirlines = request('airlines', []);

    if (!is_array($selectedAirlines)) {
        $selectedAirlines = [$selectedAirlines];
    }
@endphp

<body>
    <div id="Background"
        class="absolute top-0 w-full h-[810px] bg-[linear-gradient(180deg,#85C8FF_0%,#D4D1FE_47.05%,#F3F6FD_100%)]">
        <img src="/garuda/assets/images/backgrounds/Jumbo Jet Sky (1) 1.png"
            class="absolute right-0 top-[147px] object-contain max-h-[481px]" alt="background image">
    </div>

    <nav class="relative flex justify-center px-[75px] mt-[30px]">
        <div class="flex items-center w-full max-w-[1130px] rounded-[20px] justify-between py-4 px-5 bg-white">
            <a href="/">
                <img src="/garuda/assets/images/logos/logo.svg" class="flex shrink-0 h-10" alt="logo">
            </a>

            <ul class="flex items-center gap-[30px] flex-wrap">
                <li>
                    <a href="/available-flights" class="hover:font-bold transition-all duration-300 font-bold">
                        Flights
                    </a>
                </li>
                <li>
                    <a href="#" class="hover:font-bold transition-all duration-300">
                        Hotels
                    </a>
                </li>
                <li>
                    <a href="#" class="hover:font-bold transition-all duration-300">
                        Schedule
                    </a>
                </li>
                <li>
                    <a href="#" class="hover:font-bold transition-all duration-300">
                        Testimonials
                    </a>
                </li>
            </ul>

            <div class="flex items-center gap-3 even:w-[139px] shrink-0">
                <a href="#" class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px]">
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
        <h1 class="font-extrabold text-[50px] leading-[75px]">Flight Search</h1>

        <div class="flex w-fit rounded-[20px] p-5 gap-[30px] bg-white mt-5">
            <div class="flex flex-col gap-[2px]">
                <p class="text-sm text-garuda-grey">Departure</p>
                <p class="font-semibold text-lg">{{ $departureText }}</p>
            </div>

            <div class="flex flex-col gap-[2px]">
                <p class="text-sm text-garuda-grey">Arrival</p>
                <p class="font-semibold text-lg">{{ $arrivalText }}</p>
            </div>

            <div class="flex flex-col gap-[2px]">
                <p class="text-sm text-garuda-grey">Date</p>
                <p class="font-semibold text-lg">{{ $dateText }}</p>
            </div>

            <div class="flex flex-col gap-[2px]">
                <p class="text-sm text-garuda-grey">Quantity</p>
                <p class="font-semibold text-lg">{{ $quantity }} people</p>
            </div>
        </div>

        <div class="flex gap-[26px] mt-[30px]">
            <form id="Filter" action="{{ route('flights.available') }}" method="GET"
                class="flex flex-col w-[320px] shrink-0 h-fit rounded-3xl border border-[#E8EFF7] p-5 gap-5 bg-white">

                <input type="hidden" name="departure" value="{{ request('departure') }}">
                <input type="hidden" name="origin" value="{{ request('origin') }}">
                <input type="hidden" name="arrival" value="{{ request('arrival') }}">
                <input type="hidden" name="destination" value="{{ request('destination') }}">
                <input type="hidden" name="date" value="{{ request('date') }}">
                <input type="hidden" name="quantity" value="{{ $quantity }}">

                <h2 class="font-bold text-xl leading-[30px]">Filters Ticket</h2>

                <div id="Flights" class="flex flex-col gap-4">
                    <p class="font-semibold">Flights</p>

                    <label class="flex items-center gap-[10px]">
                        <input type="checkbox" name="flight_type" value="direct"
                            onchange="this.form.submit()"
                            {{ request('flight_type') === 'direct' ? 'checked' : '' }}
                            class="flex w-6 h-6 shrink-0 appearance-none outline-none rounded-lg ring-1 ring-garuda-black border border-white checked:bg-black checked:border-[5px]">
                        <span class="font-semibold">Direct Flight</span>
                    </label>

                    <label class="flex items-center gap-[10px] opacity-50">
                        <input type="checkbox" disabled
                            class="flex w-6 h-6 shrink-0 appearance-none outline-none rounded-lg ring-1 ring-garuda-black border border-white">
                        <span class="font-semibold">Transit 1x</span>
                    </label>

                    <label class="flex items-center gap-[10px] opacity-50">
                        <input type="checkbox" disabled
                            class="flex w-6 h-6 shrink-0 appearance-none outline-none rounded-lg ring-1 ring-garuda-black border border-white">
                        <span class="font-semibold">Transit 2x</span>
                    </label>
                </div>

                <hr class="border-[#E8EFF7]">

                <div id="Airlines" class="flex flex-col gap-4">
                    <p class="font-semibold">Airlines</p>

                    @forelse ($airlineOptions as $airline)
                        @php
                            $airlineLower = strtolower($airline);

                            if (str_contains($airlineLower, 'emirate')) {
                                $logo = 'emirates.svg';
                            } elseif (str_contains($airlineLower, 'singapore')) {
                                $logo = 'singapore-airlines.svg';
                            } else {
                                $logo = 'ana.svg';
                            }
                        @endphp

                        <label class="flex items-center gap-[10px] cursor-pointer">
                            <input type="checkbox"
                                name="airlines[]"
                                value="{{ $airline }}"
                                onchange="this.form.submit()"
                                {{ in_array($airline, $selectedAirlines) ? 'checked' : '' }}
                                class="flex w-6 h-6 shrink-0 appearance-none outline-none rounded-lg ring-1 ring-garuda-black border border-white checked:bg-black checked:border-[5px]">

                            <img src="/garuda/assets/images/logos/{{ $logo }}" alt="logo">

                            <div class="flex flex-col gap-[2px]">
                                <span class="font-semibold">{{ $airline }}</span>
                                <span class="text-sm text-garuda-grey">Available</span>
                            </div>
                        </label>
                    @empty
                        <p class="text-sm text-garuda-grey">Belum ada maskapai.</p>
                    @endforelse

                    @if (request()->filled('airlines') || request()->filled('destination') || request()->filled('arrival') || request()->filled('date'))
                        <a href="{{ route('flights.available') }}"
                            class="mt-2 w-full rounded-full py-3 px-5 text-center bg-garuda-black text-white font-semibold">
                            Reset Filter
                        </a>
                    @endif
                </div>

                <hr class="border-[#E8EFF7]">

                <div id="Facilities" class="flex flex-col gap-4">
                    <p class="font-semibold">Facilities</p>

                    <label class="flex items-center gap-[10px] opacity-70">
                        <input type="checkbox" name="facilities[]" value="baggage"
                            class="flex w-6 h-6 shrink-0 appearance-none outline-none rounded-lg ring-1 ring-garuda-black border border-white checked:bg-black checked:border-[5px]">
                        <img src="/garuda/assets/images/icons/box-black.svg" alt="icon">
                        <span class="font-semibold">Baggage</span>
                    </label>

                    <label class="flex items-center gap-[10px] opacity-70">
                        <input type="checkbox" name="facilities[]" value="entertainment"
                            class="flex w-6 h-6 shrink-0 appearance-none outline-none rounded-lg ring-1 ring-garuda-black border border-white checked:bg-black checked:border-[5px]">
                        <img src="/garuda/assets/images/icons/video-play-black.svg" alt="icon">
                        <span class="font-semibold">Entertainment</span>
                    </label>

                    <label class="flex items-center gap-[10px] opacity-70">
                        <input type="checkbox" name="facilities[]" value="usb"
                            class="flex w-6 h-6 shrink-0 appearance-none outline-none rounded-lg ring-1 ring-garuda-black border border-white checked:bg-black checked:border-[5px]">
                        <img src="/garuda/assets/images/icons/electricity-black.svg" alt="icon">
                        <span class="font-semibold">USB C and Port</span>
                    </label>

                    <label class="flex items-center gap-[10px] opacity-70">
                        <input type="checkbox" name="facilities[]" value="wifi"
                            class="flex w-6 h-6 shrink-0 appearance-none outline-none rounded-lg ring-1 ring-garuda-black border border-white checked:bg-black checked:border-[5px]">
                        <img src="/garuda/assets/images/icons/wifi-black.svg" alt="icon">
                        <span class="font-semibold">Wi-Fi Onboard</span>
                    </label>

                    <label class="flex items-center gap-[10px] opacity-70">
                        <input type="checkbox" name="facilities[]" value="meals"
                            class="flex w-6 h-6 shrink-0 appearance-none outline-none rounded-lg ring-1 ring-garuda-black border border-white checked:bg-black checked:border-[5px]">
                        <img src="/garuda/assets/images/icons/coffee-black.svg" alt="icon">
                        <span class="font-semibold">Heavy Meals</span>
                    </label>
                </div>
            </form>

            <div id="Result" class="flex flex-col w-full h-fit rounded-3xl p-5 gap-5 bg-white">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold text-xl leading-[30px]">Available Flights</h2>

                    <p class="text-sm text-garuda-grey">
                        {{ $flights->count() }} flight(s) found
                    </p>
                </div>

                @forelse ($flights as $flight)
                    @php
                        $flightAirlineLower = strtolower($flight->airline);

                        if (str_contains($flightAirlineLower, 'emirate')) {
                            $flightLogo = 'emirates.svg';
                        } elseif (str_contains($flightAirlineLower, 'singapore')) {
                            $flightLogo = 'singapore-airlines.svg';
                        } else {
                            $flightLogo = 'ana.svg';
                        }
                    @endphp

                    <div
                        class="direct-card accordion flex flex-col w-full rounded-[20px] border border-garuda-blue py-5 px-6 gap-5 overflow-hidden has-[:checked]:!h-[110px] has-[:checked]:border-[#E8EFF7] hover:!border-garuda-blue transition-all duration-300">

                        <label class="accordion-trigger flex items-center justify-between">
                            <input type="checkbox" name="accordion-input" class="hidden" checked>

                            <div class="flex items-center gap-[10px]">
                                <img src="/garuda/assets/images/logos/{{ $flightLogo }}" class="w-[60px] h-[60px] flex shrink-0" alt="logo">

                                <div>
                                    <p class="font-semibold">{{ $flight->airline }}</p>
                                    <p class="text-sm text-garuda-grey mt-[2px]">
                                        {{ $flight->departure_time }} - {{ $flight->arrival_time }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-[2px] items-center justify-center">
                                <p class="text-sm text-garuda-grey">Direct Flight</p>

                                <div class="flex items-center gap-[6px]">
                                    <p class="font-semibold">{{ strtoupper(substr($flight->origin, 0, 3)) }}</p>
                                    <img src="/garuda/assets/images/icons/direct-black.svg" alt="icon">
                                    <p class="font-semibold">{{ strtoupper(substr($flight->destination, 0, 3)) }}</p>
                                </div>

                                <p class="text-sm text-garuda-grey">{{ $flight->flight_number }}</p>
                            </div>

                            <p class="min-w-[120px] font-semibold text-garuda-green text-center">
                                Rp {{ number_format($flight->price, 0, ',', '.') }}
                            </p>

                            <a href="{{ route('booking.tiers', $flight->id) }}?quantity={{ $quantity }}&date={{ request('date') }}"
                                class="rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                                <span class="font-semibold text-white">Choose</span>
                            </a>
                        </label>

                        <hr class="border-[#E8EFF7]">

                        <div class="accordion-content flex justify-between">
                            <div class="left-content flex flex-col gap-[10px]">
                                <div class="departure flex items-center gap-5">
                                    <div class="text-center w-[83px]">
                                        <p class="font-semibold">{{ $flight->departure_time }}</p>
                                        <p class="text-sm text-garuda-grey mt-[2px]">
                                            {{ \Carbon\Carbon::parse($flight->departure_date)->format('d M Y') }}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <img src="/garuda/assets/images/icons/departure.svg" class="w-[50px] h-[50px] flex shrink-0"
                                            alt="icon">

                                        <div>
                                            <p class="text-sm text-garuda-grey mt-[2px]">Departure</p>
                                            <p class="font-semibold">{{ $flight->origin }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="time flex flex-col items-center w-[83px]">
                                    <div class="h-8 border border-garuda-black border-dashed"></div>
                                    <p class="text-xs leading-[18px] text-garuda-grey">Flight</p>
                                    <div class="h-8 border border-garuda-black border-dashed"></div>
                                </div>

                                <div class="arrival flex items-center gap-5">
                                    <div class="text-center w-[83px]">
                                        <p class="font-semibold">{{ $flight->arrival_time }}</p>
                                        <p class="text-sm text-garuda-grey mt-[2px]">
                                            {{ \Carbon\Carbon::parse($flight->departure_date)->format('d M Y') }}
                                        </p>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <img src="/garuda/assets/images/icons/arrival.svg" class="w-[50px] h-[50px] flex shrink-0"
                                            alt="icon">

                                        <div>
                                            <p class="text-sm text-garuda-grey mt-[2px]">Arrival</p>
                                            <p class="font-semibold">{{ $flight->destination }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="grid grid-cols-2 w-[320px] shrink-0 h-fit p-5 gap-y-6 justify-between rounded-[30px] bg-garuda-bg-grey">

                                <div class="flex items-center gap-3 even:w-[139px] shrink-0">
                                    <img src="/garuda/assets/images/icons/box-black.svg" class="w-6 h-6 flex shrink-0" alt="icon">
                                    <div>
                                        <p class="font-semibold text-sm">Baggages</p>
                                        <p class="text-xs leading-[18px] text-garuda-grey">Included</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 even:w-[139px] shrink-0">
                                    <img src="/garuda/assets/images/icons/video-play-black.svg" class="w-6 h-6 flex shrink-0"
                                        alt="icon">
                                    <div>
                                        <p class="font-semibold text-sm">Entertainment</p>
                                        <p class="text-xs leading-[18px] text-garuda-grey">Included</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 even:w-[139px] shrink-0">
                                    <img src="/garuda/assets/images/icons/electricity-black.svg" class="w-6 h-6 flex shrink-0"
                                        alt="icon">
                                    <div>
                                        <p class="font-semibold text-sm">USB C Port</p>
                                        <p class="text-xs leading-[18px] text-garuda-grey">Included</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 even:w-[139px] shrink-0">
                                    <img src="/garuda/assets/images/icons/coffee-black.svg" class="w-6 h-6 flex shrink-0"
                                        alt="icon">
                                    <div>
                                        <p class="font-semibold text-sm">Heavy Meals</p>
                                        <p class="text-xs leading-[18px] text-garuda-grey">Included</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 even:w-[139px] shrink-0">
                                    <img src="/garuda/assets/images/icons/security-user-black.svg" class="w-6 h-6 flex shrink-0"
                                        alt="icon">
                                    <div>
                                        <p class="font-semibold text-sm">Lifeguard</p>
                                        <p class="text-xs leading-[18px] text-garuda-grey">Included</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 even:w-[139px] shrink-0">
                                    <img src="/garuda/assets/images/icons/wifi-black.svg" class="w-6 h-6 flex shrink-0" alt="icon">
                                    <div>
                                        <p class="font-semibold text-sm">Wi-fi Onboard</p>
                                        <p class="text-xs leading-[18px] text-garuda-grey">Included</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center rounded-[20px] border border-[#E8EFF7] p-10 text-center">
                        <h3 class="font-bold text-xl">Belum ada penerbangan tersedia.</h3>

                        <p class="text-garuda-grey mt-2">
                            Tidak ada data penerbangan yang cocok dengan filter atau destinasi yang dipilih.
                        </p>

                        <div class="flex items-center gap-3 mt-5">
                            <a href="{{ route('flights.available') }}"
                                class="rounded-full py-3 px-5 text-center bg-garuda-black transition-all duration-300">
                                <span class="font-semibold text-white">Reset Filter</span>
                            </a>

                            <a href="/admin/flights"
                                class="rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                                <span class="font-semibold text-white">Kelola Data Penerbangan</span>
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </main>

    <script src="/garuda/js/accodion.js"></script>
</body>

</html>