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
            background: linear-gradient(180deg, #85C8FF 0%, #D4D1FE 45%, #F5F6FB 100%);
            min-height: 100vh;
            color: #08041F;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .register-card {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 32px;
            padding: 40px;
            box-shadow: 0 24px 60px rgba(8, 4, 31, 0.12);
            border: 1px solid #E8EFF7;
        }

        .logo {
            height: 44px;
            margin-bottom: 30px;
        }

        .title {
            font-size: 32px;
            font-weight: 800;
            margin: 0;
        }

        .subtitle {
            color: #6B7280;
            margin-top: 8px;
            margin-bottom: 28px;
            line-height: 26px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 15px 18px;
            border-radius: 18px;
            border: 1px solid #E8EFF7;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #0068FF;
            box-shadow: 0 0 0 4px rgba(0, 104, 255, 0.12);
        }

        .error-box {
            background: #FEE2E2;
            color: #991B1B;
            padding: 14px 16px;
            border-radius: 18px;
            margin-bottom: 18px;
            font-size: 14px;
            line-height: 24px;
        }

        .action-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 24px;
        }

        .link {
            color: #0068FF;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
        }

        .btn-primary {
            background: #0068FF;
            color: white;
            border: none;
            padding: 14px 26px;
            border-radius: 999px;
            font-weight: 800;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 14px 30px rgba(0, 104, 255, 0.25);
        }

        .login-text {
            text-align: center;
            color: #6B7280;
            margin-top: 26px;
            font-size: 14px;
        }

        .back-home {
            display: inline-block;
            margin-top: 22px;
            color: #08041F;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            .register-card {
                padding: 28px;
            }

            .title {
                font-size: 28px;
            }

            .action-row {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-primary {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="register-card">
            <a href="/">
                <img src="/garuda/assets/images/logos/logo.svg" class="logo" alt="Garuda Logo">
            </a>

            <h1 class="title">Create Account</h1>

            <p class="subtitle">
                Register your account to start booking flights with Garuda.
            </p>

            @if ($errors->any())
                <div class="error-box">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label>Name</label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        placeholder="Enter your full name" 
                        required 
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="Enter your email" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Create your password" 
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        placeholder="Repeat your password" 
                        required
                    >
                </div>

                <div class="action-row">
                    <a class="link" href="{{ route('login') }}">
                        Already registered?
                    </a>

                    <button type="submit" class="btn-primary">
                        Register
                    </button>
                </div>
            </form>

            <p class="login-text">
                Already have an account?
                <a href="{{ route('login') }}" class="link">Login here</a>
            </p>

            <a href="/" class="back-home">← Back to Home</a>
        </div>
    </div>
</body>
</html>