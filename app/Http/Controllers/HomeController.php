<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use App\Repository;

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
        // 获取所有类别
        $categories_level_1 = DB::table('repo_categories')->pluck('category_level_1')->toArray();

        // 获取首页信息流中的条目
        $feed_items = [];
        if (Auth::check()) {
            $feed_items = Auth::user()->feed()->paginate(20);
        }

        // foreach ($repositories as $repository) {
        //     $users = [];
        //     $user = User::find($repository->user_id);
        //     $users->;
        // }

        return view('home', compact('categories_level_1', 'feed_items'));
    }
}
