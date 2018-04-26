@extends('layouts.default')

@section('title', '修订知识清单')

@section('style')
  {{-- 标签添加插件 --}}
  <link rel="stylesheet" href="/css/taggle.css">
  {{-- select2 插件 --}}
  <link rel="stylesheet" href="/css/select2.min.css" />
  <link rel="stylesheet" href="/css/select2-bootstrap.min.css" />
@stop

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        {{-- 错误提示 --}}
        @include('shared._errors')
      </div>
    </div>

    <a class="btn btn-default" href="{{ route('repositories.show', $repository->id) }}" role="button"><i class="fas fa-arrow-left"></i> 退出编辑</a>

    <div class="row">
      <div class="col-md-12">
        <h1>修订知识清单</h1>
      </div>
    </div>

    <div class="row">
      <form action="{{ route('repositories.update', $repository->id) }}" method="POST" class="noreact-enter">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <div class="col-md-9 repo-create-left">
          <div class="form-group">
            <label for="repo-title">标题</label>
            <input type="text" class="form-control" id="repo-title" name="title" value="{{ $repository->title }}" placeholder="填写知识清单的标题" required>
          </div>

          <br />

          <div class="form-group">
            <label for="repo_description">简介</label>
            <textarea class="form-control autosize" rows="2" id="repo_description" name="description" placeholder="选填知识清单的描述">{{ $repository->description }}</textarea>
          </div>

          <br />

          <div class="form-group">
            <label for="repo-category">类别</label>
            <select class="form-control select2-style" id="repo-category" name="category_id" required>
              <option value="">选择一个类别</option>
              @foreach ($category_items as $category_item)
                <option value="{{ $category_item->id }}">
                  {{ $category_item->category_level_1 }}
                </option>
              @endforeach
            </select>
          </div>

          <br />

          <div class="form-group">
            <label for="repo_tag">标签</label>
            <div id="repo_tag" class="input textarea clearfix"></div>
            {{-- Each tag contains an hidden input with a configurable name of taggles[] by default  --}}
          </div>

          <br />

          <div class="form-group">
            <label for="repo_content">正文内容</label>
            <div style="margin-top:15px;">
              <button class="btn btn-success" type="button" id="btn_repo_edit"><i class="fas fa-edit"></i>&nbsp;打开编辑器</button>
              <span class="help-block small-p">支持 Markdown 语法。</span>
            </div>
            <textarea class="form-control hidden" id="repo_content" name="content" rows="15" placeholder="输入知识清单的正文内容" required>{!! str_replace("<br />", "\n", htmlspecialchars_decode($repository->content, ENT_QUOTES)) !!}</textarea>
            <h4 class="border-h">
              预览
            </h4>
            <article id="content_preview"></article>
          </div>
        </div>

        <div class="col-md-3">
          <ul class="list-group">
            <li class="list-group-item">
              <div class="form-group">
                <label>著作权声明</label>
                <p class="help-block small-p">声明他人是否有权转载该知识清单。</p>
                <div class="radio">
                  <label>
                    <input type="radio" name="copyright" id="copyright-limit" value="limit">
                    转载需获得作者授权
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="copyright" id="copyright-allow" value="allow">
                    允许转载（非商用）
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="copyright" id="copyright-forbid" value="forbid">
                    禁止任何形式的转载
                  </label>
                </div>
              </div>
            </li>

            <li class="list-group-item">
              <div class="form-group">
                <label>访问权限</label>
                <p class="help-block small-p">设定谁有权查看该知识清单。</p>
                <div class="radio">
                  <label>
                    <input type="radio" name="is_private" id="repo-public" value="false">
                    公开&nbsp;<i class="fas fa-users icon-gray"></i>
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="is_private" id="repo-private" value="true">
                    私有&nbsp;<i class="fas fa-lock icon-gray"></i>
                  </label>
                </div>
              </div>
            </li>
          </ul>

          {{-- 填写修订记录 --}}
          <div class="panel panel-default">
            <div class="panel-heading">修订记录</div>
            <div class="panel-body">
              <textarea class="form-control autosize" rows="2" id="repo-revision" name="log" placeholder="填写此次修订的记录" required></textarea>
            </div>
          </div>

          <button type="submit" class="btn btn-primary btn-lg pull-right">&emsp;提交修订&emsp;</button>
        </div>
        {{-- <input type="hidden" name="create" value="true" /> --}}
      </form>
    </div>
  </div>
@stop

@section('script')
  {{-- textarea 自动调整高度 --}}
  <script>
  autosize($('textarea.autosize'));
  </script>

  {{-- select2 插件 --}}
  <script src="/js/select2.min.js"></script>
  <script>
  $().ready(function(){
    $('.select2-style').select2({
      placeholder: "选择知识清单所属的类别",
      // allowClear: true
    });
  });
  </script>

  {{-- StackEdit Markdown 编辑器 --}}
  <script src="/js/stackedit.min.js"></script>
  <script>
  const el = document.querySelector('#repo_content');  // textarea 元素
  const pel = document.querySelector('#content_preview');  // 预览 article 元素
  const stackedit = new Stackedit();
  // 静默执行
  stackedit.openFile({
    content: {
      text: el.value // and the Markdown content.
    }
  }, true);
  // Open the iframe
  $('#btn_repo_edit').click(function(){
    stackedit.openFile({
      // name: 'Filename', // with an optional filename
      content: {
        text: el.value // and the Markdown content.
      }
    });
  });
  // Listen to StackEdit events and apply the changes to the textarea.
  stackedit.on('fileChange', (file) => {
    el.value = file.content.text;
    pel.innerHTML = file.content.html;
  });
</script>

{{-- Taggle 添加标签 --}}
<script src="/js/taggle.js"></script>
<?php
$tags = [];
foreach ($repoTags as $repoTag){
  array_push($tags, strval($repoTag->name));
}
$tags_str = '[\''.join("','", array_values($tags)).'\']';
?>
<script>
new Taggle('repo_tag', {
  duplicateTagClass: 'bounce',
  placeholder: '为知识清单添加标签',
  tags: {!! $tags_str !!},
});
</script>

<script>
$("option[value='{{ $repoCategory->id }}']").attr("selected", "selected");
$("input[value='{{ $repository->copyright }}']").attr("checked", "checked");
if ({{ $repository->is_private }}) {
  $("input[value='true']").attr("checked", "checked");
}
else {
  $("input[value='false']").attr("checked", "checked");
}
</script>
@stop
