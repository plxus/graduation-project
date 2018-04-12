<div class="media repo-flow-item">
  {{-- 信息流条目左侧：头像 --}}
  <div class="media-left">
    <a href="{{ route('users.show', $repoAuthor->id) }}" target="_blank">
      <img src="{{ $repoAuthor->gravatar('100') }}" alt="{{ $repoAuthor->name }}.'_avatar'" class="flow-user-avatar img-rounded" width="50px"/>
    </a>
  </div>
  {{-- 信息流条目右侧 --}}
  <div class="media-body">
    <div class="flow-top-row">
      {{-- 知识清单作者 --}}
      <span class="flow-user-name">
        <a href="{{ route('users.show', $repoAuthor->id) }}" target="_blank">{{ $repoAuthor->name }}</a>
      </span>
      {{-- 创建时间 --}}
      <span class="flow-timestamp pull-right small">
        {{ $feed_item->created_at->diffForHumans() }}
      </span>
    </div>
    {{-- 知识清单标题 --}}
    <div class="flow-repo-title">
      <a href="{{ route('repositories.show', $feed_item->id) }}" target="_blank">{{ $feed_item->title }}</a>
      @if ($feed_item->is_private)
        <span class="small-p">&emsp;<i class="fas fa-lock icon-gray-active"></i></span>
      @endif
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
