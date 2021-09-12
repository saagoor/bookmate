<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ChallangeController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\ExchangeOfferController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WriterController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [PageController::class, 'index'])->name('index');

Route::resource('books', BookController::class)->only(['index', 'show']);
Route::resource('writers', WriterController::class)->only(['index', 'show']);
Route::resource('publishers', PublisherController::class)->only(['index', 'show']);
Route::resource('exchanges', ExchangeController::class)->only(['index', 'create', 'store', 'show']);
Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);
Route::resource('exchanges.offers', ExchangeOfferController::class);
Route::resource('challanges', ChallangeController::class)->only(['index', 'create', 'store', 'show']);
Route::post('challanges/{challange}/join', [ChallangeController::class, 'join'])->name('challanges.join');
Route::post('challanges/{challange}/update-participant', [ChallangeController::class, 'updateParticipant'])->name('challanges.updateParticipant');


// Admin Panel
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('books', [AdminController::class, 'books'])->name('books');
    Route::get('writers', [AdminController::class, 'writers'])->name('writers');
    Route::get('publishers', [AdminController::class, 'publishers'])->name('publishers');
    Route::get('exchanges', [AdminController::class, 'exchanges'])->name('exchanges');
    Route::get('users', [AdminController::class, 'users'])->name('users');
    
    Route::resource('books', BookController::class)->except(['index', 'show']);
    Route::resource('writers', WriterController::class)->except(['index', 'show']);
    Route::resource('publishers', PublisherController::class)->except(['index', 'show']);
    Route::resource('exchanges', ExchangeController::class)->except(['index', 'show']);
    Route::get('exchanges/{exchange}/offers', [ExchangeController::class, 'offers'])->name('exchanges.offers');
    Route::put('exchanges/{exchange}/offers/{offer}/accept', [ExchangeController::class, 'acceptOffer'])->name('exchanges.offers.accept');
    Route::resource('users', UserController::class)->except(['index', 'show', 'create', 'store']);
    
});

// Authentication routes
require __DIR__.'/auth.php';
