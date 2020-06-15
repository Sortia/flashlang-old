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

Route::group(['middleware' => ['auth', 'locale']], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('side_type', 'Books\SideTypeController');
    Route::resource('status', 'Books\StatusController');

    Route::resource('deck', 'DeckController');

    Route::resource('flashcard', 'FlashcardController');

    Route::resource('storybook', 'StorybookController');

    Route::post('flashcard', 'FlashcardController@store')->name('flashcard.store');
    Route::post('flashcard/{flashcard}/update-status', 'FlashcardController@updateStatus');
    Route::post('deck/{deck}/update-status', 'DeckController@updateStatus');

    Route::get('settings', 'SettingsController@index')->name('settings.index');
    Route::post('settings/flashStore', 'SettingsController@flashStore')->name('settings.flashStore');
    Route::post('settings/store', 'SettingsController@store')->name('settings.store');

    Route::get('vocabulary', 'VocabularyController@index')->name('vocabulary.index');

    Route::get('collections', 'CollectionController@index')->name('collections');
    Route::post('collection/{collection}/add', 'CollectionController@add');

    Route::get('profile', 'ProfileController@index')->name('profile');
    Route::post('profile/store', 'ProfileController@store')->name('profile.store');

    Route::get('training/dashboard', 'Training\TrainingController@dashboard')->name('training.dashboard');
    Route::get('training/{typeTraining}/{deck}', 'Training\TrainingController@study')->name('training.study')
        ->where(['typeTraining' => 'flashcards|word-constructor|choose-word']);

    Route::post('training/word-constructor/{deck}/get-constructor-word', 'Training\ConstructorController@getWord');
    Route::post('training/choose-word/{deck}/get-choose-word', 'Training\ChooseController@getWord');
    Route::post('training/flashcards/{deck}/get-flashcard-word', 'Training\FlashcardController@getWord');

});

/** Auth */
Route::get('google', 'Auth\GoogleAuthController@index')->name('google.index');
Route::get('sign_in/google', 'Auth\GoogleAuthController@auth');

Route::group(['prefix' => 'telegram'], function () {
    Route::get('settings', 'Telegram\TelegramSettingsController@index')->name('telegram.settings');
    Route::get('setup', 'Telegram\TelegramSettingsController@setup')->name('telegram.settings.setup');
    Route::any('auth', 'Telegram\TelegramAuthController@auth');
    Route::post('handler', 'Telegram\TelegramController@handler');
});
