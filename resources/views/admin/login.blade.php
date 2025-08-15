<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Istanbul Gourmet</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #121212; /* dark mode background */
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-card {
            background-color: #1e1e1e;
            padding: 2rem 3rem;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.5);
            text-align: center;
            max-width: 350px;
            width: 100%;
        }

        .logo {
            max-width: 100px;
            margin-bottom: 1rem;
        }

        h1 {
            color: #44c4d4; /* secondary accent */
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        label {
            font-size: 0.9rem;
            color: #bbb;
            display: block;
            margin-bottom: 0.3rem;
        }

        input {
            width: 100%;
            padding: 0.6rem;
            border-radius: 8px;
            border: 1px solid #333;
            background-color: #2a2a2a;
            color: white;
            font-size: 1rem;
        }

        input:focus {
            outline: none;
            border-color: #44c4d4;
        }

        .login-btn {
            display: block;
            width: 100%;
            background-color: #f31e45; /* primary accent */
            color: white;
            padding: 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
            margin-top: 1rem;
        }

        .login-btn:hover {
            background-color: #d91a3c; /* darker shade on hover */
        }

        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            background-color: #4285F4;
            color: white;
            padding: 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            margin-top: 1rem;
            transition: background-color 0.2s ease;
        }

        .google-btn:hover {
            background-color: #357ae8;
        }

        .google-btn img {
            width: 20px;
            height: 20px;
            margin-right: 0.5rem;
        }

        .footer {
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <!-- Logo -->
        <img src="/images/istanbul-gourmet-logo.png" alt="Istanbul Gourmet Logo" class="logo">

        <!-- Title -->
        <h1>Admin Login</h1>

        <!-- Username/Password Form -->
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>

        <!-- Google Login -->
        <a href="{{ route('auth.google') }}" class="google-btn">
            <img src="/images/new-google-logo.jpg" alt="Google Logo">
            Login with Google
        </a>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Istanbul Gourmet Market
        </div>
    </div>
</body>
</html>
