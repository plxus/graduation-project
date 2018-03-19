<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Repository;
use Auth;

class RepositoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        //
    }

    /**
    * Show the form for creating a new resource.
    * 返回创建资源视图。
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $categories_level_1 = DB::table('categories')->pluck('category_level_1')->toArray();
        return view('repositories.create', compact('categories_level_1'));
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
    public function show($id)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    * 返回编辑资源的视图。
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
