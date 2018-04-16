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

{{-- 关注/取消关注用户的按钮 --}}
{{-- 发私信按钮&表单 --}}
@if ($user->id !== Auth::user()->id)
  <div class="user-social text-center">
    <div class="follow-form">
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
    <br />
    <div class="msg-form">
      <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#message" aria-expanded="false" aria-controls="message">
        &emsp;发私信&emsp;
      </button>
      <div class="collapse" id="message">
        <br />
        <div class="panel panel-success">
          <div class="panel-body">
            <form action="#" method="post">

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
