@extends('layouts.default')

@section('title', '修订知识清单')

@section('style')
  {{-- 标签添加插件 --}}
  <link rel="stylesheet" href="/css/taggle.css">
  {{-- jQuery 文件上传插件 --}}
  {{-- <link rel="stylesheet" href="/css/jquery.fileupload-ui.css"> --}}
  {{-- <link rel="stylesheet" href="/css/jquery.fileupload.css"> --}}
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
      <form action="{{ route('repositories.update', $repository->id) }}" method="POST">
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
            <select class="form-control" id="repo-category" name="category_id" required>
              <option value="">
                - 选择一个类别 -
              </option>
              @foreach ($category_items as $category_item)
                <option value="{{ $category_item->id }}">
                  {{ $category_item->category_level_1 }}
                </option>
              @endforeach
            </select>
          </div>

          <br />

          <div class="form-group">
            <label for="repo-tag">标签</label>
            <div id="repo-tag" class="input textarea clearfix repo_tag"></div>
            {{-- Each tag contains an hidden input with a configurable name of taggles[] by default  --}}
          </div>

          <br />

          <div class="form-group">
            <label for="repo_content">正文内容</label>
            <div style="margin-top:15px;">
              <button class="btn btn-success" type="button" id="btn_repo_edit"><i class="fas fa-edit"></i>&nbsp;打开编辑器</button>
              <span class="help-block small-p">支持 Markdown 语法。</span>
            </div>
            <h4 class="border-h">
              预览
            </h4>
            <article id="content_preview"></article>
            <textarea class="form-control hidden" id="repo_content" name="content" rows="15" placeholder="输入知识清单的正文内容" required>{{ str_replace("<br />", "\r\n", $repository->content) }}</textarea>
          </div>

          <br />

          {{-- <div class="form-group">
          <label for="fileupload">上传附件</label>
          <br />
          <span class="btn btn-default fileinput-button">
          <i class="glyphicon glyphicon-plus"></i>&nbsp;
          <span>添加文件</span>
          <!-- The file input field used as target for the file upload widget -->
          <input id="fileupload" type="file" name="files[]" multiple>
        </span>
        <br />
        <br />
        <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
      </div>
      <div id="files" class="files"></div>
      <p class="help-block small-p">可上传不超过 50 MB 的文件。</p>
    </div> --}}
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
              转载需授权
            </label>
          </div>
          <div class="radio">
            <label>
              <input type="radio" name="copyright" id="copyright-allow" value="allow">
              允许转载
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
              公开
            </label>
          </div>
          <div class="radio">
            <label>
              <input type="radio" name="is_private" id="repo-private" value="true">
              私有
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

  {{-- StackEdit Markdown 编辑器 --}}
  <script src="/js/stackedit.min.js"></script>
  <script>
  const el = document.querySelector('#repo_content');  // textarea 元素
  const pel = document.querySelector('#content_preview');  // 预览 article 元素
  const stackedit = new Stackedit();
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
window.repo_tag = new Taggle($('.repo_tag.textarea')[0], {
  duplicateTagClass: 'bounce',
  placeholder: '为知识清单添加标签',
  tags: <?php echo($tags_str) ?>,
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

{{-- jQuery File Upload --}}
{{-- <script src="/js/jQuery_file_upload/vendor/jquery.ui.widget.js"></script>
<script src="/js/jQuery_file_upload/jquery.iframe-transport.js"></script>
<script src="/js/jQuery_file_upload/jquery.fileupload.js"></script>
<script src="/js/jQuery_file_upload/jquery.fileupload-validate.js"></script>
<script src="/js/jQuery_file_upload/jquery.fileupload-image.js"></script> --}}
{{-- <script src="/js/jQuery_file_upload/jquery.fileupload-ui.js"></script>
<script src="/js/jQuery_file_upload/jquery.fileupload-jquery-ui.js"></script> --}}
{{-- <script>
/*jslint unparam: true, regexp: true */
/*global window, $ */
$(function () {
'use strict';
// Change this to the location of your server-side upload handler:
var url = 'server/php/',
uploadButton = $('<button/>')
.addClass('btn btn-default btn-sm')
.prop('disabled', true)
.text('上传中...')
.on('click', function () {
var $this = $(this),
data = $this.data();
$this
.off('click')
.text('停止上传')
.on('click', function () {
$this.remove();
data.abort();
});
data.submit().always(function () {
$this.remove();
});
});
$('#fileupload').fileupload({
url: url,
dataType: 'json',
autoUpload: true,
// acceptFileTypes: ,
maxFileSize: 5000000,  //文件不超过5M
maxNumberOfFiles: 10,  //最大上传文件数目
sequentialUploads: true,  //是否队列上传
// Enable image resizing, except for Android and Opera,
// which actually support image resizing, but fail to
// send Blob objects via XHR requests:
disableImageResize: /Android(?!.*Chrome)|Opera/
.test(window.navigator.userAgent),
previewMaxWidth: 100,
previewMaxHeight: 100,
previewCrop: true
}).on('fileuploadadd', function (e, data) {
data.context = $('<div/>').appendTo('#files');
$.each(data.files, function (index, file) {
var node = $('<p/>')
.append($('<span/>').text(file.name));
if (!index) {
node
.append('<br>')
.append(uploadButton.clone(true).data(data));
}
node.appendTo(data.context);
});
}).on('fileuploadprocessalways', function (e, data) {
var index = data.index,
file = data.files[index],
node = $(data.context.children()[index]);
if (file.preview) {
node
.prepend('<br>')
.prepend(file.preview);
}
if (file.error) {
node
.append('<br>')
.append($('<span class="text-danger"/>').text(file.error));
}
if (index + 1 === data.files.length) {
data.context.find('button')
.text('上传')
.prop('disabled', !!data.files.error);
}
}).on('fileuploaddone', function (e, data) {
$.each(data.result.files, function (index, file) {
if (file.url) {
var link = $('<a>')
.attr('target', '_blank')
.prop('href', file.url);
$(data.context.children()[index])
.wrap(link);
} else if (file.error) {
var error = $('<span class="text-danger"/>').text(file.error);
$(data.context.children()[index])
.append('<br>')
.append(error);
}
});
}).on('fileuploadfail', function (e, data) {
$.each(data.files, function (index) {
var error = $('<span class="text-danger"/>').text('文件上传失败。');
$(data.context.children()[index])
.append('<br>')
.append(error);
});
}).prop('disabled', !$.support.fileInput)
.parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script> --}}
@stop
