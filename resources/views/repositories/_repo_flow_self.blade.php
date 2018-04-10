<div class="media repo-flow-item">
  <div class="media-body">
    <div class="flow-top-row-no-avatar">
      <span class="flow-repo-title">
        <a href="{{ route('repositories.show', $feed_item->id) }}" target="_blank">{{ $feed_item->title }}</a>
      </span>
      <span class="flow-timestamp pull-right small">
        {{ $feed_item->created_at->diffForHumans() }}
      </span>
    </div>
    <div class="flow-repo-description">
      <p class="small-p">
        {{ $feed_item->description }}
      </p>
    </div>
  </div>
</div>
