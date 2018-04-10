@extends('layouts.default')

@section('title', $repository->title)

@section('style')
  {{-- Valine 评论系统 --}}
  <script src="/js/av-min.js"></script>
  <script src="/js/Valine.min.js"></script>
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
            <h2 class="repo-title">{{ $repository->title }}</h2>
            {{-- 作者 --}}
            <p class="repo-author">
              <a href="{{ route('users.show', $repoAuthor->id) }}" target="_blank">{{ $repoAuthor->name }}</a>
            </p>
            {{-- 简介 --}}
            <p class="repo-description">
              {{ $repository->description }}
            </p>
            <p>
              {{-- 标签 --}}
              @if ($repoTags->count())
                @foreach ($repoTags as $repoTag)
                  <span class="repo-tags"><button type="button" class="btn btn-sm btn-tag"><i class="fas fa-hashtag"></i>&nbsp;{{ $repoTag->name }}</button></span>
                @endforeach
              @else
                <span class="repo-tags invisible"><button type="button" class="btn btn-sm btn-tag"><i class="fas fa-hashtag"></i>&nbsp;无标签</button></span>
              @endif
              {{-- 类别 --}}
              <span class="repo-category pull-right"><i class="fas fa-th-list"></i>&nbsp;{{ $repoCategory->category_level_1 }}</span>
            </p>
            {{-- 创建和更新时间 --}}
            <p class="repo-created-at small-p">
              创建于 {{ $repository->created_at->diffForHumans() }}，最近更新于 {{ $repository->updated_at->diffForHumans() }}。
            </p>
            {{-- 著作权声明 --}}
            @if ($repository->copyright === 'allow')
              <p class="repo-copyright small-p">
                <i class="far fa-check-circle icon-green"></i>&nbsp;允许转载
              </p>
            @elseif ($repository->copyright === 'limit')
              <p class="repo-copyright small-p">
                <i class="far fa-question-circle icon-blue"></i>&nbsp;转载需授权
              </p>
            @elseif ($repository->copyright === 'forbid')
              <p class="repo-copyright small-p">
                <i class="fas fa-ban icon-red"></i>&nbsp;禁止任何形式的转载
              </p>
            @endif
            {{-- 知识清单基本信息 --}}
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            {{-- Nav tabs --}}
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#contents" aria-controls="contents" role="tab" data-toggle="tab">&emsp;<i class="far fa-list-alt"></i> 详情&emsp;</a></li>
              {{-- <li role="presentation"><a href="#attachments" aria-controls="attachments" role="tab" data-toggle="tab">&emsp;<i class="fas fa-paperclip"></i> 附件&emsp;</a></li> --}}
              <li role="presentation"><a href="#revisions" aria-controls="revisions" role="tab" data-toggle="tab">&emsp;<i class="far fa-edit"></i> 修订&emsp;</a></li>
              <li role="presentation"><a href="#discuss" aria-controls="discuss" role="tab" data-toggle="tab">&emsp;<i class="far fa-comment-alt"></i> 讨论&emsp;</a></li>
              @if ($repoAuthor->id === Auth::user()->id)
                <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">&emsp;<i class="fas fa-sliders-h"></i> 设置&emsp;</a></li>
              @endif
            </ul>

            <br />

            {{-- Tab panes --}}
            <div class="tab-content">
              {{-- 详情 --}}
              <div role="tabpanel" class="tab-pane fade in active" id="contents">
                <div class="repo-content">
                  <article>
                    {{ $repository->content }}
                  </article>
                </div>
              </div>

              {{-- 附件 --}}
              {{-- <div role="tabpanel" class="tab-pane fade" id="attachments">展示附件，下载按钮</div> --}}

              {{-- 修订 --}}
              <div role="tabpanel" class="tab-pane fade" id="revisions">
                <h3>修订</h3>
                修订时间，修订记录
              </div>

              {{-- 讨论 --}}
              <div role="tabpanel" class="tab-pane fade" id="discuss">
                <h3>讨论</h3>
                @include('repositories._repo_discuss')
              </div>

              {{-- 设置 --}}
              @if ($repoAuthor->id === Auth::user()->id)
                <div role="tabpanel" class="tab-pane fade" id="settings">
                  <h3>设置</h3>
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
                      <button type="submit" class="btn btn-danger">删除知识清单</button>
                    </form>
                  </p>
                  <p class="small-p">
                    删除该知识清单及相关的修订、讨论等信息。该操作不可撤销。
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
  <script>
  new Valine({
    el: '#comment',
    notify: false,
    verify: false,
    appId: 'IQxaTF92P4WrBdYnmROQx9Gp-gzGzoHsz',
    appKey: 'fmn5dHnEzyGaevaCrN44JS1m',
    placeholder: '说点什么...',
    path: window.location.pathname,  // 当前文章页路径，用于确保正确读取该文章页下的评论列表。
    avatar: '',  // Gravatar 官方图形，隐藏头像
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
  </script>
@stop
