<div class="media user-flow-item" id="following_item_{{ $following->id }}">
  {{-- 用户头像 --}}
  <div class="media-left">
    <a href="{{ route('users.show', $following->id) }}">
      <img src="{{ $following->gravatar('100') }}" alt="{{ $following->name }}" class="flow-user-avatar img-rounded" width="50px"/>
    </a>
  </div>

  <div class="media-body">
    {{-- 用户名 --}}
    <div class="flow-top-row">
      <span class="flow-user-name">
        <a href="{{ route('users.show', $following->id) }}">{{ $following->name }}</a>
      </span>
    </div>
    {{-- 用户个人简介 --}}
    <div class="flow-user-bio small-p">
      {{ $following->bio }}
    </div>
  </div>
</div>
