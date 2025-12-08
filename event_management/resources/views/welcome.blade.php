<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Event Management System</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root{
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

        /* Page base */
        html,body{
            height:100%;
            margin:0;
            background: linear-gradient(180deg, var(--bg-100) 0%, #eef6ff 50%, #f8fbff 100%);
            color:#0f172a;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
        }

        .container{
            max-width:1200px;
            margin:0 auto;
            padding:48px 24px;
        }

        /* Hero */
        .hero{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:32px;
            padding:56px;
            background: linear-gradient(135deg, rgba(59,130,246,0.06), rgba(79,70,229,0.04));
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            position:relative;
            overflow:hidden;
        }

        .hero-left{
            max-width:720px;
            z-index:2;
        }

        .eyebrow{
            display:inline-block;
            background:linear-gradient(90deg,var(--blue-500),var(--indigo-600));
            color:white;
            padding:6px 12px;
            border-radius:999px;
            font-weight:600;
            font-size:13px;
            letter-spacing:0.2px;
            margin-bottom:18px;
        }

        h1{
            margin:0 0 18px 0;
            font-size:44px;
            line-height:1.02;
            font-weight:700;
            color: #071133;
        }

        h1 .accent{
            color: var(--blue-600);
        }

        p.lead{
            margin:0 0 26px 0;
            color:var(--muted);
            font-size:18px;
            line-height:1.6;
        }

        .cta-row{
            display:flex;
            gap:14px;
            align-items:center;
            flex-wrap:wrap;
        }

        .btn-primary{
            display:inline-flex;
            align-items:center;
            gap:10px;
            background: linear-gradient(90deg,var(--blue-600),var(--blue-500));
            color:white;
            padding:12px 18px;
            border-radius:10px;
            font-weight:600;
            text-decoration:none;
            box-shadow: 0 6px 18px rgba(59,130,246,0.18);
            transition:transform .14s ease, box-shadow .14s ease;
            border: none;
        }

        .btn-primary:focus,
        .btn-primary:hover{
            transform:translateY(-2px);
            box-shadow: 0 10px 30px rgba(59,130,246,0.22);
            outline: none;
        }

        .btn-ghost{
            background:transparent;
            color:#0f172a;
            padding:10px 14px;
            border-radius:10px;
            font-weight:600;
            text-decoration:none;
            border:2px solid rgba(15,23,42,0.06);
        }

        /* Decorative shapes */
        .hero::before,
        .hero::after{
            content:"";
            position:absolute;
            border-radius:50%;
            filter: blur(60px);
            opacity:0.18;
            pointer-events:none;
        }

        .hero::before{
            width:420px;
            height:420px;
            right:-80px;
            top:-120px;
            background: radial-gradient(circle at 30% 30%, rgba(79,70,229,0.9), rgba(59,130,246,0.6));
            transform: rotate(12deg);
        }

        .hero::after{
            width:360px;
            height:360px;
            left:-120px;
            bottom:-80px;
            background: radial-gradient(circle at 70% 70%, rgba(59,130,246,0.9), rgba(79,70,229,0.5));
            transform: rotate(-8deg);
        }

        /* Right panel - quick stats / card */
        .hero-right{
            min-width:280px;
            max-width:360px;
            background: var(--card-bg);
            border-radius:12px;
            padding:20px;
            border:1px solid var(--glass-border);
            box-shadow: 0 6px 24px rgba(12,18,40,0.06);
            backdrop-filter: blur(6px);
        }

        .stat{
            display:flex;
            align-items:center;
            gap:12px;
            margin-bottom:12px;
        }

        .stat .dot{
            width:44px;
            height:44px;
            border-radius:10px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(180deg,var(--blue-500),var(--indigo-600));
            color:white;
            font-weight:700;
            font-size:16px;
        }

        .stat h4{
            margin:0;
            font-size:15px;
            font-weight:700;
            color:#071133;
        }

        .stat p{
            margin:0;
            color:var(--muted);
            font-size:13px;
        }

        /* Features section */
        .features{
            margin-top:48px;
            padding:48px;
            background:white;
            border-radius:12px;
            box-shadow: var(--shadow);
        }

        .features h2{
            margin:0 0 12px 0;
            font-size:28px;
            color:#071133;
        }

        .features p.lead{
            margin-bottom:28px;
        }

        .grid{
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:22px;
        }

        .feature-card{
            background: linear-gradient(180deg, rgba(59,130,246,0.03), rgba(79,70,229,0.02));
            border-radius:12px;
            padding:20px;
            border:1px solid rgba(15,23,42,0.04);
            min-height:150px;
            display:flex;
            flex-direction:column;
            gap:12px;
        }

        .feature-card dt{
            display:flex;
            align-items:center;
            gap:12px;
            font-weight:700;
            color:#071133;
            font-size:15px;
        }

        .feature-card svg{
            width:36px;
            height:36px;
            flex-shrink:0;
            color:var(--blue-600);
            background:rgba(59,130,246,0.08);
            padding:6px;
            border-radius:8px;
        }

        .feature-card dd{
            margin:0;
            color:var(--muted);
            font-size:15px;
            line-height:1.6;
            margin-top:6px;
        }

        /* Responsive */
        @media (max-width: 980px){
            .hero{
                flex-direction:column;
                padding:36px;
            }
            .hero-right{
                width:100%;
                max-width:none;
            }
            .grid{
                grid-template-columns:1fr;
            }
        }

        @media (max-width: 520px){
            h1{ font-size:28px; }
            .hero{ padding:22px; }
            .container{ padding:20px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="hero" role="banner" aria-label="Event Management hero">
            <div class="hero-left">
                <span class="eyebrow">Event Management</span>
                <h1>
                    Event Management
                    <span class="accent">System</span>
                </h1>
                <p class="lead">
                    Manage events, book tickets, and create unforgettable experiences. Join thousands of users who trust our platform for their event management needs.
                </p>

                <div class="cta-row" role="navigation" aria-label="Primary actions">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn-primary" aria-label="Go to Admin Dashboard">
                                Go to Admin Dashboard
                            </a>
                        @else
                            <a href="{{ route('user.dashboard') }}" class="btn-primary" aria-label="Go to Dashboard">
                                Go to Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-primary" aria-label="Sign In">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="btn-ghost" aria-label="Create Account">
                            Create Account →
                        </a>
                    @endauth
                </div>
            </div>

            <aside class="hero-right" aria-label="Quick overview">
                <div class="stat">
                    <div class="dot">★</div>
                    <div>
                        <h4>Trusted Platform</h4>
                        <p>Thousands of organizers and attendees</p>
                    </div>
                </div>

                <div class="stat">
                    <div class="dot">⚡</div>
                    <div>
                        <h4>Fast Booking</h4>
                        <p>Instant confirmations and secure payments</p>
                    </div>
                </div>

                <div class="stat">
                    <div class="dot">📊</div>
                    <div>
                        <h4>Insightful Analytics</h4>
                        <p>Track performance and engagement</p>
                    </div>
                </div>
            </aside>
        </header>

        <!-- Features Section -->
        <section class="features" aria-labelledby="features-heading">
            <div style="max-width:900px; margin:0 auto; text-align:center;">
                <h2 id="features-heading">Everything you need to manage events</h2>
                <p class="lead">From event creation to ticket booking, our platform provides all the tools you need.</p>
            </div>

            <div style="margin-top:28px;">
                <dl class="grid" role="list">
                    <div class="feature-card" role="listitem">
                        <dt>
                            <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" focusable="false">
                                <path fill-rule="evenodd" d="M5.5 17a4.5 4.5 0 01-1.44-8.765 4.5 4.5 0 018.302-3.046 3.5 3.5 0 014.504 4.272A4 4 0 0115 17H5.5zm3.75-2.75a.75.75 0 001.5 0V9.66l1.95 2.1a.75.75 0 101.1-1.02l-3.25-3.5a.75.75 0 00-1.1 0l-3.25 3.5a.75.75 0 101.1 1.02l1.95-2.1v4.59z" clip-rule="evenodd" />
                            </svg>
                            Event Creation
                        </dt>
                        <dd>
                            <p>Create and manage events with ease. Set dates, venues, and ticket information all in one place.</p>
                        </dd>
                    </div>

                    <div class="feature-card" role="listitem">
                        <dt>
                            <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" focusable="false">
                                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                            </svg>
                            Secure Booking
                        </dt>
                        <dd>
                            <p>Safe and secure ticket booking system with multiple payment options and instant confirmations.</p>
                        </dd>
                    </div>

                    <div class="feature-card" role="listitem">
                        <dt>
                            <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" focusable="false">
                                <path d="M4.632 3.533A2 2 0 016.577 2h6.846a2 2 0 011.945 1.533l1.976 8.234A3.489 3.489 0 0016 11.5H4c-.476 0-.93.095-1.344.267l1.976-8.234z" />
                                <path fill-rule="evenodd" d="M4 13a2 2 0 100 4h12a2 2 0 100-4H4zm11.24 2a.75.75 0 01.75-.75H16a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75h-.01a.75.75 0 01-.75-.75V15zm-2.25-.75a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75H13a.75.75 0 00.75-.75V15a.75.75 0 00-.75-.75h-.01z" clip-rule="evenodd" />
                            </svg>
                            Analytics & Reports
                        </dt>
                        <dd>
                            <p>Comprehensive analytics and reporting tools to track event performance and user engagement.</p>
                        </dd>
                    </div>
                </dl>
            </div>
        </section>
    </div>
</body>
</html>