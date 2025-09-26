<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Livewire\Admin\VideoUpload;
use App\Livewire\Admin\CourseList;
use App\Livewire\Admin\ChapterManage;
use App\Livewire\Admin\VideoManage;
use App\Livewire\Admin\CourseProgress;
use App\Livewire\Admin\CoursesIndex;
use App\Livewire\Admin\QuizManager;
use App\Livewire\Admin\AnalyticsDashboard;
use App\Livewire\Admin\AdminDashboard;

use App\Livewire\Student\CourseShow;
use App\Livewire\Student\AllCourses;
use App\Livewire\Student\ChapterPlayer;
use App\Livewire\Student\QuizAttempt;
use App\Livewire\Student\CertificateGenerator;
use App\Livewire\Student\StudentResults;
use App\Livewire\Student\StudentDashboard;
use App\Livewire\Student\StudentProgress;
use App\Livewire\Student\QuizList;
use App\Livewire\Student\CourseDetail;
use App\Livewire\Student\CertificateList;

Route::view('/', 'welcome');

// Dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// ------------------ ADMIN ROUTES ------------------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/courses', CourseList::class)->name('admin.courses');
    Route::get('/courses/{courseId}/chapters', ChapterManage::class)->name('admin.chapters');
    Route::get('/chapters/{chapterId}/videos', VideoManage::class)->name('admin.videos');
    Route::get('/chapters/{chapterId}/videos/upload', VideoUpload::class)->name('admin.video.upload');
    Route::get('/all-courses', CoursesIndex::class)->name('courses.index');
    Route::get('/course-progress/{courseId}', CourseProgress::class)->name('course.progress');
    Route::get('/quizzes', QuizManager::class)->name('admin.quizzes');
    Route::get('/analytics', AnalyticsDashboard::class)->name('admin.analytics');
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
});

// ------------------ STUDENT ROUTES ------------------
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', StudentDashboard::class)->name('dashboard');
    Route::get('/courses', AllCourses::class)->name('courses');
    Route::get('/course/{courseId}', CourseShow::class)->name('course.show');
    Route::get('/watch/{videoId}', ChapterPlayer::class)->name('watch');
    Route::get('/quiz/{quizId}', QuizAttempt::class)->name('quiz');
    Route::get('/certificate/{quizId}', CertificateGenerator::class)->name('certificate');
    Route::get('/certificates', CertificateList::class)->name('certificates');

    Route::get('/results', StudentResults::class)->name('results');
    Route::get('/progress', StudentProgress::class)->name('progress');
    Route::get('/quizzes', QuizList::class)->name('quizzes');
    Route::get('/course-detail/{courseId}', CourseDetail::class)->name('course-detail');
});

require __DIR__.'/auth.php';
