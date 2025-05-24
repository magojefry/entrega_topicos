<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="{{ asset('images/logo_finca.png') }}" type="image/npg">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @routes
        @viteReactRefresh
        @vite(['resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">



        <div class="container-fluid vh-100">
            <div class="row h-100">
                <!-- Login: Izquierda -->
                <div class="col-md-6 d-flex align-items-center justify-content-center bg-white">
                <div style="width: 100%; max-width: 400px;">
                    <h2 class="text-center text-success mb-4">Iniciar Sesión</h2>
                    <form method="POST" action="/login">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control border-success" id="email" name="email" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control border-success" id="password" name="password" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                        </div>
                        <a href="/forgot-password" class="text-success text-decoration-none small">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Iniciar Sesión</button>
                    </form>
                </div>
                </div>

                <!-- Imagen + mensaje: Derecha -->
                <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center bg-success text-white">
                <div class="text-center px-5">
                    <img src="{{ asset('images/logo_finca.png') }}" alt="Login Visual" class="img-fluid mb-4" style="max-height: 250px;">
                    <h3 class="mb-3 text-light">Bienvenido a La Estancia Verde</h3>
                    <p class="text-light">
                        Esta es la plataforma oficial de <strong>La Estancia Verde</strong>, una finca ganadera dedicada a la producción sostenible de <strong>leche fresca</strong> y el manejo responsable de <strong>cabezas de ganado</strong>.
                    </p>
                    <p class="text-light">
                        Ingresa para acceder a herramientas de gestión, reportes de producción y todo lo relacionado con nuestras operaciones en el campo.
                    </p>
                </div>
                </div>
            </div>
        </div>




    </body>
</html>
