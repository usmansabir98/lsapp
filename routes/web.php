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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'PagesController@index');
Route::get('about', 'PagesController@about');
Route::get('services', 'PagesController@services');

Route::get('posts', 'PostsController@getIndex');
Route::get('posts/data', 'PostsController@anyData')->name('posts.data');

Route::resource('posts', 'PostsController');

// Route::get('/about', function () {
//     return view('pages.about');
// });

// Route::get('/users/{id}/{name}', function ($id, $name) {
//     return 'This is user '. $id . ' with name '. $name;
// });

Route::get('/ajax/{id}', 'CitiesController@getCity');
Route::get('/ajax', 'PostsController@getData');



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::resource('datatables', 'DatatablesController', [
//     'anyData'  => 'datatables.data',
//     'getIndex' => 'datatables',
// ]);

// Route::resource('datatables', 'DatatablesController');

Route::get('datatables/data', 'DatatablesController@anyData')->name('datatables.data');
Route::resource('datatables', 'DatatablesController');

// Route::resource('photos', 'PhotoController')->names([
//     'create' => 'photos.build'
// ]);


// Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
// });

// Generate a login URL
Route::get('/facebook/login', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
{
    // Send an array of permissions to request
    $login_url = $fb->getLoginUrl(['email']);

    // Obviously you'd do this in blade :)
    echo '<a href="' . $login_url . '">Login with Facebook</a>';
});

// Endpoint that is redirected to after an authentication attempt
Route::get('/facebook/callback', 'HomeController@facebookIndex');

Route::get('/redirect', 'Auth\LoginController@redirectToProvider')->name('redirect');
Route::get('/google/callback', 'Auth\LoginController@handleProviderCallback');