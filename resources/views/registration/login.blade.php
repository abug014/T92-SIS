<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {{ config('app.name') }}</title>

    <!-- Include the glassmorphism CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <div class="image-section">
        <img src="/img/logoblack.png" alt="Placeholder Image">
    </div>
    <div class="login-form">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h2>Login</h2>
            
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="error-box">{{ $error }}</div>
                @endforeach
            @endif
            <!--
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            -->
            <div class="input-field">
                <input type="email" name="email" required value="{{ old('email') }}">
                <label>Enter your email</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Enter your password</label>
            </div>

            <div class="forget">
                <label for="remember">
                    <input type="checkbox" id="remember" name="remember">
                    <p>Remember me</p>
                </label>
                <a href="{{ route('password.request') }}">Forgot password?</a>
            </div>

            <button type="submit">Log In</button>

            <div class="register">
                <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
            </div>
        </form>
    </div>
</div>
</body>
</html>
