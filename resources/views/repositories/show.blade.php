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
            <form action="#" method="post">
              <button type="button" class="btn btn-primary pull-right star-btn"><i class="fas fa-star"></i> 收藏 <span class="badge">{{ $repoStarNum }}</span></button>
            </form>
            <h2 class="repo-title">{{ $repository->title }}</h2>
            <p class="repo-author">
              {{-- 作者 --}}
              <a href="{{ route('users.show', $repoAuthor->id) }}">{{ $repoAuthor->name }}</a>
            </p>
            <p class="repo-description">
              {{-- 简介 --}}
              {{ $repository->description }}
            </p>
            <p>
              {{-- 标签 --}}
              <span class="repo-tags"><button type="button" class="btn btn-sm btn-tag"><i class="fas fa-hashtag"></i>&nbsp;标签</button></span>
              {{-- 类别 --}}
              <span class="repo-category pull-right"><i class="fas fa-th-list"></i>&nbsp;{{ $repoCategory->category_level_1 }}</span>
            </p>
            <p class="repo-created-at small-p">
              {{-- 时间 --}}
              创建于 {{ $repository->created_at->diffForHumans() }}，最近更新于 {{ $repository->updated_at->diffForHumans() }}。
            </p>
            {{-- 知识清单基本信息：标题、作者、简介、分类、标签 --}}
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            {{-- Nav tabs --}}
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="active"><a href="#contents" aria-controls="contents" role="tab" data-toggle="tab">&emsp;<i class="far fa-list-alt"></i> 详情&emsp;</a></li>
              <li role="presentation"><a href="#attachments" aria-controls="attachments" role="tab" data-toggle="tab">&emsp;<i class="fas fa-paperclip"></i> 附件&emsp;</a></li>
              <li role="presentation"><a href="#revisions" aria-controls="revisions" role="tab" data-toggle="tab">&emsp;<i class="far fa-edit"></i> 修订&emsp;</a></li>
              <li role="presentation"><a href="#discuss" aria-controls="discuss" role="tab" data-toggle="tab">&emsp;<i class="far fa-comment-alt"></i> 讨论&emsp;</a></li>
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
              <div role="tabpanel" class="tab-pane fade" id="attachments">展示附件，下载按钮</div>

              {{-- 修订 --}}
              <div role="tabpanel" class="tab-pane fade" id="revisions">修订时间，修订记录</div>

              {{-- 讨论 --}}
              <div role="tabpanel" class="tab-pane fade" id="discuss">
                <h4>讨论</h4>
                @include('repositories._repo_discuss')
              </div>
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
