<div class="media repo-flow-item">
  <div class="media-left">
    <a href="{{ route('users.show', $user->id) }}">
      <img src="{{ $user->gravatar('100') }}" alt="{{ $user->name }}" class="flow-user-avatar img-rounded" width="50px"/>
    </a>
  </div>
  <div class="media-body">
    <div class="flow-top-row">
      <span class="flow-user-name">
        <a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a>
      </span>
      <span class="flow-timestamp pull-right small">
        {{ $repository->created_at->diffForHumans() }}
      </span>
    </div>
    <div class="flow-repo-title">
      <a href="#">{{ $repository->title }}</a>
    </div>
    <div class="flow-repo-description">
      <p class="small-p">
        {{ $repository->description }}
      </p>
    </div>
  </div>
</div>
