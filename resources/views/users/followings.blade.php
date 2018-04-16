@extends('layouts.default')

@section('title', $user->name.' 关注的用户')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        {{-- 错误提示 --}}
        @include('shared._errors')
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 user-profile">
        {{-- 用户个人信息视图 --}}
        @include('users._user_profile', ['user' => $user])
      </div>

      <div class="col-md-8">
        {{-- Nav tabs --}}
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation"><a href="{{ route('users.show', $user->id) }}" aria-controls="posts" role="tab">&emsp;发布的知识清单 <span class="badge">{{ $user->repositories->count() }}</span>&emsp;</a></li>
          <li role="presentation"><a href="{{ route('users.stars', $user->id) }}" aria-controls="stars" role="tab">&emsp;收藏的知识清单 <span class="badge">{{ $user->stars->count() }}</span>&emsp;</a></li>
          {{-- 激活 --}}
          <li role="presentation" class="active"><a href="{{ route('users.followings', $user->id) }}" aria-controls="following" role="tab">&emsp;关注的用户 <span class="badge">{{ $user->followings->count() }}</span>&emsp;</a></li>
          <li role="presentation"><a href="{{ route('users.followers', $user->id) }}" aria-controls="followers" role="tab">&emsp;关注者 <span class="badge">{{ $user->followers->count() }}</span>&emsp;</a></li>
        </ul>

        {{-- Tab panes --}}
        <div class="tab-content">
          {{-- 用户发布的知识清单 --}}

          {{-- 用户收藏的知识清单 --}}

          {{-- 用户关注的其他用户 --}}
          <div role="tabpanel" class="tab-pane fade in active" id="following">
            <div class="repo-flow-order">
              排序：最新
            </div>
            @if (count($followings))
              @foreach ($followings as $following)
                @include('users._following_flow')
              @endforeach
              {!! $followings->render() !!}
            @else
              <h4 class="msg-no-item text-center">暂无关注的用户</h4>
            @endif
          </div>

          {{-- 用户的关注者 --}}

        </div>
        {{-- Tab 栏 --}}
      </div>
    </div>
  </div>
@stop

@section('script')

@stop
