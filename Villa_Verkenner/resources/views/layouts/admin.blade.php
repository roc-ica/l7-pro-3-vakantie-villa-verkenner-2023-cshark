<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Villa Verkenner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html.login-page,
        body.login-page {
            height: 100%;
            overflow: hidden !important;
            margin: 0;
            padding: 0;
        }

        .alert-fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-out;
        }

        .close-alert {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            font-size: 0.9rem;
            padding: 0;
            margin-left: 10px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            position: relative;
        }

        .close-alert:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .close-alert i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            line-height: 1;
        }

        .alert {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .alert-content {
            flex: 1;
        }
    </style>
</head>

<body class="{{ request()->routeIs('admin.login') ? 'login-page' : '' }}">
    <div class="admin-container">
        @if (Auth::guard('admin')->check())
            </nav>
        @endif

        <main class="{{ request()->routeIs('admin.login') ? 'login-main' : 'admin-content' }}">
            @if (session('success'))
                <div class="alert alert-success auto-dismiss">
                    <div class="alert-content">
                        <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="close-alert" aria-label="Close">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger auto-dismiss">
                    <div class="alert-content">
                        <i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="close-alert" aria-label="Close">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        if (window.location.pathname.includes('/admin/login')) {
            document.documentElement.classList.add('login-page');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.auto-dismiss');
            const removeAlert = (alert) => {
                alert.classList.add('alert-fade-out');
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500); 
            };

            alerts.forEach(alert => {
                setTimeout(() => {
                    removeAlert(alert);
                }, 3000);

                const closeBtn = alert.querySelector('.close-alert');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        removeAlert(alert);
                    });
                }
            });
        });
    </script>
</body>

</html>
