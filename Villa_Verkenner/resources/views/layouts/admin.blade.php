<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Villa Verkenner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Force no scroll on login page */
        html.login-page, body.login-page {
            height: 100%;
            overflow: hidden !important;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body class="{{ request()->routeIs('admin.login') ? 'login-page' : '' }}">
    <div class="admin-container">
        @if(Auth::guard('admin')->check())
            <nav class="admin-nav">
                <!-- Your nav content remains the same -->
            </nav>
        @endif
        
        <main class="{{ request()->routeIs('admin.login') ? 'login-main' : 'admin-content' }}">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>

    <script>
        // If we're on the login page, force no scrolling
        if (window.location.pathname.includes('/admin/login')) {
            document.documentElement.classList.add('login-page');
        }
    </script>
</body>
</html>