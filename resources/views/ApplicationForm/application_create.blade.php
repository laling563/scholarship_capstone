<!-- resources/views/application_forms/create.blade.php -->
@extends('Admin.AdminLayout')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Create Application Form</h2>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('application-forms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <h4>Scholarship and Student Information</h4>
                        <div class="mb-3">
                            <label for="scholarship_id" class="form-label">Scholarship</label>
                            <select class="form-select" name="scholarship_id" required>
                                <option value="">Select Scholarship</option>
                                @foreach($scholarships as $scholarship)
                                    <option value="{{ $scholarship->scholarship_id }}">{{ $scholarship->scholarship_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student</label>
                            <select class="form-select" name="student_id" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4>Application Status</h4>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="pending" selected>Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="submission_date" class="form-label">Submission Date</label>
                            <input type="date" class="form-control" name="submission_date" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Personal Information</h4>
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" required>
                        </div>

                        <div class="mb-3">
                            <label for="place_of_birth" class="form-label">Place of Birth</label>
                            <input type="text" class="form-control" name="place_of_birth" required>
                        </div>

                        <div class="mb-3">
                            <label for="civil_status" class="form-label">Civil Status</label>
                            <select class="form-select" name="civil_status" required>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="religion" class="form-label">Religion</label>
                            <input type="text" class="form-control" name="religion">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="height" class="form-label">Height (cm)</label>
                                    <input type="number" step="0.01" class="form-control" name="height">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="weight" class="form-label">Weight (kg)</label>
                                    <input type="number" step="0.01" class="form-control" name="weight">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4>Address Information</h4>
                        <div class="mb-3">
                            <label for="home_address" class="form-label">Home Address</label>
                            <textarea class="form-control" name="home_address" rows="2" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="contact_address" class="form-label">Contact Address</label>
                            <textarea class="form-control" name="contact_address" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="boarding_address" class="form-label">Boarding Address</label>
                            <textarea class="form-control" name="boarding_address" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="landlord_landlady" class="form-label">Landlord/Landlady</label>
                            <input type="text" class="form-control" name="landlord_landlady">
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Educational Background</h4>
                        <div class="mb-3">
                            <label for="high_school_graduated" class="form-label">High School Graduated</label>
                            <input type="text" class="form-control" name="high_school_graduated" required>
                        </div>

                        <div class="mb-3">
                            <label for="high_school_year_graduated" class="form-label">High School Year Graduated</label>
                            <input type="number" class="form-control" name="high_school_year_graduated" min="1900" max="2100" required>
                        </div>

                        <div class="mb-3">
                            <label for="special_skills" class="form-label">Special Skills</label>
                            <textarea class="form-control" name="special_skills" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="curriculum_year" class="form-label">Curriculum Year</label>
                            <input type="text" class="form-control" name="curriculum_year">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4>Family Information</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="number_of_brothers" class="form-label">Number of Brothers</label>
                                    <input type="number" class="form-control" name="number_of_brothers" min="0" value="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="number_of_sisters" class="form-label">Number of Sisters</label>
                                    <input type="number" class="form-control" name="number_of_sisters" min="0" value="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="total_monthly_income" class="form-label">Total Monthly Income</label>
                            <input type="number" step="0.01" class="form-control" name="total_monthly_income">
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h4>Father's Information</h4>
                        <div class="mb-3">
                            <label for="father_first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="father_first_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="father_middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="father_middle_name">
                        </div>

                        <div class="mb-3">
                            <label for="father_last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="father_last_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="father_occupation" class="form-label">Occupation</label>
                            <input type="text" class="form-control" name="father_occupation">
                        </div>

                        <div class="mb-3">
                            <label for="father_monthly_income" class="form-label">Monthly Income</label>
                            <input type="number" step="0.01" class="form-control" name="father_monthly_income">
                        </div>

                        <div class="mb-3">
                            <label for="father_educational_attainment" class="form-label">Educational Attainment</label>
                            <input type="text" class="form-control" name="father_educational_attainment">
                        </div>

                        <div class="mb-3">
                            <label for="father_school_graduated" class="form-label">School Graduated</label>
                            <input type="text" class="form-control" name="father_school_graduated">
                        </div>

                        <div class="mb-3">
                            <label for="father_year_graduated" class="form-label">Year Graduated</label>
                            <input type="number" class="form-control" name="father_year_graduated" min="1900" max="2100">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h4>Mother's Information</h4>
                        <div class="mb-3">
                            <label for="mother_first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="mother_first_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="mother_middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="mother_middle_name">
                        </div>

                        <div class="mb-3">
                            <label for="mother_last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="mother_last_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="mother_occupation" class="form-label">Occupation</label>
                            <input type="text" class="form-control" name="mother_occupation">
                        </div>

                        <div class="mb-3">
                            <label for="mother_monthly_income" class="form-label">Monthly Income</label>
                            <input type="number" step="0.01" class="form-control" name="mother_monthly_income
