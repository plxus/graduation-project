<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
  // 静态页面控制器，用于生成静态页面的视图。继承 Controller 类。

  // 首页
  public function home()
  {
      return view('static_pages/home');
  }

  // 关于页
  public function about()
  {
      return view('static_pages/about');
  }
}
