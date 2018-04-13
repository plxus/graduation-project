@extends('layouts.default')

@section('title', $user->name.' 用户设置')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4 class="panel-h">用户设置</h4>
          </div>
          <div class="panel-body" style="padding: 30px 20px;">
            <div class="row">
              <div class="col-md-offset-1 col-md-10">

                {{-- 错误提示 --}}
                @include('shared._errors')

                <form method="POST" action="{{ route('users.update', $user->id ) }}">
                  {{ method_field('PATCH') }}
                  {{ csrf_field() }}

                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">&emsp;个人信息&emsp;</a></li>
                    <li role="presentation"><a href="#change_password" aria-controls="change_password" role="tab" data-toggle="tab">&emsp;修改密码&emsp;</a></li>
                  </ul>

                  <div class="tab-content">
                    {{-- 个人信息 --}}
                    <div role="tabpanel" class="tab-pane fade in active" id="profile">
                      <br />

                      <div class="form-group">
                        <label for="name">用户名</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                      </div>

                      <br />

                      <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="text" name="email" class="form-control" value="{{ $user->email }}" required>
                      </div>

                      <br />

                      <div class="form-group">
                        <label for="bio">个人简介</label>
                        <input type="text" name="bio" class="form-control" value="{{ $user->bio }}">
                      </div>

                      <br />

                      <div class="form-group">
                        <label for="url">URL</label>
                        <input type="text" name="url" class="form-control" value="{{ $user->url }}">
                      </div>

                      <br />

                      <div class="form-group">
                        <label>头像</label>
                        <p>
                          <a href="https://cn.gravatar.com/" target="_blank"><i class="fas fa-external-link-alt"></i>&nbsp;在 Gravatar 中设置你的头像</a>
                        </p>
                      </div>
                    </div>

                    {{-- 修改密码 --}}
                    <div role="tabpanel" class="tab-pane fade" id="change_password">
                      <br />
                      <p>
                        留空则继续使用现有的密码。
                      </p>

                      <br />

                      <div class="form-group">
                        <label for="password">新密码</label>
                        <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                      </div>

                      <br />

                      <div class="form-group">
                        <label for="password_confirmation">确认密码</label>
                        <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
                      </div>
                    </div>
                  </div>

                  <br />

                  <button type="submit" class="btn btn-primary pull-right">&emsp;保存更改&emsp;</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
