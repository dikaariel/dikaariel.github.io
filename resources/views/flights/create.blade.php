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

        .form-card {
            background: white;
            border-radius: 30px;
            padding: 34px;
            border: 1px solid #E8EFF7;
            box-shadow: 0 18px 45px rgba(8, 4, 31, 0.05);
        }

        .error-box {
            background: #FEE2E2;
            color: #991B1B;
            padding: 16px 20px;
            border-radius: 18px;
            margin-bottom: 24px;
            font-size: 14px;
            line-height: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group.full {
            grid-column: span 2;
        }

        label {
            display: block;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 15px 18px;
            border-radius: 18px;
            border: 1px solid #E8EFF7;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #0068FF;
            box-shadow: 0 0 0 4px rgba(0, 104, 255, 0.12);
        }

        .action-row {
            display: flex;
            gap: 14px;
            margin-top: 28px;
        }

        .btn-secondary {
            background: #6B7280;
            color: white;
            padding: 15px 26px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 800;
        }

        .btn-primary {
            background: #0068FF;
            color: white;
            border: none;
            padding: 15px 26px;
            border-radius: 999px;
            font-weight: 800;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
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
                flex-wrap: wrap;
                justify-content: center;
                gap: 16px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full {
                grid-column: span 1;
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
        <h1 class="page-title">Add New Flight</h1>
        <p class="page-desc">
            Add a new flight schedule to the Garuda booking database.
        </p>

        <div class="form-card">
            @if ($errors->any())
                <div class="error-box">
                    <strong>Terjadi kesalahan:</strong>
                    <ul style="margin: 8px 0 0 18px; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('flights.store') }}" method="POST">
                @csrf

                <div class="form-grid">
                    <div class="form-group">
                        <label>Maskapai</label>
                        <input type="text" name="airline" value="{{ old('airline') }}" placeholder="Contoh: Garuda Indonesia" required>
                    </div>

                    <div class="form-group">
                        <label>Kode Penerbangan</label>
                        <input type="text" name="flight_number" value="{{ old('flight_number') }}" placeholder="Contoh: GA-201" required>
                    </div>

                    <div class="form-group">
                        <label>Asal</label>
                        <input type="text" name="origin" value="{{ old('origin') }}" placeholder="Contoh: Jakarta" required>
                    </div>

                    <div class="form-group">
                        <label>Tujuan</label>
                        <input type="text" name="destination" value="{{ old('destination') }}" placeholder="Contoh: Bali" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Keberangkatan</label>
                        <input type="date" name="departure_date" value="{{ old('departure_date') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Kursi</label>
                        <input type="number" name="seats" value="{{ old('seats') }}" placeholder="Contoh: 120" required>
                    </div>

                    <div class="form-group">
                        <label>Jam Berangkat</label>
                        <input type="time" name="departure_time" value="{{ old('departure_time') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Jam Tiba</label>
                        <input type="time" name="arrival_time" value="{{ old('arrival_time') }}" required>
                    </div>

                    <div class="form-group full">
                        <label>Harga Tiket</label>
                        <input type="number" name="price" value="{{ old('price') }}" placeholder="Contoh: 750000" required>
                    </div>
                </div>

                <div class="action-row">
                    <a href="{{ route('flights.index') }}" class="btn-secondary">
                        Back
                    </a>

                    <button type="submit" class="btn-primary">
                        Save Flight
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>
</html>