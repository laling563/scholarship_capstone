<?php

// StudentDashboardController.php

namespace App\Http\Controllers;

use App\Models\ApplicationForm;
use Illuminate\Http\Request;
use App\Models\Scholarship;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }

        // Get all applications for the student, with scholarship info
        $applications = ApplicationForm::where('student_id', $studentId)
            ->with('scholarship') // Eager load scholarship data
            ->get();

        // Calculate the counts
        $totalApplications = $applications->count();
        $approvedApplications = $applications->where('status', 'approved')->count();
        $pendingApplications = $applications->where('status', 'pending')->count();

        // Pass all data to the view explicitly
        return view('Student.dashboard', [
            'applications' => $applications,
            'totalApplications' => $totalApplications,
            'approvedApplications' => $approvedApplications,
            'pendingApplications' => $pendingApplications,
        ]);
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
public function myApplications()
{
    // Get logged-in student ID
    $studentId = session('student_id');

    if (!$studentId) {
        return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
    }

    // Fetch only this student's applications
    $applications = ApplicationForm::where('student_id', $studentId)
        ->with(['scholarship', 'documents'])
        ->get();

    // Return view with data
    return view('Student.my-applications', compact('applications'));
}


}
