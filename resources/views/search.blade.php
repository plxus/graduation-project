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
            @if (isset($search_category))
              @if ($search_category_id === 'all')
                <h3 class="search-result light-h">{{ $search_category }}</h3><br />
              @else
                <h3 class="search-result light-h">在“{{ $search_category }}”类别</h3><br />
              @endif
            @endif
            {{-- 排序按钮 --}}
            <div class="btn-group pull-right">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-sort-amount-down"></i> 排序 <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li><a id="sort_by_time" role="button">按创建时间</a></li>
                <li><a id="sort_by_star" role="button">按收藏数</a></li>
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

    <script>
    $(document).ready(function(){

      $('#sort_by_time').bind("click", function(){
        $.ajax({
          type: 'GET',
          url: '/',
          data: {sort: 'created_at'},
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
          dataType: 'json',
          success: function(response){

          },
          error: function(){
            alert("error!");
          }
        });
      });

      $('#sort_by_star').bind("click", function(){
        $.ajax({
          type: 'GET',
          url: '/',
          data: {sort: 'star_num'},
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
          dataType: 'json',
          success: function(response){

          },
          error: function(){
            alert("error!");
          }
        });
      });
    });
    </script>
  @stop
