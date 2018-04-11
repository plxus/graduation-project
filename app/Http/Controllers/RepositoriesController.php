<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Star;
use App\Repository;
use App\Tag;
use Auth;
use App\Revision;
use TCG\Voyager\Http\Controllers\VoyagerBreadController;

class RepositoriesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth', [
      'except' => [''],
    ]);
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
  }

  /**
  * Show the form for creating a new resource.
  * 返回创建资源视图。
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    // 获取所有类别记录
    $category_items = DB::table('repo_categories')->get()->toArray();
    return view('repositories.create', compact('category_items'));
  }

  /**
  * Store a newly created resource in storage.
  * 处理创建资源表单提交的数据。
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $this->validate($request, [
      'title' => 'required|string|max:191',
      'description' => 'nullable|string|max:191',
      'category_id' => 'required|integer',
      'taggles' => 'nullable',
      'content' => 'required|string',
      'copyright' => 'required|string',  // allow 允许转载，limit 需授权，forbid 禁止转载。
      'is_private' => 'required',
    ]);

    $repository = Auth::user()->repositories()->create([
      'title' => $request->title,
      'description' => $request->description,
      'category_id' => $request->category_id,
      'content' => nl2br($request->content),  // 将 \n 换行符替换为 <br />
      'copyright' => $request->copyright,
      'is_private' => $request->is_private,
    ]);

    foreach ($request->input('taggles') as $tag) {
      $repository->tags()->create([
        'repository_id' => $repository->id,
        'name' => $tag,
      ]);
    }

    session()->flash('success', '知识清单创建成功');

    return redirect()->route('repositories.show', $repository->id);
  }

  /**
  * Display the specified resource.
  * 返回展示资源的视图。
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show(Repository $repository)
  {
    $repoAuthor = $repository->user;  // 该知识清单的作者实例
    $repoTags = $repository->tags;  // 该知识清单的标签
    $repoCategory = $repository->category;  // 该知识清单的类别实例
    $repoStarNum = $repository->starNum();  // 该知识清单的收藏数
    $repoRevisions = $repository->revisions()->orderBy('created_at', 'desc')->get();  // 该知识清单的修订
    return view('repositories.show', compact('repository', 'repoAuthor', 'repoTags', 'repoCategory', 'repoStarNum', 'repoRevisions'));
  }

  /**
  * Show the form for editing the specified resource.
  * 返回修订知识清单的视图。
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit(Repository $repository)
  {
    $this->authorize('update', $repository);
    $category_items = DB::table('repo_categories')->get()->toArray();  // 获取所有类别记录
    $repoTags = $repository->tags;  // 该知识清单的标签实例
    $repoCategory = $repository->category;  // 该知识清单的类别实例
    return view('repositories.edit', compact('repository', 'category_items', 'repoTags', 'repoCategory'));
  }

  /**
  * Update the specified resource in storage.
  * 处理修订知识清单表单提交的数据。
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update(Repository $repository, Request $request)
  {
    $this->validate($request, [
      'title' => 'required|string|max:191',
      'description' => 'nullable|string|max:191',
      'category_id' => 'required|integer',
      'taggles' => 'nullable',
      'content' => 'required|string',
      'copyright' => 'required|string',  // allow 允许转载，limit 需授权，forbid 禁止转载。
      'is_private' => 'required',
      'log' => 'required|string|max:191',
    ]);

    $this->authorize('update', $repository);

    $data = [
      'title' => $request->title,
      'description' => $request->description,
      'category_id' => $request->category_id,
      'content' => str_replace(["\r\n", "\n"], "<br />", $request->content),  // 将 \n、\r\n 换行符替换为 <br />
      'copyright' => $request->copyright,
      'is_private' => $request->is_private,
    ];

    // 更新知识清单
    $repository->update($data);

    // 更新知识清单的标签
    Tag::where('repository_id', $repository->id)->delete();
    foreach ($request->input('taggles') as $tag) {
      $repository->tags()->create([
        'repository_id' => $repository->id,
        'name' => $tag,
      ]);
    }

    // 添加修订记录
    $repository->revisions()->create([
      'repository_id' => $repository->id,
      'log' => $request->log,
    ]);

    session()->flash('success', '该知识清单已修订');

    return redirect()->route('repositories.show', $repository->id);
  }

  /**
  * Remove the specified resource from storage.
  * 处理删除知识清单表单提交的数据。
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function destroy(Repository $repository)
  {
    $this->authorize('destroy', $repository);

    // 删除标签表中的相关记录
    Tag::where('repository_id', $repository->id)->delete();
    // 删除收藏表中的相关记录
    Star::where('repository_id', $repository->id)->delete();
    // 删除修订表中的相关记录
    Revision::where('repository_id', $repository->id)->delete();
    // 删除知识清单表中的记录
    $repository->delete();

    session()->flash('success', '该知识清单已被删除');
    return redirect()->route('home');
  }
}
