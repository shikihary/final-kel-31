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

Route::get('/test', function() {
    return view('test');
});

Route::resource('questions', 'QuestionController');

Route::post('/answers/{question_id}', 'AnswerController@store');

Route::post('/questions/{question_id}', 'QuestionController@answerstore');

Route::resource('answers', 'AnswerController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
