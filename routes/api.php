<?php

use App\Helpers\Documents;
use App\Helpers\GPT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('olympics_question', function (){
//    return [request()->all()];
   $question = request('question');
//   return [$question];
   $olympics = Documents::getOlympicsData();
   $qEmbedding = GPT::getEmbeddings($question)['embeddings'][0];
   $contextEmbedding = Documents::getOlympicsEmbeddings();
   $indexes = GPT::semantic_search($qEmbedding, $contextEmbedding);

    // return the olympics data for the $indexes
    $context = array_map(function($index) use ($olympics){
        return $olympics[$index];
    }, $indexes);

    return [
            "question" => $question,
            "context" => $context,
            "answer" => GPT::chat($question, $context)
        ];
});
