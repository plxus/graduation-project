<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Repository;

class StarsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 处理用户收藏知识清单的表单提交的数据。
    public function store(Repository $repository)
    {
        if (!Auth::user()->isStar($repository->id)) {
            Auth::user()->star($repository->id);  // 收藏操作
        }

        return redirect()->route('repositories.show', $repository->id);
    }

    // 处理用户取消收藏知识清单的表单提交的数据。
    public function destroy(Repository $repository)
    {
        if (Auth::user()->isStar($repository->id)) {
            Auth::user()->unstar($repository->id);  // 取消收藏操作
        }

        return redirect()->route('repositories.show', $repository->id);
    }
}
