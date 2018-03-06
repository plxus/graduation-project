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
        <div class="col-md-12">
          <p>
            用户已登录
          </p>
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
