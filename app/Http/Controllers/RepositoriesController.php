<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Repository;
use Auth;
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
      'category' => 'required|string',
      'content' => 'required',
      'copyright' => 'required|string',  // allow 允许转载，limit 需授权，forbid 禁止转载。
      'is_private' => 'required',
      'create' =>'required|value:true'
    ]);

        Auth::user()->repositories()->create([
      'title' => $request->title,
      'description' => $request->description,
      'content' => $request->content,
      'category_level_1' => $request->category,
      'copyright' => $request->copyright,
      'is_private' => $request->is_private,
    ]);
        return redirect()->route('/');
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
        // $repoAuthor = User::find($repository->user_id);  // 该知识清单的作者实例
        $repoAuthor = $repository->user;  // 该知识清单的作者实例
        $repoCategory = $repository->category;  // 该知识清单的类别实例
        $repoStarNum = $repository->starNum();  // 知识清单收藏数
        return view('repositories.show', compact('repository', 'repoAuthor', 'repoCategory', 'repoStarNum'));
    }

    /**
    * Show the form for editing the specified resource.
    * 返回修改知识清单的视图。
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    * 处理修改知识清单表单提交的数据。
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        //
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
        $repository->delete();
        session()->flash('success', '该知识清单已被删除。');
        return redirect()->route('/');
    }
}
