@extends('Admin.AdminLayout')

@section('content')
<div class="container">
    <h1>Application Details</h1>
    <div class="card">
        <div class="card-header">
            Application #{{ $application->id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $application->scholarship->name }}</h5>
            <p class="card-text"><strong>Student:</strong> {{ $application->student->first_name }} {{ $application->student->last_name }}</p>
            <p class="card-text"><strong>Status:</strong> {{ $application->status }}</p>
            <p class="card-text"><strong>Applied At:</strong> {{ $application->created_at }}</p>

            <hr>

            <h5>Application Documents</h5>
            @if ($application->documents->count() > 0)
            <ul>
                @foreach ($application->documents as $document)
                <li><a href="{{ asset('storage/' . $document->file_path) }}" target="_blank">{{ $document->document_name }}</a></li>
                @endforeach
            </ul>
            @else
            <p>No documents submitted.</p>
            @endif
        </div>
    </div>
</div>
@endsection
