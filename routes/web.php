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
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');

Route::get('/posts', 'PostsController@getIndex');
Route::get('/posts/data', 'PostsController@anyData')->name('posts.data');

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
Route::get('/facebook/callback', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb)
{
    // Obtain an access token.
    try {
        $token = $fb->getAccessTokenFromRedirect();
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Access token will be null if the user denied the request
    // or if someone just hit this URL outside of the OAuth flow.
    if (! $token) {
        // Get the redirect helper
        $helper = $fb->getRedirectLoginHelper();

        $_SESSION['FBRLH_state']=$_GET['state'];
        // die($_SESSION['FBRLH_' . 'state']);

        if (! $helper->getError()) {
            abort(403, 'Unauthorized action.');
        }

        // User denied the request
        dd(
            $helper->getError(),
            $helper->getErrorCode(),
            $helper->getErrorReason(),
            $helper->getErrorDescription()
        );
    }

    if (! $token->isLongLived()) {
        // OAuth 2.0 client handler
        $oauth_client = $fb->getOAuth2Client();

        // Extend the access token.
        try {
            $token = $oauth_client->getLongLivedAccessToken($token);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    }
    $fb->setDefaultAccessToken($token);

    // Save for later
    Session::put('fb_user_access_token', (string) $token);

    // Get basic info on the user from Facebook.
    try {
        $response = $fb->get('/me?fields=id,name,email');
        $requestPicture = $fb->get('/me/picture?redirect=false&height=300'); //getting user picture
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }
	
    // showing picture on the screen
    $picture = $requestPicture->getGraphUser();
	echo "<img src='".$picture['url']."'/>";
	// saving picture
	// $img = __DIR__.'/'.$profile['id'].'.jpg';
	// file_put_contents($img, file_get_contents($picture['url']));

    // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
    $facebook_user = $response->getGraphUser();


    // Create the user if it does not exist or update the existing entry.
    // This will only work if you've added the SyncableGraphNodeTrait to your User model.
    // $user = App\User::createOrUpdateGraphNode($facebook_user);

    // Log the user into Laravel
    // Auth::login($user);
    $imageUrl = $picture['url'];
    $profileName = $facebook_user['name'];
    return redirect('/home')->with('imageUrl', $imageUrl)->with('profileName', $profileName);
});