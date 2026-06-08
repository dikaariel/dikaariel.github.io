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
            max-width: 900px;
            margin: 60px auto 90px auto;
            padding: 0 20px;
        }

        .page-title {
            font-size: 38px;
            line-height: 56px;
            font-weight: 900;
            margin: 0;
        }

        .page-desc {
            color: #6B7280;
            font-size: 16px;
            margin-top: 6px;
            margin-bottom: 28px;
        }

        .detail-card {
            background: white;
            border-radius: 30px;
            padding: 34px;
            border: 1px solid #E8EFF7;
            box-shadow: 0 18px 45px rgba(8, 4, 31, 0.05);
        }

        .flight-header {
            display: flex;
            align-items: center;
            gap: 22px;
            padding-bottom: 26px;
            border-bottom: 1px solid #E8EFF7;
            margin-bottom: 26px;
        }

        .icon-circle {
            width: 76px;
            height: 76px;
            border-radius: 999px;
            background: #F5F6FB;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .icon-circle img {
            width: 40px;
        }

        .flight-name {
            font-size: 26px;
            font-weight: 900;
            margin: 0;
        }

        .flight-code {
            color: #0068FF;
            font-weight: 800;
            margin-top: 4px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .info-item {
            background: #F5F6FB;
            border: 1px solid #E8EFF7;
            border-radius: 22px;
            padding: 20px;
        }

        .label {
            color: #6B7280;
            font-size: 13px;
            margin: 0 0 6px 0;
        }

        .value {
            font-size: 17px;
            font-weight: 800;
            margin: 0;
        }

        .price {
            color: #0068FF;
            font-size: 24px;
            font-weight: 900;
            margin: 0;
        }

        .action-row {
            display: flex;
            gap: 14px;
            margin-top: 30px;
        }

        .btn-secondary {
            background: #6B7280;
            color: white;
            padding: 15px 26px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 800;
        }

        .btn-edit {
            background: #F59E0B;
            color: white;
            padding: 15px 26px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 800;
            box-shadow: 0 14px 30px rgba(245, 158, 11, 0.25);
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
                flex-wrap: wrap;
                justify-content: center;
                gap: 16px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .flight-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-title {
                font-size: 30px;
                line-height: 42px;
            }

            .action-row {
                flex-direction: column;
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
                <a href="/">Home</a>
                <a href="/available-flights">Flights</a>
                <a href="/my-booking">My Booking</a>
                <a href="/admin/flights" class="active">Admin Flights</a>
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
        <h1 class="page-title">Flight Detail</h1>
        <p class="page-desc">
            Detailed information about the selected flight schedule.
        </p>

        <div class="detail-card">
            <div class="flight-header">
                <div class="icon-circle">
                    <img src="/garuda/assets/images/icons/airplane-black.svg" alt="icon">
                </div>

                <div>
                    <h2 class="flight-name">{{ $flight->airline }}</h2>
                    <div class="flight-code">{{ $flight->flight_number }}</div>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <p class="label">Route</p>
                    <p class="value">{{ $flight->origin }} → {{ $flight->destination }}</p>
                </div>

                <div class="info-item">
                    <p class="label">Departure Date</p>
                    <p class="value">{{ $flight->departure_date }}</p>
                </div>

                <div class="info-item">
                    <p class="label">Departure Time</p>
                    <p class="value">{{ $flight->departure_time }}</p>
                </div>

                <div class="info-item">
                    <p class="label">Arrival Time</p>
                    <p class="value">{{ $flight->arrival_time }}</p>
                </div>

                <div class="info-item">
                    <p class="label">Available Seats</p>
                    <p class="value">{{ $flight->seats }} seats</p>
                </div>

                <div class="info-item">
                    <p class="label">Ticket Price</p>
                    <p class="price">Rp {{ number_format($flight->price, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="action-row">
                <a href="{{ route('flights.index') }}" class="btn-secondary">
                    Back
                </a>

                <a href="{{ route('flights.edit', $flight->id) }}" class="btn-edit">
                    Edit Flight
                </a>
            </div>
        </div>
    </main>

</body>
</html>