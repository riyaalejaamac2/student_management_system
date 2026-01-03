@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">System Users</h4>
            <small class="text-muted">Only administrators can manage accounts.</small>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
    </div>

    <form class="card border-0 shadow-sm mb-4" method="GET">
        <div class="card-body row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Search</label>
                <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                    placeholder="Name or email">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary w-100">Search</button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('users.index') }}" class="btn btn-light w-100">Reset</a>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $roleClasses = [
                                        'admin' => 'bg-primary',
                                        'course_manager' => 'bg-info text-dark',
                                        'staff' => 'bg-secondary',
                                        'student' => 'bg-success',
                                        'attendance' => 'bg-warning text-dark',
                                        'exam' => 'bg-danger',
                                    ];
                                @endphp
                                <span class="badge {{ $roleClasses[$user->role] ?? 'bg-secondary' }}">
                                    {{ ucwords(str_replace('_', ' ', $user->role)) }}
                                </span>
                            </td>
                            <td>{{ $user->created_at?->format('M d, Y') ?? '—' }}</td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-primary">Edit</a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $users->links() }}
        </div>
    </div>
@endsection

