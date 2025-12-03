<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;

class FindScholarshipController extends Controller
{
    public function index()
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }

        $appliedScholarshipIds = \App\Models\ApplicationForm::where('student_id', $studentId)
            ->pluck('scholarship_id');

        $scholarships = Scholarship::where('status', 'open')->get();


        return view('Student.find-scholarship', [
            'appliedScholarshipIds' => $appliedScholarshipIds,
            'scholarships' => $scholarships
        ]);
    }
}
