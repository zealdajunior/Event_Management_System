
<style>


/* =========================
 GLOBAL RESET & VARIABLES
 ========================= */
:root {
    --primary: #3b82f6;
    --secondary: #0f172a;
    --accent: #2563eb;
    --muted: #64748b;
    --bg: #f8fafc;
    --card-bg: #ffffff;
    --radius: 14px;
    --shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

* {
    box-sizing: border-box;
}

body {
    font-family: "Inter", system-ui, sans-serif;
    background-color: var(--bg);
    color: var(--secondary);
    line-height: 1.7;
}

/* =========================
 SECTIONS
 ========================= */
section {
    padding: 80px 20px;
}

.section-title {
    text-align: center;
    max-width: 800px;
    margin: 0 auto 60px;
}

.section-title h2 {
    font-size: 2.4rem;
    font-weight: 700;
    margin-bottom: 12px;
    color: var(--secondary);
}

.section-title .lead {
    font-size: 1.1rem;
    color: var(--muted);
}

/* =========================
 GRID SYSTEM
 ========================= */
.grid {
    max-width: 1200px;
    margin: auto;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 28px;
}

/* =========================
 CARD COMPONENT
 ========================= */
.card {
    background: var(--card-bg);
    border-radius: var(--radius);
    padding: 28px;
    box-shadow: var(--shadow);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

.card h4 {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: var(--primary);
}

.card p {
    font-size: 0.95rem;
    color: var(--muted);
}

/* =========================
 BADGES (OPTIONAL)
 ========================= */
.badge {
    display: inline-block;
    background: rgba(59, 130, 246, 0.1);
    color: var(--primary);
    padding: 6px 14px;
    font-size: 0.75rem;
    border-radius: 999px;
    font-weight: 600;
    margin-bottom: 12px;
}

/* =========================
 KPI / STATS
 ========================= */
.kpi {
    font-size: 2.6rem;
    font-weight: 700;
    color: var(--primary);
}

.kpi-label {
    font-size: 0.85rem;
    color: var(--muted);
}

/* =========================
 BUTTONS (IF USED)
 ========================= */
.btn-primary {
    display: inline-block;
    background: var(--primary);
    color: #fff;
    padding: 12px 28px;
    border-radius: 999px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.3s ease, transform 0.2s ease;
}

.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-2px);
}

/* =========================
 RESPONSIVE ADJUSTMENTS
 ========================= */
@media (max-width: 768px) {
    section {
        padding: 60px 16px;
    }

    .section-title h2 {
        font-size: 2rem;
    }
}

/* =========================
 HERO SECTION
 ========================= */
.hero {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    align-items: center;
    gap: 60px;
    padding: 80px 10%;
    background: linear-gradient(
        135deg,
        #eff6ff 0%,
        #ffffff 50%,
        #f0f9ff 100%
    );
}

/* =========================
 HERO TEXT CONTENT
 ========================= */
.hero > div {
    max-width: 600px;
}

.hero h1 {
    font-size: 3.4rem;
    font-weight: 800;
    line-height: 1.15;
    margin: 16px 0;
    color: var(--secondary);
}

.hero h1 span {
    color: var(--primary);
}

.hero .lead {
    font-size: 1.15rem;
    color: var(--muted);
    margin-bottom: 28px;
}

/* =========================
 HERO ACTION BUTTONS
 ========================= */
.hero .actions {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.hero .btn {
    padding: 14px 32px;
    font-size: 0.95rem;
}

/* Outline button (Sign up) */
.btn-outline {
    border: 2px solid var(--primary);
    color: var(--primary);
    background: transparent;
    border-radius: 999px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline:hover {
    background: var(--primary);
    color: #fff;
}

/* =========================
 KPI PANEL (RIGHT SIDE)
 ========================= */
.hero .kpi {
    background: #ffffff;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 30px;
    display: flex;
    flex-direction: column;
    gap: 22px;
}

/* KPI ITEM */
.kpi-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 14px;
    border-radius: 10px;
    transition: background 0.3s ease;
}

.kpi-item:hover {
    background: #f1f5f9;
}

.kpi-icon {
    font-size: 1.8rem;
}

.kpi-item strong {
    font-size: 1rem;
    color: var(--secondary);
}

.kpi-item small {
    font-size: 0.8rem;
    color: var(--muted);
}

/* =========================
 MOBILE RESPONSIVE
 ========================= */
@media (max-width: 900px) {
    .hero {
        grid-template-columns: 1fr;
        padding: 60px 20px;
        text-align: center;
    }

    .hero > div {
        margin: auto;
    }

    .hero .actions {
        justify-content: center;
    }

    .hero .kpi {
        max-width: 420px;
        margin: 40px auto 0;
    }
}

</style>

<!-- =========================
 HERO SECTION
 ========================= -->
<header class="hero">
    <div>
        <span class="badge">All-in-One Event Platform</span>

        <h1>
            Event Management <span>System</span>
        </h1>

        <p class="lead">
            A centralized platform for planning, promoting, managing,
            and analyzing events of any scale — from small workshops
            to large conferences and festivals.
        </p>

        <!--
        🔧 INSERT LATER:
        - Short mission statement (1–2 lines)
        - Target audience (students, companies, NGOs, organizers)
        - Institution / company name if academic project
        -->

        <div class="actions">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                        Admin Dashboard
                    </a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="btn btn-primary">
                        My Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-outline">Create Account</a>
            @endauth
        </div>
    </div>

    <aside class="kpi">
        <div class="kpi-item">
            <div class="kpi-icon">🎟</div>
            <div>
                <strong>Event Ticketing</strong>
                <br>
                <small>
                    <!-- INSERT: Ticket types supported -->
                    Free / Paid / VIP / Group Tickets
                </small>
            </div>
        </div>

        <div class="kpi-item">
            <div class="kpi-icon">📊</div>
            <div>
                <strong>Performance Analytics</strong>
                <br>
                <small>
                    <!-- INSERT: metrics -->
                    Attendance · Revenue · Engagement rate
                </small>
            </div>
        </div>

        <div class="kpi-item">
            <div class="kpi-icon">🛡</div>
            <div>
                <strong>Security & Access</strong>
                <br>
                <small>
                    <!-- INSERT: security features -->
                    Auth roles · Secure payments · Data protection
                </small>
            </div>
        </div>
    </aside>
</header>
<!-- =========================
 SYSTEM OVERVIEW
 ========================= -->
<section>
    <div class="section-title">
        <h2>System Overview</h2>
        <p class="lead">
            The Event Management System is designed to automate
            the entire event lifecycle, reduce manual workload,
            and improve communication between organizers and attendees.
        </p>
    </div>

    <div class="grid">
        <div class="card">
            <h4>Problem Addressed</h4>
            <p>
                <!-- INSERT -->
                Difficulty in managing registrations, tracking attendance,
                handling payments, and analyzing event success using manual methods.
            </p>
        </div>

        <div class="card">
            <h4>Proposed Solution</h4>
            <p>
                A comprehensive web-based platform that streamlines event creation,
                ticket booking management, user authentication, and provides real-time
                analytics for administrators and event organizers.
            </p>
        </div>

        <div class="card">
            <h4>System Users</h4>
            <p>
                • <strong>Administrators:</strong> Full system access with user management and analytics<br>
                • <strong>Event Organizers:</strong> Create and manage events with booking oversight<br>
                • <strong>Registered Users:</strong> Book tickets, manage profiles, and view event history
            </p>
        </div>
    </div>
</section>
<!-- =========================
 FUNCTIONAL MODULES
 ========================= -->
<section>
    <div class="section-title">
        <h2>Core Functional Modules</h2>
        <p class="lead">
            The system is divided into functional modules,
            each responsible for a specific operation.
        </p>
    </div>

    <div class="grid">
        <div class="card">
            <h4>User Management Module</h4>
            <p>
                Handles user registration, secure login with Laravel Fortify,
                role-based access control (admin/user), password management,
                email verification, and comprehensive profile management.
            </p>
        </div>

        <div class="card">
            <h4>Event Management Module</h4>
            <p>
                Enables administrators to create, update, publish, and manage events
                with comprehensive details including venue, capacity, pricing,
                categories, and scheduling with real-time availability tracking.
            </p>
        </div>

        <div class="card">
            <h4>Booking & Ticket Module</h4>
            <p>
                Manages event bookings with automatic ticket generation,
                capacity validation, status tracking (pending/confirmed/cancelled),
                and comprehensive attendance history for both users and administrators.
            </p>
        </div>

        <div class="card">
            <h4>Analytics & Reporting</h4>
            <p>
                Provides real-time dashboard analytics with booking statistics,
                user growth tracking, event performance metrics, capacity utilization,
                and comprehensive reporting for data-driven decision making.
            </p>
        </div>
    </div>
</section>
<!-- =========================
 EVENT LIFECYCLE
 ========================= -->
<section>
    <div class="section-title">
        <h2>Event Lifecycle</h2>
        <p class="lead">
            Each event follows a structured lifecycle
            from creation to post-event analysis.
        </p>
    </div>

    <div class="grid">
        <div class="card">
            <h4>1. Event Creation</h4>
            <p>
                Organizer defines title, venue, date,
                capacity, ticket pricing, and description.
            </p>
        </div>

        <div class="card">
            <h4>2. Publication & Promotion</h4>
            <p>
                Event becomes visible to users,
                allowing registrations and bookings.
            </p>
        </div>

        <div class="card">
            <h4>3. Booking & Attendance</h4>
            <p>
                Users book tickets, receive confirmations,
                and attend the event.
            </p>
        </div>

        <div class="card">
            <h4>4. Post-Event Evaluation</h4>
            <p>
                Attendance data and feedback are analyzed
                to measure success.
            </p>
        </div>
    </div>
</section>
<!-- =========================
 SYSTEM ARCHITECTURE
 ========================= -->
<section>
    <div class="section-title">
        <h2>System Architecture</h2>
        <p class="lead">
            The Event Management System follows a modular and scalable
            architecture based on the Model–View–Controller (MVC) pattern.
        </p>
    </div>

    <div class="grid">
        <div class="card">
            <h4>Frontend Layer (View)</h4>
            <p>
                Built with Blade templates, Livewire components, and Tailwind CSS
                to create a modern, responsive interface. The design is optimized
                for all screen sizes with a professional blue and white theme.
            </p>
        </div>

        <div class="card">
            <h4>Application Layer (Controller)</h4>
            <p>
                Laravel controllers manage business logic, API endpoints,
                form validation, authentication middleware, and coordinate
                data flow between views and models with clean separation of concerns.
            </p>
        </div>

        <div class="card">
            <h4>Data Layer (Model)</h4>
            <p>
                Eloquent ORM provides elegant database abstraction with model relationships
                (users, events, bookings, venues), query optimization, data validation,
                and seamless MySQL integration for reliable data management.
            </p>
        </div>
    </div>
</section>
<!-- =========================
 DATABASE DESIGN
 ========================= -->
<section>
    <div class="section-title">
        <h2>Database Design</h2>
        <p class="lead">
            The database is designed to ensure data integrity,
            scalability, and efficient retrieval of event-related information.
        </p>
    </div>

    <div class="grid">
        <div class="card">
            <h4>Users Table</h4>
            <p>
                Stores user credentials with bcrypt password hashing,
                role assignment (admin/user), email verification status,
                profile information, and session management data.
            </p>
        </div>

        <div class="card">
            <h4>Events Table</h4>
            <p>
                Contains comprehensive event data: name, description, date/time,
                venue details, capacity limits, pricing, category, audience type,
                status (active/cancelled), and timestamps for tracking.
            </p>
        </div>

        <div class="card">
            <h4>Bookings Table</h4>
            <p>
                Links users to events with foreign key relationships,
                tracks ticket quantities, booking timestamps, status
                (pending/confirmed/cancelled), and maintains attendance records.
            </p>
        </div>

        <div class="card">
            <h4>Venues Table</h4>
            <p>
                Stores venue information including name, full address,
                maximum capacity limits, facility descriptions, and location
                details for efficient event planning and booking management.
            </p>
        </div>
    </div>
</section>
<!-- =========================
 SECURITY & ACCESS CONTROL
 ========================= -->
<section>
    <div class="section-title">
        <h2>Security & Access Control</h2>
        <p class="lead">
            The system implements multiple security measures
            to protect user data and restrict unauthorized access.
        </p>
    </div>

    <div class="grid">
        <div class="card">
            <h4>Authentication</h4>
            <p>
                Implements Laravel Fortify for authentication with bcrypt password hashing,
                email verification, remember tokens, secure session management,
                and password reset functionality with email notifications.
            </p>
        </div>

        <div class="card">
            <h4>Authorization</h4>
            <p>
                Role-based access control (RBAC) with middleware ensures administrators
                can access user management and analytics, while regular users are restricted
                to booking and profile management features only.
            </p>
        </div>

        <div class="card">
            <h4>Data Protection</h4>
            <p>
                Built-in Laravel security features including CSRF token validation,
                SQL injection prevention through Eloquent ORM, XSS protection,
                and secure input sanitization for all user data.
            </p>
        </div>
    </div>
</section>
<!-- =========================
 REAL-WORLD USE CASES
 ========================= -->
<section>
    <div class="section-title">
        <h2>Real-World Use Cases</h2>
        <p class="lead">
            The Event Management System can be applied
            in various real-life scenarios.
        </p>
    </div>

    <div class="grid">
        <div class="card">
            <h4>Educational Institutions</h4>
            <p>
                Perfect for managing university seminars, student workshops,
                freshman orientations, guest lectures, academic conferences,
                and graduation ceremonies with capacity tracking.
            </p>
        </div>

        <div class="card">
            <h4>Corporate Organizations</h4>
            <p>
                Ideal for organizing product launches, employee training sessions,
                team-building activities, corporate meetings, networking events,
                and professional development workshops.
            </p>
        </div>

        <div class="card">
            <h4>Entertainment & Social Events</h4>
            <p>
                Supports large-scale concerts, music festivals, cultural celebrations,
                private weddings, charity fundraisers, art exhibitions,
                and community gatherings with ticket management.
            </p>
        </div>
    </div>
</section>
<!-- =========================
 FUTURE IMPROVEMENTS
 ========================= -->
<section>
    <div class="section-title">
        <h2>Future Enhancements</h2>
        <p class="lead">
            The system is designed to support future expansion
            and additional functionalities.
        </p>
    </div>

    <div class="grid">
        <div class="card">
            <h4>Online Payments Integration</h4>
            <p>
                Planned integration with popular payment gateways including
                Stripe, PayPal, Paystack, and Mobile Money for seamless
                ticket purchases and automated payment processing.
            </p>
        </div>

        <div class="card">
            <h4>Notification System</h4>
            <p>
                Automated email and SMS notifications for booking confirmations,
                event reminders, status updates, password resets,
                and important announcements to keep users informed.
            </p>
        </div>

        <div class="card">
            <h4>Advanced Analytics</h4>
            <p>
                Machine learning integration for predictive analytics,
                attendance forecasting, event success prediction,
                user behavior analysis, and trend identification.
            </p>
        </div>

        <div class="card">
            <h4>Scalability</h4>
            <p>
                Cloud deployment on AWS/Azure, Redis caching for performance,
                CDN integration, database optimization, and load balancing
                to handle thousands of concurrent users.
            </p>
        </div>
    </div>
</section>
<!-- =========================
 CONCLUSION
 ========================= -->
<section>
    <div class="section-title">
        <h2>Conclusion</h2>
        <p class="lead">
            The Event Management System provides a complete,
            secure, and efficient solution for managing events.
        </p>
    </div>

    <div class="card" style="max-width:900px;margin:auto;">
        <p>
            Built with Laravel, Livewire, and Tailwind CSS, this Event Management System
            automates event planning, streamlines registration processes, and provides
            powerful analytics. It reduces manual effort, improves accuracy, enhances
            security, and delivers an exceptional user experience for administrators,
            organizers, and attendees alike.
        </p>
    </div>
</section>
