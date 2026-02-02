@extends('layouts.guest')

@section('title', 'Login')

@push('styles')
    <style>
        .login-hero {
            background: linear-gradient(135deg, #f97316, #ec4899, #6366f1);
            border-radius: 1.5rem;
            color: #fff;
            padding: 2.25rem 1.75rem;
            position: relative;
            overflow: hidden;
        }

        .login-hero::after,
        .login-hero::before {
            content: '👏';
            position: absolute;
            font-size: 2.5rem;
            opacity: 0.2;
            animation: clapFloat 6s linear infinite;
        }

        .login-hero::after {
            top: 10%;
            left: 8%;
            animation-delay: 0.5s;
        }

        .login-hero::before {
            bottom: 15%;
            right: 12%;
        }

        .clap-swarm span {
            display: inline-block;
            font-size: 1.75rem;
            animation: clapPulse 1.8s ease-in-out infinite;
        }

        .clap-swarm span:nth-child(2) {
            animation-delay: 0.3s;
        }

        .clap-swarm span:nth-child(3) {
            animation-delay: 0.6s;
        }

        @keyframes clapFloat {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.15;
            }

            50% {
                opacity: 0.35;
            }

            100% {
                transform: translateY(-30px) rotate(12deg);
                opacity: 0.15;
            }
        }

        @keyframes clapPulse {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-4px) scale(1.1);
            }
        }
    </style>
@endpush

@section('content')
    <div class="card border-0 shadow-lg overflow-hidden">
        <div class="login-hero text-center">
            <div class="clap-swarm mb-2">
                <span>👏</span>
                <span>👏</span>
                <span>👏</span>
            </div>
            <p class="text-white-75 mb-1 text-uppercase small">Welcome</p>
            <h2 class="fw-bold mb-2" id="loginWelcomeText">Welcome User</h2>
            <p class="mb-0 text-white-75">Sign in as admin or staff to continue.</p>
        </div>
        <div class="card-body p-4">
            <div class="text-center mb-3">
                <div class="rounded-circle mx-auto mb-2"
                    style="width: 72px; height: 72px; background: linear-gradient(135deg, #f97316, #ec4899); display: grid; place-items: center;">
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <span style="font-size: 1.6rem;">📖</span>
                        <span class="text-white fw-bold small">SMS</span>
                    </div>
                </div>
                <h3 class="mb-0">{{ $appSettings->site_name ?? 'SMS' }}</h3>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <!-- Registration disabled -->
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const welcomeTarget = document.getElementById('loginWelcomeText');
                const roles = ['User', 'Admin', 'Staff'];
                let index = 0;

                setInterval(() => {
                    index = (index + 1) % roles.length;
                    welcomeTarget.textContent = `Welcome ${roles[index]}`;
                }, 2200);
            });
        </script>
    @endpush
@endsection