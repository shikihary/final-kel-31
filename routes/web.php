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

Route::get('/', 'QuestionController@index');
Route::get('/users', 'UserController@index');

Route::get('/about', function() {
    return view('about');
});

Route::resource('questions', 'QuestionController');

Route::post('/answers/{question_id}', 'AnswerController@store');

Route::post('/questions/{question_id}', 'QuestionController@answerstore');

Route::post('/questions/{user_id}/store', 'QuestionController@store');

Route::get('/questions/user/{user_id}', 'QuestionController@userquestion');

Route::get('/questionComments/{question_id}','QuestionCommentController@show');

Route::post('/questionComments/{question_id}', 'QuestionCommentController@store');

Route::get('/answerComments/{answer_id}','AnswerCommentController@show');

Route::post('/answerComments/{answer_id}', 'AnswerCommentController@store');

Route::post('/bestanswer/{id}/{question_id}', 'AnswerController@bestanswer');

Route::resource('answers', 'AnswerController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
