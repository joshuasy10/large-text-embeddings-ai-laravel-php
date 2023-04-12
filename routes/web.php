<?php

use App\Helpers\Documents;
use App\Helpers\GPT;
use App\Http\Controllers\ProfileController;
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

//    dd(Documents::getOlympicsEmbeddings(3));
    $question ="Who won the men's high jump?";
    $olympics = Documents::getOlympicsData(350);
    dd([
        "question" => $question,
        "similar" => [
            $olympics[236],
            $olympics[284],
            $olympics[313],
            $olympics[222],
            $olympics[205],
        ]
    ]);


    $qEmbedding = GPT::getEmbeddings($question)['embeddings'][0];
    $contextEmbedding = Documents::getOlympicsEmbeddings(10);
//    dd($contextEmbedding);
//    dd(GPT::dotProduct($qEmbedding, $contextEmbedding[0]));
    dd(GPT::semantic_search($qEmbedding, Documents::getOlympicsEmbeddings()));
    return Inertia::render('Home', [
        'olympics_data' => Documents::getOlympicsData(3),
        'embeddings_data' => Documents::getRemoteCSV('https://cdn.openai.com/API/examples/data/olympics_sections_document_embeddings.csv', 3),
    ]);
});


//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});
//
//Route::get('/dashboard', function () {
//    return Inertia::render('Dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
