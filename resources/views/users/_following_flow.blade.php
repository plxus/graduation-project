<div class="media user-flow-item">
  <div class="media-left">
    <a href="{{ route('users.show', $following->id) }}">
      <img src="{{ $following->gravatar('100') }}" alt="{{ $following->name }}" class="flow-user-avatar img-rounded" width="50px"/>
    </a>
  </div>
  <div class="media-body">
    @if ($user->id === Auth::user()->id)
      {{-- 当前用户访问自己的个人主页 --}}
      {{-- <span class="flow-follow-form pull-right"> --}}
        @if (Auth::user()->isFollowing($following->id))
          <form action="{{ route('follows.destroy', $following->id) }}" method="post">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-default btn-sm flow-follow-btn pull-right">取消关注</button>
          </form>
        @else
          <form action="{{ route('follows.store', $following->id) }}" method="post">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary btn-sm flow-follow-btn pull-right">&emsp;关注&emsp;</button>
          </form>
        @endif
      {{-- </span> --}}
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
