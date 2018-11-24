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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'student'], function(){
    Route::get('/', ['as' => 'student.index', 'uses' => 'StudentController@index']);
    Route::get('/add', ['as' => 'student.add', 'uses' => 'StudentController@add']);
    Route::get('/{id}', ['as' => 'student.show', 'uses' => 'StudentController@show']);
    Route::post('/save', ['as' => 'student.save', 'uses' => 'StudentController@save']);
    Route::post('/delete/{id}', ['as' => 'student.delete', 'uses' => 'StudentController@delete']);
});

Route::group(['prefix' => 'score'], function(){
    Route::get('/', ['as' => 'score.index', 'uses' => 'ScoreController@index']);
    // Route::get('/add', ['as' => 'score.add', 'uses' => 'ScoreController@add']);
    // Route::get('/{id}', ['as' => 'score.show', 'uses' => 'ScoreController@show']);
    // Route::post('/save', ['as' => 'score.save', 'uses' => 'ScoreController@save']);
    // Route::post('/delete/{id}', ['as' => 'score.delete', 'uses' => 'ScoreController@delete']);
});