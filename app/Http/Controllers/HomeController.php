<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

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
            ->where('repositories.is_private', 'false')
            ->orderBy('repositories.created_at', 'desc')
            ->paginate(20);

        // foreach ($repositories as $repository) {
        //     $users = [];
        //     $user = User::find($repository->user_id);
        //     $users->;
        // }

        return view('home', compact('categories_level_1', 'repositories'));
    }
}
