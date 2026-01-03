@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-p1Wv6l1xFtf6r8b/nZVJ+J71Gx+PMRIzI1Y5g5kNTRU7F2R9mXBd3PaTR1HIYn/E+2vDsWb7KQ6gkU4b3gU1jw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    :root {
        --primary: #4f46e5;
        --secondary: #22c55e;
        --accent: #f97316;
        --info: #0ea5e9;
        --warning: #eab308;
        --card-radius: 1.4rem;
    }

    body {
        background: radial-gradient(circle at top left, #eef2ff 0, #f9fafb 45%, #f1f5f9 100%);
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
    }

    main {
        min-height: calc(100vh - 80px);
    }

    /* HERO SECTION */
    .dashboard-hero {
        background: linear-gradient(135deg, rgba(79,70,229,1), rgba(14,165,233,1));
        border-radius: 1.8rem;
        color: white;
        padding: 2.6rem 2.8rem;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top right, rgba(250,250,250,0.25), transparent 60%);
        opacity: 0.7;
        pointer-events: none;
    }

    .dashboard-hero h2 {
        font-size: 2.1rem;
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .dashboard-hero p {
        font-size: 1.1rem;
        margin-bottom: .4rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    /* STAT CARDS */
    .stat-card {
        background: rgba(255, 255, 255, 0.96);
        border-radius: var(--card-radius);
        padding: 1.8rem 1.6rem;
        border: 1px solid rgba(148, 163, 184, 0.25);
        text-align: left;
        cursor: pointer;
        position: relative;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease,
            border-color 0.25s ease,
            background-color 0.25s ease;
        overflow: hidden;
    }

    .stat-card::before {
        content: "";
        position: absolute;
        inset: 0;
        opacity: 0;
        background: radial-gradient(circle at top left, rgba(255,255,255,0.65), transparent 55%);
        transition: opacity 0.25s ease;
        pointer-events: none;
    }

    .stat-card:hover {
        transform: translateY(-6px) scale(1.01);
        box-shadow: 0 22px 55px rgba(15, 23, 42, 0.18);
        border-color: rgba(129, 140, 248, 0.7);
        background-color: #ffffff;
    }

    .stat-card:active {
        transform: translateY(0) scale(0.98);
        box-shadow: 0 12px 25px rgba(15, 23, 42, 0.12);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card[data-pulse="true"] {
        animation: statPulse 0.5s ease-out;
    }

    @keyframes statPulse {
        0%   { transform: scale(1); }
        40%  { transform: scale(1.03); }
        100% { transform: scale(1); }
    }

    .stat-pill {
        position: absolute;
        top: 1rem;
        right: 1.1rem;
        padding: 0.25rem 0.7rem;
        border-radius: 999px;
        font-size: 0.7rem;
        letter-spacing: .06em;
        font-weight: 600;
        text-transform: uppercase;
        backdrop-filter: blur(6px);
        background: rgba(15, 23, 42, 0.04);
        color: #64748b;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 1.2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.6rem;
        flex-shrink: 0;
        box-shadow: 0 10px 22px rgba(15, 23, 42, 0.28);
    }

    .stat-content h4 {
        font-size: 1.5rem;
        margin: 0 0 0.1rem;
        font-weight: 700;
        color: #0f172a;
    }

    .stat-content p {
        font-size: 0.95rem;
        margin: 0;
        color: #6b7280;
    }

    .students-icon { background: linear-gradient(135deg, #4f46e5, #6366f1); }
    .courses-icon  { background: linear-gradient(135deg, #22c55e, #16a34a); }
    .admins-icon   { background: linear-gradient(135deg, #f97316, #ea580c); }
    .attendance-icon { background: linear-gradient(135deg, #0ea5e9, #0284c7); }
    .exams-icon    { background: linear-gradient(135deg, #eab308, #ca8a04); }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 1.6rem;
        align-items: stretch;
    }

    @media (max-width: 768px) {
        .dashboard-hero {
            padding: 2rem 1.6rem;
            margin-bottom: 2rem;
        }

        .dashboard-hero h2 {
            font-size: 1.7rem;
        }

        .stat-card {
            padding: 1.5rem 1.3rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            font-size: 1.4rem;
        }
    }
</style>
@endpush

@section('content')

<main class="py-2">
    <div class="container">
        <div class="dashboard-hero mb-4">
            <p>Welcome back, {{ auth()->user()->name }} 👋</p>
            <h2>Your school at a glance</h2>
        </div>

        <div class="dashboard-grid">
            <div>
                <div class="stat-card" data-link="{{ route('students.index') }}">
                    <span class="stat-pill">Students</span>
                    <div class="stat-icon students-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-content">
                        <h4>{{ $counts['students'] ?? 0 }}</h4>
                        <p>Total enrolled students</p>
                    </div>
                </div>
            </div>

            <div>
                <div class="stat-card" data-link="{{ route('courses.index') }}">
                    <span class="stat-pill">Courses</span>
                    <div class="stat-icon courses-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stat-content">
                        <h4>{{ $counts['courses'] ?? 0 }}</h4>
                        <p>Active courses offered</p>
                    </div>
                </div>
            </div>

            <div>
                <div class="stat-card" data-link="{{ route('users.index') }}">
                    <span class="stat-pill">Admins</span>
                    <div class="stat-icon admins-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="stat-content">
                        <h4>{{ $counts['admin_users'] ?? 0 }}</h4>
                        <p>System administrators</p>
                    </div>
                </div>
            </div>

            <div>
                <div class="stat-card" data-link="{{ route('attendance.index') }}">
                    <span class="stat-pill">Attendance</span>
                    <div class="stat-icon attendance-icon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="stat-content">
                        <h4>{{ $counts['attendance'] ?? 0 }}</h4>
                        <p>Recorded attendance entries</p>
                    </div>
                </div>
            </div>

            <div>
                <div class="stat-card" data-link="{{ route('exams.index') }}">
                    <span class="stat-pill">Exams</span>
                    <div class="stat-icon exams-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="stat-content">
                        <h4>{{ $counts['exams'] ?? 0 }}</h4>
                        <p>Exam records and grades</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.stat-card[data-link]').forEach(function (card) {
            card.addEventListener('click', function () {
                const link = card.getAttribute('data-link');
                card.setAttribute('data-pulse', 'true');

                // Short pulse animation, then navigate
                setTimeout(function () {
                    window.location = link;
                }, 180);

                // Clean up pulse attribute
                setTimeout(function () {
                    card.removeAttribute('data-pulse');
                }, 600);
            });
        });
    });
</script>
@endpush

@endsection
