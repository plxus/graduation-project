<div class="media repo-flow-item">
  <div class="media-body">
    <div class="flow-top-row-no-avatar">
      <span class="flow-repo-title">
        <a href="#">{{ $repository->title }}</a>
      </span>
      <span class="flow-timestamp pull-right small">
        {{ $repository->created_at->diffForHumans() }}
      </span>
    </div>
    <div class="flow-repo-description">
      <p class="small-p">
        {{ $repository->description }}
      </p>
    </div>
  </div>
</div>
