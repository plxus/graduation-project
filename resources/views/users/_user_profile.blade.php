{{-- 用户个人信息 --}}
<p class="text-center">
  <img src="{{ $user->gravatar('320') }}" alt="{{ $user->name.'_avatar' }}" class="img-thumbnail" width="160px"/>
</p>
<h3 class="text-center">
  {{ $user->name }}
</h3>
<p class="text-center">
  {{ $user->bio }}
</p>

@if ($user->id !== Auth::user()->id)
  <div class="user-social text-center">
    {{-- 关注/取消关注用户的按钮 --}}
    <div class="follow-form">
      @if (Auth::user()->isFollowing($user->id))
        <form action="{{ route('follows.destroy', $user->id) }}" method="post">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <button type="submit" class="btn btn-default user-social-btn">&emsp;取消关注&emsp;</button>
        </form>
      @else
        <form action="{{ route('follows.store', $user->id) }}" method="post">
          {{ csrf_field() }}
          <button type="submit" class="btn btn-primary user-social-btn">&emsp;<i class="far fa-thumbs-up"></i>&nbsp;关注&emsp;</button>
        </form>
      @endif
    </div>

    <br />

    {{-- 发私信按钮 --}}
    <div class="msg-form">
      <button class="btn btn-success user-social-btn" type="button" data-toggle="collapse" data-target="#message" aria-expanded="false" aria-controls="message">
        &emsp;<i class="far fa-comment"></i>&nbsp;发私信&emsp;
      </button>
      <div class="collapse" id="message">
        <br />
        <div class="panel panel-success">
          <div class="panel-body">
            <form action="{{ route('notifications.store', $user->id)}}" method="post" class="noreact-enter">
              {{ csrf_field()}}
              <div class="form-group">
                <input type="text" class="form-control" name="msg_subject" placeholder="主题（选填）">
              </div>
              <div class="form-group">
                <textarea class="form-control autosize" name="msg_content" rows="2" placeholder="内容" required></textarea>
              </div>
              <button type="submit" class="btn btn-success pull-right">发送</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif

<hr />

{{-- 邮箱和 URL --}}
<p>
  <i class="far fa-envelope icon-gray"></i>&emsp;<a href="mailto:{{ $user->email }}" target="_blank">{{ $user->email }}</a>
  @if ($user->url)
    <br />
    <i class="fas fa-globe icon-gray"></i>&emsp;<a href="{{ $user->url }}" target="_blank">{{ $user->url }}</a>
  @endif
</p>
