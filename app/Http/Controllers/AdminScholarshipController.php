<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class AdminScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scholarships = Scholarship::latest()->paginate(10);
        return view('Admin.scholarships.index', compact('scholarships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // You can implement this later if needed
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // You can implement this later if needed
        return abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Scholarship $scholarship)
    {
        // You can implement this later if needed
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Scholarship $scholarship)
    {
        // You can implement this later if needed
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Scholarship $scholarship)
    {
        // You can implement this later if needed
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Scholarship $scholarship)
    {
        // You can implement this later if needed
        return abort(404);
    }

    public function createSport()
    {
        $sponsors = Sponsor::all();
        return view('Scholarship.sports_scholarship_form', compact('sponsors'));
    }

    public function storeSport(Request $request)
    {
        $validatedData = $request->validate([
            'sponsor_id' => 'required|exists:sponsors,id',
            'student_id' => 'required',
            'full_name' => 'required',
            'course_year' => 'required',
            'date_of_birth' => 'required|date',
            'email' => 'required|email',
            'contact_number' => 'required',
            'sport_category' => 'required',
            'playing_position' => 'nullable',
            'years_of_experience' => 'required|integer',
            'team_membership' => 'nullable',
            'training_schedule' => 'nullable',
            'achievements' => 'required',
            'level_of_competition' => 'nullable',
            'awards_received' => 'nullable',
        ]);

        $scholarship = new Scholarship();
        $scholarship->type = 'sport';
        $scholarship->fill($validatedData);
        $scholarship->save();

        return redirect()->route('admin.scholarships.index')->with('success', 'Sports scholarship created successfully.');
    }
}
