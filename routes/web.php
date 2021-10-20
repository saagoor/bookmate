<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\EbookExchangeController;
use App\Http\Controllers\EbookExchangeOffersController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\ExchangeOfferController;
use App\Http\Controllers\MessagesController;
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
Route::resource('users', UserController::class)->only(['index', 'show', 'edit', 'update']);
// Books
Route::resource('books', BookController::class)->only(['index', 'show']);
Route::post('books/{book}/price', [ScraperController::class, 'bookPrice'])->name('books.price');
Route::resource('writers', WriterController::class)->only(['index', 'show']);
Route::resource('publishers', PublisherController::class)->only(['index', 'show']);
// Discussions
Route::resource('discussions', DiscussionController::class)->only(['index', 'create', 'store', 'show']);
Route::resource('discussions.comments', CommentController::class)->shallow();
// Exchanges
Route::resource('exchanges', ExchangeController::class)->only(['index', 'create', 'store', 'show']);
Route::resource('exchanges.offers', ExchangeOfferController::class);
// Ebook Exchanges
Route::resource('ebooks', EbookExchangeController::class);
Route::resource('ebooks.offers', EbookExchangeOffersController::class);
// Challenges
Route::resource('challenges', ChallengeController::class)->only(['index', 'create', 'store', 'show']);
Route::post('challenges/{challenge}/join', [ChallengeController::class, 'join'])->name('challenges.join');
Route::post('challenges/{challenge}/update-participant', [ChallengeController::class, 'updateParticipant'])->name('challenges.updateParticipant');
Route::post('challenges/{challenge}/invite', [ChallengeController::class, 'invite'])->name('challenges.invite');

Route::middleware('auth')->group(function () {

    Route::get('exchanges/{exchange}/offers', [ExchangeController::class, 'offers'])->name('exchanges.offers');
    Route::post('exchanges/{exchange}/offers/{offer}/accept', [ExchangeOfferController::class, 'acceptOffer'])->name('exchanges.offers.accept');
    Route::post('exchanges/{exchange}/offers/{offer}/reject', [ExchangeOfferController::class, 'rejectOffer'])->name('exchanges.offers.reject');
    Route::post('exchanges/{exchange}/pickup', [ExchangeController::class, 'setPickupLocation'])->name('exchanges.pickup');
    Route::post('exchanges/{exchange}/complete', [ExchangeController::class, 'completeExchange'])->name('exchanges.complete');

    Route::get('conversations', [MessagesController::class, 'conversations'])->name('conversations');
    Route::get('conversations/{user}', [MessagesController::class, 'showConversation'])->name('conversations.show');
    Route::get('messages/{user}', [MessagesController::class, 'messages'])->name('messages');
    Route::post('messages/{user}', [MessagesController::class, 'sendMessage']);
    Route::post('messages/{user}/see', [MessagesController::class, 'seeMessages'])->name('messages.see');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [UsersDashboardController::class, 'index'])->name('index');
        Route::get('/exchanges', [UsersDashboardController::class, 'exchanges'])->name('exchanges');
        Route::get('/challenges', [UsersDashboardController::class, 'challenges'])->name('challenges');
    });

});

// Admin Panel
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('books', [AdminController::class, 'books'])->name('books');
    Route::get('writers', [AdminController::class, 'writers'])->name('writers');
    Route::get('publishers', [AdminController::class, 'publishers'])->name('publishers');
    Route::get('exchanges', [AdminController::class, 'exchanges'])->name('exchanges');
    Route::get('challenges', [AdminController::class, 'challenges'])->name('challenges');
    Route::get('users', [AdminController::class, 'users'])->name('users');

    Route::resource('books', BookController::class)->except(['index', 'show']);
    Route::resource('writers', WriterController::class)->except(['index', 'show']);
    Route::resource('publishers', PublisherController::class)->except(['index', 'show']);
    Route::resource('exchanges', ExchangeController::class)->except(['index', 'show']);
    Route::resource('challenges', ExchangeController::class)->except(['index', 'create', 'store', 'show']);
    Route::resource('users', UserController::class)->except(['index', 'show', 'create', 'store']);

    Route::get('scrap', function () {
        return view('admin.scrap');
    });

    Route::post('scrap', [ScraperController::class, 'searchBook']);

});

// Authentication routes
require __DIR__ . '/auth.php';
