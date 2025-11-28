<?php

namespace App\Http\Controllers;

use App\Models\ApplicationDocument;
use App\Models\ApplicationForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicationDocumentController extends Controller
{
    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request, ApplicationForm $applicationForm)
    {
        $request->validate([
            'document_type' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            'notes' => 'nullable|string',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $request->document_type . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('application_documents', $fileName, 'public');

        ApplicationDocument::create([
            'applicationform_id' => $applicationForm->applicationform_id,
            'document_type' => $request->document_type,
            'file_name' => $fileName,
            'file_path' => 'storage/'.$filePath,
            'notes' => $request->notes,
        ]);

        return redirect()->route('application-forms.show', $applicationForm)
            ->with('success', 'Document uploaded successfully!');
    }

    /**
     * Display the specified document.
     */
    public function show(ApplicationDocument $document)
    {
        return response()->file(storage_path('app/public/' . $document->file_path));
    }

    /**
     * Download the specified document.
     */
    public function download(ApplicationDocument $document)
    {
        return response()->download(storage_path('app/public/' . $document->file_path), $document->file_name);
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(ApplicationDocument $document)
    {
        $applicationFormId = $document->applicationform_id;

        // Delete file from storage
        Storage::disk('public')->delete($document->file_path);

        // Delete record from database
        $document->delete();

        return redirect()->route('application-forms.show', $applicationFormId)
            ->with('success', 'Document deleted successfully!');
    }
}
