<div class="media user-flow-item">
  <div class="media-left">
    <a href="{{ route('users.show', $follower->id) }}">
      <img src="{{ $follower->gravatar('100') }}" alt="{{ $follower->name }}" class="flow-user-avatar img-rounded" width="50px"/>
    </a>
  </div>
  
  <div class="media-body">
    <div class="flow-top-row">
      <span class="flow-user-name">
        <a href="{{ route('users.show', $follower->id) }}">{{ $follower->name }}</a>
      </span>
    </div>

    <div class="flow-user-bio small-p">
      {{ $follower->bio }}
    </div>
  </div>
</div>
