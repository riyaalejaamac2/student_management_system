@extends('layouts.app')

@section('title', 'Logout')

@section('content')
    <div class="card border-0 shadow-sm mx-auto" style="max-width: 520px;">
        <div class="card-body text-center">
            <h4 class="mb-3">Ready to leave?</h4>
            <p class="text-muted mb-4">You can always log back in whenever you need to.</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary ms-2">Cancel</a>
            </form>
        </div>
    </div>
@endsection

