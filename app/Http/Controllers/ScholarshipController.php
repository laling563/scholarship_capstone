<?php
namespace App\Http\Controllers;
use App\Models\Scholarship;
use App\Models\ApplicationForm;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScholarshipController extends Controller
{
    public function availableScholarships()
    {
        $scholarships = Scholarship::where('status', 'open')->get();
        return view('Student.dashboard', compact('scholarships'));
    }

    public function index()
    {
        $sponsor = Auth::guard('sponsor')->user();
        $scholarships = $sponsor->scholarships()->latest()->paginate(10);
        return view('Sponsor.scholarships', compact('scholarships'));
    }

    public function create()
    {
        return view('Scholarship.CreateScholarship');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string',
            'status' => 'required|string|in:open,closed,on-hold',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'student_limit' => 'nullable|integer',
            'budget' => 'nullable|numeric|min:0',
        ]);

        if (isset($validated['requirements'])) {
            $validated['requirements'] = array_filter($validated['requirements']);
        }

        $sponsor = Auth::guard('sponsor')->user();
        $sponsor->scholarships()->create($validated);

        return redirect()->route('sponsor.scholarships.index')->with('success', 'Scholarship created successfully.');
    }

    public function edit($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        return view('Sponsor.EditScholarship', compact('scholarship'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string',
            'status' => 'required|string|in:open,closed,on-hold',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'student_limit' => 'nullable|integer',
            'budget' => 'nullable|numeric|min:0',
        ]);

        if (isset($validated['requirements'])) {
            $validated['requirements'] = array_filter($validated['requirements']);
        } else {
            $validated['requirements'] = [];
        }

        $scholarship = Scholarship::findOrFail($id);
        $scholarship->update($validated);

        return redirect()->route('sponsor.scholarships.index')->with('success', 'Scholarship updated successfully.');
    }

    public function destroy($id)
    {
        $scholarship = Scholarship::findOrFail($id);
        $scholarship->delete();

        return redirect()->route('sponsor.scholarships.index')->with('success', 'Scholarship deleted successfully.');
    }

    public function acceptStudent(Request $request, Scholarship $scholarship)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'application_id' => 'required|exists:application_forms,id',
        ]);

        $application = ApplicationForm::findOrFail($request->application_id);

        if ($application->scholarship_id !== $scholarship->scholarship_id || $application->status !== 'pending') {
            return back()->with('error', 'This application cannot be accepted.');
        }

        if ($scholarship->status !== 'open') {
            return back()->with('error', 'This scholarship is not open for new acceptances.');
        }

        if ($scholarship->budget < $request->amount) {
            return back()->with('error', 'The award amount exceeds the remaining budget.');
        }

        DB::transaction(function () use ($scholarship, $application, $request) {
            $application->update(['status' => 'accepted']);

            $scholarship->decrement('budget', $request->amount);

            $acceptedCount = $scholarship->applicationForms()->where('status', 'accepted')->count();

            $shouldClose = false;
            if ($scholarship->budget <= 0) {
                $scholarship->budget = 0;
                $shouldClose = true;
            }

            if ($scholarship->student_limit && $acceptedCount >= $scholarship->student_limit) {
                $shouldClose = true;
            }

            if ($shouldClose) {
                $scholarship->status = 'closed';
            }

            $scholarship->save();
        });

        $message = 'Student application accepted successfully.';
        if ($scholarship->fresh()->status === 'closed') {
            $message .= ' The scholarship is now closed.';
        }

        return redirect()->route('sponsor.applications')->with('success', $message);
    }
}
