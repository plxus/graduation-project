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

  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="/css/bootstrap-theme-paper.css">
  <link rel="stylesheet" href="/css/style.css">
  {{-- 自定义 CSS --}}
  @yield('style', '')
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
  <script src="/js/fontawesome-all.min.js"></script>
  <script src="/js/autosize.min.js"></script>
  {{-- 自定义脚本 --}}
  @yield('script', '')
</body>
</html>
