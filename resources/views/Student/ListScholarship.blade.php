{{-- @extends('Student.StudentDashboardLayout')

@section('title', 'My Scholarships')

@section('content')



<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-gradient-primary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-white mb-0">My Scholarship Applications</h5>
                        <a href="" class="btn btn-sm btn-light">Browse All Scholarships</a>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($scholarships->count())
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                      
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($scholarships as $scholarship)
                                    @php
                                        $applicantCount = \App\Models\ApplicationForm::where('scholarship_id', $scholarship->scholarship_id)->count();
                                        $isApplied = $appliedScholarshipIds->contains($scholarship->scholarship_id);
                                        $isFull = $applicantCount >= $scholarship->student_limit;
                                        $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($scholarship->end_date), false);
                                    @endphp
                                    <tr>
                                        <td class="fw-bold">{{ $scholarship->title }}</td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 250px;" title="{{ $scholarship->description }}">
                                                {{ Str::limit($scholarship->description, 100) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($daysLeft < 0)
                                                <span class="badge bg-danger">Expired</span>
                                            @elseif($daysLeft < 7)
                                                <span class="badge bg-warning text-dark">{{ $daysLeft }} days left</span>
                                            @else
                                                <span class="badge bg-info">{{ \Carbon\Carbon::parse($scholarship->end_date)->format('M d, Y') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($isApplied)
                                                <span class="badge bg-success">Applied</span>
                                            @elseif($isFull)
                                                <span class="badge bg-danger">Full</span>
                                            @else
                                                <span class="badge bg-primary">Open</span>
                                            @endif
                                        </td>
                                   
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="" 
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                
                                                @if(!$isApplied && !$isFull && $daysLeft >= 0)
                                                    <a href="{{ route('scholarships.apply', $scholarship->scholarship_id) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-paper-plane"></i> Apply
                                                    </a>
                                                @elseif($isApplied)
                                                    <a href="" 
                                                       class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-file-alt"></i> Application
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if(method_exists($scholarships, 'links'))
                            <div class="mt-3">
                                {{ $scholarships->links() }}
                            </div>
                        @endif
                        
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/empty-state.svg') }}" alt="No scholarships" class="img-fluid mb-3" style="max-height: 200px;">
                            <h5>No Scholarships Available</h5>
                            <p class="text-muted">Check back later for new scholarship opportunities</p>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Add any additional scripts here
    });
</script>
@endsection --}}