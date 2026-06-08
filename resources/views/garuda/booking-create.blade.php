<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/garuda/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
</head>

@php
    $tier = $tier ?? request('tier', 'economy');
    $quantity = (int) ($quantity ?? request('quantity', 1));
    $selectedSeats = $selectedSeats ?? request('seats', '');

    if ($quantity < 1) {
        $quantity = 1;
    }

    $className = $tier === 'business' ? 'Business Class' : 'Economy Class';
    $seatImage = $tier === 'business' ? 'business-seat.png' : 'economy-seat.png';
    $pricePerTicket = $tier === 'business' ? $flight->price + 2000000 : $flight->price;

    $subTotal = $pricePerTicket * $quantity;
    $tax = round($subTotal * 0.11);
    $grandTotal = $subTotal + $tax;

    $displayDate = \Carbon\Carbon::parse($flight->departure_date)->format('d M Y');
    $originCode = strtoupper(substr($flight->origin, 0, 3));
    $destinationCode = strtoupper(substr($flight->destination, 0, 3));
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
                    <a href="/available-flights" class="hover:font-bold transition-all duration-300 font-bold">Flights</a>
                </li>
                <li>
                    <a href="#" class="hover:font-bold transition-all duration-300">Hotels</a>
                </li>
                <li>
                    <a href="#" class="hover:font-bold transition-all duration-300">Schedule</a>
                </li>
                <li>
                    <a href="#" class="hover:font-bold transition-all duration-300">Testimonials</a>
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
        <a href="{{ route('booking.seats', $flight->id) }}?tier={{ $tier }}&quantity={{ $quantity }}"
            class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
            <img src="/garuda/assets/images/icons/arrow-left-white.svg" class="w-6 h-6" alt="icon">
            <p class="font-semibold text-white">Back to Choose Seats</p>
        </a>

        <h1 class="font-extrabold text-[50px] leading-[75px] mt-[30px]">Passenger Details</h1>

        <div class="flex gap-[30px] mt-[30px]">
            <div id="Left-Content" class="flex flex-col gap-[30px] w-[470px] shrink-0">
                <div id="Flight-Info"
                    class="accordion group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden">
                    <label class="flex items-center justify-between p-5">
                        <h2 class="font-bold text-xl leading-[30px]">Your Flight</h2>
                        <img src="/garuda/assets/images/icons/arrow-up-circle-black.svg" class="w-9 h-8" alt="icon">
                    </label>

                    <div class="p-5 pt-0 flex flex-col gap-5">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-garuda-grey">Departure</p>
                                <p class="font-semibold text-lg">{{ $flight->origin }}</p>
                            </div>

                            <div class="text-end">
                                <p class="text-sm text-garuda-grey">Arrival</p>
                                <p class="font-semibold text-lg">{{ $flight->destination }}</p>
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
                                        <img src="/garuda/assets/images/logos/ana.svg" class="h-[80px] flex shrink-0" alt="logo">
                                    </div>

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

                <div id="Transaction-Info" class="flex flex-col h-fit rounded-[20px] bg-white overflow-hidden">
                    <label class="flex items-center justify-between p-5">
                        <h2 class="font-bold text-xl leading-[30px]">Transaction Details</h2>
                        <img src="/garuda/assets/images/icons/arrow-up-circle-black.svg" class="w-9 h-8" alt="icon">
                    </label>

                    <div class="p-5 pt-0 flex flex-col gap-5">
                        <div class="flex justify-between">
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

                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-garuda-grey">Price</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]">
                                    Rp {{ number_format($subTotal, 0, ',', '.') }}
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

                        <div class="flex justify-between items-center">
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

            <div id="Right-Content" class="w-[520px] flex flex-col gap-[20px]">
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded-[20px]">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="list-disc ml-5 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('booking.store', $flight->id) }}" method="POST" class="flex flex-col gap-[20px]">
                    @csrf

                    <input type="hidden" name="tier" value="{{ $tier }}">
                    <input type="hidden" name="quantity" value="{{ $quantity }}">
                    <input type="hidden" name="selected_seats" value="{{ $selectedSeats }}">

                    <div class="flex flex-col rounded-[20px] bg-white p-5 gap-5">
                        <div class="flex items-center justify-between">
                            <h2 class="font-bold text-xl leading-[30px]">Customer Information</h2>
                            <img src="/garuda/assets/images/icons/arrow-up-circle-black.svg" class="w-9 h-8" alt="icon">
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Complete Name</label>
                            <input type="text" name="passenger_name" value="{{ old('passenger_name') }}"
                                class="w-full mt-2 px-5 py-4 rounded-full bg-[#F5F6FB] border border-[#E8EFF7] outline-none"
                                placeholder="Write your complete name" required>
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Email Address</label>
                            <input type="email" name="passenger_email" value="{{ old('passenger_email') }}"
                                class="w-full mt-2 px-5 py-4 rounded-full bg-[#F5F6FB] border border-[#E8EFF7] outline-none"
                                placeholder="Write your valid email" required>
                        </div>

                        <div>
                            <label class="font-semibold text-sm">Phone No.</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number') }}"
                                class="w-full mt-2 px-5 py-4 rounded-full bg-[#F5F6FB] border border-[#E8EFF7] outline-none"
                                placeholder="Write your active number" required>
                        </div>
                    </div>

                    @for ($i = 1; $i <= $quantity; $i++)
                        <div class="flex flex-col rounded-[20px] bg-white p-5 gap-5">
                            <div class="flex items-center justify-between">
                                <h2 class="font-bold text-xl leading-[30px]">Passenger {{ $i }}</h2>
                                <img src="/garuda/assets/images/icons/arrow-up-circle-black.svg" class="w-9 h-8" alt="icon">
                            </div>

                            <div>
                                <label class="font-semibold text-sm">Complete Name</label>
                                <input type="text" name="passenger_detail_name[]"
                                    class="w-full mt-2 px-5 py-4 rounded-full bg-[#F5F6FB] border border-[#E8EFF7] outline-none"
                                    placeholder="Write passenger name" required>
                            </div>

                            <div>
                                <label class="font-semibold text-sm">Date of Birth</label>
                                <input type="date" name="birth_date[]"
                                    class="w-full mt-2 px-5 py-4 rounded-full bg-[#F5F6FB] border border-[#E8EFF7] outline-none"
                                    required>
                            </div>

                            <div>
                                <label class="font-semibold text-sm">Nationality</label>
                                <input type="text" name="nationality[]"
                                    class="w-full mt-2 px-5 py-4 rounded-full bg-[#F5F6FB] border border-[#E8EFF7] outline-none"
                                    placeholder="Example: Indonesia" required>
                            </div>
                        </div>
                    @endfor

                    <button type="submit"
                        class="w-full rounded-full py-4 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                        <span class="font-semibold text-white">Confirm Booking</span>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <script src="/garuda/js/accodion.js"></script>
</body>
</html>