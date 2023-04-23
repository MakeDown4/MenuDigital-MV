<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //MenuItems route
    Route::get('/menuitems', [MenuItemController::class, 'index'])->name('menuitems.index');

    //Reservations routes
    Route::get('/reservations/create', [ReservationsController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationsController::class, 'store'])->name('reservations.store');
    });
    //Admin Routes
    Route::middleware('auth.admin')->group(function () {
        // Dashboard admin
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        //Route list and confirm reservations
        Route::get('/admin/list-reservations', [AdminController::class, 'listReservationsAdmin'])->name('admin.list.reservations');
        Route::delete('/admin/list-reservations/{id}', [AdminController::class, 'deleteReservationsAdmin'])->name('admin.list.reservations.delete');
        Route::put('/admin/list-reservations/{id}', [AdminController::class, 'confirmReservationsAdmin'])->name('admin.list.reservations.update');

        // Crud routes Menu Items
        Route::get('/admin/menuitems', [AdminController::class, 'listMenuItems'])->name('admin.menuItems.index');
        Route::post('/admin/menuitems/create', [AdminController::class, 'createMenuItem'])->name('admin.menuItems.create');
        Route::post('/admin/menuitems/{id}', [AdminController::class, 'updateMenuItem'])->name('admin.menuItems.update');
        Route::delete('/admin/menuitems/{id}', [AdminController::class, 'deleteMenuItem'])->name('admin.menuItems.delete');
    });

require __DIR__.'/auth.php';
