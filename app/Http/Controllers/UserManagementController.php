<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    /**
     * List all users.
     */
    public function index()
    {
        $users = User::whereKeyNot(auth()->id())
            ->orderBy('name')
            ->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show form to create a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('status', 'User created.');
    }

    /**
     * Toggle a user's active status.
     */
    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('status', 'You cannot disable your own account.');
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        return back()->with('status', $user->is_active ? 'User enabled.' : 'User disabled.');
    }

    /**
     * Permanently delete a user account (cannot delete yourself).
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('status', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('status', 'User deleted.');
    }

    /**
     * Show form to change a user's password.
     */
    public function editPassword(User $user)
    {
        return view('users.edit_password', compact('user'));
    }

    /**
     * Update a user's password.
     */
    public function updatePassword(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->password = $data['password'];
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('status', 'Password updated for ' . $user->email . '.');
    }
}
