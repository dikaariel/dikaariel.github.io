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

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 28px;
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
        }

        .btn-primary {
            background: #0068FF;
            color: white;
            padding: 15px 24px;
            border-radius: 999px;
            text-decoration: none;
            font-weight: 800;
            box-shadow: 0 14px 30px rgba(0, 104, 255, 0.25);
            display: inline-block;
        }

        .alert-success {
            background: #DCFCE7;
            color: #15803D;
            border-radius: 18px;
            padding: 16px 20px;
            margin-bottom: 22px;
            font-weight: 700;
        }

        .table-card {
            background: white;
            border-radius: 30px;
            padding: 26px;
            border: 1px solid #E8EFF7;
            box-shadow: 0 18px 45px rgba(8, 4, 31, 0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th {
            background: #F5F6FB;
            color: #08041F;
            font-size: 14px;
            text-align: left;
            padding: 16px;
            border-bottom: 1px solid #E8EFF7;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #E8EFF7;
            font-size: 14px;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .flight-title {
            font-weight: 800;
            font-size: 15px;
        }

        .small-text {
            color: #6B7280;
            font-size: 13px;
            margin-top: 4px;
        }

        .price {
            font-weight: 800;
            color: #0068FF;
        }

        .action-links {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-small {
            padding: 9px 13px;
            border-radius: 999px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 700;
        }

        .btn-detail {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .btn-edit {
            background: #FEF3C7;
            color: #B45309;
        }

        .btn-delete {
            background: #FEE2E2;
            color: #B91C1C;
        }

        .empty-box {
            text-align: center;
            padding: 40px;
            color: #6B7280;
            font-weight: 600;
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

            .page-header {
                flex-direction: column;
                align-items: flex-start;
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
        <div class="page-header">
            <div>
                <h1 class="page-title">Admin Flight Data</h1>
                <p class="page-desc">
                    Manage flight schedules, routes, ticket prices, and available seats.
                </p>
            </div>

            <a href="{{ route('flights.create') }}" class="btn-primary">
                + Add Flight
            </a>
        </div>

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Flight</th>
                        <th>Route</th>
                        <th>Date & Time</th>
                        <th>Seats</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($flights as $flight)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <div class="flight-title">
                                    {{ $flight->airline }}
                                </div>
                                <div class="small-text">
                                    {{ $flight->flight_number }}
                                </div>
                            </td>

                            <td>
                                <div class="flight-title">
                                    {{ $flight->origin }} → {{ $flight->destination }}
                                </div>
                            </td>

                            <td>
                                <div>{{ $flight->departure_date }}</div>
                                <div class="small-text">
                                    {{ $flight->departure_time }} - {{ $flight->arrival_time }}
                                </div>
                            </td>

                            <td>
                                {{ $flight->seats }} seats
                            </td>

                            <td>
                                <span class="price">
                                    Rp {{ number_format($flight->price, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <div class="action-links">
                                    <a href="{{ route('flights.show', $flight->id) }}" class="btn-small btn-detail">
                                        Detail
                                    </a>

                                    <a href="{{ route('flights.edit', $flight->id) }}" class="btn-small btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('flights.destroy', $flight->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data penerbangan ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-small btn-delete">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-box">
                                    Belum ada data penerbangan. Klik tombol Add Flight untuk menambahkan data baru.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top: 24px;">
                {{ $flights->links() }}
            </div>
        </div>
    </main>

</body>
</html>