<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $categories_level_1 = DB::table('categories')->pluck('category_level_1')->toArray();

        $repositories = DB::table('repositories')
            ->join('users', 'users.id', '=', 'repositories.user_id')
            ->select('repositories.*', 'users.name')
            ->orderBy('repositories.created_at')
            ->paginate(20);

        return view('home', compact('categories_level_1', 'repositories'));
    }
}
