<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/garuda/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #F5F6FB;
            color: #08041F;
        }

        .navbar-wrapper {
            display: flex;
            justify-content: center;
            padding: 30px 75px 0 75px;
        }

        .navbar {
            width: 100%;
            max-width: 1130px;
            background: white;
            border-radius: 20px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar img.logo {
            height: 40px;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-menu a {
            text-decoration: none;
            color: #08041F;
            font-weight: 500;
        }

        .nav-menu a.active {
            font-weight: 800;
        }

        .logout-btn {
            background: white;
            color: #08041F;
            border: 1px solid #08041F;
            padding: 12px 22px;
            border-radius: 999px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }

        .page-wrapper {
            width: 100%;
            max-width: 1130px;
            margin: 60px auto 90px auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 38px;
            line-height: 56px;
            font-weight: 800;
            margin: 0;
        }

        .page-desc {
            color: #6B7280;
            font-size: 17px;
            margin-top: 8px;
            margin-bottom: 34px;
        }

        .booking-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .booking-card {
            background: white;
            border: 1px solid #E8EFF7;
            border-radius: 30px;
            padding: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            box-shadow: 0 18px 45px rgba(8, 4, 31, 0.04);
        }

        .booking-left {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .icon-circle {
            width: 74px;
            height: 74px;
            border-radius: 999px;
            background: #F5F6FB;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .icon-circle img {
            width: 38px;
        }

        .small-label {
            color: #6B7280;
            font-size: 13px;
            margin: 0 0 4px 0;
        }

        .booking-code {
            color: #0068FF;
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 10px 0;
        }

        .flight-title {
            font-size: 19px;
            font-weight: 800;
            margin: 0;
        }

        .route-text {
            color: #6B7280;
            margin: 5px 0 0 0;
            font-size: 14px;
        }

        .booking-right {
            text-align: right;
            min-width: 210px;
        }

        .status-badge {
            display: inline-block;
            background: #DCFCE7;
            color: #15803D;
            padding: 8px 15px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .price {
            font-size: 24px;
            font-weight: 800;
            margin: 0;
        }

        .ticket-count {
            color: #6B7280;
            margin-top: 4px;
            font-size: 14px;
        }

        .empty-card {
            background: white;
            border: 1px solid #E8EFF7;
            border-radius: 30px;
            padding: 50px;
            text-align: center;
        }

        .empty-card h2 {
            font-size: 24px;
            font-weight: 800;
            margin: 0;
        }

        .empty-card p {
            color: #6B7280;
            margin-top: 10px;
        }

        .primary-btn {
            display: inline-block;
            margin-top: 24px;
            background: #0068FF;
            color: white;
            text-decoration: none;
            padding: 15px 26px;
            border-radius: 999px;
            font-weight: 800;
            box-shadow: 0 14px 30px rgba(0, 104, 255, 0.25);
        }

        @media (max-width: 768px) {
            .navbar-wrapper {
                padding: 20px;
            }

            .navbar {
                flex-direction: column;
                gap: 18px;
            }

            .nav-menu {
                gap: 15px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .booking-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .booking-right {
                text-align: left;
                width: 100%;
            }

            .page-title {
                font-size: 30px;
                line-height: 42px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar-wrapper">
        <div class="navbar">
            <a href="/">
                <img src="/garuda/assets/images/logos/logo.svg" class="logo" alt="Garuda Logo">
            </a>

            <div class="nav-menu">
                <a href="/available-flights">Flights</a>
                <a href="/my-booking" class="active">My Booking</a>
                <a href="/dashboard">Dashboard</a>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="page-wrapper">
        <h1 class="page-title">My Booking</h1>
        <p class="page-desc">
            List of flight tickets you have booked.
        </p>

        <div class="booking-list">
            @forelse ($bookings as $booking)
                <div class="booking-card">
                    <div class="booking-left">
                        <div class="icon-circle">
                            <img src="/garuda/assets/images/icons/airplane-black.svg" alt="icon">
                        </div>

                        <div>
                            <p class="small-label">Booking Code</p>
                            <h2 class="booking-code">{{ $booking->booking_code }}</h2>

                            <p class="flight-title">
                                {{ $booking->flight->airline }} - {{ $booking->flight->flight_number }}
                            </p>

                            <p class="route-text">
                                {{ $booking->flight->origin }} → {{ $booking->flight->destination }}
                            </p>

                            <p class="route-text">
                                {{ $booking->flight->departure_date }} |
                                {{ $booking->flight->departure_time }} - {{ $booking->flight->arrival_time }}
                            </p>

                            <p class="route-text">
                                Passenger: {{ $booking->passenger_name }}
                            </p>
                        </div>
                    </div>

                    <div class="booking-right">
                        <div class="status-badge">
                            {{ $booking->status }}
                        </div>

                        <p class="small-label">Total Payment</p>
                        <p class="price">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </p>

                        <p class="ticket-count">
                            {{ $booking->quantity }} ticket(s)
                        </p>
                    </div>
                </div>
            @empty
                <div class="empty-card">
                    <h2>Belum ada booking.</h2>
                    <p>
                        Silakan pilih penerbangan terlebih dahulu untuk membuat pemesanan tiket.
                    </p>

                    <a href="/available-flights" class="primary-btn">
                        Cari Penerbangan
                    </a>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>