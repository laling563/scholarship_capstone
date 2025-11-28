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
        } else
            $TotalApplication = ApplicationForm::count();
        $TotalPending = ApplicationForm::where('status', 'pending')->count();
        $TotalAccept = ApplicationForm::where('status', 'approved')->count();
        $TotalStudent = Student::count();
        return view('Admin.dashboard')
            ->with('TotalApplication', $TotalApplication)
            ->with('TotalPending', $TotalPending)
            ->with('TotalAccept', $TotalAccept)
            ->with('TotalStudent', $TotalStudent);
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
