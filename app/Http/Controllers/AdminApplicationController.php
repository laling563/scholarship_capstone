<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationForm;
use Illuminate\Http\Request;

class AdminApplicationController extends Controller
{
    public function index()
    {
        $applications = ApplicationForm::where('status', 'Pending')->get();
        return view('Admin.applications', compact('applications'));
    }

    public function view($id)
    {
        $application = Application::with(['student', 'scholarship', 'documents'])->findOrFail($id);
        return view('Admin.applicationview', compact('application'));
    }

    public function accept(ApplicationForm $application)
    {
        $application->update(['status' => 'Endorsed']);
        return redirect()->route('admin.applications')->with('success', 'Application accepted and forwarded to sponsor.');
    }

    public function reject(ApplicationForm $application)
    {
        $application->update(['status' => 'Rejected']);
        return redirect()->route('admin.applications')->with('success', 'Application rejected.');
    }
}
