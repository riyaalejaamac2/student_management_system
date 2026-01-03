<?php

namespace App\Http\Controllers;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, Closure $next) {
            abort_unless(auth()->user()?->isAdmin(), 403, 'Only administrators can manage users.');

            return $next($request);
        });
    }

    /**
     * Display a listing of the users.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $users = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('users.create', [
            'user' => new User(),
        ]);
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validatedData($request, $user->id, isUpdate: true);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        abort_if(auth()->id() === $user->id, 422, 'You cannot delete your own account.');

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Validate incoming data for user CRUD operations.
     *
     * @return array<string, mixed>
     */
    private function validatedData(
        Request $request,
        ?int $userId = null,
        bool $isUpdate = false
    ): array {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'role' => ['required', Rule::in(['admin', 'staff', 'course_manager', 'student', 'attendance', 'exam'])],
            'password' => [
                $isUpdate ? 'nullable' : 'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);
    }
}

