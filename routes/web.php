<?php

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

//Route about
Route::get('/about', function() {
    return view('about');
});

//QuestionController
Route::resource('questions', 'QuestionController');
Route::get('/', 'QuestionController@index');
Route::post('/questions/{question_id}', 'QuestionController@answerstore');
Route::post('/questions/{user_id}/store', 'QuestionController@store');
Route::get('/questions/user/{user_id}', 'QuestionController@userquestion');

//AnswerController
Route::resource('answers', 'AnswerController');
Route::post('/answers/{question_id}', 'AnswerController@store');
Route::post('/bestanswer/{id}/{question_id}', 'AnswerController@bestanswer');

//UserController
Route::get('/users', 'UserController@index');

//TagController
Route::get('/tags', 'TagController@index');
Route::get('/tags/{id}', 'TagController@questionsByTag');

//QuestionCommentController
Route::get('/questionComments/{question_id}','QuestionCommentController@show');
Route::post('/questionComments/{question_id}', 'QuestionCommentController@store');

//AnswerCommentController
Route::get('/answerComments/{answer_id}','AnswerCommentController@show');
Route::post('/answerComments/{answer_id}', 'AnswerCommentController@store');

//QuestionVoteController
Route::post('/questionupvote', 'QuestionVoteController@upvote')->name('question.upvote');
Route::post('/questiondownvote', 'QuestionVoteController@downvote')->name('question.downvote');

//AnswerVoteController
Route::post('/answerupvote', 'AnswerVoteController@upvote')->name('answer.upvote');
Route::post('/answerdownvote', 'AnswerVoteController@downvote')->name('answer.downvote');

//HomeController
Route::get('/home', 'HomeController@index')->name('home');

//Authentication Route
Auth::routes();

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
