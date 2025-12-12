@extends('Admin.AdminLayout')

@section('content')
<div class="container">
    <h1>Dropped Applications</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Scholarship</th>
                <th>Date Dropped</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($droppedStudents as $application)
                <tr>
                    <td>{{ $application->student->fname }} {{ $application->student->lname }}</td>
                    <td>{{ $application->scholarship->title }}</td>
                    <td>{{ $application->updated_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No students have been dropped.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
