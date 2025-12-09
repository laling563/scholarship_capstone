@extends('Admin.AdminLayout')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">🎓 Scholarship Applications</h2>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover text-center">
                    <thead class="table-primary">
                        <tr class="align-middle">
                            <th style="width: 10%">Student ID</th>
                            <th style="width: 20%">Full Name</th>
                            <th style="width: 20%">Scholarship</th>
                            <th style="width: 15%">Status</th>
                            <th style="width: 15%">Applied At</th>
                            <th style="width: 20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $application)
                        <tr class="align-middle
                            @if($application->status == 'Approved') table-success
                            @elseif($application->status == 'Rejected') table-danger
                            @elseif($application->status == 'Pending') table-warning
                            @endif">

                            <td>{{ $application->student->student_id }}</td>
                            <td>{{ $application->student->fname }} {{ $application->student->lname }}</td>
                            <td>{{ $application->scholarship->title }}</td>
                            <td>
                                <span class="badge
                                    @if($application->status == 'Approved') bg-success
                                    @elseif($application->status == 'Pending') bg-warning text-dark
                                    @elseif($application->status == 'Rejected') bg-danger
                                    @elseif($application->status == 'Endorsed') bg-info text-dark
                                    @else bg-secondary @endif px-3 py-2">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </td>
                            <td>{{ $application->created_at->format('M d, Y') }}</td>
                            <td class="d-flex justify-content-center align-items-center" style="gap: 0.5rem;">
                                <button type="button"
                                    class="btn btn-outline-primary btn-sm viewBtn px-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#applicationModal"

                                    data-id="{{ $application->id }}"
                                    data-scholarship="{{ $application->scholarship->title }}"
                                    data-student="{{ $application->student->fname }} {{ $application->student->lname }}"
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
                                    data-fedu="{{ $application->father_educational_attainment }}"
                                    data-fschool="{{ $application->father_school_graduated }}"
                                    data-fyear="{{ $application->father_year_graduated }}"

                                    data-mother="{{ $application->mother_first_name }} {{ $application->mother_middle_name }} {{ $application->mother_last_name }}"
                                    data-moccupation="{{ $application->mother_occupation }}"
                                    data-mincome="{{ $application->mother_monthly_income }}"
                                    data-medu="{{ $application->mother_educational_attainment }}"
                                    data-mschool="{{ $application->mother_school_graduated }}"
                                    data-myear="{{ $application->mother_year_graduated }}"

                                    data-brothers="{{ $application->number_of_brothers }}"
                                    data-sisters="{{ $application->number_of_sisters }}"
                                    data-totalincome="{{ $application->total_monthly_income }}"

                                    data-notes="{{ $application->notes }}"
                                    data-documents='@json($application->documents)'
                                >
                                    <i class="bi bi-eye"></i> View
                                </button>
                                <form action="{{ route('admin.applications.accept', $application) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-check-circle"></i> Accept
                                    </button>
                                </form>
                                <form action="{{ route('admin.applications.reject', $application) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-x-circle"></i> Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="applicationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold">Application Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <section class="mb-4">
                    <h5 class="text-primary fw-semibold mb-3">Application Info</h5>
                    <div class="p-3 border rounded bg-light">
                        <div><strong>ID:</strong> <span id="appId"></span></div>
                        <div><strong>Scholarship:</strong> <span id="appScholarship"></span></div>
                        <div><strong>Student:</strong> <span id="appStudent"></span></div>
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
                        <div><strong>Landlord:</strong> <span id="appLandlord"></span></div>
                        <div><strong>High School:</strong> <span id="appHs"></span></div>
                        <div><strong>Year Graduated:</strong> <span id="appHsYear"></span></div>
                    </div>
                </section>

                <hr>

                <!-- Family -->
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

<script>
document.querySelectorAll('.viewBtn').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('appId').innerText = button.dataset.id;
        document.getElementById('appScholarship').innerText = button.dataset.scholarship;
        document.getElementById('appStudent').innerText = button.dataset.student;
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
        document.getElementById('appFather').innerText = button.dataset.father;
        document.getElementById('appFOccupation').innerText = button.dataset.foccupation;
        document.getElementById('appFIncome').innerText = button.dataset.fincome;
        document.getElementById('appMother').innerText = button.dataset.mother;
        document.getElementById('appMOccupation').innerText = button.dataset.moccupation;
        document.getElementById('appMIncome').innerText = button.dataset.mincome;
        document.getElementById('appBrothers').innerText = button.dataset.brothers;
        document.getElementById('appSisters').innerText = button.dataset.sisters;
        document.getElementById('appTotalIncome').innerText = button.dataset.totalincome;
        document.getElementById('appNotes').innerText = button.dataset.notes;

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
                a.innerText = doc.document_type;
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
