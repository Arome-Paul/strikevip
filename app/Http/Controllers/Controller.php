<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function blogs(){
        $blogs = DB::table('blogs')->where('author_role', 'admin')->inRandomOrder()->paginate(20);
        $recent = DB::table('blogs')->where('author_role', 'admin')->orderBy('created_at', 'desc')->limit(15)->get();

        
        return view('blogs', [
            'blogs' => $blogs,
            'recent' => $recent,
            'title' => 'Blogs',
            'url' => url('storage/'),
        ]);
    }

    public function blogread(int $id, string $title){
        $single = DB::table('blogs')->where(['blogs.id' => $id, 'title' => $title])->first();
        $blogs = DB::table('blogs')->where('author_role', 'admin')->inRandomOrder()->get();
        $recent = DB::table('blogs')->where('author_role', 'admin')->orderBy('created_at', 'desc')->limit(15)->get();

        return view('read', [
            'single' => $single,
            'blogs' => $blogs,
            'recent' => $recent,
            'title' => $title,
            'url' => url('storage/'),
        ]);
    }
    public function about(){
        
    }
    public function contact(){
        
    }
    public function tnc(){
        
    }
}
