<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Category;
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
  * 首页视图
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Request $request)
  {
    // 获取所有类别记录
    $category_items = Category::all();

    // 根据排序选项设置相应的查询
    $sort_rule = 'created_at';
    if($request->input('sort') !== null){
      if($request->input('sort') === 'star_num'){
        $sort_rule = 'star_num';
      }
      if($request->input('sort') === 'created_at'){
        $sort_rule = 'created_at';
      }
      if($request->input('sort') === 'updated_at'){
        $sort_rule = 'updated_at';
      }
    }

    // 获取首页信息流中的条目（默认为当前用户发布的，以及其关注的用户公开发布的知识清单）
    $feed_items = [];
    if (Auth::check()) {
      $feed_items = Repository::where('user_id', Auth::user()->id)
      ->orWhere(function($query){
        $following_ids = Auth::user()->followings->pluck('id')->toArray();  // 关注用户的 ID
        $query->where('is_private', false)
        ->whereIn('user_id', $following_ids);
      })
      ->with('user')
      ->orderBy("$sort_rule", 'desc')->paginate(20);
      // 使用了 Eloquent 关联的预加载 with 方法，预加载避免了 N+1 查找的问题
    }

    return view('home', compact('category_items', 'feed_items', 'sort_rule'));
  }

  // 搜索结果视图
  // 搜索结果的信息流中不包含任何私有的知识清单
  public function search(Request $request)
  {
    // 根据排序选项设置相应的查询
    $sort_rule = 'created_at';
    if($request->input('sort') !== null){
      if($request->input('sort') === 'star_num'){
        $sort_rule = 'star_num';
      }
      if($request->input('sort') === 'created_at'){
        $sort_rule = 'created_at';
      }
      if($request->input('sort') === 'updated_at'){
        $sort_rule = 'updated_at';
      }
    }

    if ($request->keywords !== null) {
      $this->validate($request, [
        'keywords' => 'required|string|max:191',
      ]);
    }

    if ($request->category !== null) {
      $this->validate($request, [
        'category' => 'required',
      ]);
    }

    if ($request->tag !== null) {
      $this->validate($request, [
        'tag' => 'required|string|max:191',
      ]);
    }

    // 获取关键词的搜索结果
    if ($request->keywords !== null && $request->category == null) {
      $feed_items = Repository::whereRaw('is_private = false and (title like \'%'.$request->keywords.'%\' or description like \'%'.$request->keywords.'%\')')
      ->with('user')
      ->orderBy("$sort_rule", 'desc')
      ->paginate(20);
      $search_keywords = $request->keywords;  // 搜索关键词
      $search_category_id = 'all';  // 搜索类别 ID（all）
      $search_category = '全部类别';  // 搜索类别名
    }

    // 获取指定类别的搜索结果
    if ($request->category !== null && $request->keywords == null) {
      // 全部类别
      if ($request->category === 'all') {
        $feed_items = Repository::where('is_private', false)
        ->with('user')
        ->orderBy("$sort_rule", 'desc')
        ->paginate(20);
        $search_category_id = $request->category;  // 搜索类别 ID（all）
        $search_category = '全部类别';  // 搜索类别名
      }
      // 指定类别
      else {
        $feed_items = Repository::where('is_private', false)
        ->where('category_id', $request->category)
        ->with('user')
        ->orderBy("$sort_rule", 'desc')
        ->paginate(20);
        $search_category_id = $request->category;  // 搜索类别 ID
        $search_category = Category::find($request->category)->category_level_1;  // 搜索类别名
      }
    }

    // 获取关键词+指定类别的搜索结果
    if ($request->keywords !== null && $request->category !== null) {
      // 全部类别
      if ($request->category === 'all') {
        $feed_items = Repository::whereRaw('is_private = false and (title like \'%'.$request->keywords.'%\' or description like \'%'.$request->keywords.'%\')')
        ->with('user')
        ->orderBy("$sort_rule", 'desc')
        ->paginate(20);
        $search_keywords = $request->keywords;  // 搜索关键词
        $search_category_id = $request->category;  // 搜索类别 ID（all）
        $search_category = '全部类别';
      }
      // 指定类别
      else {
        $feed_items = Repository::where('category_id', $request->category)
        ->whereRaw('is_private = false and (title like \'%'.$request->keywords.'%\' or description like \'%'.$request->keywords.'%\')')
        ->with('user')
        ->orderBy("$sort_rule", 'desc')
        ->paginate(20);
        $search_keywords = $request->keywords;  // 搜索关键词
        $search_category_id = $request->category;  // 搜索类别 ID
        $search_category = Category::find($request->category)->category_level_1;  // 搜索类别名
      }
    }

    // 无搜索关键词和指定类别
    if ($request->keywords == null && $request->category == null && $request->tag == null) {
      $feed_items = null;
      return redirect()->route('home');
    }

    // 获取标签名的搜索结果
    if ($request->tag !== null) {
      // 有标签和关键词
      if ($request->keywords !== null) {
        $feed_items = Repository::join('tags', 'repositories.id', '=', 'tags.repository_id')
        ->select('repositories.*', 'tags.name')
        ->where('tags.name', 'like', '%'.$request->tag.'%')
        ->whereRaw('is_private = false and (title like \'%'.$request->keywords.'%\' or description like \'%'.$request->keywords.'%\')')
        ->distinct()
        ->with('user')
        ->orderBy("$sort_rule", 'desc')
        ->paginate(20);
        $search_tag = $request->tag;  // 搜索标签名
        $search_keywords = $request->keywords;  // 搜索关键词
      }
      // 只有标签，无关键词
      else {
        $feed_items = Repository::join('tags', 'repositories.id', '=', 'tags.repository_id')
        ->select('repositories.*', 'tags.name')
        ->where([
          ['tags.name', 'like', '%'.$request->tag.'%'],
          ['is_private', false]
        ])
        ->distinct()
        ->with('user')
        ->orderBy("$sort_rule", 'desc')
        ->paginate(20);
        $search_tag = $request->tag;  // 搜索标签名
      }
    }

    return view('search', compact('feed_items', 'search_keywords', 'search_category_id', 'search_category', 'search_tag', 'sort_rule'));
  }
}
