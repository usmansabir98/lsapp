<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Post;
use App\Country;
use App\City;

use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::all();
        // $posts = Post::where('title', 'Post Two');
        // $posts = DB::select('select posts.id, posts.title, posts.body, cities.city_name, 
        // countries.country_name, posts.created_at, posts.updated_at
        // from posts
        // inner join cities on posts.city_id = cities.id
        // inner join countries on posts.country_id = countries.id'); 
        
        // $posts = Post::all();

        // $posts = Post::orderBy('title', 'desc')->take(10)->get();

        // $posts = Post::orderBy('created_at', 'desc')->paginate(5);

        // return view('posts.index')->with('posts', $posts);
        
        return view('posts.grid');
        // echo Datatables::of(Post::all())->make(true);
        // $query = Post::with(['city', 'country'])->select('posts.*');
        // return Datatables::of($query)->make(true);
    }

    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex()
    {
        
        return view('posts.grid');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        // return Datatables::of(Post::query())->make(true);
        $query = Post::with(['city', 'country'])->select('posts.*');
        // foreach($query as $q){

        //     $doc = new DOMDocument();
        //     $doc->loadHTML($q->body);
            
        //     $q->body = $doc->saveHTML();
        //     $q->save();
            
        // }

        // $query->body;
        // $data = Datatables::of($query)->make(true);
        // $data = Datatables::of($query)->make(true);
        $data = Datatables::of($query)
                ->addColumn('delete', 'datatables.delete')
                ->editColumn('id', '<a href="posts/{{$id}}/edit">{{$id}}</a>')
                ->editColumn('title', '<a href="posts/{{$id}}/edit/">{{$title}}</a>')
                ->toJson();


        // echo "<pre>";
        // print_r($query->first()->body);
        // exit();
        // foreach($data->data as $d){
        //     // $doc = new DOMDocument();
        //     // $doc->loadHTML($d->body);
            
        //     // $d->body = $doc->saveHTML();

        //     // $d->body ='sad';
            
        // }
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $countries = Country::all();
        $cities = City::all();


        return view('posts.create')->with('countries', $countries)->with('cities', $cities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['title'=>'required', 'body'=>'required']);

        // Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->city_id = $request->input('city');
        $post->country_id = $request->input('country');

        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit')->with('post', $post);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, ['title'=>'required', 'body'=>'required']);

        // Create Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted');
        
    }
}
