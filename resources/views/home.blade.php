<?php
use Illuminate\Support\Facades\Auth;

// 获取当前已认证的用户
$user = Auth::user();
?>

@extends('layouts.default')

@section('title', '知识清单管理系统')

@section('content')
  <div class="container">
    {{-- 错误提示 --}}
    @include('shared._errors')

    @auth
      <div class="row">

        <div class="col-md-4 home-left">
          <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
              <h5><i class="fas fa-th-list"></i> 知识清单类别</h5>
            </div>
            <div class="panel-body">
              {{-- <div class="list-group">
              <a href="#" class="list-group-item">全部</a>
            </div> --}}
            <button type="button" class="btn btn-default btn-lg btn-block">全部类别&nbsp;<span class="badge">{{ count($categories_level_1) }}</span></button>
            <br />
            <div class="form-inline">
              <div class="form-group">
                <label for="search-category">&nbsp;<i class="fas fa-search icon-gray"></i>&nbsp;</label>
                <input type="search" class="form-control" id="search-category" name="search-category" placeholder="搜索特定类别" style="width: 274px;">
              </div>
            </div>
            <br />
            <div class="category-wall">
              @foreach ($categories_level_1 as $category_level_1)
                <button class="btn btn-default btn-sm btn-category" role="button">{{ $category_level_1 }}</button>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="row home-btn-row">
          <div class="btn-group pull-right" role="group">
            {{-- 时间范围按钮 --}}
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-clock"></i> 时间范围 <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="#">近一周</a></li>
                <li><a href="#">近一个月</a></li>
                <li><a href="#">近一年</a></li>
              </ul>
            </div>

            {{-- 排序按钮 --}}
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-sort-amount-down"></i> 排序 <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="#">按发布时间</a></li>
                <li><a href="#">按收藏数</a></li>
              </ul>
            </div>
            {{-- 按钮组 --}}
          </div>
        </div>

        <div class="row home-feed-flow">
          <div class="col-md-12">
            FEED 信息流
            {{-- @if (count($repositories))
              @foreach ($repositories as $repository)
                @include('repositories._repo_flow_home')
              @endforeach
              {!! $repositories->render() !!}
            @endif --}}
          </div>
        </div>
      </div>
    </div>
  @else
    <div class="row">
      <div class="col-md-12">
        <div class="jumbotron">
          <h1>标题</h1>
          <p>
            这是示例项目主页。
          </p>
          <p>
            <a class="btn btn-lg btn-success" href="{{ route('register') }}" role="button">注册</a>
          </p>
        </div>
      </div>
    </div>
  @endauth
</div>
@stop

@section('script')
  <script src="/js/holmes.js"></script>
  <script>
  holmes({
    find: '.category-wall button'
  });
  </script>
@stop
