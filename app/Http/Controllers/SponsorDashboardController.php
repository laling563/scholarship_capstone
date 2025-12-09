<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Scholarship;
use App\Models\ApplicationForm;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SponsorDashboardController extends Controller
{
    public function index()
    {
        $sponsor = Auth::guard('sponsor')->user();
        $scholarships = $sponsor->scholarships()->withCount('applicationForms')->get();
        $scholarshipIds = $sponsor->scholarships()->pluck('scholarship_id');
        $applications = ApplicationForm::whereIn('scholarship_id', $scholarshipIds)->get();
        return view('Sponsor.dashboard', compact('sponsor', 'scholarships', 'applications'));
    }

    public function analytics(Request $request)
    {
        $sponsor = Auth::guard('sponsor')->user();
        $scholarshipIds = $sponsor->scholarships()->pluck('scholarship_id');
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

        // Application Volume by Scholarship
        $applicationVolume = Scholarship::whereIn('scholarship_id', $scholarshipIds)
            ->withCount(['applicationForms' => function ($query) use ($dateRange) {
                if ($dateRange) {
                    $query->whereBetween('created_at', $dateRange);
                }
            }])
            ->get();

        $applicationQuery = ApplicationForm::whereIn('scholarship_id', $scholarshipIds);

        if ($dateRange) {
            $applicationQuery->whereBetween('created_at', $dateRange);
        }

        // Application Status
        $applicationStatus = (clone $applicationQuery)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Allowance Distribution - not time-dependent
        $allowanceDistribution = Scholarship::whereIn('scholarship_id', $scholarshipIds)
            ->select('grant_amount', DB::raw('count(*) as count'))
            ->where('grant_amount', '>', 0)
            ->groupBy('grant_amount')
            ->get();

        return view('Sponsor.analytics', compact(
            'applicationVolume',
            'applicationStatus',
            'allowanceDistribution'
        ));
    }
}
