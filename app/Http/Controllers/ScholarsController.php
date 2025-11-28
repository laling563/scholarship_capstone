<?php

namespace App\Http\Controllers;

use App\Models\ApplicationForm;
use Illuminate\Http\Request;

class ScholarsController extends Controller
{
    public function index()
    {
        // Get only approved applications
        $scholars = ApplicationForm::with('student', 'scholarship')
            ->where('status', 'approved')
            ->get();

        return view('Admin.Scholars', compact('scholars'));
    }
}
