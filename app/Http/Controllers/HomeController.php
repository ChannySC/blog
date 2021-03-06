<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
 
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
    // By joining this two table I will be able to get the name of the author of our posts.
    public function index()
    {   
         $posts = DB::table('users')->leftjoin('posts', 'users.id', '=', 'posts.author')->paginate(10);
        return view('home', ['posts' => $posts]);
    }
    //function when we click on botton Post will show create post
    public function getPostForm() {
        return view('post/post_form');
    }
    // create post add to database
     public function createPost(Request $request){
        $post = Post::create(array(
            'title' => Input::get('title'),
            'description' => Input::get('description'),
            'author' => Auth::user()->id
        ));
        return redirect()->route('home')->with('success', 'Post has been successfully added!');
    }



    public function getPost($id){
        $post = Post::find($id);
        return view('post/post_detail', ['post' => $post]);
    }
}