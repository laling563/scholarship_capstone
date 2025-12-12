<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\DropList;
use Illuminate\Http\Request;

class AdminApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::where('status', 'Pending')->get();
        return view('Admin.applications', compact('applications'));
    }

    public function view($id)
    {
        $application = Application::with(['student', 'scholarship', 'documents'])->findOrFail($id);
        return view('Admin.applicationview', compact('application'));
    }

    public function accept(Application $application)
    {
        $application->update(['status' => 'Endorsed']);
        return redirect()->route('admin.applications')->with('success', 'Application accepted and forwarded to sponsor.');
    }

    public function reject(Request $request, Application $application)
    {
        $request->validate([
            'reason' => 'required|string',
        ]);

        $application->update(['status' => 'Rejected']);

        DropList::create([
            'student_id' => $application->student_id,
            'application_id' => $application->id,
            'reason' => $request->reason,
        ]);

        return redirect()->route('admin.applications')->with('success', 'Application rejected.');
    }
}
