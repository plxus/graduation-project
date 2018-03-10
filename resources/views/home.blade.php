<?php
use Illuminate\Support\Facades\Auth;

// 获取当前已认证的用户
$user = Auth::user();
?>

@extends('layouts.default')

@section('title', '知识清单管理系统')

@section('content')
  <div class="container">
    @auth
      <div class="row">

        <div class="col-md-4 home-left">
          <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
              <h5>知识清单类别</h5>
            </div>
            <!-- List group -->
            <div class="list-group">
              <a href="#" class="list-group-item active">全部</a>
              <a href="#" class="list-group-item">Dapibus ac facilisis in</a>
              <a href="#" class="list-group-item">Morbi leo risus</a>
              <a href="#" class="list-group-item">Porta ac consectetur ac</a>
              <a href="#" class="list-group-item">Vestibulum at eros</a>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="row">
            {{-- 排序按钮 --}}
            <div class="btn-group float-right">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                排序 <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a href="#">按发布时间</a></li>
                <li><a href="#">按收藏数</a></li>
              </ul>
            </div>
          </div>
          FEED 信息流
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
