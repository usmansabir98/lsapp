<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;
use App\Country;
use App\City;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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

        foreach ($popular as $value) {
            # code...
            $id = str_replace('post:', '', $value);
            $post = Post::find($id);
            $post->views = $redis->get('post:'.$id.':views');
            array_push($posts, $post);
        }

        return view('home')->with('posts', $posts);
    }
}
