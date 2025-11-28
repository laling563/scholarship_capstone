<?php

namespace App\Http\Controllers;

use App\Models\ApplicationForm;
use App\Models\Student;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_id')) {
            return redirect()->route('Login.LoginPage')->with('error', 'Please log in first.');
        }

        // Fetch all counts and data
        $totalApplication = ApplicationForm::count();
        $totalPending = ApplicationForm::where('status', 'pending')->count();
        $totalAccept = ApplicationForm::where('status', 'approved')->count();
        $totalStudent = Student::count();
        $totalActiveScholarships = Scholarship::where('is_open', true)->count();

        // Fetch the list of active scholarships with their application counts
        $activeScholarships = Scholarship::where('is_open', true)
            ->withCount('applicationForms') // This creates `application_forms_count` attribute
            ->latest()
            ->take(5) // Get the top 5 for the dashboard
            ->get();

        // Return view with all data
        return view('Admin.dashboard', [
            'TotalApplication' => $totalApplication,
            'TotalPending' => $totalPending,
            'TotalAccept' => $totalAccept,
            'TotalStudent' => $totalStudent,
            'TotalActiveScholarships' => $totalActiveScholarships,
            'activeScholarshipsList' => $activeScholarships // Pass the new list
        ]);
    }

    public function analytics()
    {
        // Application Volume by Scholarship Type
        $applicationVolumeByType = Scholarship::select('title', DB::raw('count(*) as count'))
            ->groupBy('title')
            ->get();

        // Application Volume by Course
        $applicationVolumeByCourse = Student::join('application_forms', 'students.id', '=', 'application_forms.student_id')
            ->select('students.course', DB::raw('count(*) as count'))
            ->groupBy('students.course')
            ->get();

        // Application Volume by Year Level
        $applicationVolumeByYear = Student::join('application_forms', 'students.id', '=', 'application_forms.student_id')
            ->select('students.year_level', DB::raw('count(*) as count'))
            ->groupBy('students.year_level')
            ->get();

        // Application Status Rates
        $applicationStatusRates = ApplicationForm::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Allowance Distribution
        $allowanceDistribution = Scholarship::select('grant_amount', DB::raw('count(*) as count'))
            ->groupBy('grant_amount')
            ->get();

        return view('Admin.analytics', compact(
            'applicationVolumeByType',
            'applicationVolumeByCourse',
            'applicationVolumeByYear',
            'applicationStatusRates',
            'allowanceDistribution'
        ));
    }
}
