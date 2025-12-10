<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Scholarship;
use App\Models\StudentMasterList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StudentController extends Controller
{
    public function dashboard()
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }

        // Get all applications for the student
        $applications = \App\Models\ApplicationForm::with('scholarship')
            ->where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate application stats
        $totalApplications = $applications->count();
        $approvedApplications = $applications->where('status', 'approved')->count();
        $pendingApplications = $applications->where('status', 'pending')->count();

        // Get new scholarships for announcements
        $newScholarships = Scholarship::where('is_open', true)
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Student.dashboard', compact(
            'applications',
            'newScholarships',
            'totalApplications',
            'approvedApplications',
            'pendingApplications'
        ));
    }

    public function showScholarship(Scholarship $scholarship)
    {
        return view('Student.show_scholarship', compact('scholarship'));
    }

    public function ListScholarship()
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }

        // Get IDs of scholarships the student already applied to
        $appliedScholarshipIds = \App\Models\ApplicationForm::where('student_id', $studentId)
            ->pluck('scholarship_id');

        // Get scholarships that are open AND not full
        $scholarships = \App\Models\Scholarship::where('is_open', true)
            ->get();

        return view('Student.ListScholarship', compact('scholarships', 'appliedScholarshipIds'));

    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Login.RegistrationPage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'student_id' => [
                'required',
                'string',
                'max:20',
                'unique:students',
                'regex:/^\d{2}-SC-\d{4}$/',
                Rule::exists('student_master_list')->where('status', 'available'),
            ],
            'sex' => 'required|in:Male,Female',
            'course' => 'required|in:BSIT,BSHM,BSBA,BSED,BEED',
            'year_level' => 'required|in:1ST YEAR,2ND YEAR,3RD YEAR,4TH YEAR',
            'email' => 'required|string|email|max:255|unique:students',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
            ],
        ], [
            'student_id.regex' => 'The Student ID must be in the format XX-SC-XXXX (e.g., 22-SC-0001).',
            'student_id.exists' => 'The provided Student ID is not in the master list or has already been used.' // Custom error message
        ]);

        // Create user
        $user = Student::create([
            'fname' => $validated['fname'],
            'mname' => $validated['mname'],
            'lname' => $validated['lname'],
            'student_id' => $validated['student_id'],
            'sex' => $validated['sex'],
            'course' => $validated['course'],
            'year_level' => $validated['year_level'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Update the status in the master list
        StudentMasterList::where('student_id', $validated['student_id'])->update(['status' => 'used']);


        // Redirect to login page with success message
        return redirect()->route('LoginPage')
            ->with('success', 'Account created successfully! Please login.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('Login.LoginPage');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
