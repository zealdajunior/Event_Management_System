<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventHub - Professional Event Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #0f172a;
            --text-muted: #64748b;
            --bg-light: #eff6ff;
            --white: #ffffff;
            --shadow: 0 10px 40px rgba(37, 99, 235, 0.15);
            --shadow-lg: 0 20px 60px rgba(37, 99, 235, 0.2);
            --gradient: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--secondary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        .animate-on-scroll {
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards;
        }

        .animate-delay-1 {
            animation-delay: 0.1s;
        }

        .animate-delay-2 {
            animation-delay: 0.2s;
        }

        .animate-delay-3 {
            animation-delay: 0.3s;
        }

        .animate-delay-4 {
            animation-delay: 0.4s;
        }

        .animate-delay-5 {
            animation-delay: 0.5s;
        }

        .animate-delay-6 {
            animation-delay: 0.6s;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header/Navigation */
        .header {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 20px 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--white);
            animation: slideInLeft 0.8s ease;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: var(--white);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .nav-buttons {
            display: flex;
            animation: slideInRight 0.8s ease;
            gap: 15px;
        }

        .nav-btn {
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .nav-btn-login {
            color: var(--white);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .nav-btn-login:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-btn-signup {
            background: var(--white);
            color: var(--primary);
        }

        .nav-btn-signup:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
        }

        /* Hero Section */
        .hero {
            background: var(--gradient);
            color: var(--white);
            padding: 140px 20px 120px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="60" height="60" xmlns="http://www.w3.org/2000/svg"><circle cx="30" cy="30" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            animation: fadeIn 1s ease;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            margin-bottom: 25px;
            animation: scaleIn 0.6s ease 0.3s backwards;
            backdrop-filter: blur(10px);
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 25px;
            animation: fadeInUp 0.8s ease 0.4s backwards;
            line-height: 1.1;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            opacity: 0.95;
            max-width: 700px;
            animation: fadeInUp 0.8s ease 0.6s backwards;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            animation: fadeInUp 0.8s ease 0.8s backwards;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 60px;
        }

        .btn {
            display: inline-block;
            padding: 18px 45px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--white);
            color: var(--primary);
            box-shadow: 0 4px 20px rgba scale(1.02);
            box-shadow: 0 8px 35px rgba(255, 255, 255, 0.4);
        }

        .btn i {
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .btn:hover i {
            transform: translateX(3px

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 35px rgba scale(1.02)(255, 255, 255, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
            border: 2px solid var(--white);
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease 1s backwards;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.3);
            transition: transform 0.3s ease;
        }

        .stat:hover {
            transform: scale(1.1);
            transform: translateY(-3px);
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 60px;
            flex-wrap: wrap;
        }

        .stat {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            display: block;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.9;
        }

        /* Recent Events Showcase */
        .events-showcase {
            padding: 100px 20px;
            background: var(--white);
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
            animation: fadeInUp 0.8s ease;
        }

        .section-title h2 {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--secondary);
        }

        .section-title p {
            font-size: 1.2rem;
            color: var(--text-muted);
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .event-card:nth-child(1) { animation-delay: 0.1s; }
        .event-card:nth-child(2) { animation-delay: 0.2s; }
        .event-card:nth-child(3) { animation-delay: 0.3s; }
        .event-card:nth-child(4) { animation-delay: 0.4s; }
        .event-card:nth-child(5) { animation-delay: 0.5s; }
        .event-card:nth-child(6) { animation-delay: 0.6s; }

        .event-card {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e2e8f0;
            animation: fadeInUp 0.6s ease backwards;
        }

        .event-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: var(--shadow-lg);
        }

        .event-card:hover .event-image {
            transform: scale(1.05);
        }

        .event-image i {
            animation: float 3s ease-in-out infinite;
        }

        .event-image {
            width: 100%;
            height: 220px;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 3rem;
            position: relative;
            overflow: hidden;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--white);
            color: var(--primary);
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .event-content {
            padding: 25px;
        }

        .event-date {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .event-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--secondary);
        }

        .event-location {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .event-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }

        .event-attendees {
            font-size: 0.9rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .feature-card:nth-child(1) { animation-delay: 0.1s; }
        .feature-card:nth-child(2) { animation-delay: 0.2s; }
        .feature-card:nth-child(3) { animation-delay: 0.3s; }
        .feature-card:nth-child(4) { animation-delay: 0.4s; }
        .feature-card:nth-child(5) { animation-delay: 0.5s; }
        .feature-card:nth-child(6) { animation-delay: 0.6s; }

        .event-price {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.1rem;
        }

        /* Features Section */
        .features {
            padding: 100px 20px;
            background: var(--bg-light);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: var(--white);
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.6s ease backwards;
        }

        .feature-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: var(--shadow-lg);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: var(--gradient);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            font-size: 2rem;
            color: var(--white);
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
            transition: all 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            transform: rotateY(360deg) scale(1.1);
            box-shadow: 0 15px 40px rgba(37, 99, 235, 0.5);
        }

        .feature-card h3 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--secondary);
        }

        .feature-card p {
            color: var(--text-muted);
            line-height: 1.8;
            font-size: 1rem;
        }

        /* Testimonials */
        .testimonials {
            padding: 100px 20px;
            background: var(--white);
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 35px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .testimonial-card {
            background: var(--bg-light);
            padding: 35px;
            border-radius: 16px;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.4s ease;
            animation: fadeInUp 0.6s ease backwards;
        }

        .testimonial-card:nth-child(1) { animation-delay: 0.1s; }
        .testimonial-card:nth-child(2) { animation-delay: 0.2s; }
        .testimonial-card:nth-child(3) { animation-delay: 0.3s; }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.15);
        }

        .quote-icon {
            font-size: 3rem;
            color: var(--primary);
            opacity: 0.2;
            position: absolute;
            top: 20px;
            right: 25px;
        }

        .testimonial-text {
            font-size: 1.05rem;
            line-height: 1.8;
            color: var(--secondary);
            margin-bottom: 25px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .author-avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 1.3rem;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
        }

        .testimonial-card:hover .author-avatar {
            transform: scale(1.1) rotate(5deg);
        }

        .author-info h4 {
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 3px;
        }

        .author-role {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .rating {
            color: #fbbf24;
            margin-top: 5px;
        }

        /* How It Works */
        .how-it-works {
            padding: 100px 20px;
            background: var(--bg-light);
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .step {
            background: var(--white);
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            box-shadow: var(--shadow);
            animation: fadeIn 0.8s ease backwards;
            transition: transform 0.3s ease;
        }

        .step:nth-child(1) { animation-delay: 0.1s; }
        .step:nth-child(2) { animation-delay: 0.3s; }
        .step:nth-child(3) { animation-delay: 0.5s; }

        .step:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .step-number {
            width: 70px;
            height: 70px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 2rem;
            font-weight: 800;
            margin: 0 auto 25px;
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
            transition: all 0.4s ease;
        }

        .step:hover .step-number {
            transform: scale(1.15) rotate(360deg);
            box-shadow: 0 12px 35px rgba(37, 99, 235, 0.5);
        }

        .step h3 {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--secondary);
        }

        .step p {
            color: var(--text-muted);
            line-height: 1.8;
            font-size: 1rem;
        }

        /* Stats Section */
        .stats-section {
            padding: 80px 20px;
            background: var(--gradient);
            color: var(--white);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .stat-box {
            text-align: center;
            animation: fadeIn 0.8s ease backwards;
            transition: transform 0.3s ease;
        }

        .stat-box:nth-child(1) { animation-delay: 0.2s; }
        .stat-box:nth-child(2) { animation-delay: 0.4s; }
        .stat-box:nth-child(3) { animation-delay: 0.6s; }
        .stat-box:nth-child(4) { animation-delay: 0.8s; }

        .stat-box:hover {
            transform: scale(1.1);
        }

        .stat-box-number {
            font-size: 3.5rem;
            font-weight: 800;
            display: block;
            margin-bottom: 10px;
        }

        .stat-box-label {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        /* CTA Section */
        .cta {
            padding: 100px 20px;
            background: var(--white);
            text-align: center;
        }

        .cta-content {
            max-width: 700px;
            margin: 0 auto;
        }

        .cta h2 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: var(--secondary);
        }

        .cta p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            color: var(--text-muted);
        }

        /* Footer */
        footer {
            background: var(--secondary);
            color: var(--white);
            padding: 60px 20px 30px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h3 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--white);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
        }

        .social-links {
            display: flex; rotate(360deg);
        }

        .rating i {
            display: inline-block;
            animation: pulse 2s ease-in-out infinite;
        }

        .rating i:nth-child(1) { animation-delay: 0s; }
        .rating i:nth-child(2) { animation-delay: 0.1s; }
        .rating i:nth-child(3) { animation-delay: 0.2s; }
        .rating i:nth-child(4) { animation-delay: 0.3s; }
        .rating i:nth-child(5) { animation-delay: 0.4s;     gap: 15px;
            margin-top: 20px;
        }

        .social-link {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-buttons {
                gap: 10px;
            }

            .nav-btn {
                padding: 8px 16px;
                font-size: 0.85rem;
            }

            .hero {
                padding: 120px 20px 80px;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .hero-stats {
                gap: 40px;
            }

            .stat-number {
                font-size: 2rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .events-grid,
            .features-grid,
            .testimonials-grid,
            .steps {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .cta h2 {
                font-size: 2rem;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .social-links {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .logo-text {
                font-size: 1.2rem;
            }

            .logo-icon {
                width: 40px;
                height: 40px;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Header/Navigation -->
    <header class="header">
        <nav class="nav-container">
            <a href="{{ route('home') }}" class="logo">
                <div class="logo-icon">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 3L24 9V21L15 27L6 21V9L15 3Z" fill="url(#gradient)" stroke="url(#gradient)" stroke-width="2"/>
                        <circle cx="15" cy="15" r="4" fill="white"/>
                        <defs>
                            <linearGradient id="gradient" x1="6" y1="3" x2="24" y2="27">
                                <stop offset="0%" stop-color="#3b82f6"/>
                                <stop offset="100%" stop-color="#1d4ed8"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <span class="logo-text">EventHub</span>
            </a>
            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="nav-btn nav-btn-login">Sign In</a>
                <a href="{{ route('register') }}" class="nav-btn nav-btn-signup">Get Started</a>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-sparkles"></i> Trusted by 10,000+ Event Organizers
            </div>
            <h1>Create Unforgettable Events</h1>
            <p>The complete platform to plan, manage, and scale your events. From small meetups to large conferences, we've got you covered.</p>
            <div class="hero-buttons">
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-rocket"></i> Start Free Today
                </a>
                <a href="#events" class="btn btn-secondary">
                    <i class="fas fa-play-circle"></i> Explore Events
                </a>
            </div>
            <div class="hero-stats">
                <div class="stat">
                    <span class="stat-number">50K+</span>
                    <span class="stat-label">Events Created</span>
                </div>
                <div class="stat">
                    <span class="stat-number">2M+</span>
                    <span class="stat-label">Happy Attendees</span>
                </div>
                <div class="stat">
                    <span class="stat-number">98%</span>
                    <span class="stat-label">Satisfaction Rate</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Events Showcase -->
    <section class="events-showcase" id="events">
        <div class="container">
            <div class="section-title">
                <h2>Upcoming Events</h2>
                <p>Discover amazing events happening near you</p>
            </div>
            <div class="events-grid">
                @if($upcomingEvents && $upcomingEvents->count() > 0)
                    @foreach($upcomingEvents as $event)
                        <div class="event-card">
                            <div class="event-image">
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}">
                                @else
                                    <i class="fas fa-calendar-star"></i>
                                @endif
                                <span class="event-badge">Upcoming</span>
                            </div>
                            <div class="event-content">
                                <div class="event-date">
                                    <i class="far fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }} • {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                </div>
                                <h3 class="event-title">{{ Str::limit($event->title, 50) }}</h3>
                                <div class="event-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $event->venue->name ?? 'Location TBA' }}
                                </div>
                                <div class="event-footer">
                                    <span class="event-attendees">
                                        <i class="fas fa-users"></i>
                                        {{ $event->bookings->count() }} attending
                                    </span>
                                    <span class="event-price">
                                        @if($event->price > 0)
                                            ${{ number_format($event->price, 2) }}
                                        @else
                                            Free
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Default placeholder events -->
                    <div class="event-card">
                        <div class="event-image">
                            <i class="fas fa-music"></i>
                            <span class="event-badge">Upcoming</span>
                        </div>
                        <div class="event-content">
                            <div class="event-date">
                                <i class="far fa-calendar"></i>
                                {{ now()->addDays(15)->format('M d, Y') }} • 7:00 PM
                            </div>
                            <h3 class="event-title">Summer Music Festival 2026</h3>
                            <div class="event-location">
                                <i class="fas fa-map-marker-alt"></i>
                                Central Park Amphitheater
                            </div>
                            <div class="event-footer">
                                <span class="event-attendees">
                                    <i class="fas fa-users"></i>
                                    1,234 attending
                                </span>
                                <span class="event-price">$45.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="event-card">
                        <div class="event-image">
                            <i class="fas fa-laptop-code"></i>
                            <span class="event-badge">Upcoming</span>
                        </div>
                        <div class="event-content">
                            <div class="event-date">
                                <i class="far fa-calendar"></i>
                                {{ now()->addDays(8)->format('M d, Y') }} • 9:00 AM
                            </div>
                            <h3 class="event-title">Tech Conference 2026</h3>
                            <div class="event-location">
                                <i class="fas fa-map-marker-alt"></i>
                                Innovation Hub Convention Center
                            </div>
                            <div class="event-footer">
                                <span class="event-attendees">
                                    <i class="fas fa-users"></i>
                                    856 attending
                                </span>
                                <span class="event-price">$89.00</span>
                            </div>
                        </div>
                    </div>

                    <div class="event-card">
                        <div class="event-image">
                            <i class="fas fa-palette"></i>
                            <span class="event-badge">Upcoming</span>
                        </div>
                        <div class="event-content">
                            <div class="event-date">
                                <i class="far fa-calendar"></i>
                                {{ now()->addDays(21)->format('M d, Y') }} • 6:00 PM
                            </div>
                            <h3 class="event-title">Art & Design Workshop</h3>
                            <div class="event-location">
                                <i class="fas fa-map-marker-alt"></i>
                                Creative Studio Downtown
                            </div>
                            <div class="event-footer">
                                <span class="event-attendees">
                                    <i class="fas fa-users"></i>
                                    234 attending
                                </span>
                                <span class="event-price">Free</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Everything You Need to Succeed</h2>
                <p>Powerful tools designed for modern event organizers</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <h3>Easy Event Creation</h3>
                    <p>Create professional events in minutes with our intuitive builder. Customize every detail from pricing to capacity limits.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Attendee Management</h3>
                    <p>Track registrations, manage check-ins, send bulk communications, and keep all attendee data organized in one place.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>Smart Notifications</h3>
                    <p>Automated email confirmations, reminders, and updates keep your attendees informed and engaged throughout their journey.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Real-Time Analytics</h3>
                    <p>Track ticket sales, monitor attendance rates, and analyze event performance with comprehensive dashboards and reports.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3>Secure Payments</h3>
                    <p>Accept payments seamlessly with integrated payment processing. Support for multiple payment methods and currencies.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3>Mobile Optimized</h3>
                    <p>Fully responsive design ensures your events look perfect on any device. Manage events on-the-go from anywhere.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>What Event Organizers Say</h2>
                <p>Join thousands of satisfied customers worldwide</p>
            </div>
            <div class="testimonials-grid">
                <div class="testimonial-card">
                    <i class="fas fa-quote-right quote-icon"></i>
                    <p class="testimonial-text">"EventHub transformed how we manage our conferences. The analytics dashboard gives us insights we never had before, and ticket sales increased by 40% in just three months!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">SJ</div>
                        <div class="author-info">
                            <h4>Sarah Johnson</h4>
                            <p class="author-role">Conference Director</p>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <i class="fas fa-quote-right quote-icon"></i>
                    <p class="testimonial-text">"The best event management platform I've used. Customer support is outstanding, and the automated notifications save us hours of manual work. Highly recommend for any size event!"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">MC</div>
                        <div class="author-info">
                            <h4>Michael Chen</h4>
                            <p class="author-role">Festival Organizer</p>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card">
                    <i class="fas fa-quote-right quote-icon"></i>
                    <p class="testimonial-text">"We switched from our old system and couldn't be happier. EventHub is intuitive, powerful, and affordable. Our attendees love the seamless registration and ticketing experience."</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">EP</div>
                        <div class="author-info">
                            <h4>Emily Parker</h4>
                            <p class="author-role">Community Event Manager</p>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works">
        <div class="container">
            <div class="section-title">
                <h2>How It Works</h2>
                <p>Start organizing professional events in three simple steps</p>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Create Your Event</h3>
                    <p>Sign up for free and use our intuitive builder to create your event. Add all the details: dates, location, pricing, capacity, and custom branding.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Share & Promote</h3>
                    <p>Get your unique event link and share it everywhere. Accept registrations, process payments, and watch your attendee list grow in real-time.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Manage & Analyze</h3>
                    <p>Track attendance with QR code check-ins, send automated updates, and use analytics to understand what makes your events successful.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-box">
                    <span class="stat-box-number">50K+</span>
                    <span class="stat-box-label">Events Created</span>
                </div>
                <div class="stat-box">
                    <span class="stat-box-number">2M+</span>
                    <span class="stat-box-label">Tickets Sold</span>
                </div>
                <div class="stat-box">
                    <span class="stat-box-number">150+</span>
                    <span class="stat-box-label">Countries</span>
                </div>
                <div class="stat-box">
                    <span class="stat-box-number">24/7</span>
                    <span class="stat-box-label">Support</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="cta">
        <div class="cta-content">
            <h2>Ready to Create Amazing Events?</h2>
            <p>Join thousands of event organizers who trust EventHub to power their events. Start for free today!</p>
            <a href="{{ route('register') }}" class="btn btn-primary">
                <i class="fas fa-rocket"></i> Get Started Free
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>EventHub</h3>
                    <p style="color: rgba(255, 255, 255, 0.7); margin-top: 15px; line-height: 1.8;">
                        The complete event management platform trusted by organizers worldwide. Create, manage, and scale your events with confidence.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h3>Product</h3>
                    <ul class="footer-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#events">Browse Events</a></li>
                        <li><a href="#pricing">Pricing</a></li>
                        <li><a href="#api">API Documentation</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Company</h3>
                    <ul class="footer-links">
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#blog">Blog</a></li>
                        <li><a href="#careers">Careers</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Legal</h3>
                    <ul class="footer-links">
                        <li><a href="#privacy">Privacy Policy</a></li>
                        <li><a href="#terms">Terms of Service</a></li>
                        <li><a href="#cookies">Cookie Policy</a></li>
                        <li><a href="#gdpr">GDPR</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} EventHub. All rights reserved. Made with <i class="fas fa-heart" style="color: #ef4444;"></i> for event organizers.
            </div>
        </div>
    </footer>
</body>
</html>
