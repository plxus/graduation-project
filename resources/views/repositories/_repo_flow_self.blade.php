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
        {{ $feed_item->created_at->diffForHumans() }}
      </span>
    </div>
    {{-- 知识清单简介 --}}
    <div class="flow-repo-description">
      <p class="small-p">
        {{ $feed_item->description }}
      </p>
    </div>
    {{-- 类别 --}}
    <span class="pull-right small-p"><i class="fas fa-th-list icon-gray"></i>&nbsp;{{ $repoCategory->category_level_1 }}</span>
  </div>
</div>
