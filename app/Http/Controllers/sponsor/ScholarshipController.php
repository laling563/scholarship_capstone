<?php

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipController extends Controller
{
    public function index()
    {
        $sponsor = Auth::guard('sponsor')->user();
        $scholarships = $sponsor->scholarships()->withCount('applicationForms')->get();

        return view('Sponsor.scholarships.index', compact('scholarships'));
    }

    public function create()
    {
        return view('Sponsor.scholarships.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'grant_amount' => 'required|numeric',
            'requirements' => 'nullable|array',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric',
            'student_limit' => 'nullable|integer',
        ]);

        $sponsor = Auth::guard('sponsor')->user();

        $scholarshipData = $request->all();
        $scholarshipData['type'] = 'Sponsored'; // Set default type

        $sponsor->scholarships()->create($scholarshipData);

        return redirect()->route('sponsor.scholarships.index')->with('success', 'Scholarship created successfully.');
    }

    public function show(Scholarship $scholarship)
    {
        // Ensure the authenticated sponsor owns the scholarship
        if ($scholarship->sponsor_id !== Auth::guard('sponsor')->id()) {
            abort(403);
        }

        return view('Sponsor.scholarships.show', compact('scholarship'));
    }

    public function edit(Scholarship $scholarship)
    {
        // Ensure the authenticated sponsor owns the scholarship
        if ($scholarship->sponsor_id !== auth()->guard('sponsor')->id()) {
            abort(403);
        }

        return view('Scholarship.EditScholarship', compact('scholarship'));
    }

    public function update(Request $request, Scholarship $scholarship)
    {
        // Ensure the authenticated sponsor owns the scholarship
        if ($scholarship->sponsor_id !== auth()->guard('sponsor')->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'grant_amount' => 'required|numeric',
            'requirements' => 'nullable|array',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric',
            'student_limit' => 'nullable|integer',
        ]);

        $scholarship->update($request->all());

        return redirect()->route('sponsor.scholarships.index')->with('success', 'Scholarship updated successfully.');
    }
}
