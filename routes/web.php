<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Screening\ConsentController;
use App\Http\Controllers\Screening\ScreeningController;
use App\Http\Controllers\Screening\AnswerController;
use App\Http\Controllers\Screening\EmergencyController;
use App\Http\Controllers\Screening\ResultController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\HistoryController as UserHistoryController;
use App\Http\Controllers\User\RecommendationController as UserRecommendationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Admin\FuzzyRuleController as AdminFuzzyRuleController;
use App\Http\Controllers\Admin\FuzzyMembershipController as AdminFuzzyMembershipController;
use App\Http\Controllers\Admin\AuditLogController as AdminAuditLogController;

Route::get('/', [GuestController::class, 'index'])->name('home');

// Universal Screening Routes
Route::prefix('screening')->name('screening.')->group(function () {
    Route::get('consent', [ConsentController::class, 'show'])->name('consent');
    Route::post('consent', [ConsentController::class, 'store'])->name('consent.store');
    
    Route::middleware('consent')->group(function () {
        Route::get('question', [ScreeningController::class, 'show'])->name('question');
        Route::post('answer', [AnswerController::class, 'store'])->name('answer');
        Route::get('emergency', [EmergencyController::class, 'show'])->name('emergency');
        Route::get('result', [ResultController::class, 'show'])->name('result');
    });
});

// User App Routes
Route::prefix('app')->name('user.')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('history', [UserHistoryController::class, 'index'])->name('history');
    Route::get('recommendation', [UserRecommendationController::class, 'index'])->name('recommendation');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin', 'audit'])->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('questions', AdminQuestionController::class);
    Route::resource('fuzzy-rules', AdminFuzzyRuleController::class);
    Route::resource('fuzzy-memberships', AdminFuzzyMembershipController::class);
    Route::get('audit-logs', [AdminAuditLogController::class, 'index'])->name('audit-logs.index');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role->value === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
