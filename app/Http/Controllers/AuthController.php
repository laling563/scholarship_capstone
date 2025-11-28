<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');  // This view should be your login form
    }

    // Handle login form submission
    public function login(Request $request)
    {
        // Validate the form input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Attempt login
        if (Auth::attempt($validated)) {
            // Redirect to the intended page or dashboard
            return redirect()->intended('/home');  // Adjust to the route you want to go after login
        }

        // If login fails, redirect back with an error message
        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}
