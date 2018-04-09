<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
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
    $this->middleware('auth', [
      'except' => ['index', 'search']
    ]);
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Request $request)
  {
    // 获取所有类别
    $category_items = DB::table('repo_categories')->get();

    // 根据排序选项设置相应的查询
    $sort_rule = 'created_at';
    if($request->input('sort_rule') !== null){
      // 按收藏数排序：可以在 repositories 表中添加一个冗余字段表示收藏数
      if($request->input('sort_rule') === 'star_num'){
        $sort_rule = 'star_num';
      }
      if($request->input('sort_rule') === 'created_at'){
        $sort_rule = 'created_at';
      }
    }

    // 获取搜索结果
    if ($request->input('keywords') !== null) {
      $feed_items = Repository::where('title', 'like', '%'.$request->input('keywords').'%')->orWhere('description', 'like', '%'.$request->input('keywords').'%')->orderBy("$sort_rule", 'desc')->paginate(20);
      return view('home', compact('category_items', 'feed_items'));
    }

    // 获取类别筛选的结果
    if($request->input('category') !== null){
      if($request->input('category') === 'all'){
        // 筛选全部类别中的知识清单
        $feed_items = Repository::orderBy("$sort_rule", 'desc')->paginate(20);
        // return response()->json(['feed_items' => $feed_items]);  // JSON 响应
        return view('home', compact('category_items', 'feed_items'));
      }
      elseif (is_integer($request->input('category'))){
        // 筛选特定类别中的知识清单
        $feed_items = Repository::where('category_id','=',"$request->input('category')")->orderBy("$sort_rule", 'desc')->paginate(20);
        return view('home', compact('category_items', 'feed_items'));
      }
    }

    // 获取首页信息流中的条目（默认为当前用户和其关注的用户发布的知识清单）
    $feed_items = [];
    if (Auth::check()) {
      $feed_items = Auth::user()->feed($sort_rule)->paginate(20);
    }

    return view('home', compact('category_items', 'feed_items'));
  }

  /* // 搜索结果视图
  public function search(Request $request)
  {
  // 获取所有类别
  $categories_level_1 = DB::table('repo_categories')->pluck('category_level_1')->toArray();

  // 根据排序选项设置相应的查询

  // 获取搜索结果
  $feed_items = Repository::where('title', 'like', '%'.$request.'%')->orWhere('description', 'like', '%'.$request.'%')->orderBy('created_at', 'desc')->get();

  return view('home', compact('categories_level_1', 'feed_items'));
} */
}
