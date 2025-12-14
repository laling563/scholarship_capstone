<?php

namespace App\Http\Controllers;

use App\Models\ApplicationForm;
use App\Models\Student;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!session('admin_id')) {
            return redirect()->route('Login.LoginPage')->with('error', 'Please log in first.');
        }

        $period = $request->input('period', 'all');
        $now = Carbon::now();
        $currentYear = $now->year;
        $dateRange = null;

        if ($period == 'last_year') {
            $lastYear = $currentYear - 1;
            $dateRange = [Carbon::create($lastYear, 1, 1), Carbon::create($lastYear, 12, 31)->endOfDay()];
        } elseif ($period == 'first_semester') {
            $year = ($now->month < 8) ? $currentYear - 1 : $currentYear;
            $dateRange = [Carbon::create($year, 8, 1), Carbon::create($year, 12, 31)->endOfDay()];
        } elseif ($period == 'second_semester') {
            $year = ($now->month > 5) ? $currentYear : $currentYear;
            $dateRange = [Carbon::create($year, 1, 1), Carbon::create($year, 5, 31)->endOfDay()];
        }

        $applicationQuery = ApplicationForm::query();

        if ($dateRange) {
            $applicationQuery->whereBetween('created_at', $dateRange);
        }

        // Fetch all counts and data
        $totalApplication = (clone $applicationQuery)->count();
        $totalPending = (clone $applicationQuery)->where('status', 'pending')->count();
        $totalAccept = (clone $applicationQuery)->where('status', 'approved')->count();
        $totalStudent = Student::count();
        $totalActiveScholarships = Scholarship::where('is_open', true)->count();

        // Fetch the list of active scholarships with their application counts
        $activeScholarships = Scholarship::where('is_open', true)
            ->withCount(['applicationForms' => function ($query) use ($dateRange) {
                if ($dateRange) {
                    $query->whereBetween('created_at', $dateRange);
                }
            }])
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

    public function analytics(Request $request)
    {
        $period = $request->input('period', 'all');
        $now = Carbon::now();
        $currentYear = $now->year;
        $dateRange = null;

        if ($period == 'last_year') {
            $lastYear = $currentYear - 1;
            $dateRange = [Carbon::create($lastYear, 1, 1), Carbon::create($lastYear, 12, 31)->endOfDay()];
        } elseif ($period == 'first_semester') {
            $year = ($now->month < 8) ? $currentYear - 1 : $currentYear;
            $dateRange = [Carbon::create($year, 8, 1), Carbon::create($year, 12, 31)->endOfDay()];
        } elseif ($period == 'second_semester') {
            $year = ($now->month > 5) ? $currentYear : $currentYear;
            $dateRange = [Carbon::create($year, 1, 1), Carbon::create($year, 5, 31)->endOfDay()];
        }

        // Application Volume by Scholarship Type
        $applicationVolumeByType = Scholarship::withCount(['applicationForms' => function ($query) use ($dateRange) {
                if ($dateRange) {
                    $query->whereBetween('created_at', $dateRange);
                }
            }])
            ->get()
            ->map(function ($scholarship) {
                return (object)[
                    'title' => $scholarship->title,
                    'count' => $scholarship->application_forms_count,
                ];
            });

        // Application Volume by Course
        $applicationVolumeByCourseQuery = Student::join('application_forms', 'students.id', '=', 'application_forms.student_id')
            ->select('students.course', DB::raw('count(*) as count'));
        if ($dateRange) {
            $applicationVolumeByCourseQuery->whereBetween('application_forms.created_at', $dateRange);
        }
        $applicationVolumeByCourse = $applicationVolumeByCourseQuery->groupBy('students.course')->get();

        // Application Volume by Year Level
        $applicationVolumeByYearQuery = Student::join('application_forms', 'students.id', '=', 'application_forms.student_id')
            ->select('students.year_level', DB::raw('count(*) as count'));
        if ($dateRange) {
            $applicationVolumeByYearQuery->whereBetween('application_forms.created_at', $dateRange);
        }
        $applicationVolumeByYear = $applicationVolumeByYearQuery->groupBy('students.year_level')->get();

        // Application Status Rates
        $applicationStatusRatesQuery = ApplicationForm::select('status', DB::raw('count(*) as count'));
        if ($dateRange) {
            $applicationStatusRatesQuery->whereBetween('created_at', $dateRange);
        }
        $applicationStatusRates = $applicationStatusRatesQuery->groupBy('status')->get();

        // Allowance Distribution - Counts accepted students per grant amount
        $allowanceDistributionQuery = ApplicationForm::join('scholarships', 'application_forms.scholarship_id', '=', 'scholarships.scholarship_id')
            ->where('application_forms.status', 'approved')
            ->select('scholarships.grant_amount', DB::raw('count(*) as count'))
            ->groupBy('scholarships.grant_amount');

        if ($dateRange) {
            $allowanceDistributionQuery->whereBetween('application_forms.created_at', $dateRange);
        }

        $allowanceDistribution = $allowanceDistributionQuery->get();

        return view('Admin.analytics', compact(
            'applicationVolumeByType',
            'applicationVolumeByCourse',
            'applicationVolumeByYear',
            'applicationStatusRates',
            'allowanceDistribution'
        ));
    }
}
