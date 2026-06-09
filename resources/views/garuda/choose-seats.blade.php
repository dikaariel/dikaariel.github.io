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
    $tier = strtolower(request('tier', $tier ?? 'economy'));
    $quantity = (int) request('quantity', $quantity ?? 1);

    if ($quantity < 1) {
        $quantity = 1;
    }

    $classLabel = request('class') ?: ($tier === 'business' ? 'Business' : 'Economy');
    $className = str_contains(strtolower($classLabel), 'class') ? $classLabel : $classLabel . ' Class';

    $seatImage = $tier === 'business' ? 'business-seat.png' : 'economy-seat.png';

    $defaultPrice = $tier === 'business'
        ? (int) $flight->price + 2000000
        : (int) $flight->price;

    $pricePerTicket = (int) request('price', $defaultPrice);

    $subTotal = $pricePerTicket * $quantity;
    $tax = round($subTotal * 0.11);
    $grandTotal = $subTotal + $tax;

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

    $rawDate = request('date') ?: $flight->departure_date;

    $displayDate = request('date')
        ? \Carbon\Carbon::parse(request('date'))->format('d M Y')
        : \Carbon\Carbon::parse($flight->departure_date)->format('d M Y');

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

    $backQuery = http_build_query([
        'quantity' => $quantity,
        'date' => $rawDate,
        'departure' => $selectedDeparture,
        'arrival' => $selectedArrival,
    ]);

    $disabledSeats = ['A1', 'B3', 'B4', 'D2', 'D3', 'D4', 'E4', 'F4', 'G4'];
    $rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
    $numbers = [1, 2, 3, 4];
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
        <div class="flex">
            <div id="Left-Content" class="flex flex-col gap-[30px] w-[470px] shrink-0">
                <a href="{{ route('booking.tiers', $flight->id) }}?{{ $backQuery }}"
                    class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
                    <img src="/garuda/assets/images/icons/arrow-left-white.svg" class="w-6 h-6" alt="icon">
                    <p class="font-semibold text-white">Back to Choose Class</p>
                </a>

                <h1 class="font-extrabold text-[50px] leading-[75px]">Choose Seats</h1>

                <div id="Flight-Info"
                    class="accordion group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden has-[:checked]:!h-[75px] transition-all duration-300">
                    <label class="flex items-center justify-between p-5">
                        <h2 class="font-bold text-xl leading-[30px]">Your Flight</h2>
                        <img src="/garuda/assets/images/icons/arrow-up-circle-black.svg"
                            class="w-9 h-8 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
                        <input type="checkbox" class="hidden">
                    </label>

                    <div class="accordion-content p-5 pt-0 flex flex-col gap-5">
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
                                            class="h-[100px] flex shrink-0 object-contain" alt="logo">
                                    </div>

                                    <a href="#"
                                        class="flex items-center rounded-[50px] py-3 px-5 gap-[10px] w-fit bg-garuda-black">
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
                                        <p class="text-sm text-garuda-grey">{{ $flightTypeText }}</p>
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

                <div id="Transaction-Info"
                    class="accordion group flex flex-col h-fit rounded-[20px] bg-white overflow-hidden has-[:checked]:!h-[75px] transition-all duration-300">
                    <label class="flex items-center justify-between p-5">
                        <h2 class="font-bold text-xl leading-[30px]">Transaction Details</h2>
                        <img src="/garuda/assets/images/icons/arrow-up-circle-black.svg"
                            class="w-9 h-8 group-has-[:checked]:rotate-180 transition-all duration-300" alt="icon">
                        <input type="checkbox" class="hidden">
                    </label>

                    <div class="accordion-content p-5 pt-0 flex flex-col gap-5">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-garuda-grey">Quantity</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]" id="quantityText">0 People</p>
                            </div>

                            <div>
                                <p class="text-sm text-garuda-grey">Tiers</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]">{{ ucfirst($tier) }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-garuda-grey">Seats</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]" id="selectedSeatsText">-</p>
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <div>
                                <p class="text-sm text-garuda-grey">Price</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]" id="priceText">Rp 0</p>
                            </div>

                            <div>
                                <p class="text-sm text-garuda-grey">Govt. Tax</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]">11%</p>
                            </div>

                            <div>
                                <p class="text-sm text-garuda-grey">Sub Total</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]" id="subTotalText">Rp 0</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-garuda-grey">Total Tax</p>
                                <p class="font-semibold text-lg leading-[27px] mt-[2px]" id="totalTaxText">Rp 0</p>
                            </div>

                            <div>
                                <p class="text-sm text-garuda-grey">Grand Total</p>
                                <p class="font-bold text-2xl leading-9 text-garuda-blue mt-[2px]" id="grandTotalText">
                                    Rp 0
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="Plane" class="relative flex w-[558px] shrink-0 mt-[30px] mx-auto">
                <img id="Plane-Body" src="/garuda/assets/images/backgrounds/plane-body.svg"
                    class="absolute w-full h-full object-contain" alt="background">

                <div class="relative flex flex-col justify-end">
                    <img id="Plane-Windshield" src="/garuda/assets/images/backgrounds/plane-windshield.svg"
                        class="absolute top-16 w-full object-contain px-[56px]" alt="image">

                    <form action="{{ route('booking.create', $flight->id) }}" method="GET"
                        class="relative px-[56px] pb-[60px]" id="form-seat">

                        <input type="hidden" name="tier" value="{{ $tier }}">
                        <input type="hidden" name="class" value="{{ $classLabel }}">
                        <input type="hidden" name="price" value="{{ $pricePerTicket }}">
                        <input type="hidden" name="quantity" value="{{ $quantity }}">
                        <input type="hidden" name="date" value="{{ $rawDate }}">
                        <input type="hidden" name="departure" value="{{ $selectedDeparture }}">
                        <input type="hidden" name="arrival" value="{{ $selectedArrival }}">
                        <input type="hidden" name="seats" id="seatsInput" value="">

                        <p class="text-center font-bold text-xl leading-[30px]">{{ $className }}</p>

                        <div id="Legend" class="flex items-center justify-center mb-[30px] gap-5 mt-5">
                            <div class="flex items-center gap-[6px]">
                                <span class="w-4 h-4 flex shrink-0 rounded-[6px] bg-white border border-[#FFA44B]"></span>
                                <span class="font-semibold">Available</span>
                            </div>

                            <div class="flex items-center gap-[6px]">
                                <span class="w-4 h-4 flex shrink-0 rounded-[6px] bg-[#C2C9DA]"></span>
                                <span class="font-semibold">Booked</span>
                            </div>

                            <div class="flex items-center gap-[6px]">
                                <span class="w-4 h-4 flex shrink-0 rounded-[6px] bg-garuda-blue"></span>
                                <span class="font-semibold">Selected</span>
                            </div>
                        </div>

                        <div id="Seats-Options" class="flex flex-wrap w-full gap-y-8 gap-x-[14px]">
                            @foreach ($rows as $row)
                                @foreach ($numbers as $number)
                                    @php
                                        $seat = $row . $number;
                                        $disabled = in_array($seat, $disabledSeats);
                                    @endphp

                                    <label class="group relative flex w-[55px] h-[52.25px] shrink-0 [&:nth-child(4n+2)]:mr-[46px]">
                                        <input type="checkbox"
                                            value="{{ $seat }}"
                                            class="seat-checkbox absolute top-1/2 left-1/2 opacity-0"
                                            {{ $disabled ? 'disabled' : '' }}>

                                        <img src="/garuda/assets/images/icons/seat.svg"
                                            class="absolute w-full h-full object-contain opacity-100 group-has-[:checked]:opacity-0 group-has-[:disabled]:opacity-0 transition-all duration-300"
                                            alt="seat">

                                        <img src="/garuda/assets/images/icons/seat-choosed.svg"
                                            class="absolute w-full h-full object-contain opacity-0 group-has-[:checked]:opacity-100 group-has-[:disabled]:opacity-0 transition-all duration-300"
                                            alt="seat">

                                        <img src="/garuda/assets/images/icons/seat-disabled.svg"
                                            class="absolute w-full h-full object-contain opacity-0 group-has-[:disabled]:opacity-100 transition-all duration-300"
                                            alt="seat">

                                        <p class="relative flex items-center justify-center h-full w-full pb-[8.25px] font-semibold text-[16.5px] leading-[24.75px] text-premiere-black group-has-[:checked]:text-white">
                                            {{ $seat }}
                                        </p>
                                    </label>
                                @endforeach
                            @endforeach
                        </div>

                        <button type="submit"
                            class="w-full rounded-full py-3 px-5 text-center bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300 mt-[30px]">
                            <span class="font-semibold text-white">Continue Booking</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="/garuda/js/accodion.js"></script>

    <script>
        const requiredQuantity = {{ $quantity }};
        const pricePerTicket = {{ $pricePerTicket }};
        const seatCheckboxes = document.querySelectorAll('.seat-checkbox');
        const seatsInput = document.getElementById('seatsInput');
        const formSeat = document.getElementById('form-seat');

        const quantityText = document.getElementById('quantityText');
        const selectedSeatsText = document.getElementById('selectedSeatsText');
        const priceText = document.getElementById('priceText');
        const subTotalText = document.getElementById('subTotalText');
        const totalTaxText = document.getElementById('totalTaxText');
        const grandTotalText = document.getElementById('grandTotalText');

        function formatRupiah(number) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }

        function getSelectedSeats() {
            return Array.from(seatCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
        }

        function updateTransaction() {
            const selectedSeats = getSelectedSeats();
            const count = selectedSeats.length;
            const subTotal = count * pricePerTicket;
            const tax = Math.round(subTotal * 0.11);
            const grandTotal = subTotal + tax;

            seatsInput.value = selectedSeats.join(',');

            quantityText.textContent = count + ' People';
            selectedSeatsText.textContent = selectedSeats.length ? selectedSeats.join(', ') : '-';
            priceText.textContent = formatRupiah(subTotal);
            subTotalText.textContent = formatRupiah(subTotal);
            totalTaxText.textContent = formatRupiah(tax);
            grandTotalText.textContent = formatRupiah(grandTotal);
        }

        seatCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const selectedSeats = getSelectedSeats();

                if (selectedSeats.length > requiredQuantity) {
                    this.checked = false;
                    alert('Jumlah kursi yang dipilih tidak boleh lebih dari ' + requiredQuantity + ' kursi.');
                }

                updateTransaction();
            });
        });

        formSeat.addEventListener('submit', function (event) {
            const selectedSeats = getSelectedSeats();

            if (selectedSeats.length < requiredQuantity) {
                event.preventDefault();
                alert('Pilih ' + requiredQuantity + ' kursi terlebih dahulu.');
            }
        });

        updateTransaction();
    </script>
</body>

</html>