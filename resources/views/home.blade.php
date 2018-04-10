@extends('layouts.default')

@section('title', '知识清单管理系统')

@section('content')
  <div class="container">
    {{-- 错误提示 --}}
    @include('shared._errors')

    @auth
      <div class="row">

        <div class="col-md-4 home-left">
          <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">
              <h5><i class="fas fa-th-list icon-gray-active"></i> 知识清单类别</h5>
            </div>

            <div class="panel-body">
              <button type="button" class="btn btn-default btn-lg btn-block" id="btn_all_categories">全部类别&nbsp;<span class="badge">{{ count($category_items) }}</span></button>
              <br />

              <div class="form-inline">
                <div class="form-group">
                  <label for="search-category">&nbsp;<i class="fas fa-search icon-gray"></i>&nbsp;</label>
                  <input type="search" class="form-control" id="search-category" name="search-category" placeholder="选择特定类别" style="width: 274px;">
                </div>
              </div>
              <br />

              <div class="category-wall">
                {{-- 获取类别表中的每一行记录 --}}
                @foreach ($category_items as $category_item)
                  <form action="{{ route('home') }}" method="get" class="form-inline form-category-select">
                    {{ csrf_field() }}
                    <input type="hidden" name="category" value="{{ $category_item->id }}">
                    <button class="btn btn-default btn-sm btn-category" type="submit">{{ $category_item->category_level_1 }}</button>
                  </form>
                @endforeach
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12 home-btn-row">
              {{-- 排序按钮 --}}
              <div class="btn-group pull-right">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-sort-amount-down"></i> 排序 <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a id="sort_by_time" role="button">按发布时间</a></li>
                  <li><a id="sort_by_star" role="button">按收藏数</a></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="row home-feed-flow">
            <div class="col-md-12" id="feed_flow">
              @if (count($feed_items))
                @foreach ($feed_items as $feed_item)
                  @include('repositories._repo_flow', ['repoAuthor' => $feed_item->user])
                  {{-- $feed_item->user 对应了 Repository 模型类中的 user() 方法，使用 user 可以获取到 Eloquent 集合。 --}}
                @endforeach
                {!! $feed_items->render() !!}
              @else
                <div class="alert alert-info text-center" role="alert">无知识清单条目</div>
              @endif
            </div>
          </div>
        </div>
      </div>
    @else
      <div class="row">
        <div class="col-md-12">
          <div class="jumbotron">
            <h1>知所</h1>
            <p>
              知识清单管理系统
            </p>
            <p>
              <a class="btn btn-lg btn-success" href="{{ route('register') }}" role="button">现在注册</a>
            </p>
          </div>
        </div>
      </div>
    @endauth
  </div>
@stop

@section('script')
  <script src="/js/holmes.js"></script>
  <script>
  holmes({
    find: '.category-wall button'
  });

  $(document).ready(function(){
    /* 点击全部类别按钮 */
    $('#btn_all_categories').bind("click", function(){
      $.ajax({
        type: 'GET',
        url: '/',
        data: {category: 'all'},
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        dataType: 'json',
        success: function(response){

        },
        error: function(){
          // alert('Ajax error!')
        }
      });
    });

    /* 点击特定类别 */
    // $('.btn_specific_category').bind("click", function(){
    //   $.ajax({
    //     type: 'GET',
    //     url: '/',
    //     data: .serialize(),
    //     headers: {
    //       'X-CSRF-TOKEN': '',
    //     },
    //     dataType: 'json',
    //     success: function(response){
    //
    //     },
    //     error: function(){
    //       // alert('Ajax error!')
    //     }
    //   });
    // });

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
