@extends('layouts.default')

@section('title', '通知与私信')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        {{-- 错误提示 --}}
        @include('shared._errors')
      </div>
    </div>

    <h2>通知与私信</h2>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">

        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#notifications" aria-controls="notifications" role="tab" data-toggle="tab">&emsp;系统通知 <span class="badge">{{ $notifications->count() }}</span>&emsp;</a></li>
          <li role="presentation"><a href="#received" aria-controls="received" role="tab" data-toggle="tab">&emsp;收到的私信 <span class="badge">{{ $received_msg->count() }}</span>&emsp;</a></li>
          <li role="presentation"><a href="#sent" aria-controls="sent" role="tab" data-toggle="tab">&emsp;发出的私信 <span class="badge">{{ $sent_msg->count() }}</span>&emsp;</a></li>
        </ul>

        <div class="tab-content">
          {{-- 系统通知 --}}
          <div role="tabpanel" class="tab-pane fade in active" id="notifications">
            {{-- 发送通知的按钮 --}}
            @if (Auth::user()->is_admin)
              <br />
              <p>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#notification" aria-expanded="false" aria-controls="notification">
                  发送系统通知
                </button>
                <div class="collapse" id="notification">
                  <br />
                  <div class="panel panel-success">
                    <div class="panel-body">
                      <form action="{{ route('notifications.store', Auth::user()->id) }}" method="post">
                        {{ csrf_field()}}
                        <div class="form-group">
                          <input type="text" class="form-control" name="msg_subject" placeholder="主题（选填）">
                        </div>
                        <div class="form-group">
                          <textarea class="form-control autosize" name="msg_content" rows="2" placeholder="内容" required></textarea>
                        </div>
                        <input type="hidden" name="receive_id" value="0" />
                        <button type="submit" class="btn btn-primary pull-right">发送</button>
                      </form>
                    </div>
                  </div>
                </div>
              </p>
              <p>
                以管理员身份向全部用户发送系统通知。
              </p>
            @endif
            @if ($notifications->count())
              <br />
              <ul class="list-group">
                @foreach ($notifications as $notification)
                  <li class="list-group-item">
                    @if ($notification->subject)
                      <h5 class="color-h">{{ $notification->subject }}</h5>
                    @else
                      <h5></h5>
                    @endif
                    <p>
                      {{ $notification->content }}
                    </p>
                    <p class="small text-right gray-p">
                      知所团队敬上，
                      {{ $notification->created_at->diffForHumans() }}
                    </p>
                  </li>
                @endforeach
              </ul>
            @else
              <h4 class="text-center msg-no-item">暂无系统通知</h4>
            @endif
          </div>

          {{-- 收到的私信 --}}
          <div role="tabpanel" class="tab-pane fade" id="received">
            @if ($received_msg->count())
              <br />
              <ul class="list-group">
                @foreach ($received_msg as $msg_item)
                  <li class="list-group-item">
                    @if ($msg_item->subject)
                      <h5 class="color-h">{{ $msg_item->subject }}</h5>
                    @else
                      <h5></h5>
                    @endif
                    <p>
                      {{ $msg_item->content }}
                    </p>
                    <p class="small text-right gray-p">
                      来自&nbsp;<a href="{{ route('users.show', $msg_item->send_id)}}" target="_blank">{{ $msg_item->name }}</a>&nbsp;，
                      {{ $msg_item->created_at->diffForHumans() }}
                    </p>
                  </li>
                @endforeach
              </ul>
            @else
              <h4 class="text-center msg-no-item">暂无私信</h4>
            @endif
          </div>

          {{-- 发出的私信 --}}
          <div role="tabpanel" class="tab-pane fade" id="sent">
            @if ($sent_msg->count())
              <br />
              <ul class="list-group">
                @foreach ($sent_msg as $msg_item)
                  <li class="list-group-item">
                    @if ($msg_item->subject)
                      <h5 class="color-h">{{ $msg_item->subject }}</h5>
                    @else
                      <h5></h5>
                    @endif
                    <p>
                      {{ $msg_item->content }}
                    </p>
                    <p class="small text-right gray-p">
                      发送给&nbsp;<a href="{{ route('users.show', $msg_item->receive_id)}}" target="_blank">{{ $msg_item->name }}</a>&nbsp;，
                      {{ $msg_item->created_at->diffForHumans() }}
                    </p>
                  </li>
                @endforeach
              </ul>
            @else
              <h4 class="text-center msg-no-item">暂无私信</h4>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

@section('script')
  {{-- textarea 自动调整高度 --}}
  <script>
  autosize($('textarea.autosize'));
  </script>
@stop
