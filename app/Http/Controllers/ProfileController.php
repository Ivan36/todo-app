<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile')->with('success', 'Password changed successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();

        // Delete all user's tasks first
        $user->tasks()->delete();

        // Logout the user
        Auth::logout();

        // Delete the user account
        $user->delete();

        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Your account has been deleted successfully.');
    }
}
