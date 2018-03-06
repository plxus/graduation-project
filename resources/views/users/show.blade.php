@extends('layouts.default')

@section('title', $user->name)

@section('content')
  <div class="container">
    <h1>用户主页<br>测试 Test</h1>
    <p>
      <a href="#">{{ $user->name }} - {{ $user->email }} <br />
        {{ $user->bio }}
      </a>
    </p>
  </div>
@stop
