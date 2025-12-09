<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;
use App\Models\ApplicationForm;

class FindScholarshipController extends Controller
{
    public function index()
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }

        $appliedScholarshipIds = ApplicationForm::where('student_id', $studentId)
            ->pluck('scholarship_id');

        $hasApprovedScholarship = ApplicationForm::where('student_id', $studentId)
            ->where('status', 'approved')
            ->exists();

        $scholarships = Scholarship::where('status', 'open')->get();

        return view('Student.find-scholarship', [
            'appliedScholarshipIds' => $appliedScholarshipIds,
            'scholarships' => $scholarships,
            'hasApprovedScholarship' => $hasApprovedScholarship
        ]);
    }
}
