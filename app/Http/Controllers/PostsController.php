<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index','show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(10);  

        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this -> validate($request,[
           'title' => 'required',
           'body' => 'required',
           'cover_image' => 'image|nullable|max:7999' 
        ]);

        //Handle File Upload
        if($request->hasFile('cover_image')){

            //Get filename with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get file extension 
            $fileExt = $request->file('cover_image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            //Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
            // run php artisan storage:link to link storage folder with public, run only once.
        } else {
            $fileNameToStore = 'noimage.jpg';
        }

        //Create Post
        $post = new Post;
        //Assign values
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        //Getting user id
        $post->user_id = auth()->user()->id;
        //Save cover image
        $post->cover_image = $fileNameToStore;
        //Save Post
        $post->save();
        //Redirect
        return redirect('/posts')->with('success','Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        return view('posts.show')->with('post',$post); 
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
        //Check for correct user
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect('/posts')->with('error','Unauthorized Page'); 
        }
        return view('posts.edit')->with('post',$post); 
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
        $this -> validate($request,[
           'title' => 'required',
           'body' => 'required',
           'cover_image' => 'image|nullable|max:7999' 
        ]);

        //Find Post to be updated
        $post = Post::find($id);

        //Handle File Upload
        if($request->hasFile('cover_image')){

            //Get filename with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get filename
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Get file extension 
            $fileExt = $request->file('cover_image')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$fileExt;
            //Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_images',$fileNameToStore);
            // run php artisan storage:link to link storage folder with public, run only once.
        }

        //Assign values
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        //Assign cover image if the cover image was updated
        if($request->hasFile('cover_image')){
        if($post->cover_image != 'noimage.jpg'){
          //Delete old image
          Storage::delete('public/cover_images/'.$post->cover_image);
        }
          //Assign new image
          $post->cover_image = $fileNameToStore;  
        }
        //Update Post
        $post->save();
        //Redirect
        return redirect('/posts')->with('success','Post Updated');
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
        //Check for correct user
        if(auth()->user()->id !== $post->user_id)
        {
            return redirect('/posts')->with('error','Unauthorized Page'); 
        }
        //Delete image only if its not noimage
        if($post->cover_image != 'noimage.jpg'){
           //Delete image
           Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success','Post Deleted');
    }
}
