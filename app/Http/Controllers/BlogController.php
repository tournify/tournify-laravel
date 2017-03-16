<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $posts = Post::orderBy('created_at', 'desc')->take(10)->get();

        if (Lang::getLocale() == 'sv') {
            return view('blog')->with(['posts' => $posts, 'lang' => 'sv']);
        } else {
            return view('blog')->with(['posts' => $posts, 'lang' => 'en']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        return view('blog.create');
    }

    public function view($slug) {
        if (Lang::getLocale() == 'sv') {
            $post = Post::where(['slug' => $slug])->first();
            if ($post) {
                return view('blog.view')->with(['post' => $post, 'lang' => 'sv']);
            }
        } else {
            $post = Post::where(['slug_en' => $slug])->first();
            if ($post) {
            return view('blog.view')->with(['post' => $post, 'lang' => 'en']);
            }
        }
    }


    public function postCreate(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $input = $request->all();
            if (strlen($input['title']) > 1 && strlen($input['text']) > 1) {
                $p = Post::create(['title' => $input['title'], 'content' => $input['text'], 'title_en' => $input['entitle'], 'content_en' => $input['entext']]);
                $user->posts()->save($p);
            }
        }
        return redirect('/blog');
    }
}
