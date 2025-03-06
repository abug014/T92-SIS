<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | {{ config('app.name') }}</title>

    <!-- Glassmorphism CSS -->
    <link rel="stylesheet" href="{{ asset('css/registerstyle.css') }}">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        
        <!-- Image Section -->
        <div class="image-section">
            <img src="{{ asset('/img/logoblack.png') }}" alt="Register Image">
        </div>

        <!-- Register Form -->
        <div class="register-form">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h2>Create an Account</h2>

                <!-- Name -->
                <div class="input-field">
                    <input type="text" name="name" required value="{{ old('name') }}">
                    <label>Name</label>
                </div>

                <!-- Email -->
                <div class="input-field">
                    <input type="email" name="email" required value="{{ old('email') }}"
                        pattern="[a-zA-Z0-9._%+-]+@(student\.buksu\.edu\.ph|buksu\.edu\.ph)$"
                        title="Please use your BukSU email address (@student.buksu.edu.ph or @buksu.edu.ph)">
                    <label>Email Address</label>
                </div>
                @error('email')
                    <div class="error-box">{{ $message }}</div>
                @enderror

                <!-- Age & Year Level -->
                <div class="two-column">
                    <div class="input-field">
                        <input type="number" name="age" required value="{{ old('age') }}" min="16" max="100">
                        <label>Age</label>
                    </div>
                    <div class="input-field">
                        <input type="number" name="year_level" required value="{{ old('year_level') }}" min="1" max="6">
                        <label>Year Level</label>
                    </div>
                </div>

                <!-- Address -->
                <div class="input-field">
                    <input type="text" name="address" required value="{{ old('address') }}">
                    <label>Address</label>
                </div>

                <!-- Password -->
<div class="input-field">
    <input type="password" name="password" required>
    <label>Password</label>
</div>

<!-- Confirm Password -->
<div class="input-field">
    <input type="password" name="password_confirmation" required>
    <label>Confirm Password</label>
</div>

<!-- Display Password Errors -->
@error('password')
    <div class="error-box">{{ $message }}</div>
@enderror
@error('password_confirmation')
    <div class="error-box">{{ $message }}</div>
@enderror

                <!-- Register Button -->
                <button type="submit">Register</button>

                <!-- Login Link -->
                <div class="register">
                    <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
