@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    @php
        $isAdmin = auth()->user()->isAdmin();
    @endphp
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">System Settings</h4>
            <small class="text-muted">Update system-wide preferences.</small>
        </div>
        @unless ($isAdmin)
            <span class="badge bg-secondary">View only</span>
        @endunless
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('settings.update') }}">
                @csrf
                @method('PUT')
                <fieldset @disabled(!$isAdmin)>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">System Name</label>
                            <input type="text" class="form-control" name="site_name"
                                value="{{ old('site_name', $settings->site_name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">System Email</label>
                            <input type="email" class="form-control" name="system_email"
                                value="{{ old('system_email', $settings->system_email) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Contact Phone</label>
                            <input type="text" class="form-control" name="contact_phone"
                                value="{{ old('contact_phone', $settings->contact_phone) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Academic Year</label>
                            <input type="text" class="form-control" name="academic_year"
                                value="{{ old('academic_year', $settings->academic_year) }}" placeholder="e.g. 2024/2025">
                        </div>
                    </div>
                </fieldset>
                @if ($isAdmin)
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </div>
                @endif
            </form>
            @unless ($isAdmin)
                <p class="text-muted mb-0 mt-3">You have read-only access to settings.</p>
            @endunless
        </div>
    </div>
@endsection

