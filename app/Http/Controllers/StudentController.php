<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function myScholarshipApplications()
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }

        // Get all applications for this student with scholarship details
        $applications = \App\Models\ApplicationForm::where('student_id', $studentId)
            ->with('scholarship')
            ->orderBy('created_at', 'desc')
            ->get();

        // Format the applications data for display
        $formattedApplications = $applications->map(function ($application) {
            // Determine status
            $statusClass = match ($application->status) {
                'approved' => 'bg-success',
                'pending' => 'bg-warning',
                'rejected' => 'bg-danger',
                'expired' => 'bg-secondary',
                default => 'bg-secondary'
            };

            // Format date
            $appliedDate = \Carbon\Carbon::parse($application->created_at)->format('F d, Y');

            // Check if expired
            $isExpired = $application->status === 'pending' &&
                \Carbon\Carbon::parse($application->scholarship->end_date)->isPast();

            if ($isExpired) {
                $application->status = 'expired';
                $statusClass = 'bg-secondary';
            }

            return [
                'id' => $application->id,
                'scholarship_id' => $application->scholarship->scholarship_code ?? ('SCH-' . date('Y') . '-' . str_pad($application->scholarship_id, 3, '0', STR_PAD_LEFT)),
                'scholarship_name' => $application->scholarship->title,
                'applied_date' => $appliedDate,
                'status' => $application->status,
                'status_class' => $statusClass,
                'scholarship_id_numeric' => $application->scholarship_id
            ];
        });

        // Debug to see if this method is being called
        // dd('Method called', $formattedApplications);

        // Make sure formattedApplications is never NULL
        if (!$formattedApplications) {
            $formattedApplications = collect([]);
        }

        return view('Student.dashboard', [
            'formattedApplications' => $formattedApplications
        ]);
    }
    public function dashboard()
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }

        $applications = \App\Models\ApplicationForm::with(['scholarship', 'student', 'documents'])
            ->where('student_id', $studentId)
            ->get();

        return view('Student.dashboard', compact('applications'));
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
    {
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'lname' => 'required|string|max:255',
            'student_id' => 'required|string|max:20|unique:students',
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


        // Redirect to login page with success message
        return redirect()->route('LoginPage', ['id' => 1])
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
