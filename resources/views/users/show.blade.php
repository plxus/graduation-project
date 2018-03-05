@extends('layouts.default')

@section('title', $user->name)

@section('content')
  <div class="container">
    <h1>用户主页</h1>
    {{ $user->name }} - {{ $user->email }}
  </div>
@stop
