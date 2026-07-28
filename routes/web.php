<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialiteController;

// ─────────────────────────────────────────────
// Halaman Publik
// ─────────────────────────────────────────────
Route::get('/profil', function () {
    return view('profil');
});

Route::get('/katalog', function () {
    return view('katalog');
});

Route::get('/bantuan', function () {
    return view('bantuan');
})->name('bantuan');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kategori', [HomeController::class, 'categories'])->name('categories');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/events/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/organizers/{slug}', [\App\Http\Controllers\OrganizationProfileController::class, 'show'])->name('organizers.show');
Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

// ─────────────────────────────────────────────
// Auth User Publik (bukan admin)
// ─────────────────────────────────────────────
Route::get('/user/login', [LoginController::class, 'showLogin'])->name('user.login');
Route::post('/user/logout', [LoginController::class, 'logout'])->name('user.logout');
Route::get('/user/register', [\App\Http\Controllers\Auth\UserRegisterController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/user/register', [\App\Http\Controllers\Auth\UserRegisterController::class, 'register'])->name('user.register.post');

// Google OAuth via Socialite
Route::get('/auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

// ─────────────────────────────────────────────
// Review & Rating (butuh login)
// ─────────────────────────────────────────────
Route::post('/events/{event}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])
    ->name('reviews.store')
    ->middleware('auth');

// ─────────────────────────────────────────────
// Admin Panel
// ─────────────────────────────────────────────

// Fallback /login → admin login
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// Admin Routes (public: login/logout)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Routes (protected by middleware)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard', [DashboardController::class, 'index']);

    Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
    Route::resource('events', EventAdminController::class);

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');
    Route::get('/partners/create', [PartnerController::class, 'create'])->name('partners.create');
    Route::post('/partners', [PartnerController::class, 'store'])->name('partners.store');
    Route::get('/partners/{id}/edit', [PartnerController::class, 'edit'])->name('partners.edit');
    Route::put('/partners/{id}', [PartnerController::class, 'update'])->name('partners.update');
    Route::delete('/partners/{id}', [PartnerController::class, 'destroy'])->name('partners.destroy');

    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');

    // Superadmin: Kelola Penyelenggara (SaaS)
    Route::get('/organizations', [\App\Http\Controllers\Admin\OrganizationController::class, 'index'])->name('organizations.index');
    Route::post('/organizations/{id}/approve', [\App\Http\Controllers\Admin\OrganizationController::class, 'approve'])->name('organizations.approve');
    Route::post('/organizations/{id}/suspend', [\App\Http\Controllers\Admin\OrganizationController::class, 'suspend'])->name('organizations.suspend');
});

// ─────────────────────────────────────────────
// Organizer SaaS Panel
// ─────────────────────────────────────────────
Route::get('/organizer/register', [\App\Http\Controllers\Organizer\Auth\RegisterController::class, 'showRegistrationForm'])->name('organizer.register');
Route::post('/organizer/register', [\App\Http\Controllers\Organizer\Auth\RegisterController::class, 'register'])->name('organizer.register.post');

Route::prefix('organizer')->name('organizer.')->middleware(['auth', 'organizer'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Organizer\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('events', \App\Http\Controllers\Organizer\EventController::class);
    Route::get('/transactions', [\App\Http\Controllers\Organizer\TransactionController::class, 'index'])->name('transactions.index');


    // Check-in Scanner routes
    Route::get('/events/{event}/scanner', [\App\Http\Controllers\Organizer\ScannerController::class, 'index'])->name('scanner.index');
    Route::post('/events/{event}/scanner/checkin', [\App\Http\Controllers\Organizer\ScannerController::class, 'checkIn'])->name('scanner.checkin');
});

// ─────────────────────────────────────────────
// Checkout & Pembayaran
// ─────────────────────────────────────────────
Route::get('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/payment/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/success/{order_id}', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransWebhookController::class, 'handle']);