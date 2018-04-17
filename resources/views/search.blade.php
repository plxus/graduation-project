@extends('layouts.default')

@section('title', '搜索结果')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        {{-- 错误提示 --}}
        @include('shared._errors')
      </div>
    </div>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <a class="btn btn-default" href="javascript:history.go(-1);" role="button"><i class="fas fa-arrow-left"></i> 返回</a>

        <div class="row">
          <div class="col-md-12 home-btn-row">
            <h2>搜索结果</h2>
            {{-- 类别 --}}
            @if (isset($search_category_id))
              @if ($search_category_id === 'all')
                <h3 class="search-result light-h">{{ $search_category }}</h3><br />
              @else
                <h3 class="search-result light-h">在“{{ $search_category }}”类别中</h3><br />
              @endif
            @endif
            {{-- 标签 --}}
            @if (isset($search_tag))
              <h3 class="search-result light-h">包含“{{ $search_tag }}”标签</h3><br />
            @endif

            {{-- 排序按钮 --}}
            <div class="btn-group pull-right">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">排序：<span id="sort_by"></span>&nbsp;<span class="caret"></span>
              </button>
              <ul class="dropdown-menu">

                {{-- 按创建时间排序 --}}
                <li id="li_created_at"><a id="sort_by_created_at" role="button">最近创建</a></li>
                <form method="get" action="{{ route('search') }}" class="hidden" id="form_created_at">
                  {{ csrf_field() }}
                  @if (isset($search_keywords))
                    <input type="hidden" name="keywords" value="{{ $search_keywords }}" />
                  @endif
                  @if (isset($search_category_id))
                    <input type="hidden" name="category" value="{{ $search_category_id }}" />
                  @endif
                  @if (isset($search_tag))
                    <input type="hidden" name="tag" value="{{ $search_tag }}" />
                  @endif
                  <input type="hidden" name="sort" value="created_at" />
                </form>

                {{-- 按更新时间排序 --}}
                <li id="li_updated_at"><a id="sort_by_updated_at" role="button">最近更新</a></li>
                <form method="get" action="{{ route('search') }}" class="hidden" id="form_updated_at">
                  {{ csrf_field() }}
                  @if (isset($search_keywords))
                    <input type="hidden" name="keywords" value="{{ $search_keywords }}" />
                  @endif
                  @if (isset($search_category_id))
                    <input type="hidden" name="category" value="{{ $search_category_id }}" />
                  @endif
                  @if (isset($search_tag))
                    <input type="hidden" name="tag" value="{{ $search_tag }}" />
                  @endif
                  <input type="hidden" name="sort" value="updated_at" />
                </form>

                {{-- 按收藏数排序 --}}
                <li id="li_star_num"><a id="sort_by_star_num" role="button">最多收藏</a></li>
                <form method="get" action="{{ route('search') }}" class="hidden" id="form_star_num">
                  {{ csrf_field() }}
                  @if (isset($search_keywords))
                    <input type="hidden" name="keywords" value="{{ $search_keywords }}" />
                  @endif
                  @if (isset($search_category_id))
                    <input type="hidden" name="category" value="{{ $search_category_id }}" />
                  @endif
                  @if (isset($search_tag))
                    <input type="hidden" name="tag" value="{{ $search_tag }}" />
                  @endif
                  <input type="hidden" name="sort" value="star_num" />
                </form>
              </ul>
            </div>
            <h3 class="search-result">{{ $feed_items->total() }} 个知识清单</h3>
            {{-- total() 方法获取分页的总记录数 --}}
          </div>
        </div>

        <div class="row home-feed-flow">
          <div class="col-md-12" id="feed_flow">
            @if (count($feed_items))
              @foreach ($feed_items as $feed_item)
                @include('repositories._repo_flow', ['repoAuthor' => $feed_item->user, 'repoCategory' => $feed_item->category])
                {{-- $feed_item->user 对应了 Repository 模型类中的 user() 方法，使用 user 可以获取到 Eloquent 集合。 --}}
              @endforeach
              {{ $feed_items->appends([
                '_token' => csrf_token(),
                'keywords' => isset($search_keywords) ? $search_keywords : '',
                'category' => isset($search_category_id) ? $search_category_id : '',
                'tag' => isset($search_tag) ? $search_tag : '',
                'sort' => isset($sort_rule) ? $sort_rule : '',
                ])->links() }}
                {{-- 渲染分页视图时添加 URI --}}
              @else
                <h4 class="msg-no-item text-center">无结果</h4>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  @stop

  @section('script')
    {{-- 显示搜索关键词 --}}
    <script>
    @if (isset($search_keywords))
    $('input.navbar-search').attr('value', '{{ $search_keywords }}');
    @endif
    </script>

    {{-- 排序 --}}
    <script>
    $().ready(function(){
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
