@extends('Admin.AdminLayout')

@section('title', 'Create Sports Scholarship')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Sports Scholarship Application Form</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.scholarships.store.sport') }}" method="POST">
                @csrf

                <fieldset class="mb-4">
                    <legend class="h6">Sponsor Information</legend>
                    <div class="form-group">
                        <label for="sponsor_id">Sponsor</label>
                        <select class="form-control" id="sponsor_id" name="sponsor_id" required>
                            <option value="">Select a Sponsor</option>
                            @foreach($sponsors as $sponsor)
                                <option value="{{ $sponsor->id }}">{{ $sponsor->sponsor_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>

                <fieldset class="mb-4">
                    <legend class="h6">Personal Information</legend>
                    <div class="form-group">
                        <label for="student_id">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" required>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="course_year">Course / Year Level</label>
                        <input type="text" class="form-control" id="course_year" name="course_year" required>
                    </div>
                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                    </div>
                </fieldset>

                <fieldset class="mb-4">
                    <legend class="h6">Sports Information</legend>
                    <div class="form-group">
                        <label for="sport_category">Sport Category</label>
                        <input type="text" class="form-control" id="sport_category" name="sport_category" placeholder="e.g., Basketball, Volleyball, Athletics, Taekwondo, Swimming, etc." required>
                    </div>
                    <div class="form-group">
                        <label for="playing_position">Playing Position / Event</label>
                        <input type="text" class="form-control" id="playing_position" name="playing_position">
                    </div>
                    <div class="form-group">
                        <label for="years_of_experience">Years of Experience</label>
                        <input type="number" class="form-control" id="years_of_experience" name="years_of_experience" required>
                    </div>
                    <div class="form-group">
                        <label for="team_membership">Team Membership</label>
                        <input type="text" class="form-control" id="team_membership" name="team_membership" placeholder="School Team, City Team, Regional, etc.">
                    </div>
                    <div class="form-group">
                        <label for="training_schedule">Training Schedule (optional)</label>
                        <textarea class="form-control" id="training_schedule" name="training_schedule" rows="3"></textarea>
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="h6">Achievements</legend>
                    <div class="form-group">
                        <label for="achievements">List of Sports Achievements</label>
                        <textarea class="form-control" id="achievements" name="achievements" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="level_of_competition">Level of Competition</label>
                        <input type="text" class="form-control" id="level_of_competition" name="level_of_competition" placeholder="School, District, Regional, National, International">
                    </div>
                    <div class="form-group">
                        <label for="awards_received">Awards Received</label>
                        <textarea class="form-control" id="awards_received" name="awards_received" rows="3"></textarea>
                    </div>
                </fieldset>

                <hr>
                <button type="submit" class="btn btn-primary">Create Scholarship</button>
            </form>
        </div>
    </div>
</div>
@endsection
