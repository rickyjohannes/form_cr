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
use App\Http\Controllers\Dashboard\MonitoringStockController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Dashboard\PoMonitoringController;


//aa
// Pages
Route::get('/home', [DashboardController::class, 'dashboard'])->name('home');
Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::get('/contact', [PagesController::class, 'contact'])->name('contact');

Route::get('/fetch-data', [PoMonitoringController::class, 'fetchData'])->name('fetch-data');

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

// Route untuk approve/reject tanpa autentikasi
Route::get('/proposal/{proposal_id}/approveDH/{token}', [ProposalController::class, 'approveDH'])->name('proposal.approveDH');
Route::get('/proposal/{proposal_id}/rejectDH/{token}', [ProposalController::class, 'rejectDH'])->name('proposal.rejectDH');
Route::get('/proposal/{proposal_id}/approveDIVH/{token}', [ProposalController::class, 'approveDIVH'])->name('proposal.approveDIVH');
Route::get('/proposal/{proposal_id}/rejectDIVH/{token}', [ProposalController::class, 'rejectDIVH'])->name('proposal.rejectDIVH');
Route::get('/data/user', [ProposalController::class, 'getData'])->name('data.user');


// Dashboard
Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/get-cr-data', [DashboardController::class, 'getCrData'])->name('getCrData');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'password'])->name('profile.password');

    Route::get('/monitoring-po', [PoMonitoringController::class, 'index'])->name('monitoringpo.index');
    Route::get('/monitoring-chart-po', [PoMonitoringController::class, 'indexChart'])->name('monitoringchartpo.index');
    Route::get('/data/po', [PoMonitoringController::class, 'getData'])->name('data.po');
    Route::get('/dataChart/po', [PoMonitoringController::class, 'getDataChart'])->name('dataChart.po');
    Route::get('/Chart/po', [PoMonitoringController::class, 'getChart'])->name('Chart.po');
   

    // // Routes for Proposal and Change Request
    // Route::get('proposal/create', [ProposalController::class, 'create'])->name('proposal.create');
    // Route::post('proposal/store', [ProposalController::class, 'store'])->name('proposal.store');

    // // Rute untuk update proposal
    // Route::put('/proposal/{proposal}/update', [ProposalController::class, 'update'])->name('proposal.update');

     // Rute resource proposal
     Route::resource('proposal', ProposalController::class);

    // Route lainnya
    Route::post('/proposal/{proposal}/print', [ProposalController::class, 'print'])->name('proposal.print');
    Route::patch('/proposal/{proposal}/approval', [ProposalController::class, 'approval'])->name('proposal.approval');
    Route::get('/proposal/{proposal}/edit', [ProposalController::class, 'edit'])->name('proposal.edit');
    Route::get('/proposal/{proposal}/editit', [ProposalController::class, 'editit'])->name('proposal.editit');
    // Rute untuk update proposal dengan logika khusus
    Route::put('/proposal/{proposal}/updateit', [ProposalController::class, 'updateit'])->name('proposal.updateit');
    Route::get('/proposal/{proposal}/detail', [ProposalController::class, 'detail'])->name('proposal.detail');
    Route::patch('/proposal/{proposal}/updateStatus', [ProposalController::class, 'updateStatus'])->name('proposal.updateStatus');

    // Account Routes
    Route::resource('account', AccountController::class);

    // Import Route
    Route::post('account/import', [AccountController::class, 'import'])->name('account.import');

    // Edit User Route
    Route::get('account/{id}/editUser', [AccountController::class, 'editUser'])->name('account.editUser');

    // Update User Route
    Route::put('account/{id}/updateUser', [AccountController::class, 'updateUser'])->name('account.updateUser');

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
    
    Route::get('download/{filename}', function ($filename) {
        $file_path = public_path('uploads/' . $filename);
    
        if (!file_exists($file_path)) {
            return response()->json(['error' => 'File tidak ditemukan!', 'path' => $file_path], 404);
        }
    
        return response()->download($file_path);
    })->where('filename', '.*')->name('download.file');
    
    //MonitoringStock
    Route::prefix('monitoringstock')->middleware(['auth'])->group(function () {
        Route::get('/', [MonitoringStockController::class, 'index'])->name('monitoringstock.index');
        Route::get('/indexData', [MonitoringStockController::class, 'indexData'])->name('indexData.index');
        Route::get('/transaksi-scan', [MonitoringStockController::class, 'transaksi'])->name('monitoringstock.transaksi');
        Route::post('/transaksi-scan', [MonitoringStockController::class, 'store'])->name('monitoringstock.store');
        Route::get('/{id}/edit', [MonitoringStockController::class, 'edit'])->name('monitoringstock.edit');
        Route::put('/{id}', [MonitoringStockController::class, 'update'])->name('monitoringstock.update');
        Route::delete('/{id}', [MonitoringStockController::class, 'destroy'])->name('monitoringstock.destroy');
    });

});