<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\ApplicationForm;
use Illuminate\Http\Request;

class AdminApplicationController extends Controller
{
    public function index()
    {
        $applications = ApplicationForm::all();
        return view('Admin.applications', compact('applications'));
    }

    public function view($id)
    {
        $application = Application::with(['student', 'scholarship', 'documents'])->findOrFail($id);
        return view('Admin.applicationview', compact('application'));
    }
}
