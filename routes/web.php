<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ChallangeController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\ExchangeOfferController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersDashboardController;
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
Route::resource('users', UserController::class)->only(['index', 'show', 'edit', 'update']);
Route::resource('exchanges.offers', ExchangeOfferController::class);
Route::resource('challanges', ChallangeController::class)->only(['index', 'create', 'store', 'show']);
Route::post('challanges/{challange}/join', [ChallangeController::class, 'join'])->name('challanges.join');
Route::post('challanges/{challange}/update-participant', [ChallangeController::class, 'updateParticipant'])->name('challanges.updateParticipant');
Route::post('challanges/{challange}/invite', [ChallangeController::class, 'invite'])->name('challanges.invite');


Route::prefix('dashboard')->middleware('auth')->name('dashboard.')->group(function () {
    Route::get('/', [UsersDashboardController::class, 'index'])->name('index');
    Route::get('/exchanges', [UsersDashboardController::class, 'exchanges'])->name('exchanges');
    Route::get('/challanges', [UsersDashboardController::class, 'challanges'])->name('challanges');
});


// Admin Panel
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('books', [AdminController::class, 'books'])->name('books');
    Route::get('writers', [AdminController::class, 'writers'])->name('writers');
    Route::get('publishers', [AdminController::class, 'publishers'])->name('publishers');
    Route::get('exchanges', [AdminController::class, 'exchanges'])->name('exchanges');
    Route::get('challanges', [AdminController::class, 'challanges'])->name('challanges');
    Route::get('users', [AdminController::class, 'users'])->name('users');

    Route::resource('books', BookController::class)->except(['index', 'show']);
    Route::resource('writers', WriterController::class)->except(['index', 'show']);
    Route::resource('publishers', PublisherController::class)->except(['index', 'show']);
    Route::resource('exchanges', ExchangeController::class)->except(['index', 'show']);
    Route::get('exchanges/{exchange}/offers', [ExchangeController::class, 'offers'])->name('exchanges.offers');
    Route::put('exchanges/{exchange}/offers/{offer}/accept', [ExchangeController::class, 'acceptOffer'])->name('exchanges.offers.accept');
    Route::resource('challanges', ExchangeController::class)->except(['index', 'create', 'store', 'show']);
    Route::resource('users', UserController::class)->except(['index', 'show', 'create', 'store']);

    Route::get('scrap', function(){
        return view('admin.scrap');
    });

    Route::post('scrap', [ScraperController::class, 'searchBook']);
    Route::post('books/{book}/price', [ScraperController::class, 'bookPrice'])->name('books.price');
    
});

// Authentication routes
require __DIR__ . '/auth.php';
