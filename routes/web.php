<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageGoogleController;
use App\Http\Controllers\MinistryController;
use Illuminate\Support\Facades\Route;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// PAGE D'ACCUEIL
Route::get('/', function () {
    return view('accueil');
})->name('accueil');

// PAGE DE FORMULAIRE DE CONTACT
Route::get('/message', [MessageGoogleController::class, 'formContactGoogle'])->name('form.contact.google');
Route::post('/message', [MessageGoogleController::class, 'sendMessageGoogle'])->name('send.message.google');

// RECHERCHE DE L'ÉVÉNEMENT PAR MOT CLEF
Route::get('/search', [EventController::class, 'search'])->name('eventSearch');

// => CONCERNE L'INVITÉ
Route::middleware(['guest'])->group(function() {
    // PAGE D'INSCRIPTION
    Route::get('/registration', [UserController::class, 'register'])->name('registration');
    Route::post('/registration', [UserController::class, 'handleRegistration'])->name('registration');

    // PAGE DE CONNEXION
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'handleLogin'])->name('login');
});

// => CONCERNE LE MEMBRE
Route::middleware(['auth'])->group(function() {
    // ROUTES CONCERNANT LE BLOG
    Route::prefix('articles')->group(function() {
        Route::get('/', [ArticleController::class, 'index'])->withoutMiddleware('auth')->name('articles.index');
        Route::post('/', [ArticleController::class, 'store'])->name('articles.store');
        Route::get('/{article}', [ArticleController::class, 'show'])->withoutMiddleware('auth')->name('articles.show');
        Route::get('/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::put('/{article}/update', [ArticleController::class, 'update'])->name('articles.update');
        Route::delete('/{article}/delete', [ArticleController::class, 'delete'])->name('articles.delete');
    });

    Route::get('/profil', [UserController::class, 'profil'])->name('users.profil');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('home');

    // ROUTES CONCERNANT LES COMMENTAIRES ET SES RÉPONSES
    Route::post('/{article}', [CommentController::class, 'store'])->name('comment');

    Route::prefix('comments')->group(function() {
        Route::get('/{comment}', [CommentController::class, 'show'])->withoutMiddleware('auth')->name('comments.show');
        Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
        Route::put('/{comment}/update', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/{comment}/delete', [CommentController::class, 'delete'])->name('comments.delete');

        Route::post('/{comment}/replies', [ReplyController::class, 'store'])->name('comments.replies.store');
    });

    Route::prefix('replies')->group(function() {
        Route::get('/{reply}/edit', [ReplyController::class, 'edit'])->name('comments.replies.edit');
        Route::put('/{reply}/update', [ReplyController::class, 'update'])->name('comments.replies.update');
        Route::delete('/{reply}/delete', [ReplyController::class, 'destroy'])->name('comments.replies.delete');
    });

    // ROUTES CONCERNANT LE MINISTÈRE
    Route::prefix('ministries')->group(function() {
        Route::get('/', [MinistryController::class, 'index'])->withoutmiddleware('auth')->name('ministries.index');
        Route::get('/create', [MinistryController::class, 'create'])->name('ministries.create');
        Route::post('/store', [MinistryController::class, 'store'])->name('ministries.store');
        // Route::get('/{ministry}', [MinistryController::class, 'show'])->name('ministries.show');
        Route::get('/{ministry}/edit', [MinistryController::class, 'edit'])->name('ministries.edit');
        Route::put('/{ministry}/update', [MinistryController::class, 'update'])->name('ministries.update');
        Route::delete('/{ministry}/destroy', [MinistryController::class, 'destroy'])->name('ministries.destroy');
    });

     // ROUTES CONCERNANT L'ÉVÉNEMENT
     Route::prefix('events')->group(function() {
        Route::get('/', [EventController::class, 'index'])->withoutmiddleware('auth')->name('events.index');
        Route::get('/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/store', [EventController::class, 'store'])->name('events.store');
        Route::get('/{event}', [EventController::class, 'show'])->withoutmiddleware('auth')->name('events.show');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/{event}/update', [EventController::class, 'update'])->name('events.update');
        Route::delete('/{event}/destroy', [EventController::class, 'destroy'])->name('events.destroy');
    });
});


// CONCERNE BOTMAN
$config = [
    // Votre configuration BotMan
];

// Configuration des pilotes
DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);

// Création d'une instance de BotMan
$botman = BotManFactory::create($config);

// Définition de la route pour le chatbot
Route::match(['get', 'post'], '/botman', function (Request $request) use ($botman) {
    // Prise en charge de la requête par BotMan
    $botman->listen();
});

// Définition des interactions avec le chatbot
$botman->hears('Bonjour', function (BotMan $bot) {
    $bot->reply('Salut ! Comment puis-je vous aider ?');
});

$botman->hears('Comment ça va ?', function (BotMan $bot) {
    $bot->reply('Je vais bien, merci ! Et vous ?');
});

$botman->hears('Quel temps fait-il aujourd\'hui ?', function (BotMan $bot) {
    $bot->reply('Il fait beau et ensoleillé !');
});

$botman->hears('Quel est ton nom ?', function (BotMan $bot) {
    $bot->reply('Je suis un chatbot conçu pour vous aider.');
});

$botman->hears('Au revoir', function (BotMan $bot) {
    $bot->reply('À bientôt !');
});
