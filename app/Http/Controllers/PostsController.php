<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{


        public function __construct()
        {
            $this->middleware('auth')
                ->only(['create', 'store', 'edit', 'update', 'destroy']);
        }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // DB::connection()->enableQueryLog();

        // $posts = BlogPost::with('comments')->get();

        // foreach ($posts as $post){
        //     foreach ($post->comments as $comment){
        //         echo $comment->content;
        //     }
        // }
        // dd(DB::getQueryLog());
        return view('posts.index',
            ['posts' => BlogPost::latest()->withCount('comments')
            // ->orderBy('created_at', 'desc')
            ->get(),
            'mostCommented' => BlogPost::mostCommented()->take(5)->get(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $post = BlogPost::create($validated);




        $request->session()->flash('status', 'The blog post was created');


        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            //  abort_if(!isset($this->posts[$id]), 404);
    
            return view('posts.show', [
                'post' => BlogPost::with('comments')->findOrFail($id)
                ]);

                // return view('posts.show', [
                //     'post' => BlogPost::with(['comments' => function ($query) {
                //         return $query->latest();
                //     }])->findOrFail($id)
                //     ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('update-post', $post))
        // {
        //     abort(403, 'You cannot edit this blog post!');
        // }
        $this->authorize('update', $post);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('update-post', $post))
        // {
        //     abort(403, 'You cannot edit this blog post!');
        // }

        $this->authorize('update', $post);

        $validated = $request->validated(); 
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'Blog Post was updated');

        redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        // if(Gate::denies('delete-post', $post))
        // {
        //     abort(403, 'You cannot delete this blog post!');
        // }

        $this->authorize('delete', $post);

        $post->delete();

        session()->flash('status', 'blog post was delete!');

        return redirect()->route('posts.index');
    }
}
