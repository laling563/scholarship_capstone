<?php

use App\Http\Controllers\AdminApplicationController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminScholarshipController;
use App\Http\Controllers\FindScholarshipController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ScholarController;
use App\Http\Controllers\ScholarsController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ApplicationFormController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApplicationDocumentController;
use App\Http\Controllers\SponsorDashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Models\ApplicationForm;
use Illuminate\Support\Facades\Route;

Route::get('/debug-applications', function () {
    return response()->json(\App\Models\ApplicationForm::latest()->take(5)->get());
});

// URL PARA SA LOGIN PAGE

Route::get('/',[LoginController::class,'LoginPage']);
Route::get('/LoginPage',[LoginController::class,'LoginPage'])->name('LoginPage');
// URL PARA SA REGISTRATION PAGE
Route::get('/RegistrationPage',[LoginController::class,'RegistrationPage'])->name('RegistrationPage');
//CRUD FORMAT BACKEND PARA SA STUDENT
Route::resource('Student',StudentController::class);
//PAG MAG LOLOGIN KA, DITO FINIFILTRATE OR VINAVALIDATE KUNG TAMA UNG INPUT MO SA PAG LOGIN AT NASA STUDENTCONTROLLER ANG LOGIC
Route::post('/login',[LoginController::class,'login'])->name('login');

Route::post('/logout',[LoginController::class,'logout'])->name('logout');
//PAG SUCCESSFUL PUPUNTA SYA SA DASHBOARD NG STUDENT!
Route::get('/dashboard', function () {
    if (!session('student_id')) {
        return redirect()->route('LoginPage')->with('error', 'Please log in first.');
    }

    return view('Student.dashboard');
})->name('dashboard');
//PAG SUCCESSFUL PUPUNTA SYA SA DASHBOARD NG ADMIN!
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin_dashboard');

// Application Form Routes
Route::resource('application-forms', ApplicationFormController::class);

Route::get('/student/scholarships', [ScholarshipController::class, 'showScholarships'])->name('student.scholarships');


// web.php

Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');

// This is a duplicate name, I will remove one of them.
// Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
Route::get('/student/find-scholarship', [FindScholarshipController::class, 'index'])->name('student.find-scholarship');

Route::get('/scholarships/{scholarship}/apply', [ApplicationFormController::class, 'apply'])->name('scholarships.apply');
Route::post('/scholarships/{scholarship}/apply', [ApplicationFormController::class, 'submitApplication'])->name('scholarships.submit');

Route::post('/scholarships/{scholarship}/submit', [ApplicationFormController::class, 'submitApplication'])->name('scholarships.submit');


Route::get('/student/my-applications', [StudentDashboardController::class, 'myApplications'])
->name('student.my-applications');
Route::get('/student/listscholarship', [StudentController::class, 'ListScholarship'])
->name('student.listscholarship');

Route::get('/Scholars', [ScholarsController::class, 'index'])->name('scholars.index');

// Sponsor routes
Route::get('sponsor/login', [LoginController::class, 'showSponsorLoginForm'])->name('sponsor.login');
Route::post('sponsor/login', [LoginController::class, 'sponsorLogin']);

Route::middleware(['auth:sponsor'])->prefix('sponsor')->name('sponsor.')->group(function () {
    Route::get('dashboard', [SponsorDashboardController::class, 'index'])->name('dashboard');
    Route::get('analytics', [SponsorDashboardController::class, 'analytics'])->name('analytics');

    // Application routes
    Route::get('applications', [ApplicationController::class, 'index'])->name('applications');
    Route::patch('applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    Route::get('applications/{id}/view', [ApplicationController::class, 'view'])->name('applications.view');
    Route::put('applications/{id}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
    Route::put('applications/{id}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');

    // Scholarship routes
    Route::resource('scholarships', ScholarshipController::class);
});

Route::get('admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'adminLogin']);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('applications', [AdminApplicationController::class, 'index'])->name('applications');
    Route::get('applications/{id}/view', [AdminApplicationController::class, 'view'])->name('applications.view');
    Route::get('analytics', [AdminDashboardController::class, 'analytics'])->name('analytics');
    Route::resource('scholarships', AdminScholarshipController::class);
});
