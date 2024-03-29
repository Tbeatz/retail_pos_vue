<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\BusinessTypeController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\InvoiceTypeController;
use App\Http\Controllers\InvoiceStatusController;
use App\Http\Controllers\TaxTypeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyTypeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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

Route::middleware('auth')->group(function () {
    //Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //files
    Route::get('/file/{path}', function ($path) {
        if (Storage::path('upload/'.$path)) {
            return response()->file(Storage::path('upload/'.$path));
        } else {
            abort(404, 'File Not Found');
        }
    })->name('file')->where('path', '.*');

    //Nav Tabs
    //(User Management)
    Route::resource('role', RoleController::class);
    Route::resource('tenant', TenantController::class);
    Route::resource('user', UserController::class);
    Route::resource('reg_user', RegisterUserController::class);
    Route::resource('position', PositionController::class);
});

require __DIR__.'/auth.php';
