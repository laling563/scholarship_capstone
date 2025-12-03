<?php

namespace App\Http\Controllers;

use App\Models\ApplicationForm;
use App\Models\ApplicationDocument;
use App\Models\Scholarship;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ApplicationFormController extends Controller
{
    public function apply(Scholarship $scholarship)
    {
        // Get student info from session
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()->route('login')->with('error', 'Please log in to apply for the scholarship.');
        }

        $student = Student::find($studentId);

        return view('Scholarship.scholarship_apply', compact('scholarship', 'student'));
    }



    public function submitApplication(Request $request, Scholarship $scholarship)
    {
        $studentId = session('student_id');

        if (!$studentId) {
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }

        // Check for existing application
        $existing = ApplicationForm::where('scholarship_id', $scholarship->scholarship_id)
            ->where('student_id', $studentId)
            ->first();

        if ($existing) {
            return redirect('/student/dashboard')
                ->with('error', 'You have already applied for this scholarship.');
        }

        // Validate all input
        $validated = $request->validate([
            'date_of_birth' => 'required|date',
            'civil_status' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'religion' => 'nullable|string|max:255',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'home_address' => 'required|string',
            'contact_address' => 'nullable|string',
            'boarding_address' => 'nullable|string',
            'landlord_landlady' => 'nullable|string|max:255',
            'high_school_graduated' => 'required|string|max:255',
            'high_school_year_graduated' => 'required|digits:4|integer',
            'special_skills' => 'nullable|string',
            'curriculum_year' => 'nullable|string|max:255',
            'father_first_name' => 'required|string|max:255',
            'father_middle_name' => 'nullable|string|max:255',
            'father_last_name' => 'required|string|max:255',
            'father_occupation' => 'nullable|string|max:255',
            'father_monthly_income' => 'nullable|numeric|min:0',
            'father_educational_attainment' => 'nullable|string|max:255',
            'father_school_graduated' => 'nullable|string|max:255',
            'father_year_graduated' => 'nullable|digits:4|integer',
            'mother_first_name' => 'required|string|max:255',
            'mother_middle_name' => 'nullable|string|max:255',
            'mother_last_name' => 'required|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'mother_monthly_income' => 'nullable|numeric|min:0',
            'mother_educational_attainment' => 'nullable|string|max:255',
            'mother_school_graduated' => 'nullable|string|max:255',
            'mother_year_graduated' => 'nullable|digits:4|integer',
            'number_of_brothers' => 'required|integer|min:0',
            'number_of_sisters' => 'required|integer|min:0',
            'total_monthly_income' => 'nullable|numeric|min:0',
            'submission_date' => 'required|date',
            'notes' => 'nullable|string',
            'documents' => 'nullable|array',
            'documents.*.document_type' => 'required|string',
            'documents.*.file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        // Add scholarship and student IDs
        $validated['student_id'] = $studentId;
        $validated['scholarship_id'] = $scholarship->scholarship_id;

        // Create the application
        $application = ApplicationForm::create($validated);

        // Save uploaded documents
        if ($request->has('documents')) {
            foreach ($request->documents as $index => $doc) {
                if (isset($doc['file']) && isset($doc['document_type'])) {
                    $file = $doc['file'];
                    $filename = time() . '_' . $index . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('application_documents', $filename, 'public');

                    ApplicationDocument::create([
                        'applicationform_id' => $application->applicationform_id,
                        'document_type' => $doc['document_type'],
                        'file_name' => $filename,
                        'file_path' => $filePath,
                        'notes' => $validated['notes'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('student.dashboard')
            ->with('success', 'Application submitted successfully.');
    }




    public function index()
    {
        $applications = ApplicationForm::with('student', 'scholarship')->latest()->paginate(10);
        return view('ApplicationForm.application_index', compact('applications'));
    }

    public function create()
    {
        $scholarships = Scholarship::all();
        $students = Student::all();
        return view('ApplicationForm.application_create', compact('scholarships', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'scholarship_id' => 'required|exists:scholarships,scholarship_id',
            'student_id' => 'required|exists:students,id',
            'date_of_birth' => 'required|date',
            'civil_status' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'religion' => 'nullable|string|max:255',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'home_address' => 'required|string',
            'contact_address' => 'nullable|string',
            'boarding_address' => 'nullable|string',
            'landlord_landlady' => 'nullable|string|max:255',
            'high_school_graduated' => 'required|string|max:255',
            'high_school_year_graduated' => 'required|digits:4|integer',
            'special_skills' => 'nullable|string',
            'curriculum_year' => 'nullable|string|max:255',
            'father_first_name' => 'required|string|max:255',
            'father_middle_name' => 'nullable|string|max:255',
            'father_last_name' => 'required|string|max:255',
            'father_occupation' => 'nullable|string|max:255',
            'father_monthly_income' => 'nullable|numeric|min:0',
            'father_educational_attainment' => 'nullable|string|max:255',
            'father_school_graduated' => 'nullable|string|max:255',
            'father_year_graduated' => 'nullable|digits:4|integer',
            'mother_first_name' => 'required|string|max:255',
            'mother_middle_name' => 'nullable|string|max:255',
            'mother_last_name' => 'required|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'mother_monthly_income' => 'nullable|numeric|min:0',
            'mother_educational_attainment' => 'nullable|string|max:255',
            'mother_school_graduated' => 'nullable|string|max:255',
            'mother_year_graduated' => 'nullable|digits:4|integer',
            'number_of_brothers' => 'required|integer|min:0',
            'number_of_sisters' => 'required|integer|min:0',
            'total_monthly_income' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:pending,approved,rejected',
            'submission_date' => 'required|date',
            'notes' => 'nullable|string',
            'documents' => 'nullable|array',
            'documents.*.document_type' => 'required|string',
            'documents.*.file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        // Create application form
        $applicationForm = ApplicationForm::create($request->except('documents'));

        // Handle document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $file) {
                $documentType = $request->input("documents.$index.document_type");
                $fileName = time() . '_' . $documentType . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('application_documents', $fileName, 'public');

                ApplicationDocument::create([
                    'applicationform_id' => $applicationForm->applicationform_id,
                    'document_type' => $documentType,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'notes' => $request->input("documents.$index.notes") ?? null,
                ]);
            }
        }

        return redirect()->route('student.dashboard')->with('success', 'Application submitted successfully!');
    }

    public function show(Request $request, $id)
    {
        $applicationForm = ApplicationForm::with('documents')->findOrFail($id);
        return view('ApplicationForm.application_show', compact('applicationForm'));
    }

    public function edit(Request $request, $id)
{
    $applicationForm = ApplicationForm::with('documents')->findOrFail($id);
    $scholarships = Scholarship::all();
    $students = Student::all();
    return view('ApplicationForm.application_edit', compact('applicationForm', 'scholarships', 'students'));
}

public function update(Request $request, $id)
{
    $applicationForm = ApplicationForm::findOrFail($id);

    $request->validate([
        'scholarship_id' => 'required|exists:scholarships,scholarship_id',
        'student_id' => 'required|exists:students,id',
        'date_of_birth' => 'required|date',
        'civil_status' => 'required|string|max:255',
        'place_of_birth' => 'required|string|max:255',
        'religion' => 'nullable|string|max:255',
        'height' => 'nullable|numeric|min:0',
        'weight' => 'nullable|numeric|min:0',
        'home_address' => 'required|string',
        'contact_address' => 'nullable|string',
        'boarding_address' => 'nullable|string',
        'landlord_landlady' => 'nullable|string|max:255',
        'high_school_graduated' => 'required|string|max:255',
        'high_school_year_graduated' => 'required|digits:4|integer',
        'special_skills' => 'nullable|string',
        'curriculum_year' => 'nullable|string|max:255',
        'father_first_name' => 'required|string|max:255',
        'father_middle_name' => 'nullable|string|max:255',
        'father_last_name' => 'required|string|max:255',
        'father_occupation' => 'nullable|string|max:255',
        'father_monthly_income' => 'nullable|numeric|min:0',
        'father_educational_attainment' => 'nullable|string|max:255',
        'father_school_graduated' => 'nullable|string|max:255',
        'father_year_graduated' => 'nullable|digits:4|integer',
        'mother_first_name' => 'required|string|max:255',
        'mother_middle_name' => 'nullable|string|max:255',
        'mother_last_name' => 'required|string|max:255',
        'mother_occupation' => 'nullable|string|max:255',
        'mother_monthly_income' => 'nullable|numeric|min:0',
        'mother_educational_attainment' => 'nullable|string|max:255',
        'mother_school_graduated' => 'nullable|string|max:255',
        'mother_year_graduated' => 'nullable|digits:4|integer',
        'number_of_brothers' => 'required|integer|min:0',
        'number_of_sisters' => 'required|integer|min:0',
        'total_monthly_income' => 'nullable|numeric|min:0',
        'status' => 'required|string|in:pending,approved,rejected',
        'submission_date' => 'required|date',
        'notes' => 'nullable|string',
        'new_documents' => 'nullable|array',
        'new_documents.*.document_type' => 'required|string',
        'new_documents.*.file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
    ]);

    $applicationForm->update($request->except(['documents', 'new_documents']));

    if ($request->hasFile('new_documents')) {
        foreach ($request->file('new_documents') as $index => $file) {
            $documentType = $request->input("new_documents.$index.document_type");
            $fileName = time() . '_' . $documentType . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('application_documents', $fileName, 'public');

            ApplicationDocument::create([
                'applicationform_id' => $applicationForm->applicationform_id,
                'document_type' => $documentType,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'notes' => $request->input("new_documents.$index.notes") ?? null,
            ]);
        }
    }

    return redirect()->route('application-forms.index')->with('success', 'Application updated successfully!');
}


public function destroy(Request $request, $id)
{
    $applicationForm = ApplicationForm::with('documents')->findOrFail($id);

    foreach ($applicationForm->documents as $document) {
        Storage::disk('public')->delete($document->file_path);
    }

    $applicationForm->delete();

    return redirect()->route('application-forms.index')->with('success', 'Application deleted successfully!');
}
}
