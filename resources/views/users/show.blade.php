@extends('layouts.default')

@section('title', $user->name)

@section('content')
  <div class="container">
    <div class="row">

      <div class="col-md-4 user-profile-left">
        {{-- 用户个人信息 --}}
        <p class="text-center">
          <img src="{{ $user->gravatar('300') }}" alt="{{ $user->name.'_avatar' }}" class="img-thumbnail" width="160px"/>
        </p>
        <h2 class="text-center">
          {{ $user->name }}
        </h2>
        <p class="text-center">
          {{ $user->bio }}
        </p>
        <br />
        <p>
          <i class="far fa-envelope icon-gray"></i>&nbsp;<a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
        </p>
      </div>

      <div class="col-md-8">
        {{-- Nav tabs --}}
        <ul class="nav nav-tabs nav-justified" role="tablist">
          <li role="presentation" class="active"><a href="{{ route('users.show', $user->id) }}#posts" aria-controls="posts" role="tab" data-toggle="tab">我发布的</a></li>
          <li role="presentation"><a href="{{ route('users.show', $user->id) }}#stars" aria-controls="stars" role="tab" data-toggle="tab">我收藏的</a></li>
          <li role="presentation"><a href="{{ route('users.show', $user->id) }}#following" aria-controls="following" role="tab" data-toggle="tab">我关注的用户</a></li>
          <li role="presentation"><a href="{{ route('users.show', $user->id) }}#followers" aria-controls="followers" role="tab" data-toggle="tab">我的关注者</a></li>
        </ul>

        {{-- Tab panes --}}
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="posts">我发布的</div>
          <div role="tabpanel" class="tab-pane" id="stars">我收藏的</div>
          <div role="tabpanel" class="tab-pane" id="following">我关注的用户</div>
          <div role="tabpanel" class="tab-pane" id="followers">我的关注者</div>
        </div>
        {{-- Tab 栏 --}}
      </div>
    </div>
  </div>
@stop
