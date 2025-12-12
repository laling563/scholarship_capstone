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

            <hr>

            <div class="d-flex justify-content-end">
                <form action="{{ route('admin.applications.accept', $application) }}" method="POST" class="me-2">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success">Accept</button>
                </form>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    Reject
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel">Reject Application</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.applications.reject', $application) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body">
              <div class="mb-3">
                  <label for="reason" class="form-label">Reason for Rejection</label>
                  <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Reject Application</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
