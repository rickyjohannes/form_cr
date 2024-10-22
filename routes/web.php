<?php

use App\Http\Controllers\Auth\EmailController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\AccountController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\ProposalController;
use App\Http\Controllers\Pages\PagesController;
use Illuminate\Support\Facades\Route;

//aa
// Pages
Route::get('/home', [DashboardController::class, 'dashboard'])->name('home');
Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');

// Authentication
Route::prefix('auth')->group(function () {
    // ... (Your existing routes)

    // Register
    Route::get('/register', [RegisterController::class, 'registerForm'])->middleware(['guest'])->name('register.form');
    // Route::post('/register', [RegisterController::class, 'register'])->name('register');

    // Email Verify
    Route::get('/email/verify', [EmailController::class, 'verifyEmailForm'])->middleware('auth')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailController::class, 'verifyEmail'])->middleware(['auth', 'signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailController::class, 'verifyEmailNotice'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    //Forgot Password (maintenance)
    Route::get('/forgot-password', [PasswordController::class, 'forgotPasswordForm'])->middleware(['guest'])->name('password.request');
    Route::post('/forgot-password', [PasswordController::class, 'forgotPassword'])->middleware(['guest'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordController::class, 'resetPasswordForm'])->middleware(['guest'])->name('password.reset');
    Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->middleware(['guest'])->name('password.update');

    // Login
    Route::get('/login', [LoginController::class, 'loginForm'])->middleware(['guest'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->middleware(['guest'])->name('login');

    //Logout
    Route::post('/logout', [LoginController::class, 'logout'])->middleware(['auth'])->name('logout');
});

// Redirect to login
Route::get('/', function () {
    return redirect()->route('login.form');
});

// Dashboard
Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'password'])->name('profile.password');

    // Proposal
    Route::resource('proposal', ProposalController::class);
    // Route untuk mencetak proposal
    Route::post('/proposal/{proposal}/print', [ProposalController::class, 'print'])->name('proposal.print');
    // Route untuk approval proposal
    Route::patch('/proposal/{proposal}/approval', [ProposalController::class, 'approval'])->middleware(['role:dh,divh'])->name('proposal.approval');
    // Route untuk mengedit proposal
    Route::get('/proposal/{proposal}/edit', [ProposalController::class, 'edit'])->name('proposal.edit');
    Route::get('/proposal/{proposal}/editit', [ProposalController::class, 'editit'])->name('proposal.editit');
    // Route untuk memperbarui proposal
    Route::put('/proposal/{proposal}', [ProposalController::class, 'update'])->name('proposal.update');
    Route::put('/proposal/{proposal}', [ProposalController::class, 'updateit'])->name('proposal.updateit');
    // Route untuk approve/reject
    Route::get('/proposal/{proposal_id}/approveDH', [ProposalController::class, 'approveDH'])->name('proposal.approveDH');
    Route::get('/proposal/{proposal_id}/rejectDH', [ProposalController::class, 'rejectDH'])->name('proposal.rejectDH');
    Route::get('/proposal/{proposal_id}/approveDIVH', [ProposalController::class, 'approveDIVH'])->name('proposal.approveDIVH');
    Route::get('/proposal/{proposal_id}/rejectDIVH', [ProposalController::class, 'rejectDIVH'])->name('proposal.rejectDIVH');
    // Route untuk detail proposal
    Route::get('/proposal/{proposal}/detail', [ProposalController::class, 'detail'])->name('proposal.detail');
    // Route untuk mengupdate status proposal
    Route::patch('/proposal/{proposal}/updateStatus', [ProposalController::class, 'updateStatus'])->name('proposal.updateStatus');

    // Account
    Route::resource('account', AccountController::class);

    // Download Route
    Route::get('download/{filename}', function ($filename) {
        $file_path = public_path('uploads/' . $filename);
        if (file_exists($file_path)) {
            return response()->download($file_path, $filename, [
                'Content-Length' => filesize($file_path),
            ]);
        } else {
            abort(404, 'Requested file does not exist on our server!');
        }
    })->where('filename', '[A-Za-z0-9\-\_\.]+');

    Route::get('files', [ProposalController::class, 'showFiles'])->name('files.index');

    // Download Route IT
    Route::get('download/{filename}', function ($filename) {
        $file_path = public_path('uploadsIT/' . $filename);
        if (file_exists($file_path)) {
            return response()->download($file_path, $filename, [
                'Content-Length' => filesize($file_path),
            ]);
        } else {
            abort(404, 'Requested file does not exist on our server!');
        }
    })->where('filename', '[A-Za-z0-9\-\_\.]+');

    Route::get('filesIT', [ProposalController::class, 'showFilesIT'])->name('filesIT.index');
    
});