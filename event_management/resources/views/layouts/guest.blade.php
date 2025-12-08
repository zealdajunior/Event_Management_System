<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --bg-100: #f5f9ff;
                --bg-200: #eaf3ff;
                --blue-600: #2563eb;
                --blue-500: #3b82f6;
                --indigo-600: #4f46e5;
                --muted: #6b7280;
                --card-bg: rgba(255,255,255,0.85);
                --glass-border: rgba(255,255,255,0.6);
                --shadow: 0 8px 30px rgba(16,24,40,0.08);
                --radius: 14px;
                font-family: 'Figtree', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            }

            body {
                margin: 0;
                background: linear-gradient(180deg, var(--bg-100) 0%, #eef6ff 50%, #f8fbff 100%);
                color: #0f172a;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .auth-container {
                max-width: 400px;
                width: 100%;
                background: var(--card-bg);
                border-radius: var(--radius);
                padding: 32px;
                border: 1px solid var(--glass-border);
                box-shadow: var(--shadow);
                backdrop-filter: blur(6px);
                position: relative;
                overflow: hidden;
            }

            .auth-container::before {
                content: "";
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle at 30% 30%, rgba(79,70,229,0.1), transparent 70%);
                pointer-events: none;
                z-index: -1;
            }

            .logo-section {
                text-align: center;
                margin-bottom: 24px;
            }

            .logo-link {
                display: inline-flex;
                align-items: center;
                gap: 12px;
                font-weight: 600;
                color: #0f172a;
                text-decoration: none;
                font-size: 18px;
            }

            .logo-icon {
                width: 40px;
                height: 40px;
                background: linear-gradient(135deg, var(--blue-500), var(--indigo-600));
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
            }

            .form-section {
                position: relative;
                z-index: 1;
            }

            @media (max-width: 640px) {
                body {
                    padding: 16px;
                }
                .auth-container {
                    padding: 24px;
                }
            }
        </style>
    </head>
    <body>
        <div class="auth-container">
            <div class="logo-section">
                <a href="{{ route('home') }}" class="logo-link" wire:navigate>
                    <div class="logo-icon">
                        <x-app-logo-icon class="w-6 h-6" />
                    </div>
                    <span>{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>

            <div class="form-section">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
