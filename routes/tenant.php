<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
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
use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/
Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
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
        Route::resource('user', UserController::class);
        Route::resource('reg_user', RegisterUserController::class);
        //(Business)
        Route::resource('business_type', BusinessTypeController::class);
        Route::resource('business', BusinessController::class);
        Route::resource('position', PositionController::class);
        //(Financial)
        Route::resource('payment_method', PaymentMethodController::class);
        Route::resource('invoice_type', InvoiceTypeController::class);
        Route::resource('invoice_status', InvoiceStatusController::class);
        Route::resource('tax_type', TaxTypeController::class);
        //(Product Category)
        Route::resource('category', CategoryController::class);
        //(Miscellaneous)
        Route::resource('currency_type', CurrencyTypeController::class);
        Route::resource('unit', UnitController::class);

        //Side Tabs
        Route::resource('product', ProductController::class);
        Route::resource('sale', SaleController::class);
        Route::resource('transaction', TransactionController::class);
        Route::resource('invoice', InvoiceController::class);
    });

    require __DIR__.'/auth.php';
});
