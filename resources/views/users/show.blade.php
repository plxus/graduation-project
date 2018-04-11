@extends('layouts.default')

@section('title', $user->name)

@section('content')
  <div class="container">
    <div class="row">

      <div class="col-md-4 user-profile">
        {{-- 用户个人信息 --}}
        <p class="text-center">
          <img src="{{ $user->gravatar('320') }}" alt="{{ $user->name.'_avatar' }}" class="img-thumbnail" width="160px"/>
        </p>
        <h2 class="text-center">
          {{ $user->name }}
        </h2>
        <p class="text-center">
          {{ $user->bio }}
        </p>

        {{-- 关注/取消关注用户的按钮 --}}
        @if ($user->id !== Auth::user()->id)
          <div class="follow-form text-center">
            @if (Auth::user()->isFollowing($user->id))
              <form action="{{ route('follows.destroy', $user->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-default">&emsp;取消关注&emsp;</button>
              </form>
            @else
              <form action="{{ route('follows.store', $user->id) }}" method="post">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary">&emsp;关注&emsp;</button>
              </form>
            @endif
          </div>
        @else
          <div class="follow-form-blank"></div>
        @endif

        {{-- 邮箱和 URL --}}
        <p>
          <i class="far fa-envelope icon-gray"></i>&nbsp;<a href="mailto:{{ $user->email }}" target="_blank">{{ $user->email }}</a>
        </p>
        @if ($user->url)
          <p>
            <i class="fas fa-globe icon-gray"></i>&nbsp;<a href="{{ $user->url }}" target="_blank">{{ $user->url }}</a>
          </p>
        @endif
      </div>

      <div class="col-md-8">
        {{-- 错误提示 --}}
        @include('shared._errors')

        {{-- Nav tabs --}}
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#posts" aria-controls="posts" role="tab" data-toggle="tab">&emsp;发布的知识清单 <span class="badge">{{ $user->repositories->count() }}</span>&emsp;</a></li>
          <li role="presentation"><a href="#stars" aria-controls="stars" role="tab" data-toggle="tab">&emsp;收藏的知识清单 <span class="badge">{{ $user->stars->count() }}</span>&emsp;</a></li>
          <li role="presentation"><a href="#following" aria-controls="following" role="tab" data-toggle="tab">&emsp;关注的用户 <span class="badge">{{ $user->followings->count() }}</span>&emsp;</a></li>
          <li role="presentation"><a href="#followers" aria-controls="followers" role="tab" data-toggle="tab">&emsp;关注者 <span class="badge">{{ $user->followers->count() }}</span>&emsp;</a></li>
        </ul>

        {{-- Tab panes --}}
        <div class="tab-content">
          {{-- 用户发布的知识清单 --}}
          <div role="tabpanel" class="tab-pane fade in active" id="posts">
            <div class="repo-flow-order">
              排序：最新
            </div>
            @if (count($repositories))
              @foreach ($repositories as $feed_item)
                @include('repositories._repo_flow_self', ['repoCategory' => $feed_item->category])
              @endforeach
              {!! $repositories->render() !!}
            @endif
          </div>

          {{-- 用户收藏的知识清单 --}}
          <div role="tabpanel" class="tab-pane fade" id="stars">
            <div class="repo-flow-order">
              排序：最新
            </div>
            @if (count($repositories_star))
              @foreach ($repositories_star as $feed_item)
                @include('repositories._repo_flow', ['repoAuthor' => $feed_item->user, 'repoCategory' => $feed_item->category])
              @endforeach
              {!! $repositories_star->render() !!}
            @endif
          </div>

          {{-- 用户关注的其他用户 --}}
          <div role="tabpanel" class="tab-pane fade" id="following">
            <div class="repo-flow-order">
              排序：最新
            </div>
            @if (count($followings))
              @foreach ($followings as $following)
                @include('users._following_flow')
              @endforeach
              {!! $followings->render() !!}
            @endif
          </div>

          {{-- 用户的关注者 --}}
          <div role="tabpanel" class="tab-pane fade" id="followers">
            <div class="repo-flow-order">
              排序：最新
            </div>
            @if (count($followers))
              @foreach ($followers as $follower)
                @include('users._follower_flow')
              @endforeach
              {!! $followers->render() !!}
            @endif
          </div>
        </div>
        {{-- Tab 栏 --}}
      </div>
    </div>
  </div>
@stop
