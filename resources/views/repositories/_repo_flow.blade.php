<div class="media repo-flow-item">
  <div class="media-left">
    <a href="{{ route('users.show', $repoAuthor->id) }}">
      <img src="{{ $repoAuthor->gravatar('100') }}" alt="{{ $repoAuthor->name }}.'_avatar'" class="flow-user-avatar img-rounded" width="50px"/>
    </a>
  </div>
  <div class="media-body">
    <div class="flow-top-row">
      <span class="flow-user-name">
        <a href="{{ route('users.show', $repoAuthor->id) }}">{{ $repoAuthor->name }}</a>
      </span>
      <span class="flow-timestamp pull-right small">
        {{ $feed_item->created_at->diffForHumans() }}
      </span>
    </div>
    <div class="flow-repo-title">
      <a href="{{ route('repositories.show', $feed_item->id) }}">{{ $feed_item->title }}</a>
    </div>
    <div class="flow-repo-description">
      <p class="small-p">
        {{ $feed_item->description }}
      </p>
    </div>
  </div>
</div>
