<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // blog posts controller
    public function index(){
        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $blogs = DB::table('blogs')->join('users', 'users.id', '=', 'blogs.author')->select('users.username', "blogs.*")->where('author_role', 'admin')->inRandomOrder()->paginate(20);
        $recent = DB::table('blogs')->join('users', 'users.id', '=', 'blogs.author')->select('users.username', "blogs.*")->where('author_role', 'admin')->orderBy('created_at', 'desc')->limit(15)->get();

        $url = url('storage/' . $details->profile_photo);
        return view('blogs.index', [
            'blogs' => $blogs,
            'recent' => $recent,
            'title' => 'Blogs',
            'url' => url('storage/'),
            'base' => $url,
            'header' => $this->user_details()
        ]);
    }

    // create blog page
    public function create(){
        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        // $url = url('storage/' . $details->profile_photo);
        return view('blogs.create_blog', [
            // 'base' => $url,
            'title' => 'Create Blog',
            'header' => $this->user_details()
        ]);
    }

    // read post
    public function read(int $id, string $title){
        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $single = DB::table('blogs')->join('users', 'users.id', '=', 'blogs.author')->select('users.username', "blogs.*")->where(['blogs.id' => $id, 'title' => $title])->first();
        $blogs = DB::table('blogs')->join('users', 'users.id', '=', 'blogs.author')->select('users.username', "blogs.*")->where('author_role', 'admin')->inRandomOrder()->get();
        $recent = DB::table('blogs')->join('users', 'users.id', '=', 'blogs.author')->select('users.username', "blogs.*")->where('author_role', 'admin')->orderBy('created_at', 'desc')->limit(15)->get();

        $url = url('storage/' . $details->profile_photo);
        return view('blogs.post', [
            'single' => $single,
            'blogs' => $blogs,
            'recent' => $recent,
            'title' => $title,
            'url' => url('storage/'),
            'base' => $url,
            'header' => $this->user_details()
        ]);
    }
    
    // create blog post
    public function store(Request $request) :RedirectResponse
    {
        $this->validateInputs($request);
        $validated = $request->validate([
            'image' => ['image']
        ]);

        if($request->has('image')){
            $imagePath = $request->file('image')->store('postthumnail', 'public');
            $validated['image'] = $imagePath;
            $thumbnail = $validated['image'];
        }
        else{
            $thumbnail = 'no thumb';
        }
        if(DB::table('blogs')->where('title', '=', $request->tile)->where('body', '=', $request->article)->doesntExist()){
            $blog = Blog::create([
                'author' => Auth::id(),
                'title' => $request->title,
                'thumbnail' => $thumbnail,
                'author_role' => Auth::user()->role,
                'body' => $request->article
            ]);

            // $notifications = Notification::create([
            //     'userid' => Auth::id(),
            //     'subject' => 'Blog post successfully created'
            // ]);
    
            return Redirect::route('blogs')->with('status', 'blog-created');
        }
        return Redirect::route('blogs')->with('status', 'blog-exist');

    }

    // my post
    // public function mypost(){
    //     $details = DB::table('user_details')->where('userid', Auth::id())->first();
    //     $myblogs = DB::table('blogs')->join('users', 'users.id', '=', 'blogs.author')->select('users.username', "blogs.*")->where('author', Auth::id())->get();

    //     $url = url('storage/' . $details->profile_photo);
    //     return view('blogs.myposts', [
    //         'myblogs' => $myblogs,
    //         'url' => url('storage/'),
    //         'title' => 'My Post',
    //         'base' => $url,
    //         'header' => $this->user_details()
    //     ]);
    // }

    // edit blogpost
    public function editpost(int $id, string $title)
    {
        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $blogpost = DB::table('blogs')->where(['id' => $id, 'title' => $title])->first();
        if($blogpost->author == Auth::id()){
            // $url = url('storage/' . $details->profile_photo);
            return view('blogs.editblog', [
                // 'base' => $url,
                'title' => 'Edit Blog Post',
                'blogpost' => $blogpost,
                'url' => url('storage/'),
                'header' => $this->user_details()
            ]);
        }
        else{
            $url = url('storage/' . $details->profile_photo);
            return view('blogs.index', [
                'base' => $url,
                'title' => 'Blogs',
                'header' => $this->user_details()
            ]);
        }
    }

    // update blog post
    public function updateblog(Request $request): RedirectResponse
    {
        $deleteThumbnail = DB::table('blogs')->where('id', $request->blog)->first();
        $request->validate([
            'blog' => ['required', 'integer']
        ]);
        $this->validateInputs($request);
        $validated = $request->validate([
            'image' => ['image']
        ]);
        if($request->has('image')){
            $imagePath = $request->file('image')->store('postthumnail', 'public');
            $validated['image'] = $imagePath;
            $thumbnail = $validated['image'];
        }
        else{
            $thumbnail = 'no thumb';
        }
        if($deleteThumbnail->thumbnail != 'no thumb'){
            Storage::disk('public')->delete($deleteThumbnail->thumbnail);
        }
        $blog = DB::table('blogs')->where('id', $request->blog)->update([
            'title' => $request->title,
            'body' => $request->article,
            'thumbnail' => $thumbnail
        ]);
        return Redirect::route('blogs')->with('status', 'blog-updated');
    }

    // delete blogpost
    public function deletepost(int $id, string $title){

        $details = DB::table('user_details')->where('userid', Auth::id())->first();
        $blogpost = DB::table('blogs')->where(['id' => $id, 'title' => $title])->first();
        if($blogpost->author == Auth::id()){
            Storage::disk('public')->delete($blogpost->thumbnail);
            $deleted = DB::table('blogs')->where(['id' => $id, 'title' => $title])->delete();
            return Redirect::route('blogs')->with('status', 'blog-deleted');
        }
        else{
            $url = url('storage/' . $details->profile_photo);
            return view('blogs.index', [
                'base' => $url,
                'title' => 'Blogs',
                'header' => $this->user_details()]
            );
        }
    }

    public function validateInputs(Request $request){
        $request->validate([
            'title' => ['required', 'string', 'max:225'],
            'article' => ['required', 'string'],
            'thumnail' => ['photo']
        ]);
    }

    public function user_details(){
        
        $details = DB::table('user_details')->where('userid', '=', Auth::id())->first();
        $notification = DB::table('notifications')->where(['userid' => Auth::id(), 'state' => 'new'])->get();
        $transaction = DB::table('transactions')->where(['userid' => Auth::id(), 'state' => 'new'])->get();
        
        // pass all user necesarry data to the view
        $nav_header = [
            'details' => $details,
            'notification' => $notification,
            'transaction' => $transaction
        ];

        return $nav_header;
    }
}