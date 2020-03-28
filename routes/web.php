<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('right', 'Books\RightController');
    Route::resource('side_type', 'Books\SideTypeController');
    Route::resource('status', 'Books\StatusController');

    Route::resource('deck', 'DeckController');
    Route::post('deck/{deck}/add', 'DeckController@add');

    Route::resource('flashcard', 'FlashcardController');

    Route::post('flashcard', 'FlashcardController@store')->name('flashcard.store');
    Route::post('flashcard/{flashcard}/update-status', 'FlashcardController@updateStatus');
    Route::post('deck/{deck}/update-status', 'DeckController@updateStatus');

    Route::get('settings', 'SettingsController@index')->name('settings.index');
    Route::post('settings/update', 'SettingsController@update')->name('settings.update');
    Route::post('settings/store', 'SettingsController@store')->name('settings.store');

    Route::get('vocabulary', 'VocabularyController@index')->name('vocabulary.index');
    Route::get('collections', 'CollectionController@index')->name('collections');

    Route::get('profile', 'ProfileController@index')->name('profile');
    Route::post('profile/store', 'ProfileController@store')->name('profile.store');

    Route::get('training/dashboard', 'Training\TrainingController@dashboard')->name('training.dashboard');
    Route::get('training/{deck}/{typeTraining}', 'Training\TrainingController@study')->name('training.study')
        ->where(['typeTraining' => 'flashcards|word-constructor|choose-word']);

    Route::post('training/{deck}/word-constructor/get-constructor-word', 'Training\ConstructorController@getWord');
    Route::post('training/{deck}/choose-word/get-choose-word', 'Training\ChooseController@getWord');
    Route::post('training/{deck}/flashcards/get-flashcard-word', 'Training\FlashcardController@getWord');

});
