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

        .hero-card {
            background: linear-gradient(135deg, #85C8FF 0%, #D4D1FE 55%, #FFFFFF 100%);
            border-radius: 36px;
            padding: 46px;
            position: relative;
            overflow: hidden;
            border: 1px solid #E8EFF7;
            box-shadow: 0 18px 45px rgba(8, 4, 31, 0.06);
        }

        .hero-card h1 {
            font-size: 42px;
            line-height: 58px;
            font-weight: 900;
            margin: 0;
            max-width: 620px;
        }

        .hero-card p {
            color: #3f3b57;
            font-size: 17px;
            line-height: 30px;
            max-width: 620px;
            margin-top: 14px;
        }

        .plane-img {
            position: absolute;
            right: -60px;
            bottom: -30px;
            max-width: 470px;
            opacity: 0.95;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 32px;
        }

        .menu-card {
            background: white;
            border-radius: 30px;
            padding: 28px;
            border: 1px solid #E8EFF7;
            text-decoration: none;
            color: #08041F;
            box-shadow: 0 18px 45px rgba(8, 4, 31, 0.04);
            transition: 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 55px rgba(8, 4, 31, 0.09);
        }

        .icon-circle {
            width: 68px;
            height: 68px;
            border-radius: 999px;
            background: #F5F6FB;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .icon-circle img {
            width: 34px;
        }

        .menu-card h2 {
            font-size: 21px;
            font-weight: 800;
            margin: 0 0 8px 0;
        }

        .menu-card p {
            color: #6B7280;
            font-size: 14px;
            line-height: 24px;
            margin: 0;
        }

        .user-box {
            background: white;
            border-radius: 30px;
            padding: 28px;
            border: 1px solid #E8EFF7;
            margin-top: 32px;
        }

        .user-box h2 {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 8px 0;
        }

        .user-box p {
            color: #6B7280;
            margin: 0;
        }

        @media (max-width: 900px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .plane-img {
                display: none;
            }

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

            .hero-card h1 {
                font-size: 32px;
                line-height: 45px;
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
                <a href="/" class="active">Home</a>
                <a href="/available-flights">Flights</a>
                <a href="/my-booking">My Booking</a>
                <a href="/admin/flights">Admin Flights</a>
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
        <section class="hero-card">
            <h1>
                Welcome, {{ Auth::user()->name }}
            </h1>

            <p>
                Manage your flight booking, check your tickets, and access the admin flight data from one dashboard.
            </p>

            <img src="/garuda/assets/images/backgrounds/Jumbo Jet Sky (1) 1.png" class="plane-img" alt="plane">
        </section>

        <section class="dashboard-grid">
            <a href="/available-flights" class="menu-card">
                <div class="icon-circle">
                    <img src="/garuda/assets/images/icons/airplane-black.svg" alt="icon">
                </div>

                <h2>Available Flights</h2>
                <p>
                    View available flight schedules and start booking your next trip.
                </p>
            </a>

            <a href="/my-booking" class="menu-card">
                <div class="icon-circle">
                    <img src="/garuda/assets/images/icons/note-favorite-white.svg" alt="icon">
                </div>

                <h2>My Booking</h2>
                <p>
                    See your booking history, booking code, passenger data, and total payment.
                </p>
            </a>

            <a href="/admin/flights" class="menu-card">
                <div class="icon-circle">
                    <img src="/garuda/assets/images/icons/global-black.svg" alt="icon">
                </div>

                <h2>Admin Flights</h2>
                <p>
                    Add, edit, view, and delete flight data stored in the MySQL database.
                </p>
            </a>
        </section>

        <section class="user-box">
            <h2>Account Information</h2>
            <p>Name: {{ Auth::user()->name }}</p>
            <p>Email: {{ Auth::user()->email }}</p>
        </section>
    </main>

</body>
</html>