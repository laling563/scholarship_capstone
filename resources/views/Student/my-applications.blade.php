@extends('Student.StudentDashboardLayout')

@section('title', 'My Applications - PSU System')

@section('content')

<div class="d-flex">

    <!-- Sidebar -->
    <div class="bg-dark text-white sidebar d-flex flex-column" id="sidebar" style="min-width:250px;">
        <div class="p-3 border-bottom border-secondary text-center">
            <h4 class="mb-0">PSU Scholarship</h4>
        </div>

        <div class="p-3 border-bottom border-secondary bg-primary bg-opacity-25 text-center">
            <i class="fas fa-user-circle fa-3x mb-2"></i>
            <h6 class="mb-0">{{ session('student_fname') }} {{ session('student_lname') }}</h6>
        </div>

        <ul class="nav flex-column p-3">
            <li class="nav-item">
                <a class="nav-link text-white" href="/student/dashboard">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white active bg-primary bg-opacity-75 rounded" href="/student/my-applications">
                    <i class="fas fa-scroll me-2"></i> My Applications
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="/student/find-scholarship">
                    <i class="fas fa-search me-2"></i> Find Scholarships
                </a>
            </li>
        </ul>

        <div class="sidebar-footer text-center mt-auto mb-3">
            <a href="#"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-danger fw-bold">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebarOverlay"></div>

    <!-- Main content -->
    <div class="main-content flex-grow-1">

        <!-- Mobile Toggle Button -->
        <button class="btn btn-primary d-md-none m-2" id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <div class="container container-left py-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-primary">📄 My Scholarship Applications</h2>
            </div>

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover text-center">
                            <thead class="table-primary">
                                <tr class="align-middle">
                                    <th style="width: 25%">Scholarship</th>
                                    <th style="width: 20%">Status</th>
                                    <th style="width: 20%">Applied At</th>
                                    <th style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $application)
                                <tr class="align-middle
                                    @if($application->status == 'Approved') table-success
                                    @elseif($application->status == 'Rejected') table-danger
                                    @elseif($application->status == 'Pending') table-warning
                                    @elseif($application->status == 'Endorsed') table-info
                                    @endif">

                                    <td>{{ $application->scholarship->title }}</td>

                                    <td>
                                        <span class="badge
                                            @if(ucfirst($application->status) == 'Approved') bg-success
                                            @elseif(ucfirst($application->status) == 'Pending') bg-warning text-dark
                                            @elseif(ucfirst($application->status) == 'Rejected') bg-danger
                                            @endif px-3 py-2">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>

                                    <td>{{ $application->created_at->format('M d, Y') }}</td>

                                    <td>
                                        <button type="button"
                                            class="btn btn-outline-primary btn-sm viewBtn px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#applicationModal"

                                            data-id="{{ $application->id }}"
                                            data-scholarship="{{ $application->scholarship->title }}"
                                            data-status="{{ $application->status }}"
                                            data-applied="{{ $application->created_at }}"

                                            data-dob="{{ $application->date_of_birth }}"
                                            data-civil="{{ $application->civil_status }}"
                                            data-birthplace="{{ $application->place_of_birth }}"
                                            data-religion="{{ $application->religion }}"
                                            data-height="{{ $application->height }}"
                                            data-weight="{{ $application->weight }}"
                                            data-home="{{ $application->home_address }}"
                                            data-contact="{{ $application->contact_address }}"
                                            data-boarding="{{ $application->boarding_address }}"
                                            data-landlord="{{ $application->landlord_landlady }}"
                                            data-hs="{{ $application->high_school_graduated }}"
                                            data-hsyear="{{ $application->high_school_year_graduated }}"
                                            data-skills="{{ $application->special_skills }}"
                                            data-curriculum="{{ $application->curriculum_year }}"

                                            data-father="{{ $application->father_first_name }} {{ $application->father_middle_name }} {{ $application->father_last_name }}"
                                            data-foccupation="{{ $application->father_occupation }}"
                                            data-fincome="{{ $application->father_monthly_income }}"
                                            data-mother="{{ $application->mother_first_name }} {{ $application->mother_middle_name }} {{ $application->mother_last_name }}"
                                            data-moccupation="{{ $application->mother_occupation }}"
                                            data-mincome="{{ $application->mother_monthly_income }}"

                                            data-brothers="{{ $application->number_of_brothers }}"
                                            data-sisters="{{ $application->number_of_sisters }}"
                                            data-totalincome="{{ $application->total_monthly_income }}"

                                            data-notes="{{ $application->notes }}"
                                            data-documents='@json($application->documents)'
                                        >
                                            <i class="bi bi-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                                @endforeach

                                @if ($applications->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-muted py-3">No applications submitted yet.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- MODAL -->
<div class="modal fade" id="applicationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold">Application Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Application Info -->
                <section class="mb-4">
                    <h5 class="text-primary fw-semibold mb-3">Application Info</h5>
                    <div class="p-3 border rounded bg-light">
                        <div><strong>ID:</strong> <span id="appId"></span></div>
                        <div><strong>Scholarship:</strong> <span id="appScholarship"></span></div>
                        <div><strong>Status:</strong> <span id="appStatus"></span></div>
                        <div><strong>Applied At:</strong> <span id="appApplied"></span></div>
                    </div>
                </section>

                <hr>

                <!-- Personal Info -->
                <section class="mb-4">
                    <h5 class="text-primary fw-semibold mb-3">Personal Information</h5>
                    <div class="p-3 border rounded bg-light">
                        <div><strong>Date of Birth:</strong> <span id="appDob"></span></div>
                        <div><strong>Civil Status:</strong> <span id="appCivil"></span></div>
                        <div><strong>Place of Birth:</strong> <span id="appBirthplace"></span></div>
                        <div><strong>Religion:</strong> <span id="appReligion"></span></div>
                        <div><strong>Height:</strong> <span id="appHeight"></span></div>
                        <div><strong>Weight:</strong> <span id="appWeight"></span></div>
                        <div><strong>Home Address:</strong> <span id="appHome"></span></div>
                        <div><strong>Contact Address:</strong> <span id="appContact"></span></div>
                        <div><strong>Boarding Address:</strong> <span id="appBoarding"></span></div>
                        <div><strong>Landlord/Landlady:</strong> <span id="appLandlord"></span></div>
                        <div><strong>High School:</strong> <span id="appHs"></span></div>
                        <div><strong>Year Graduated:</strong> <span id="appHsYear"></span></div>
                        <div><strong>Special Skills:</strong> <span id="appSkills"></span></div>
                        <div><strong>Curriculum Year:</strong> <span id="appCurriculum"></span></div>
                    </div>
                </section>

                <hr>

                <!-- Family Background -->
                <section class="mb-4">
                    <h5 class="text-primary fw-semibold mb-3">Family Background</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light h-100">
                                <h6 class="fw-bold text-secondary mb-2">Father</h6>
                                <p><strong>Name:</strong> <span id="appFather"></span></p>
                                <p><strong>Occupation:</strong> <span id="appFOccupation"></span></p>
                                <p><strong>Monthly Income:</strong> ₱<span id="appFIncome"></span></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded bg-light h-100">
                                <h6 class="fw-bold text-secondary mb-2">Mother</h6>
                                <p><strong>Name:</strong> <span id="appMother"></span></p>
                                <p><strong>Occupation:</strong> <span id="appMOccupation"></span></p>
                                <p><strong>Monthly Income:</strong> ₱<span id="appMIncome"></span></p>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3 g-3 text-center">
                        <div class="col-md-4"><div class="p-3 border rounded bg-light"><strong>Brothers:</strong> <p id="appBrothers"></p></div></div>
                        <div class="col-md-4"><div class="p-3 border rounded bg-light"><strong>Sisters:</strong> <p id="appSisters"></p></div></div>
                        <div class="col-md-4"><div class="p-3 border rounded bg-light"><strong>Total Monthly Income:</strong> ₱<p id="appTotalIncome"></p></div></div>
                    </div>
                </section>

                <hr>

                <!-- Notes -->
                <section class="mb-4">
                    <h5 class="text-primary fw-semibold mb-3">Notes</h5>
                    <div class="p-3 bg-light rounded" id="appNotes"></div>
                </section>

                <hr>

                <!-- Documents -->
                <section>
                    <h5 class="text-primary fw-semibold mb-3">Application Documents</h5>
                    <ul id="appDocuments" class="list-group list-group-flush"></ul>
                </section>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


        </div>
    </div>
</div>

@endsection

@section('scripts')
<style>
/* Sidebar base */
.sidebar {
    width: 250px;
    min-height: 100vh;
    transition: transform 0.3s ease;
    position: fixed; /* Keep sidebar fixed */
    top: 0;
    left: 0;
    z-index: 1000;
    display: flex;
    flex-direction: column;
}

/* Main content desktop */
@media (min-width: 769px) {
    .main-content {
        margin-left: 250px; /* Sidebar width */
        padding: 2rem;
        width: calc(100% - 250px);
    }
}

/* Card/table styling */
.card {
    margin: 0 auto;
    max-width: 1000px; /* optional max width for desktop */
}

/* Mobile adjustments remain the same */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        position: fixed;
    }
    .sidebar.active {
        transform: translateX(0);
    }
    #sidebarOverlay.active {
        display: block;
    }
}

/* Overlay */
#sidebarOverlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.45);
    z-index: 999;
}

</style>

<script>
// Sidebar Toggle
const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('toggleSidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');

sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    sidebarOverlay.classList.toggle('active');
});

// Close sidebar when clicking overlay
sidebarOverlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    sidebarOverlay.classList.remove('active');
});

// View Modal Script
document.querySelectorAll('.viewBtn').forEach(button => {
    button.addEventListener('click', () => {

        document.getElementById('appId').innerText = button.dataset.id;
        document.getElementById('appScholarship').innerText = button.dataset.scholarship;
        document.getElementById('appStatus').innerText = button.dataset.status;
        document.getElementById('appApplied').innerText = button.dataset.applied;

        document.getElementById('appDob').innerText = button.dataset.dob;
        document.getElementById('appCivil').innerText = button.dataset.civil;
        document.getElementById('appBirthplace').innerText = button.dataset.birthplace;
        document.getElementById('appReligion').innerText = button.dataset.religion;
        document.getElementById('appHeight').innerText = button.dataset.height;
        document.getElementById('appWeight').innerText = button.dataset.weight;
        document.getElementById('appHome').innerText = button.dataset.home;
        document.getElementById('appContact').innerText = button.dataset.contact;
        document.getElementById('appBoarding').innerText = button.dataset.boarding;
        document.getElementById('appLandlord').innerText = button.dataset.landlord;
        document.getElementById('appHs').innerText = button.dataset.hs;
        document.getElementById('appHsYear').innerText = button.dataset.hsyear;
        document.getElementById('appSkills').innerText = button.dataset.skills;
        document.getElementById('appCurriculum').innerText = button.dataset.curriculum;

        document.getElementById('appFather').innerText = button.dataset.father;
        document.getElementById('appFOccupation').innerText = button.dataset.foccupation;
        document.getElementById('appFIncome').innerText = button.dataset.fincome;
        document.getElementById('appMother').innerText = button.dataset.mother;
        document.getElementById('appMOccupation').innerText = button.dataset.moccupation;
        document.getElementById('appMIncome').innerText = button.dataset.mincome;
        document.getElementById('appBrothers').innerText = button.dataset.brothers;
        document.getElementById('appSisters').innerText = button.dataset.sisters;
        document.getElementById('appTotalIncome').innerText = button.dataset.totalincome;

        document.getElementById('appNotes').innerText = button.dataset.notes || "None";

        let docs = JSON.parse(button.dataset.documents || '[]');
        let docList = document.getElementById('appDocuments');
        docList.innerHTML = '';

        if (docs.length > 0) {
            docs.forEach(doc => {
                let li = document.createElement('li');
                li.className = "list-group-item d-flex justify-content-between align-items-center";

                let a = document.createElement('a');
                a.href = `/storage/${doc.file_path}`;
                a.target = "_blank";

                // Use proper naming like Sponsor view
                a.innerText = doc.original_name || doc.file_name || 'Document';

                li.appendChild(a);
                docList.appendChild(li);
            });
        } else {
            docList.innerHTML = '<li class="list-group-item text-muted text-center">No documents submitted.</li>';
        }
    });
});
</script>

@endsection
