@extends('layouts.default')

@section('title', '创建知识清单')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        @include('shared._errors')
        <h1>创建知识清单</h1>
      </div>
    </div>

    <div class="row">
      <form action="{{ route('repositories.store') }}" method="POST">
        {{ csrf_field() }}
        <div class="col-md-9 repo-create-left">
          <div class="form-group">
            <label for="repo-title">标题</label>
            <input type="text" class="form-control" id="repo-title" placeholder="" required>
          </div>

          <br />

          <div class="form-group">
            <label for="repo-description">简介</label>
            <textarea class="form-control" rows="2" id="repo-description" placeholder="选填该知识清单的描述..."></textarea>
          </div>

          <br />

          <div class="form-group">
            <label for="repo-title">类别</label>
            <select class="form-control">
              <option>1</option>
              <option>2</option>
              <option>3</option>
            </select>
          </div>

          <br />

          <div class="form-group">
            <label for="repo-title">标签</label>

          </div>

          <br />

          <div class="form-group">
            <label for="repo-file">上传文件</label>
            <input type="file" id="repo-file" multiple>
            <p class="help-block small-p">可上传不超过 100 MB 的文件。</p>
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
                    <input type="radio" name="repo-copyright" id="copyright-limit" value="limit" checked>
                    转载需授权
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="repo-copyright" id="copyright-allow" value="allow">
                    允许转载
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="repo-copyright" id="copyright-forbid" value="forbid">
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
                    <input type="radio" name="repo-is_private" id="repo-public" value="0" checked>
                    公开
                  </label>
                </div>
                <div class="radio">
                  <label>
                    <input type="radio" name="repo-is_private" id="repo-private" value="1">
                    私有
                  </label>
                </div>
              </div>
            </li>
          </ul>

          <button type="submit" class="btn btn-primary btn-lg pull-right">创建</button>
        </div>
      </form>
    </div>
  </div>
@stop
