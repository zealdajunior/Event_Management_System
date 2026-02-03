<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System - Browse Events</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-blue: #2563eb;
            --secondary-blue: #1e40af;
            --light-blue: #dbeafe;
            --dark: #0f172a;
            --gray: #64748b;
            --white: #ffffff;
            --gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #f1f5f9, #ffffff);
            color: var(--dark);
            overflow-x: hidden;
        }

        /* ANIMATIONS */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
        }

        .animate-fadeIn {
            animation: fadeIn 1s ease-out forwards;
            opacity: 0;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.8s ease-out forwards;
            opacity: 0;
        }

        .animate-slideInRight {
            animation: slideInRight 0.8s ease-out forwards;
            opacity: 0;
        }

        .animate-scaleIn {
            animation: scaleIn 0.6s ease-out forwards;
            opacity: 0;
        }

        /* NAVIGATION */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            animation: fadeIn 0.5s ease-out;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.2rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary-blue);
        }

        .btn {
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--gradient);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(37, 99, 235, 0.4);
        }

        .btn-outline {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--primary-blue);
            color: var(--white);
        }

        /* HERO SECTION */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8rem 2rem 4rem;
            background: linear-gradient(135deg, #eff6ff 0%, #ffffff 50%, #dbeafe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            top: -250px;
            right: -250px;
            animation: float 6s ease-in-out infinite;
        }

        .hero::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(37, 99, 235, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -200px;
            left: -200px;
            animation: float 8s ease-in-out infinite;
        }

        .hero-content {
            max-width: 1400px;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-text h1 {
            font-size: 4rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .hero-text h1 .highlight {
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-text p {
            font-size: 1.25rem;
            color: var(--gray);
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .badge {
            display: inline-block;
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary-blue);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        /* STATS BOX */
        .stats-box {
            background: var(--white);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .stat-item {
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-radius: 15px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-item:hover {
            transform: translateX(10px);
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        }

        .stat-item:last-child {
            margin-bottom: 0;
        }

        .stat-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .stat-item h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.3rem;
        }

        .stat-item p {
            font-size: 0.9rem;
            color: var(--gray);
            margin: 0;
        }

        /* SECTION STYLES */
        section {
            padding: 6rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 3rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .section-header p {
            font-size: 1.2rem;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto;
        }

        /* CARD GRID */
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
        }

        .card {
            background: var(--white);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--gradient);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .card p {
            color: var(--gray);
            line-height: 1.8;
        }

        .card ul {
            list-style: none;
            padding: 0;
        }

        .card ul li {
            color: var(--gray);
            padding: 0.5rem 0;
            padding-left: 1.5rem;
            position: relative;
        }

        .card ul li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: var(--primary-blue);
            font-weight: bold;
        }

        /* TIMELINE */
        .timeline {
            position: relative;
            padding: 2rem 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 100%;
            background: var(--gradient);
        }

        .timeline-item {
            display: flex;
            gap: 2rem;
            margin-bottom: 3rem;
            position: relative;
        }

        .timeline-item:nth-child(even) {
            flex-direction: row-reverse;
        }

        .timeline-content {
            flex: 1;
            background: var(--white);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .timeline-number {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 800;
            box-shadow: 0 0 0 10px rgba(255, 255, 255, 0.9);
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 3rem;
            }

            .hero-actions {
                justify-content: center;
            }

            .stats-box {
                max-width: 500px;
                margin: 0 auto;
            }

            .timeline::before {
                left: 30px;
            }

            .timeline-item {
                flex-direction: column !important;
                padding-left: 80px;
            }

            .timeline-number {
                left: 30px;
            }
        }

        @media (max-width: 768px) {
            .hero-text h1 {
                font-size: 2.5rem;
            }

            .section-header h2 {
                font-size: 2rem;
            }

            .card-grid {
                grid-template-columns: 1fr;
            }

            .nav-links {
                display: none;
            }
        }

        /* SCROLL REVEAL */
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.6s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* TESTIMONIALS */
        .testimonials-section {
            padding: 6rem 2rem;
            background: var(--white);
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .testimonial-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 2.5rem;
            border-radius: 20px;
            position: relative;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .quote-icon {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 3rem;
            color: var(--primary-blue);
            opacity: 0.1;
        }

        .testimonial-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--dark);
            margin-bottom: 2rem;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .author-info h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.3rem;
        }

        .author-role {
            font-size: 0.9rem;
            color: var(--gray);
        }

        .rating {
            display: flex;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }

        .rating i {
            color: #fbbf24;
            font-size: 0.9rem;
        }

        /* FOOTER */
        footer {
            background: var(--dark);
            color: var(--white);
            padding: 4rem 2rem 2rem;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-section h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-section p {
            color: #94a3b8;
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-links a:hover {
            color: var(--white);
            transform: translateX(5px);
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary-blue);
            transform: translateY(-5px);
        }

        .footer-bottom {
            max-width: 1400px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: #94a3b8;
        }

        .mobile-menu-btn {
            display: none;
            font-size: 1.5rem;
            background: none;
            border: none;
            color: var(--dark);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--white);
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            .nav-links.active {
                display: flex;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .social-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <!-- NAVIGATION -->
    <nav>
        <div class="nav-container">
            <div class="logo animate-fadeIn">
                <i class="fas fa-calendar-star"></i> EventHub
            </div>
            <button class="mobile-menu-btn" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="nav-links animate-fadeIn" style="animation-delay: 0.2s;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fas fa-chart-line"></i> Dashboard</a>
                    <?php else: ?>
                        <a href="<?php echo e(route('user.dashboard')); ?>"><i class="fas fa-user"></i> Dashboard</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <a href="<?php echo e(route('profile.show')); ?>"><i class="fas fa-cog"></i> Settings</a>
                    <a href="<?php echo e(route('logout')); ?>" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="btn btn-outline">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
                <?php else: ?>
                    <a href="#features">Features</a>
                    <a href="#modules">Modules</a>
                    <a href="#architecture">Architecture</a>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Sign In
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <span class="badge animate-fadeInUp">🚀 All-in-One Event Platform</span>
                <h1 class="animate-fadeInUp" style="animation-delay: 0.1s;">
                    Event Management <span class="highlight">System</span>
                </h1>
                <p class="animate-fadeInUp" style="animation-delay: 0.2s;">
                    A centralized platform for planning, promoting, managing, and analyzing events of any scale — 
                    from small workshops to large conferences and festivals.
                </p>
                <div class="hero-actions animate-fadeInUp" style="animation-delay: 0.3s;">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isAdmin()): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-primary">
                                <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-primary">
                                <i class="fas fa-calendar-check"></i> My Dashboard
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Sign In
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-outline">
                            <i class="fas fa-user-plus"></i> Create Account
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="stats-box animate-scaleIn" style="animation-delay: 0.4s;">
                <div class="stat-item">
                    <div class="stat-icon">🎟️</div>
                    <h3>Event Ticketing</h3>
                    <p>Free / Paid / VIP / Group Tickets</p>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">📊</div>
                    <h3>Performance Analytics</h3>
                    <p>Attendance · Revenue · Engagement rate</p>
                </div>
                <div class="stat-item">
                    <div class="stat-icon">🛡️</div>
                    <h3>Security & Access</h3>
                    <p>Auth roles · Secure payments · Data protection</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SYSTEM OVERVIEW -->
    <section id="features">
        <div class="section-header reveal">
            <h2>System Overview</h2>
            <p>The Event Management System is designed to automate the entire event lifecycle, 
            reduce manual workload, and improve communication between organizers and attendees.</p>
        </div>
        <div class="card-grid">
            <div class="card reveal" style="transition-delay: 0.1s;">
                <div class="card-icon"><i class="fas fa-exclamation-circle"></i></div>
                <h3>Problem Addressed</h3>
                <p>Difficulty in managing registrations, tracking attendance, handling payments, 
                and analyzing event success using manual methods.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.2s;">
                <div class="card-icon"><i class="fas fa-lightbulb"></i></div>
                <h3>Proposed Solution</h3>
                <p>A comprehensive web-based platform that streamlines event creation, 
                ticket booking management, user authentication, and provides real-time analytics.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.3s;">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <h3>System Users</h3>
                <ul>
                    <li><strong>Administrators:</strong> Full system access with user management</li>
                    <li><strong>Event Organizers:</strong> Create and manage events</li>
                    <li><strong>Registered Users:</strong> Book tickets and manage profiles</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- FUNCTIONAL MODULES -->
    <section id="modules">
        <div class="section-header reveal">
            <h2>Core Functional Modules</h2>
            <p>The system is divided into functional modules, each responsible for a specific operation.</p>
        </div>
        <div class="card-grid">
            <div class="card reveal" style="transition-delay: 0.1s;">
                <div class="card-icon"><i class="fas fa-user-shield"></i></div>
                <h3>User Management Module</h3>
                <p>Handles user registration, secure login with Laravel Fortify, role-based access control, 
                password management, email verification, and comprehensive profile management.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.2s;">
                <div class="card-icon"><i class="fas fa-calendar-alt"></i></div>
                <h3>Event Management Module</h3>
                <p>Enables administrators to create, update, publish, and manage events with comprehensive details 
                including venue, capacity, pricing, categories, and scheduling.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.3s;">
                <div class="card-icon"><i class="fas fa-ticket-alt"></i></div>
                <h3>Booking & Ticket Module</h3>
                <p>Manages event bookings with automatic ticket generation, capacity validation, 
                status tracking, and comprehensive attendance history.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.4s;">
                <div class="card-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Analytics & Reporting</h3>
                <p>Provides real-time dashboard analytics with booking statistics, user growth tracking, 
                event performance metrics, and comprehensive reporting.</p>
            </div>
        </div>
    </section>

    <!-- EVENT LIFECYCLE TIMELINE -->
    <section>
        <div class="section-header reveal">
            <h2>Event Lifecycle</h2>
            <p>Each event follows a structured lifecycle from creation to post-event analysis.</p>
        </div>
        <div class="timeline">
            <div class="timeline-item reveal">
                <div class="timeline-number">1</div>
                <div class="timeline-content">
                    <h3>Event Creation</h3>
                    <p>Organizer defines title, venue, date, capacity, ticket pricing, and description.</p>
                </div>
                <div style="flex: 1;"></div>
            </div>
            <div class="timeline-item reveal">
                <div class="timeline-number">2</div>
                <div style="flex: 1;"></div>
                <div class="timeline-content">
                    <h3>Publication & Promotion</h3>
                    <p>Event becomes visible to users, allowing registrations and bookings.</p>
                </div>
            </div>
            <div class="timeline-item reveal">
                <div class="timeline-number">3</div>
                <div class="timeline-content">
                    <h3>Booking & Attendance</h3>
                    <p>Users book tickets, receive confirmations, and attend the event.</p>
                </div>
                <div style="flex: 1;"></div>
            </div>
            <div class="timeline-item reveal">
                <div class="timeline-number">4</div>
                <div style="flex: 1;"></div>
                <div class="timeline-content">
                    <h3>Post-Event Evaluation</h3>
                    <p>Attendance data and feedback are analyzed to measure success.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SYSTEM ARCHITECTURE -->
    <section id="architecture">
        <div class="section-header reveal">
            <h2>System Architecture</h2>
            <p>The Event Management System follows a modular and scalable architecture based on the 
            Model–View–Controller (MVC) pattern.</p>
        </div>
        <div class="card-grid">
            <div class="card reveal" style="transition-delay: 0.1s;">
                <div class="card-icon"><i class="fas fa-desktop"></i></div>
                <h3>Frontend Layer (View)</h3>
                <p>Built with Blade templates, Livewire components, and Tailwind CSS to create a modern, 
                responsive interface optimized for all screen sizes.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.2s;">
                <div class="card-icon"><i class="fas fa-cogs"></i></div>
                <h3>Application Layer (Controller)</h3>
                <p>Laravel controllers manage business logic, API endpoints, form validation, 
                authentication middleware, and coordinate data flow.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.3s;">
                <div class="card-icon"><i class="fas fa-database"></i></div>
                <h3>Data Layer (Model)</h3>
                <p>Eloquent ORM provides elegant database abstraction with model relationships, 
                query optimization, data validation, and seamless MySQL integration.</p>
            </div>
        </div>
    </section>

    <!-- DATABASE DESIGN -->
    <section>
        <div class="section-header reveal">
            <h2>Database Design</h2>
            <p>The database is designed to ensure data integrity, scalability, and efficient retrieval 
            of event-related information.</p>
        </div>
        <div class="card-grid">
            <div class="card reveal" style="transition-delay: 0.1s;">
                <div class="card-icon"><i class="fas fa-user-circle"></i></div>
                <h3>Users Table</h3>
                <p>Stores user credentials with bcrypt password hashing, role assignment, email verification status, 
                profile information, and session management data.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.2s;">
                <div class="card-icon"><i class="fas fa-calendar"></i></div>
                <h3>Events Table</h3>
                <p>Contains comprehensive event data: name, description, date/time, venue details, capacity limits, 
                pricing, category, audience type, and status tracking.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.3s;">
                <div class="card-icon"><i class="fas fa-bookmark"></i></div>
                <h3>Bookings Table</h3>
                <p>Links users to events with foreign key relationships, tracks ticket quantities, booking timestamps, 
                status, and maintains attendance records.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.4s;">
                <div class="card-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3>Venues Table</h3>
                <p>Stores venue information including name, full address, maximum capacity limits, 
                facility descriptions, and location details.</p>
            </div>
        </div>
    </section>

    <!-- SECURITY -->
    <section>
        <div class="section-header reveal">
            <h2>Security & Access Control</h2>
            <p>The system implements multiple security measures to protect user data and 
            restrict unauthorized access.</p>
        </div>
        <div class="card-grid">
            <div class="card reveal" style="transition-delay: 0.1s;">
                <div class="card-icon"><i class="fas fa-lock"></i></div>
                <h3>Authentication</h3>
                <p>Implements Laravel Fortify for authentication with bcrypt password hashing, email verification, 
                remember tokens, secure session management, and password reset functionality.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.2s;">
                <div class="card-icon"><i class="fas fa-user-lock"></i></div>
                <h3>Authorization</h3>
                <p>Role-based access control (RBAC) with middleware ensures administrators can access user management 
                and analytics, while regular users are restricted to booking features.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.3s;">
                <div class="card-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Data Protection</h3>
                <p>Built-in Laravel security features including CSRF token validation, SQL injection prevention, 
                XSS protection, and secure input sanitization for all user data.</p>
            </div>
        </div>
    </section>

    <!-- USE CASES -->
    <section>
        <div class="section-header reveal">
            <h2>Real-World Use Cases</h2>
            <p>The Event Management System can be applied in various real-life scenarios.</p>
        </div>
        <div class="card-grid">
            <div class="card reveal" style="transition-delay: 0.1s;">
                <div class="card-icon"><i class="fas fa-graduation-cap"></i></div>
                <h3>Educational Institutions</h3>
                <p>Perfect for managing university seminars, student workshops, freshman orientations, 
                guest lectures, academic conferences, and graduation ceremonies.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.2s;">
                <div class="card-icon"><i class="fas fa-building"></i></div>
                <h3>Corporate Organizations</h3>
                <p>Ideal for organizing product launches, employee training sessions, team-building activities, 
                corporate meetings, and networking events.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.3s;">
                <div class="card-icon"><i class="fas fa-music"></i></div>
                <h3>Entertainment & Social Events</h3>
                <p>Supports large-scale concerts, music festivals, cultural celebrations, private weddings, 
                charity fundraisers, and art exhibitions.</p>
            </div>
        </div>
    </section>

    <!-- FUTURE ENHANCEMENTS -->
    <section>
        <div class="section-header reveal">
            <h2>Future Enhancements</h2>
            <p>The system is designed to support future expansion and additional functionalities.</p>
        </div>
        <div class="card-grid">
            <div class="card reveal" style="transition-delay: 0.1s;">
                <div class="card-icon"><i class="fas fa-credit-card"></i></div>
                <h3>Online Payments Integration</h3>
                <p>Planned integration with popular payment gateways including Stripe, PayPal, Paystack, 
                and Mobile Money for seamless ticket purchases.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.2s;">
                <div class="card-icon"><i class="fas fa-bell"></i></div>
                <h3>Notification System</h3>
                <p>Automated email and SMS notifications for booking confirmations, event reminders, 
                status updates, and important announcements.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.3s;">
                <div class="card-icon"><i class="fas fa-brain"></i></div>
                <h3>Advanced Analytics</h3>
                <p>Machine learning integration for predictive analytics, attendance forecasting, 
                event success prediction, and user behavior analysis.</p>
            </div>
            <div class="card reveal" style="transition-delay: 0.4s;">
                <div class="card-icon"><i class="fas fa-expand-arrows-alt"></i></div>
                <h3>Scalability</h3>
                <p>Cloud deployment on AWS/Azure, Redis caching for performance, CDN integration, 
                database optimization, and load balancing.</p>
            </div>
        </div>
    </section>

    <!-- CONCLUSION -->
    <section>
        <div class="section-header reveal">
            <h2>Conclusion</h2>
            <p>The Event Management System provides a complete, secure, and efficient solution for managing events.</p>
        </div>
        <div class="card reveal" style="max-width: 900px; margin: 0 auto;">
            <div class="card-icon"><i class="fas fa-check-circle"></i></div>
            <h3>Built for Excellence</h3>
            <p>Built with Laravel, Livewire, and Tailwind CSS, this Event Management System automates event planning, 
            streamlines registration processes, and provides powerful analytics. It reduces manual effort, improves accuracy, 
            enhances security, and delivers an exceptional user experience for administrators, organizers, and attendees alike.</p>
            <div style="margin-top: 2rem; text-align: center;">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-primary">
                            <i class="fas fa-rocket"></i> Go to Dashboard
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('user.dashboard')); ?>" class="btn btn-primary">
                            <i class="fas fa-rocket"></i> Go to Dashboard
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">
                        <i class="fas fa-rocket"></i> Get Started Now
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS WITH RATINGS -->
    <section class="testimonials-section">
        <div class="section-header reveal">
            <h2>What Our Users Say</h2>
            <p>Hear from event organizers who transformed their events with our platform</p>
        </div>
        <div class="testimonials-grid">
            <div class="card reveal" style="transition-delay: 0.1s;">
                <i class="fas fa-quote-right quote-icon"></i>
                <p class="testimonial-text">
                    "This Event Management System completely transformed how we organize our conferences. 
                    The intuitive interface and powerful analytics gave us insights we never had before. 
                    Ticket sales increased by 45% in the first quarter!"
                </p>
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

            <div class="card reveal" style="transition-delay: 0.2s;">
                <i class="fas fa-quote-right quote-icon"></i>
                <p class="testimonial-text">
                    "The best event management platform I've used in my 10 years as an organizer. 
                    The automated notifications save us countless hours, and the booking system is flawless. 
                    Customer support is outstanding!"
                </p>
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

            <div class="card reveal" style="transition-delay: 0.3s;">
                <i class="fas fa-quote-right quote-icon"></i>
                <p class="testimonial-text">
                    "We switched from our old system and the difference is night and day. 
                    EventHub is intuitive, powerful, and affordable. Our attendees love the seamless 
                    registration and ticketing experience. Highly recommended!"
                </p>
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
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>EventHub</h3>
                <p>The complete event management platform trusted by organizers worldwide. Create, manage, and scale your events with confidence.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Product</h3>
                <ul class="footer-links">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#modules">Modules</a></li>
                    <li><a href="#architecture">Architecture</a></li>
                    <li><a href="<?php echo e(route('register')); ?>">Pricing</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Company</h3>
                <ul class="footer-links">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Legal</h3>
                <ul class="footer-links">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                    <li><a href="#">GDPR</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo e(date('Y')); ?> EventHub. All rights reserved. Built with ❤️ for event organizers worldwide.</p>
        </div>
    </footer>

    <!-- SCROLL REVEAL SCRIPT -->
    <script>
        // Scroll reveal animation
        function reveal() {
            const reveals = document.querySelectorAll('.reveal');
            
            reveals.forEach(element => {
                const windowHeight = window.innerHeight;
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < windowHeight - elementVisible) {
                    element.classList.add('active');
                }
            });
        }

        window.addEventListener('scroll', reveal);
        reveal(); // Initial check

        // Mobile menu toggle
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const navLinks = document.querySelector('.nav-links');
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });
        }
    </script>

</body>
</html>
<?php /**PATH C:\Users\Zealda Junior\Desktop\Event\event_management\resources\views/welcome.blade.php ENDPATH**/ ?>