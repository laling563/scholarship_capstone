<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Scholarship;
use App\Models\Admin;  // Add the Admin model
use App\Models\Sponsor;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function LoginPage()
    {
        return view('Login.LoginPage');
    }

    public function RegistrationPage()
    {
        return view('Login.RegistrationPage');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login_input = $request->input('login');

        // Only check for student login
        $student = null;

        if (filter_var($login_input, FILTER_VALIDATE_EMAIL)) {
            // If it's an email, look for a student
            $student = Student::where('email', $login_input)->first();
        } else {
            // If it's not an email, assume it's a student_id
            $student = Student::where('student_id', $login_input)->first();
        }

        // Check if student login is valid
        if ($student && Hash::check($request->password, $student->password)) {
            // Manually login the student
            $scholarships = Scholarship::where('is_open', true)->get();

            session([
                'student_id' => $student->id,
                'student_fname' => $student->fname,
                'student_lname' => $student->lname,
                'student_email' => $student->email,
                'student_course' => $student->course,
                'student_yearlevel' => $student->year_level,
                // Add more attributes as needed
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Student login successful!')
                ->with('scholarships', $scholarships);
        }

        // If no match is found
        return back()->with('error', 'Invalid student credentials. Please try again.');
    }


    public function logout(Request $request)
    {
        $request->session()->forget(['student_id', 'admin_id']);  // Clear both student and admin session data
        Auth::guard('web')->logout();
        Auth::guard('student')->logout();
        Auth::guard('sponsor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('LoginPage')->with('success', 'Logged out successfully.');
    }

    public function showSponsorLoginForm()
    {
        return view('Login.SponsorLoginPage');
    }

    public function sponsorLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('sponsor')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('sponsor.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showAdminLoginForm()
    {
        return view('Login.AdminLoginPage');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('faculty_id', $request->faculty_id)->first();

        // Validate admin credentials
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Store session
            session([
                'admin_id' => $admin->id,
                'admin_fname' => $admin->fname,
                'admin_lname' => $admin->lname,
                'admin_email' => $admin->email,
                'admin_role' => $admin->role,
            ]);

            return redirect()->route('admin_dashboard')
                ->with('success', 'Admin login successful!');
        }

        return back()->with('error', 'Invalid Faculty ID or password. Please try again.');
    }

}
