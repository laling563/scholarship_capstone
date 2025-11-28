<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
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
}
