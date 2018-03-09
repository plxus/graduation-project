@extends('layouts.default')

@section('title', $user->name.' 个人信息')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h5>个人信息</h5>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-offset-2 col-md-8">

                {{-- 错误提示 --}}
                @include('shared._errors')

                <form method="POST" action="{{ route('users.update', $user->id ) }}">
                  {{ method_field('PATCH') }}
                  {{ csrf_field() }}

                  <div class="form-group">
                    <label for="name">用户名：</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                  </div>

                  <br />

                  <div class="form-group">
                    <label for="email">E-Mail：</label>
                    <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                  </div>

                  <br />

                  <div class="form-group">
                    <label for="email">个人简介：</label>
                    <input type="text" name="bio" class="form-control" value="{{ $user->bio }}">
                  </div>

                  <br />

                  <div class="form-group">
                    <label for="password">新密码：</label>
                    <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                  </div>

                  <br />

                  <div class="form-group">
                    <label for="password_confirmation">确认密码：</label>
                    <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}">
                  </div>

                  <br />

                  <button type="submit" class="btn btn-primary float-right">保存更改</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
