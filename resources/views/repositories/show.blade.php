@extends('layouts.default')

@section('title', $repository->title)

@section('style')
  {{-- Valine 评论系统 --}}
  <script src="/js/av-min_beta9.js"></script>
  <script src="/js/Valine_beta9.min.js"></script>
  {{-- 自定义 Valine CSS --}}
  <link rel="stylesheet" href="/css/valine.css" />
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        {{-- 错误提示 --}}
        @include('shared._errors')
      </div>
    </div>

    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="row">
          <div class="col-md-12">
            {{-- 收藏/取消收藏按钮 --}}
            @if (Auth::user()->isStar($repository->id))
              {{-- 取消收藏按钮 --}}
              <form action="{{ route('stars.destroy', $repository->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-default pull-right star-btn"><i class="fas fa-star"></i>&emsp;取消收藏&emsp;<span class="badge">{{ $repoStarNum }}</span></button>
              </form>
            @else
              {{-- 收藏按钮 --}}
              <form action="{{ route('stars.store', $repository->id) }}" method="post">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary pull-right star-btn"><i class="fas fa-star"></i>&emsp;收藏&emsp;<span class="badge">{{ $repoStarNum }}</span></button>
              </form>
            @endif

            {{-- 知识清单标题 --}}
            <h2 class="repo-title"><a href="{{ route('repositories.show', $repository->id) }}" class="repo-title">{{ $repository->title }}</a></h2>

            {{-- 作者 --}}
            <p class="repo-author">
              <a href="{{ route('users.show', $repoAuthor->id) }}" target="_blank">{{ $repoAuthor->name }}</a>
              @if ($repository->is_private)
                <span class="small-p is-private"><i class="fas fa-lock icon-gray-active"></i>&nbsp;私有</span>
              @endif
            </p>

            {{-- 简介 --}}
            <p class="repo-description">
              {{ $repository->description }}
            </p>
            <br />

            <p>
              {{-- 标签 --}}
              @if ($repoTags->count())
                @foreach ($repoTags as $repoTag)
                  <span class="repo-tags">
                    <form action="{{ route('search') }}" method="get" class="form-inline repo-tags-form">
                      {{ csrf_field() }}
                      <input type="hidden" name="tag" value="{{ $repoTag->name }}" />
                      <button type="submit" class="btn btn-sm btn-tag"><i class="fas fa-hashtag"></i>&nbsp;{{ $repoTag->name }}</button>
                    </form>
                  </span>
                @endforeach
              @else
                <span class="repo-tags invisible"><button type="button" class="btn btn-sm btn-tag"><i class="fas fa-hashtag"></i>&nbsp;无标签</button></span>
              @endif

              {{-- 类别 --}}
              <span class="repo-category pull-right">
                <form action="{{ route('search') }}" method="get" class="form-inline form-category-select">
                  {{ csrf_field() }}
                  <input type="hidden" name="category" value="{{ $repoCategory->id }}">
                  <button class="btn" type="submit"><i class="fas fa-th-list"></i>&nbsp;{{ $repoCategory->category_level_1 }}</button>
                </form>
              </span>
            </p>

            {{-- 创建和更新时间 --}}
            <p class="repo-created-at small-p">
              创建于 {{ $repository->created_at->diffForHumans() }}，最近更新于 {{ $repository->updated_at->diffForHumans() }}。
            </p>

            {{-- 著作权声明 --}}
            @if ($repository->copyright === 'allow')
              <p class="repo-copyright small-p">
                <i class="fas fa-check-circle icon-green"></i>&nbsp;允许转载（非商用）
              </p>
            @elseif ($repository->copyright === 'limit')
              <p class="repo-copyright small-p">
                <i class="fas fa-exclamation-triangle icon-yellow"></i></i>&nbsp;转载需获得作者授权
              </p>
            @elseif ($repository->copyright === 'forbid')
              <p class="repo-copyright small-p">
                <i class="fas fa-ban icon-red"></i>&nbsp;禁止任何形式的转载
              </p>
            @endif
            <br />
            {{-- 知识清单基本信息 --}}
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            {{-- Nav tabs --}}
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#contents" aria-controls="contents" role="tab" data-toggle="tab">&emsp;<i class="far fa-list-alt"></i> 内容&emsp;</a></li>
              <li role="presentation"><a href="#revisions" aria-controls="revisions" role="tab" data-toggle="tab">&emsp;<i class="far fa-edit"></i> 修订&emsp;</a></li>
              <li role="presentation"><a href="#discuss" aria-controls="discuss" role="tab" data-toggle="tab">&emsp;<i class="far fa-comments"></i> 讨论&emsp;</a></li>
              @if ($repoAuthor->id === Auth::user()->id || Auth::user()->is_admin)
                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">&emsp;<i class="fas fa-sliders-h"></i> 设置&emsp;</a></li>
              @endif
            </ul>

            <br />

            {{-- Tab panes --}}
            <div class="tab-content">
              {{-- 内容 --}}
              <div role="tabpanel" class="tab-pane fade in active" id="contents">
                <div class="repo-content">
                  <article id="content"></article>
                </div>
              </div>

              {{-- 修订 --}}
              <div role="tabpanel" class="tab-pane fade" id="revisions">
                @if ($repoRevisions->count())
                  <h4>{{ $repoRevisions->count() }} 条修订记录</h4>
                  <br />
                  @foreach ($repoRevisions as $repoRevision)
                    <div class="row">
                      <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-default">
                          <div class="panel-heading revision-time">{{ $repoRevision->created_at->toDateString() }}</div>
                          <div class="panel-body">
                            {{ $repoRevision->log }}
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @else
                  <h4 class="text-center msg-no-item">无修订记录</h4>
                @endif
              </div>

              {{-- 讨论 --}}
              <div role="tabpanel" class="tab-pane fade" id="discuss">
                <div id="comment"></div>
              </div>

              {{-- 设置 --}}
              @if ($repoAuthor->id === Auth::user()->id || Auth::user()->is_admin)
                <div role="tabpanel" class="tab-pane fade" id="settings">
                  <br />
                  {{-- 修订按钮 --}}
                  <p>
                    <a class="btn btn-default" href="{{ route('repositories.edit', $repository->id)}}" role="button">修订知识清单</a>
                  </p>
                  <p class="small-p">
                    修订该知识清单的内容，并填写修订记录。
                  </p>
                  <br />

                  {{-- 删除按钮 --}}
                  <p>
                    <form action="{{ route('repositories.destroy', $repository->id) }}" method="post">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_repo_delete">删除知识清单</button>

                      {{-- 模态框 --}}
                      <div class="modal fade" id="modal_repo_delete" tabindex="-1" role="dialog" aria-labelledby="modal_label">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="modal_label">删除知识清单</h4>
                            </div>
                            <div class="modal-body">
                              <p>
                                确定删除该知识清单以及相关的修订、讨论等信息？该操作不可撤销。
                              </p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                              &emsp;
                              <button type="submit" class="btn btn-danger">删除</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </p>
                  <p class="small-p">
                    删除该知识清单以及相关的修订、讨论等信息。该操作不可撤销。
                  </p>
                </div>
              @endif
            </div>
            {{-- Tab 栏 --}}
          </div>
        </div>
        {{-- 容器 --}}
      </div>
    </div>
  </div>
@stop

@section('script')
  {{-- textarea 自动调整高度 --}}
  <script>
  autosize($('textarea.autosize'));
  </script>

  {{-- Stackedit Markdown 渲染 --}}
  <script src="/js/stackedit.min.js"></script>
  <script>
  let md_content = '{!! $repository->content !!}';

  var reg1 = new RegExp("&lt;br /&gt;", "g");
  md_content = md_content.replace(reg1, "\n");
  var reg2 = new RegExp("&gt;", "g");
  md_content = md_content.replace(reg2, ">");

  const el = document.querySelector('#content');
  const stackedit = new Stackedit();
  stackedit.openFile({
    content: { text: md_content }
  }, true /* silent mode */);
  // In silent mode, the `fileChange` event is emitted only once.
  stackedit.on('fileChange', (file) => {
    el.innerHTML = file.content.html;
  });
  </script>

  {{-- Valine 评论系统 --}}
  <script>
  new Valine({
    el: '#comment',
    notify: false,
    verify: false,
    appId: 'IQxaTF92P4WrBdYnmROQx9Gp-gzGzoHsz',
    appKey: 'fmn5dHnEzyGaevaCrN44JS1m',
    placeholder: '说点什么……',
    path: window.location.pathname,  // 当前文章页路径，用于确保正确读取该文章页下的评论列表。
    avatar: '',  // Gravatar 官方头像
    avatar_cdn: 'https://gravatar.loli.net/avatar/',  // Gravatar头像镜像
    guest_info: ['nick', 'mail'],
    pageSize: 10,
  });

  $("input[name='nick']").attr({
    "value": "{{ Auth::user()->name }}",
    "data-com.agilebits.onepassword.user-edited": "yes"
  });
  $("input[name='mail']").attr({
    "value": "{{ Auth::user()->email }}",
    "data-com.agilebits.onepassword.user-edited": "yes"
  });

  $('button.vsubmit').html('发表');
  </script>
@stop
