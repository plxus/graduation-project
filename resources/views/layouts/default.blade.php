<?php
use Illuminate\Support\Facades\Auth;

// 获取当前已认证的用户
$user = Auth::user();
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

  <!-- Scripts -->
  <script src="/js/app.js"></script>
  <script src="/js/fontawesome-all.min.js"></script>
</head>

<body>
  {{--  页眉  --}}
  {{-- @include('layouts._header', ['user'=>$user]) --}}
  @include('layouts._header')

  {{--  .container 类用于固定宽度并支持响应式布局的容器.  --}}
  {{--  .container-fluid 类用于 100% 宽度，占据全部视口（viewport）的容器.  --}}

  {{-- 消息提示框 --}}
  <div class="container">
    @include('shared._messages')
  </div>

  {{--  主体内容  --}}
  @yield('content')

  {{--  页脚  --}}
  @include('layouts._footer')
</body>
</html>
