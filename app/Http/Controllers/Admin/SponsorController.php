<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sponsors = Sponsor::with('scholarships')->latest()->paginate(10);
        return view('Admin.sponsors.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.sponsors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sponsor_name' => 'required|string|max:255',
            'type' => ['required', Rule::in(['sport', 'financial_aid'])],
            'email' => 'required|string|email|max:255|unique:sponsors',
            'contact_number' => 'nullable|string|max:20',
            'username' => 'required|string|max:255|unique:sponsors',
            'password' => 'required|string|min:8',
            'notes' => 'nullable|string',
        ]);

        Sponsor::create([
            'sponsor_name' => $validated['sponsor_name'],
            'type' => $validated['type'],
            'email' => $validated['email'],
            'contact_number' => $validated['contact_number'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sponsor $sponsor)
    {
        return view('Admin.sponsors.show', compact('sponsor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sponsor $sponsor)
    {
        return view('Admin.sponsors.edit', compact('sponsor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        $validated = $request->validate([
            'sponsor_name' => 'required|string|max:255',
            'type' => ['required', Rule::in(['sport', 'financial_aid'])],
            'email' => 'required|string|email|max:255|unique:sponsors,email,' . $sponsor->id,
            'contact_number' => 'nullable|string|max:20',
            'username' => 'required|string|max:255|unique:sponsors,username,' . $sponsor->id,
            'password' => 'nullable|string|min:8',
            'notes' => 'nullable|string',
        ]);

        $updateData = [
            'sponsor_name' => $validated['sponsor_name'],
            'type' => $validated['type'],
            'email' => $validated['email'],
            'contact_number' => $validated['contact_number'],
            'username' => $validated['username'],
            'notes' => $validated['notes'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $sponsor->update($updateData);

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();
        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor deleted successfully.');
    }
}
