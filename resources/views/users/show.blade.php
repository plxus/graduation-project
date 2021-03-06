@extends('layouts.default')

@section('title', $user->name.' 个人主页')

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
          {{-- 激活 --}}
          <li role="presentation" class="active"><a href="#posts" aria-controls="posts" role="tab" data-toggle="tab">&emsp;发布的知识清单 <span class="badge">{{ $user->repositories->count() }}</span>&emsp;</a></li>
          <li role="presentation"><a href="{{ route('users.stars', $user->id) }}" aria-controls="stars" role="tab">&emsp;收藏的知识清单 <span class="badge">{{ $user->stars->count() }}</span>&emsp;</a></li>
          <li role="presentation"><a href="{{ route('users.followings', $user->id) }}" aria-controls="followings" role="tab">&emsp;关注的用户 <span class="badge">{{ $user->followings->count() }}</span>&emsp;</a></li>
          <li role="presentation"><a href="{{ route('users.followers', $user->id) }}" aria-controls="followers" role="tab">&emsp;关注者 <span class="badge">{{ $user->followers->count() }}</span>&emsp;</a></li>
        </ul>

        {{-- Tab panes --}}
        <div class="tab-content">
          {{-- 用户发布的知识清单 --}}
          <div role="tabpanel" class="tab-pane fade in active" id="posts">
            <div class="repo-flow-order">
              排序：最新发布
            </div>
            @if (count($repositories))
              @foreach ($repositories as $feed_item)
                @include('repositories._repo_flow_self', ['repoCategory' => $feed_item->category])
              @endforeach
              {!! $repositories->render() !!}
            @else
              <h4 class="msg-no-item text-center">无知识清单</h4>
            @endif
          </div>

          {{-- 用户收藏的知识清单 --}}

          {{-- 用户关注的其他用户 --}}

          {{-- 用户的关注者 --}}

        </div>
        {{-- Tab 栏 --}}
      </div>
    </div>
  </div>
@stop

@section('script')
  {{-- textarea 自动调整高度 --}}
  <script>
  autosize($('textarea.autosize'));
  </script>
@stop
