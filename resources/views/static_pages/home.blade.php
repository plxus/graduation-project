@extends('layouts.default')

@section('title', '知识清单管理系统')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="jumbotron">
      <h1>标题</h1>
      <p>
        这是示例项目主页。
      </p>
      <p>
        <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">注册</a>
      </p>
    </div>
  </div>
</div>
@stop
