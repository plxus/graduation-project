@extends('layouts.default')

@section('title', '用户列表')

@section('content')
  <div class="col-md-offset-2 col-md-8">
    <h2>所有用户</h2>
    <ul class="users">
      @foreach ($users as $user)
        <li>
          <a href="{{ route('users.show', $user->id )}}" class="username">{{ $user->name }}</a>
        </li>
      @endforeach
    </ul>
  </div>
@stop
