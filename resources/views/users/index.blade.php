@extends('layouts.default')

@section('title', '用户列表')

@section('content')
  <div class="row">
    <div class="col-md-offset-2 col-md-8">
      <h2>所有用户</h2>
      <ul class="list-group">
        @foreach ($users as $user)
          <li class="list-group-item">
            <img src="{{ $user->gravatar() }}" alt="{{ $user->name }}" class="img-rounded gravatar" width="30px"/>&nbsp;<a href="{{ route('users.show', $user->id ) }}" class="username">{{ $user->name }}</a>
          </li>
        @endforeach
      </ul>
      {!! $users->render() !!}
    </div>
  </div>
@stop
