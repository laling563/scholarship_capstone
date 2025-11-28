<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Scholarship;
use App\Models\ApplicationForm;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class SponsorDashboardController extends Controller
{
    public function index()
    {
        $sponsor = Auth::guard('sponsor')->user();

        // Eager load scholarships with a count of their applications
        $scholarships = $sponsor->scholarships()->withCount('applicationForms')->get();

        // Get all application IDs for the sponsor's scholarships
        $scholarshipIds = $sponsor->scholarships()->pluck('scholarship_id');

        // Get all applications for those scholarships
        $applications = ApplicationForm::whereIn('scholarship_id', $scholarshipIds)->get();

        return view('Sponsor.dashboard', compact('sponsor', 'scholarships', 'applications'));
    }

    public function analytics()
    {
        $sponsor = Auth::guard('sponsor')->user();
        $scholarshipIds = $sponsor->scholarships()->pluck('scholarship_id');

        // Application Volume by Scholarship
        $applicationVolume = Scholarship::whereIn('scholarship_id', $scholarshipIds)
            ->withCount('applicationForms')
            ->get();

        // Application Status
        $applicationStatus = ApplicationForm::whereIn('scholarship_id', $scholarshipIds)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Allowance Distribution
        $allowanceDistribution = Scholarship::whereIn('scholarship_id', $scholarshipIds)
            ->select('grant_amount', DB::raw('sum(grant_amount) as count'))
            ->groupBy('grant_amount')
            ->get();

        return view('Sponsor.analytics', compact(
            'applicationVolume',
            'applicationStatus',
            'allowanceDistribution'
        ));
    }
}
