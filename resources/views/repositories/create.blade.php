@extends('layouts.default')

@section('title', '创建知识清单')

@section('style')
  <link rel="stylesheet" href="/css/taggle.css">
  {{-- <link rel="stylesheet" href="/css/jquery.fileupload-ui.css"> --}}
  <link rel="stylesheet" href="/css/jquery.fileupload.css">
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
      <div class="col-md-12">
        <h1>创建知识清单</h1>
      </div>
    </div>

    <div class="row">
      <form action="{{ route('repositories.store') }}" method="POST">
        {{ csrf_field() }}
        <div class="col-md-9 repo-create-left">
          <div class="form-group">
            <label for="repo-title">标题</label>
            <input type="text" class="form-control" id="repo-title" name="title" placeholder="填写该知识清单的标题" required>
          </div>

          <br />

          <div class="form-group">
            <label for="repo-description">简介</label>
            <textarea class="form-control" rows="2" id="repo-description" name="description" placeholder="选填该知识清单的描述"></textarea>
          </div>

          <br />

          <div class="form-group">
            <label for="repo-category">类别</label>
            <select class="form-control" id="repo-category" name="category">
              <option value="null" checked>
                请选择
              </option>
              @foreach ($categories_level_1 as $category_level_1)
                <option>
                  {{ $category_level_1 }}
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
            <label for="repo-content">正文内容</label>

          </div>

          <br />

          <div class="form-group">
            <label for="fileupload">上传附件</label>
            <br />
            <span class="btn btn-default fileinput-button">
              <i class="glyphicon glyphicon-plus"></i>&nbsp;
              <span>添加文件</span>
              <!-- The file input field used as target for the file upload widget -->
              <input id="fileupload" type="file" name="files[]" multiple>
            </span>
            <br />
            {{-- <br />
            <div id="progress" class="progress">
            <div class="progress-bar progress-bar-success"></div>
          </div> --}}
          <div id="files" class="files"></div>
          <p class="help-block small-p">可上传不超过 50 MB 的文件。</p>
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
                  <input type="radio" name="copyright" id="copyright-limit" value="limit" checked>
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
                  <input type="radio" name="is_private" id="repo-public" value="false" checked>
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

        <button type="submit" class="btn btn-primary btn-lg pull-right">创建</button>
      </div>
      <input type="hidden" name="create" value="true" />
    </form>
  </div>
</div>
@stop

@section('script')
  {{-- Taggle --}}
  <script src="/js/taggle.js"></script>
  <script type="text/javascript">
  window.repo_tag = new Taggle($('.repo_tag.textarea')[0], {
    duplicateTagClass: 'bounce',
    placeholder: '为该知识清单添加标签'
  });
  </script>

  {{-- jQuery File Upload --}}
  <script src="/js/jQuery_file_upload/vendor/jquery.ui.widget.js"></script>
  <script src="/js/jQuery_file_upload/jquery.iframe-transport.js"></script>
  <script src="/js/jQuery_file_upload/jquery.fileupload.js"></script>
  <script src="/js/jQuery_file_upload/jquery.fileupload-validate.js"></script>
  <script src="/js/jQuery_file_upload/jquery.fileupload-image.js"></script>
  {{-- <script src="/js/jQuery_file_upload/jquery.fileupload-ui.js"></script>
  <script src="/js/jQuery_file_upload/jquery.fileupload-jquery-ui.js"></script> --}}
  <script>
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
</script>
@stop
