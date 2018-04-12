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
          <i class="far fa-envelope icon-gray"></i>&emsp;<a href="mailto:{{ $user->email }}" target="_blank">{{ $user->email }}</a>
          @if ($user->url)
            <br />
            <i class="fas fa-globe icon-gray"></i>&emsp;<a href="{{ $user->url }}" target="_blank">{{ $user->url }}</a>
          @endif
        </p>
      </div>

      <div class="col-md-8">
        {{-- 错误提示 --}}
        @include('shared._errors')

        {{-- Nav tabs --}}
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation"><a href="{{ route('users.show', $user->id) }}" aria-controls="posts" role="tab">&emsp;发布的知识清单 <span class="badge">{{ $user->repositories->count() }}</span>&emsp;</a></li>
          {{-- 激活 --}}
          <li role="presentation" class="active"><a href="{{ route('users.stars', $user->id) }}" aria-controls="stars" role="tab">&emsp;收藏的知识清单 <span class="badge">{{ $user->stars->count() }}</span>&emsp;</a></li>
          <li role="presentation"><a href="{{ route('users.followings', $user->id) }}" aria-controls="following" role="tab">&emsp;关注的用户 <span class="badge">{{ $user->followings->count() }}</span>&emsp;</a></li>
          <li role="presentation"><a href="{{ route('users.followers', $user->id) }}" aria-controls="followers" role="tab">&emsp;关注者 <span class="badge">{{ $user->followers->count() }}</span>&emsp;</a></li>
        </ul>

        {{-- Tab panes --}}
        <div class="tab-content">
          {{-- 用户发布的知识清单 --}}

          {{-- 用户收藏的知识清单 --}}
          <div role="tabpanel" class="tab-pane fade in active" id="stars">
            <div class="repo-flow-order">
              排序：最新
            </div>
            @if (count($repositories_star))
              @foreach ($repositories_star as $feed_item)
                @include('repositories._repo_flow', ['repoAuthor' => $feed_item->user, 'repoCategory' => $feed_item->category])
              @endforeach
              {!! $repositories_star->render() !!}
            @else
              <h4 class="msg-no-item text-center">无知识清单</h4>
            @endif
          </div>

          {{-- 用户关注的其他用户 --}}

          {{-- 用户的关注者 --}}

        </div>
        {{-- Tab 栏 --}}
      </div>
    </div>
  </div>
@stop

@section('script')

@stop
