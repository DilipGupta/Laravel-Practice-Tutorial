<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPost;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Gate;
use App\User;
use Illuminate\Support\Facades\Cache;

//Start This is for understanding purpose for this line($this->authorize($post);)
// [
//     'show'=>'view',
//     'create'=>'create',
//     'store'=>'create',
//     'edit'=>'update',
//     'update'=>'update',
//     'destroy'=>'delete',
// ]
//End

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['create','edit','update','destroy']);
    }


    public function index()
    {
        $mostCommented=Cache::remember('blog-post-commented', 60, function () {
            return BlogPost::mostCommented()->take(5)->get();
        });
        $mostActiveUser=Cache::remember('use-active', 60, function () {
            return User::withMostBlogPosts()->take(5)->get();
        });
        $mostActiveLastMonth=Cache::remember('user-active-last-month', 60, function () {
            return User::withMostBlogPostLastMonth()->take(5)->get();
        });
        // return view('posts.index',['post'=>BlogPost::all()]);
        return view('posts.index',[
            'post'=>BlogPost::latest()->withCount('comments')->get(),
            'mostCommented'=>$mostCommented,
            'mostActiveUser'=>$mostActiveUser,
            'mostActiveLastMonth'=>$mostActiveLastMonth,
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
        $validatedData=$request->validated();
        
        // $blogpost=new BlogPost();
        // $blogpost->title=$request->input('title');
        // $blogpost->content=$request->input('content');
        // $blogpost->save();
        $validatedData['user_id']=$request->user()->id;
        $blogpost=BlogPost::create($validatedData);


        $request->session()->flash('status','Blog post created successfully!');

        return redirect()->route('posts.show',['post'=>$blogpost->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $request->session()->reflash();
        // return view('posts.show',[
        //     'post'=> BlogPost::with(['comments'=>function ($query){
        //         return $query->latest();
        //      }])->findOrfail($id)
        // ]);
        $blogPost=Cache::remember("blog-post-{$id}", 60, function () use($id) {
            return BlogPost::with('comments')->findOrfail($id);
        });

        $sessionId=session()->getId();
        $counterKey='blog-post-{$id}-counter';
        $usersKey='blog-post-{$id}-users';

        $users=Cache::get($usersKey,[]);
        $usersUpdate=[];
        $difference=0;

        foreach($users as $session=>$lastVisit){
            if(now()->diffInMinutes($lastVisit) >= 1){
                $difference--;
            }else{
                $usersUpdate[$session]=$lastVisit;
            }
        }

        if(!array_key_exists($sessionId, $users) || now()->diffInMinutes($users[$sessionId]) >= 1){
            $difference++;
        }

        $usersUpdate[$sessionId]=now();
        Cache::forever($usersKey, $usersUpdate);

        if(!Cache::has($counterKey)){
            Cache::forever($counterKey, 1);
        }else{
            Cache::increment($counterKey, $difference);
        }
        
        $counter=cache::get($counterKey);

        return view('posts.show',[
            'post'=> $blogPost,
            'counter'=>$counter,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=BlogPost::findOrFail($id);

        //Start 1 Method how to authorize user on action(method)
        // if (Gate::denies('update-post',$post))
        // {    
        //     abort(403, "You can't edit this blog post!");
        // }
        //End

        //Start 2 Method how to authorize user on action(method)
        // $this->authorize('posts.update', $post);
        //End

        //Start 3 Method how to authorize user on action(method)
        // $this->authorize('update',$post);
        //End

        //Start 4 Method how to authorize user on action(method)
        $this->authorize($post);
        //End

        return view('posts.edit',['post'=>$post]);
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
        $post=BlogPost::findOrFail($id);
        
        // if (Gate::denies('update-post',$post))
        // {
        //     abort(403, "You can't edit this blog post!");
        // }
        // $this->authorize('posts.update', $post);

        // $this->authorize('update', $post);

        $this->authorize($post);

        $validatedData=$request->validated();
        $post->fill($validatedData);
        $post->save();

        $request->session()->flash('status','Blog post was updated!');

        return redirect()->route('posts.show',['post'=>$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $post=BlogPost::findOrFail($id);
        // $this->authorize('posts.delete', $post);
        $this->authorize($post);
        $post->delete();

        $request->session()->flash('status','Blog post was deleted!');
        return redirect()->route('posts.index');
    }
}
