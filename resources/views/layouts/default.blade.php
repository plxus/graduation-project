<?php
use Illuminate\Support\Facades\Auth;
?>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', '知识清单管理系统') - 知所</title>

  {{-- Stylesheet --}}
  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="/css/bootstrap-theme-paper.css">
  {{-- slick 图片轮播插件 --}}
  <link rel="stylesheet" href="/css/slick.css">
  <link rel="stylesheet" href="/css/slick-theme.css">
  {{-- 自定义 CSS --}}
  @yield('style', '')
  <link rel="stylesheet" href="/css/style.css">
</head>

<body>
  {{--  页眉  --}}
  @include('layouts._header')

  {{-- 消息提示框 --}}
  <div class="container">
    @include('shared._messages')
  </div>

  {{--  主体内容  --}}
  @yield('content')

  {{--  页脚  --}}
  @include('layouts._footer')

  <!-- Scripts -->
  <script src="/js/app.js"></script>
  {{-- fontawesome --}}
  <script src="/js/fontawesome-all.min.js"></script>
  {{-- textarea 自适应高度 --}}
  <script src="/js/autosize.min.js"></script>
  {{-- slick 图片轮播插件 --}}
  <script src="/js/slick.min.js"></script>
  {{-- 取消表单项按回车触发提交表单的操作 --}}
  <script>
  $("form.noreact-enter").keydown(function(){
    if(event.keyCode == 13){
      return false;
    }
  });
  </script>
  {{-- 自定义脚本 --}}
  @yield('script', '')
</body>
</html>
