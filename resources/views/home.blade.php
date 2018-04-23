@extends('layouts.default')

@section('title', '知识清单管理系统')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        {{-- 错误提示 --}}
        @include('shared._errors')
      </div>
    </div>

    {{-- 已登录用户的首页视图 --}}
    @auth
      <div class="row">
        {{-- 左侧：知识清单类别 --}}
        <div class="col-md-4 home-left">
          <div class="panel panel-default home-panel">
            <!-- Default panel contents -->
            <div class="panel-heading">
              <h3 class="light-h repo-category-head"><i class="fas fa-th-list icon-gray"></i> 知识清单类别</h3>
            </div>

            <div class="panel-body">
              <form action="{{ route('search') }}" method="get">
                {{ csrf_field() }}
                <input type="hidden" name="category" value="all" />
                <button type="submit" class="btn btn-default btn-lg btn-block">全部类别&nbsp;<span class="badge">{{ count($category_items) }}</span></button>
              </form>
              <br />

              <div class="form-inline">
                <div class="form-group">
                  <label for="search-category">&nbsp;<i class="fas fa-search icon-gray"></i>&nbsp;</label>
                  <input type="search" class="form-control" id="search_category" name="search-category" placeholder="搜索以下类别" style="width: 274px;">
                </div>
              </div>
              <br />

              <div class="category-wall">
                {{-- 获取类别表中的每一行记录 --}}
                @foreach ($category_items as $category_item)
                  <span>
                    <form action="{{ route('search') }}" method="get" class="form-inline form-category-select">
                      {{ csrf_field() }}
                      <input type="hidden" name="category" value="{{ $category_item->id }}">
                      <button class="btn btn-default btn-sm btn-category" type="submit">{{ $category_item->category_level_1 }}</button>
                    </form>
                  </span>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        {{-- 右侧 --}}
        <div class="col-md-8">
          {{-- 图片轮播 --}}
          <div id="home-carousel">
            <div class="carousel-item slick-slide">
              <img src="/storage/pages/home/zhisuo_home_banner_0.png" alt="轮播图1">
              <div class="carousel-caption">
              </div>
            </div>
            <div class="carousel-item slick-slide">
              <img src="/storage/pages/home/zhisuo_home_banner_1.png" alt="轮播图2">
              <div class="carousel-caption">
              </div>
            </div>
            <div class="carousel-item slick-slide">
              <img src="/storage/pages/home/zhisuo_home_banner_2.png" alt="轮播图3">
              <div class="carousel-caption">
              </div>
            </div>
          </div>

          {{-- Tab 栏 --}}
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#timeline" aria-controls="timeline" role="tab" data-toggle="tab">&emsp;时间线&emsp;</a></li>
            <li role="presentation"><a href="{{ route('home.preferences') }}" aria-controls="preferred_categories" role="tab">&emsp;偏好的类别&emsp;</a></li>
          </ul>

          <div class="tab-content">
            {{-- 时间线 --}}
            <div role="tabpanel" class="tab-pane fade in active" id="timeline">
              {{-- 排序按钮 --}}
              <div class="row">
                <div class="col-md-12 home-btn-row">
                  <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">排序：<span id="sort_by"></span>&nbsp;<span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                      {{-- 按创建时间排序 --}}
                      <li id="li_created_at"><a id="sort_by_created_at" role="button">最近创建</a></li>
                      <form method="get" action="{{ route('home') }}" class="hidden" id="form_created_at">
                        {{ csrf_field() }}
                        <input type="hidden" name="sort" value="created_at" />
                      </form>
                      {{-- 按更新时间排序 --}}
                      <li id="li_updated_at"><a id="sort_by_updated_at" role="button">最近更新</a></li>
                      <form method="get" action="{{ route('home') }}" class="hidden" id="form_updated_at">
                        {{ csrf_field() }}
                        <input type="hidden" name="sort" value="updated_at" />
                      </form>
                      {{-- 按收藏数排序 --}}
                      <li id="li_star_num"><a id="sort_by_star_num" role="button">最多收藏</a></li>
                      <form method="get" action="{{ route('home') }}" class="hidden" id="form_star_num">
                        {{ csrf_field() }}
                        <input type="hidden" name="sort" value="star_num" />
                      </form>
                    </ul>
                  </div>
                </div>
              </div>

              {{-- 时间线信息流 --}}
              <div class="row home-feed-flow">
                <div class="col-md-12" id="feed_flow">
                  @if (count($feed_items))
                    @foreach ($feed_items as $feed_item)
                      @include('repositories._repo_flow', ['repoAuthor' => $feed_item->user, 'repoCategory' => $feed_item->category])
                      {{-- $feed_item->user 对应了 Repository 模型类中的 user() 方法，使用 user 可以获取到 Eloquent 集合。 --}}
                    @endforeach
                    {!! $feed_items->appends([
                      '_token' => csrf_token(),
                      'sort' => isset($sort_rule) ? $sort_rule : '',
                      ])->links() !!}
                      {{-- 渲染分页视图时添加 URI --}}
                    @else
                      <h4 class="msg-no-item text-center">暂无知识清单<br /><a href="{{ route('repositories.create') }}">创建你的第一份知识清单</a>，或者关注其他用户</h4>
                    @endif
                  </div>
                </div>
              </div>

              {{-- 偏好的类别 --}}
            </div>
          </div>
        </div>

        {{-- 未登录用户的首页视图 --}}
      @else
        <div class="row">
          <div class="col-md-12">
            {{-- 巨幕 --}}
            <div class="jumbotron">
              <h1>知所</h1>
              <h3>面向大学生的<br />知识清单管理系统</h3>
              <br />
              <p>
                <a class="btn btn-lg btn-success" href="{{ route('register') }}" role="button">&emsp;现在注册&emsp;</a>
              </p>
            </div>

            {{-- 系统图文展示 --}}
            <div class="row home-intro-row">
              <div class="col-md-6 text-center">
                <h1 class="light-h home-intro">分享与探索<br />各个学科领域的知识</h1>
              </div>
              <div class="col-md-6 text-center">

              </div>
            </div>

            <div class="row home-intro-row">
              <div class="col-md-6 text-center">

              </div>
              <div class="col-md-6 text-center">
                <h1 class="light-h home-intro">个性化推荐<br />精准搜索</h1>
              </div>
            </div>

            <div class="row home-intro-row">
              <div class="col-md-6 text-center">
                <h1 class="light-h home-intro">版本跟踪<br />权限控制</h1>
              </div>
              <div class="col-md-6 text-center">

              </div>
            </div>
          </div>
        </div>
      @endauth
    </div>
  @stop

  @section('script')
    {{-- holmes 插件 --}}
    <script src="/js/holmes.js"></script>
    <script>
    // holmes 插件
    @auth
    holmes({
      find: '.category-wall span'
    });
    @endauth
    </script>

    <script>
    $().ready(function(){
      // 图片轮播
      $('#home-carousel').slick({
        arrows: false,
        // prevArrow: '<button type="button" class="slick-prev">Previous</button>',
        // nextArrow: '<button type="button" class="slick-next">Next</button>',
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        adaptiveHeight: true,
        easing: 'ease',
      });

      // 按创建时间排序
      $('#sort_by_created_at').bind("click", function(){
        $('#form_created_at').submit();
      });

      // 按更新时间排序
      $('#sort_by_updated_at').bind("click", function(){
        $('#form_updated_at').submit();
      });

      // 按收藏数排序
      $('#sort_by_star_num').bind("click", function(){
        $('#form_star_num').submit();
      });

      var sort_rule = '{{ $sort_rule }}';
      // 根据排序规则显示相应排序按钮的激活状态
      if (sort_rule === 'created_at'){
        $('#li_created_at').addClass('active');
        $('#sort_by').text('最近创建');
      }

      if (sort_rule === 'updated_at'){
        $('#li_updated_at').addClass('active');
        $('#sort_by').text('最近更新');
      }

      if (sort_rule === 'star_num'){
        $('#li_star_num').addClass('active');
        $('#sort_by').text('最多收藏');
      }
    });
    </script>
  @stop
