<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 1rem;
            position: fixed;
            width: 250px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 0.75rem 1rem;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 2rem;
        }
        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">Admin Panel</h4>
        <a href="{{ url('/dashboard') }}">Dashboard</a>
        <a href="{{ url('/products') }}">Products</a>
        <a href="{{ url('/orders') }}">Orders</a>
        <a href="{{ url('/settings') }}">Settings</a>
        <a href="{{ route('logout') }}">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand navbar-light">
            <div class="container-fluid">
                <span class="navbar-text">
                    Logged in as: <strong>{{ Auth::user()->name }}</strong>
                </span>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="mt-4">
            @yield('content')
        </div>
    </div>

</body>
</html>
