<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Country;
use App\City;
use App\User;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Session;
use SammyK\LaravelFacebookSdk\LaravelFacebookSdk;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redis = Redis::connection();
        $popular = $redis->zRevRange('postViews', 0, 4);

        $posts = [];

        // $redisPosts = $redis->get('posts');
        $redisPosts = Cache::get('posts');

        if($redisPosts){
            $posts = json_decode($redisPosts);
        }

        else{
            foreach ($popular as $value) {
                # code...
                $id = str_replace('post:', '', $value);
                $post = Post::find($id);
                $post->views = $redis->get('post:'.$id.':views');
                array_push($posts, $post);
            }
        }

        // $redis->set('posts', json_encode($posts, true));
        // $redis->expire('posts', 60);

        $expiresAt = now()->addMinutes(1);
        Cache::put('posts', json_encode($posts, true), $expiresAt);

        return view('home')->with('posts', $posts);
    }

    public function facebookIndex(LaravelFacebookSdk $fb){

        

        
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
        

        // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
        $facebook_user = $response->getGraphUser();

        // var_dump($response);
        // echo $facebook_user;

        //echo "<img src='".$picture['url']."'/>";
        // saving picture
        $img = __DIR__.'/'.$facebook_user['id'].'.jpg';
        file_put_contents($img, file_get_contents($picture['url']));

        // Create the user if it does not exist or update the existing entry.
        // This will only work if you've added the SyncableGraphNodeTrait to your User model.
        $user = User::createOrUpdateGraphNode($facebook_user);

        // Log the user into Laravel
        Auth::login($user);
        $imageUrl = $picture['url'];
        // $imageUrl = $img;

        // echo $imageUrl;
        $profileName = $facebook_user['name'];
        return redirect('/home');

        // return view('home')->with('posts', $posts)->with('imageUrl', $imageUrl)->with('profileName', $profileName);

    }
}
