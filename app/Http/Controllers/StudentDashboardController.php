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

        // 👇 Get list of already applied scholarship IDs
        $appliedScholarshipIds = \App\Models\ApplicationForm::where('student_id', $studentId)
            ->pluck('scholarship_id');

        // 👇 Pass both to the view
        return view('Student.dashboard', [
            'appliedScholarshipIds' => $appliedScholarshipIds
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
