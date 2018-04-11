<div class="media user-flow-item" id="following_item_{{ $following->id }}">
  <div class="media-left">
    <a href="{{ route('users.show', $following->id) }}">
      <img src="{{ $following->gravatar('100') }}" alt="{{ $following->name }}" class="flow-user-avatar img-rounded" width="50px"/>
    </a>
  </div>

  <div class="media-body">
    {{-- 当前用户访问自己的个人主页 --}}
    @if ($user->id === Auth::user()->id)
      @if (Auth::user()->isFollowing($following->id))
        {{-- 取消关注按钮 --}}
          <form method="post">
            <input type="hidden" name="unfollow_id" value="{{ $following->id }}"/>
            <button type="button" id="" class="btn btn-default btn-sm flow-follow-btn pull-right btn_unfollow">&nbsp;取消关注&nbsp;</button>
          </form>
      @else
        {{-- 关注按钮 --}}
        <form action="{{ route('follows.store', $following->id) }}" method="post">
          {{ csrf_field() }}
          <button type="submit" class="btn btn-primary btn-sm flow-follow-btn pull-right">&nbsp;关注&nbsp;</button>
        </form>
      @endif
    @endif

    <div class="flow-top-row">
      <span class="flow-user-name">
        <a href="{{ route('users.show', $following->id) }}">{{ $following->name }}</a>
      </span>
    </div>

    <div class="flow-user-bio small-p">
      {{ $following->bio }}
    </div>
  </div>
</div>
