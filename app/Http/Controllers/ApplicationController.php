<?php
namespace App\Http\Controllers;

use App\Models\ApplicationForm;
use App\Models\Scholarship; // Import the Scholarship model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function index()
    {
        if (Auth::guard('sponsor')->check()) {
            $sponsor = Auth::guard('sponsor')->user();
            $scholarshipIds = $sponsor->scholarships()->pluck('scholarship_id');

            $applications = ApplicationForm::with(['student', 'scholarship', 'documents'])
                ->whereIn('scholarship_id', $scholarshipIds)
                ->where('status', 'Endorsed')
                ->get();

            return view('Sponsor.applications', compact('applications'));
        }

        // For admin
        $applications = ApplicationForm::with(['student', 'scholarship'])
            ->where('status', 'pending')
            ->get();

        return view('Admin.ValidateApplication', compact('applications'));
    }

    public function view($id)
    {
        $application = ApplicationForm::with('student', 'documents')->findOrFail($id);

        if (Auth::guard('sponsor')->check()) {
            $this->authorizeSponsorAction($application);
            return view('Sponsor.applicationview', compact('application'));
        }

        return view('admin.applicationview', compact('application'));
    }

    public function accept($id)
    {
        $application = ApplicationForm::findOrFail($id);
        $this->authorizeSponsorAction($application);

        $scholarship = $application->scholarship;

        // Check if the scholarship has a budget and grant amount
        if ($scholarship->budget !== null && $scholarship->grant_amount !== null) {
            // Ensure there is enough budget
            if ($scholarship->budget >= $scholarship->grant_amount) {
                $scholarship->budget -= $scholarship->grant_amount;

                // If the budget is depleted, close the scholarship
                if ($scholarship->budget <= 0) {
                    $scholarship->status = 'closed';
                }

                $scholarship->save();

                $application->status = 'approved';
                $application->save();

                return redirect()->back()->with('success', 'Application accepted and budget updated.');
            } else {
                return redirect()->back()->with('error', 'Not enough budget to accept this application.');
            }
        } else {
            // If no budget or grant amount is set, just accept the application
            $application->status = 'approved';
            $application->save();

            return redirect()->back()->with('success', 'Application accepted.');
        }
    }

    public function reject($id)
    {
        $application = ApplicationForm::findOrFail($id);
        $this->authorizeSponsorAction($application);
        $application->status = 'rejected';
        $application->save();

        return redirect()->back()->with('success', 'Application rejected.');
    }

    private function authorizeSponsorAction(ApplicationForm $application)
    {
        if (Auth::guard('sponsor')->check()) {
            $sponsor = Auth::guard('sponsor')->user();
            $scholarshipIds = $sponsor->scholarships()->pluck('scholarship_id')->toArray();

            if (!in_array($application->scholarship_id, $scholarshipIds)) {
                abort(403);
            }
        }
    }
}
