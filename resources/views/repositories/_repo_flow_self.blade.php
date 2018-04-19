<div class="media repo-flow-item">
  <div class="media-body">
    <div class="flow-top-row-no-avatar">
      {{-- 知识清单标题 --}}
      <span class="flow-repo-title">
        <a href="{{ route('repositories.show', $feed_item->id) }}" target="_blank">{{ $feed_item->title }}</a>
        @if ($feed_item->is_private)
          <span class="small-p">&emsp;<i class="fas fa-lock icon-gray-active"></i></span>
        @endif
      </span>
      {{-- 创建时间 --}}
      <span class="flow-timestamp pull-right small">
        创建于&nbsp;{{ $feed_item->created_at->diffForHumans() }}
      </span>
    </div>
    {{-- 知识清单简介 --}}
    <div class="flow-repo-description">
      <p class="small-p">
        {{ $feed_item->description }}
      </p>
    </div>
    {{-- 收藏数，类别 --}}
    <span class="pull-right small-p gray-p bold-5">
      <span><i class="fas fa-star icon-gray"></i>&nbsp;{{ $feed_item->star_num }}</span>
      &emsp;
      <span><i class="fas fa-th-list icon-gray"></i>&nbsp;{{ $repoCategory->category_level_1 }}</span>
    </span>
  </div>
</div>
