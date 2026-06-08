<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/garuda/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
</head>

<body>
    <div id="Background-home" class="absolute w-full h-full top-0 bg-white">
        <div class="absolute top-0 w-full h-[1020px] bg-[linear-gradient(180deg,#85C8FF_0%,#D4D1FE_47.05%,#F5F6FB_77.08%,#FFFFFF_100%)]">
            <img src="/garuda/assets/images/backgrounds/Jumbo Jet Sky (1) 1.png"
                class="absolute right-0 top-[147px] object-contain max-h-[481px]" alt="background image">
        </div>
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

            <div class="flex items-center gap-3">
                <a href="#" class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px]">
                    <img src="/garuda/assets/images/icons/call-calling-black.svg" class="w-5 h-5 flex shrink-0" alt="icon">
                    <span class="font-semibold">Call Us</span>
                </a>

                <a href="/my-booking" class="flex items-center rounded-full border border-garuda-black py-3 px-5 gap-[10px] bg-garuda-black">
                    <img src="/garuda/assets/images/icons/note-favorite-white.svg" class="w-5 h-5 flex shrink-0" alt="icon">
                    <span class="font-semibold text-white">My Booking</span>
                </a>
            </div>
        </div>
    </nav>

    <div id="Hero-Text" class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto gap-[30px] mt-[86px]">
        <div class="Badge flex items-center w-fit rounded-full p-[8px_14px] gap-[10px] bg-white">
            <img src="/garuda/assets/images/icons/crown-black.svg" class="w-5 h-5 flex shrink-0" alt="icon">
            <p class="font-semibold text-sm">Top Flight Awards Fly Group Sky 500</p>
        </div>

        <h1 class="font-extrabold text-[50px] leading-[75px]">
            Explore Magical <br>Wonderful Worlds
        </h1>

        <p class="text-lg leading-8">
            Book your next flight based on available flight data <br>
            from the database.
        </p>
    </div>

    <form action="/available-flights" method="GET" class="relative flex flex-col w-full max-w-[1280px] px-[75px] mx-auto mt-[86px]">
        <input type="hidden" name="departure" id="departureText" value="">
        <input type="hidden" name="origin" id="originValue" value="">
        <input type="hidden" name="arrival" id="arrivalText" value="">
        <input type="hidden" name="destination" id="destinationValue" value="">
        <input type="hidden" name="quantity" id="quantity" value="1">

        <div class="flex flex-col rounded-[30px] p-[30px] gap-4 bg-white">
            <h2 class="font-bold text-xl leading-[30px]">Book Your Next Flight</h2>

            <div class="flex items-center gap-5">
                <div class="grid grid-cols-4 items-center rounded-[20px] border border-[#E8EFF7]">

                    <div id="Departure" class="dropdown-container relative flex items-center h-full border-r border-[#E8EFF7]">
                        <button type="button" class="dropdown flex items-center gap-4 p-5 first:pl-6" data-dropdown-target="#Departure-Dropdown">
                            <img src="/garuda/assets/images/icons/departure.svg" class="w-[50px] flex shrink-0" alt="icon">
                            <div class="text-left">
                                <p class="text-sm text-garuda-grey">Departure</p>
                                <p id="Departure-Label" class="font-semibold text-lg mt-[2px] text-nowrap">Select Departure</p>
                            </div>
                        </button>

                        <div id="Departure-Dropdown" class="dropdown-content hidden absolute z-10 top-full mt-4 h-[300px] rounded-[18px] bg-white border border-[#E8EFF7] overflow-y-scroll custom-scrollbar">
                            <div class="flex flex-col justify-center w-[483px] p-5 gap-4 shrink-0">
                                @forelse ($departureOptions as $origin)
                                    <label class="departure-option relative flex items-center rounded-[10px] gap-[10px] p-[10px] hover:bg-garuda-bg-grey transition-all duration-300 cursor-pointer"
                                        data-label="{{ $origin }}"
                                        data-origin="{{ $origin }}">
                                        <input type="radio" name="departure-radio" class="absolute top-1/2 left-1/2 opacity-0">
                                        <img src="/garuda/assets/images/icons/airplane-black.svg" class="flex shrink-0 w-[34px]" alt="icon">
                                        <div>
                                            <p class="font-semibold">{{ $origin }}</p>
                                            <p class="text-sm text-garuda-grey">Available Departure</p>
                                        </div>
                                    </label>

                                    <hr class="border-[#E8EFF7]">
                                @empty
                                    <p class="text-sm text-garuda-grey">Belum ada data asal penerbangan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div id="Arrival" class="dropdown-container relative flex items-center h-full border-r border-[#E8EFF7]">
                        <button type="button" class="dropdown flex items-center gap-4 p-5 first:pl-6" data-dropdown-target="#Arrival-Dropdown">
                            <img src="/garuda/assets/images/icons/departure.svg" class="w-[50px] flex shrink-0" alt="icon">
                            <div class="text-left">
                                <p class="text-sm text-garuda-grey">Arrival</p>
                                <p id="Arrival-Label" class="font-semibold text-lg mt-[2px] text-nowrap">Select Arrival</p>
                            </div>
                        </button>

                        <div id="Arrival-Dropdown" class="dropdown-content hidden absolute z-10 top-full mt-4 h-[300px] rounded-[18px] bg-white border border-[#E8EFF7] overflow-y-scroll custom-scrollbar">
                            <div class="flex flex-col justify-center w-[483px] p-5 gap-4 shrink-0">
                                @forelse ($arrivalOptions as $destination)
                                    <label class="arrival-option relative flex items-center rounded-[10px] gap-[10px] p-[10px] hover:bg-garuda-bg-grey transition-all duration-300 cursor-pointer"
                                        data-label="{{ $destination }}"
                                        data-destination="{{ $destination }}">
                                        <input type="radio" name="arrival-radio" class="absolute top-1/2 left-1/2 opacity-0">
                                        <img src="/garuda/assets/images/icons/airplane-black.svg" class="flex shrink-0 w-[34px]" alt="icon">
                                        <div>
                                            <p class="font-semibold">{{ $destination }}</p>
                                            <p class="text-sm text-garuda-grey">Available Destination</p>
                                        </div>
                                    </label>

                                    <hr class="border-[#E8EFF7]">
                                @empty
                                    <p class="text-sm text-garuda-grey">Belum ada data tujuan penerbangan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div id="Date" class="dropdown-container relative flex items-center h-full border-r border-[#E8EFF7]">
                        <input type="date" name="date" id="date" class="absolute top-1/2 left-0 opacity-0 w-full h-full cursor-pointer">
                        <button type="button" id="Date-Button" class="relative flex items-center gap-4 p-5 first:pl-6">
                            <img src="/garuda/assets/images/icons/departure.svg" class="w-[50px] flex shrink-0" alt="icon">
                            <div class="text-left">
                                <p class="text-sm text-garuda-grey">Date</p>
                                <p id="Date-Label" class="font-semibold text-lg mt-[2px] text-nowrap">Select Date</p>
                            </div>
                        </button>
                    </div>

                    <div id="Quantity" class="dropdown-container relative flex items-center h-full">
                        <button type="button" class="dropdown flex items-center gap-4 p-5 first:pl-6" data-dropdown-target="#Quantity-Dropdown">
                            <img src="/garuda/assets/images/icons/departure.svg" class="w-[50px] flex shrink-0" alt="icon">
                            <div class="text-left">
                                <p class="text-sm text-garuda-grey">Quantity</p>
                                <p id="Quantity-Label" class="font-semibold text-lg mt-[2px] text-nowrap">
                                    <span class="number">1</span> people
                                </p>
                            </div>
                        </button>

                        <div id="Quantity-Dropdown" class="dropdown-content hidden absolute z-10 top-full mt-4">
                            <div class="flex items-center rounded-[18px] border border-[#E8EFF7] p-5 gap-[28px] bg-white">
                                <button type="button" id="minus" class="w-[38px] h-[38px] flex shrink-0">
                                    <img src="/garuda/assets/images/icons/minus.svg" alt="icon">
                                </button>

                                <p class="font-semibold text-nowrap">
                                    <span class="number">1</span> people
                                </p>

                                <button type="button" id="plus" class="w-[38px] h-[38px] flex shrink-0">
                                    <img src="/garuda/assets/images/icons/plus.svg" alt="icon">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="flex flex-col items-center gap-[6px] rounded-[30px] py-3 px-5 bg-garuda-blue hover:shadow-[0px_14px_30px_0px_#0068FF66] transition-all duration-300">
                    <img src="/garuda/assets/images/icons/search-status-white.svg" class="flex shrink-0 w-[30px]" alt="icon">
                    <p class="text-center font-semibold text-sm text-white">Explore</p>
                </button>
            </div>
        </div>
    </form>

    <section id="Popular" class="relative flex flex-col gap-[30px] mt-[70px] mb-[86px]">
        <div class="w-full max-w-[1280px] px-[75px] mx-auto">
            <h2 class="font-bold text-[28px] leading-[42px]">Popular This Year</h2>
            <p class="text-lg mt-[6px]">Destinations available from your flight database</p>
        </div>

        <div class="swiper !w-full overflow-x-hidden">
            <div class="swiper-wrapper">
                @forelse ($popularDestinations as $index => $destination)
                    @php
                        $thumbnailNumber = ($index % 5) + 1;
                    @endphp

                    <div class="swiper-slide !w-fit {{ $loop->first ? 'first:ml-[calc(((100%-1280px)/2)+75px-24px)]' : '' }}">
                        <a href="/available-flights?destination={{ urlencode($destination) }}&arrival={{ urlencode($destination) }}&quantity=1" class="card">
                            <div class="flex items-end w-[230px] h-[280px] shrink-0 rounded-[30px] bg-white overflow-hidden hover:border-2 hover:border-garuda-blue hover:p-[10px] transition-all duration-300">
                                <img src="/garuda/assets/images/thumbnails/thumbnail-{{ $thumbnailNumber }}.png" class="w-full h-full object-cover rounded-[30px]" alt="thumbnails">

                                <div class="absolute flex w-[210px] items-center bottom-[10px] left-[10px] right-[10px] rounded-[20px] p-[10px] gap-[10px] bg-white">
                                    <img src="/garuda/assets/images/icons/global-black.svg" class="w-6 flex shrink-0" alt="icon">
                                    <div>
                                        <p class="font-semibold">{{ $destination }}</p>
                                        <p class="text-sm text-garuda-grey">Available Destination</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="w-full max-w-[1280px] px-[75px] mx-auto">
                        <div class="bg-white rounded-[30px] p-8">
                            <h3 class="font-bold text-xl">Belum ada destinasi tersedia.</h3>
                            <p class="text-garuda-grey mt-2">
                                Tambahkan data penerbangan melalui halaman admin agar destinasi muncul di sini.
                            </p>

                            <a href="/admin/flights" class="inline-block mt-5 rounded-full py-3 px-5 bg-garuda-blue text-white font-semibold">
                                Kelola Data Penerbangan
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        const dropdownButtons = document.querySelectorAll('.dropdown');

        dropdownButtons.forEach((button) => {
            button.addEventListener('click', function () {
                const target = document.querySelector(this.dataset.dropdownTarget);

                document.querySelectorAll('.dropdown-content').forEach((dropdown) => {
                    if (dropdown !== target) {
                        dropdown.classList.add('hidden');
                    }
                });

                target.classList.toggle('hidden');
            });
        });

        document.addEventListener('click', function (event) {
            if (!event.target.closest('.dropdown-container')) {
                document.querySelectorAll('.dropdown-content').forEach((dropdown) => {
                    dropdown.classList.add('hidden');
                });
            }
        });

        const departureOptions = document.querySelectorAll('.departure-option');
        const arrivalOptions = document.querySelectorAll('.arrival-option');

        const departureLabel = document.getElementById('Departure-Label');
        const arrivalLabel = document.getElementById('Arrival-Label');

        const departureText = document.getElementById('departureText');
        const originValue = document.getElementById('originValue');
        const arrivalText = document.getElementById('arrivalText');
        const destinationValue = document.getElementById('destinationValue');

        departureOptions.forEach((option) => {
            option.addEventListener('click', function () {
                const label = this.dataset.label;
                const origin = this.dataset.origin;

                departureLabel.textContent = label;
                departureText.value = label;
                originValue.value = origin;

                document.getElementById('Departure-Dropdown').classList.add('hidden');
            });
        });

        arrivalOptions.forEach((option) => {
            option.addEventListener('click', function () {
                const label = this.dataset.label;
                const destination = this.dataset.destination;

                arrivalLabel.textContent = label;
                arrivalText.value = label;
                destinationValue.value = destination;

                document.getElementById('Arrival-Dropdown').classList.add('hidden');
            });
        });

        const dateInput = document.getElementById('date');
        const dateButton = document.getElementById('Date-Button');
        const dateLabel = document.getElementById('Date-Label');

        dateButton.addEventListener('click', function () {
            if (dateInput.showPicker) {
                dateInput.showPicker();
            } else {
                dateInput.click();
            }
        });

        dateInput.addEventListener('change', function () {
            if (!this.value) {
                dateLabel.textContent = 'Select Date';
                return;
            }

            const selectedDate = new Date(this.value);
            const options = { day: '2-digit', month: 'short', year: 'numeric' };

            dateLabel.textContent = selectedDate.toLocaleDateString('en-GB', options);
        });

        const minus = document.getElementById('minus');
        const plus = document.getElementById('plus');
        const quantityInput = document.getElementById('quantity');
        const quantityNumbers = document.querySelectorAll('.number');

        let quantity = 1;

        function updateQuantity() {
            quantityInput.value = quantity;

            quantityNumbers.forEach((number) => {
                number.textContent = quantity;
            });
        }

        minus.addEventListener('click', function () {
            if (quantity > 1) {
                quantity--;
                updateQuantity();
            }
        });

        plus.addEventListener('click', function () {
            quantity++;
            updateQuantity();
        });

        updateQuantity();

        const swiper = new Swiper('.swiper', {
            slidesPerView: 'auto',
            spaceBetween: 24,
            freeMode: true,
        });
    </script>
</body>
</html>