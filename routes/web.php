<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\ItemController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('login', [AuthController::class, 'getLoginView'])->name('login');
Route::get('register', [AuthController::class, 'getRegisterView'])->name('register');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('borrowers', BorrowingController::class);

Route::middleware('auth', 'admin')->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::resource('tools', ToolController::class);
    Route::put('/borrowings/{id}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
    Route::put('/borrowings/{id}/return', [BorrowingController::class, 'markReturned'])->name('borrowings.return');
});

Route::prefix('testimoni')->controller(TestimoniController::class)->group(function () {
    Route::get('/', 'index')->name('testimoni.index');
    Route::get('/create', 'create')->name('testimoni.create');
    Route::post('/','store')->name('testimoni.store');
});

Route::post('/kontak', [KontakController::class, 'kirim'])->name('kontak.kirim');

Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');