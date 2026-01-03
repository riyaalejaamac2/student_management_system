<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $appSettings->site_name ?? 'Students Management System' }} - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Font Awesome for footer/contact icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-p1Wv6l1xFtf6r8b/nZVJ+J71Gx+PMRIzI1Y5g5kNTRU7F2R9mXBd3PaTR1HIYn/E+2vDsWb7KQ6gkU4b3gU1jw=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-color: #f4f6fb;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Inter', sans-serif;
        }

        .content-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .app-footer {
            margin-top: auto;
            background: radial-gradient(circle at top, #111827 0, #020617 35%, #020617 100%);
            color: #e5e7eb;
            padding: 1.75rem 2.25rem;
            border-top: 1px solid rgba(148, 163, 184, 0.35);
        }

        .app-footer h6 {
            font-weight: 700;
            letter-spacing: .08em;
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #9ca3af;
        }

        .app-footer p {
            margin-bottom: 0.35rem;
            font-size: 0.9rem;
            color: #d1d5db;
        }

        .footer-contact-links a {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            color: #e5e7eb;
            text-decoration: none;
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                background-color 0.2s ease,
                color 0.2s ease;
        }

        .footer-contact-links a:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.8);
            color: #f9fafb;
        }

        .footer-contact-links .telegram {
            background: linear-gradient(135deg, #0ea5e9, #0284c7);
        }

        .footer-contact-links .facebook {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .footer-contact-links .email {
            background: linear-gradient(135deg, #f97316, #ec4899);
        }

        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #f97316, #ec4899, #6366f1);
            color: #f9fafb;
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.35);
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
            position: relative;
            overflow: hidden;
            margin-right: 1.25rem; /* create breathing space from the main content */
        }

        .sidebar::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(255,255,255,0.25), transparent 60%);
            opacity: 0.8;
            pointer-events: none;
        }

        .sidebar-inner {
            position: relative;
            z-index: 1;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .sidebar-logo {
            width: 46px;
            height: 46px;
            border-radius: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.18);
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.35);
            font-size: 1.6rem;
        }

        .sidebar-title {
            font-size: 1rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .sidebar-subtitle {
            font-size: 0.75rem;
            opacity: 0.9;
        }

        .sidebar-nav-link {
            color: #f9fafb;
            text-decoration: none;
            padding: 0.55rem 0.85rem;
            border-radius: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.93rem;
            opacity: 0.94;
            transition:
                background-color 0.25s ease,
                transform 0.2s ease,
                opacity 0.2s ease;
        }

        .sidebar-nav-link span {
            flex: 1;
        }

        .sidebar-nav-link.active,
        .sidebar-nav-link:hover {
            background-color: rgba(15, 23, 42, 0.16);
            transform: translateX(4px);
            opacity: 1;
        }

    </style>
    @stack('styles')
</head>

<body>
    <div class="d-flex">
        <aside class="sidebar text-white p-4 d-flex flex-column align-self-start">
            <div class="sidebar-inner d-flex flex-column h-100">
                <div class="sidebar-brand">
                    <div class="sidebar-logo">
                        <span>📖</span>
                    </div>
                    <div>
                        <div class="sidebar-title">
                            Students Management<br>System
                        </div>
                        <div class="sidebar-subtitle">
                            {{ $appSettings->site_name ?? 'SMS' }}
                        </div>
                    </div>
                </div>

                <nav class="nav flex-column gap-1 mb-3">
                    <a class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        <span>Dashboard</span>
                    </a>
                    <a class="sidebar-nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}"
                       href="{{ route('students.index') }}">
                        <span>Students</span>
                    </a>
                    <a class="sidebar-nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}"
                       href="{{ route('courses.index') }}">
                        <span>Courses</span>
                    </a>
                    <a class="sidebar-nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}"
                       href="{{ route('attendance.index') }}">
                        <span>Attendance</span>
                    </a>
                    <a class="sidebar-nav-link {{ request()->routeIs('exams.*') ? 'active' : '' }}"
                       href="{{ route('exams.index') }}">
                        <span>Exams</span>
                    </a>
                    <a class="sidebar-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                       href="{{ route('users.index') }}">
                        <span>Users</span>
                    </a>
                    <a class="sidebar-nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}"
                       href="{{ route('settings.index') }}">
                        <span>Settings</span>
                    </a>
                    <a class="sidebar-nav-link {{ request()->routeIs('logout.confirm') ? 'active' : '' }}"
                       href="{{ route('logout.confirm') }}">
                        <span>Logout</span>
                    </a>
                </nav>

            </div>
        </aside>

        <div class="flex-grow-1 content-wrapper">
            <nav class="navbar bg-white shadow-sm px-4">
                <div class="container-fluid">
                    <span class="navbar-brand fw-semibold">@yield('title', 'Dashboard')</span>
                    <div class="d-flex align-items-center gap-2">
                        <div class="text-end">
                            <div class="fw-semibold">{{ auth()->user()?->name }}</div>
                            <small class="text-muted text-capitalize">{{ auth()->user()?->role }}</small>
                        </div>
                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center"
                            style="width: 45px; height: 45px;">
                            {{ strtoupper(substr(auth()->user()?->name ?? '?', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </nav>

            <main class="p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>We spotted a few issues:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>

          
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>

