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
          <li role="presentation" class="active"><a href="#notifications" aria-controls="notifications" role="tab" data-toggle="tab">&emsp;系统通知&emsp;</a></li>
          <li role="presentation"><a href="#received" aria-controls="received" role="tab" data-toggle="tab">&emsp;收到的私信&emsp;</a></li>
          <li role="presentation"><a href="#sent" aria-controls="sent" role="tab" data-toggle="tab">&emsp;发出的私信&emsp;</a></li>
        </ul>

        <div class="tab-content">
          {{-- 系统通知 --}}
          <div role="tabpanel" class="tab-pane fade in active" id="notifications">
            @if ($notifications->count())
              <br />
              <ul class="list-group">
              @foreach ($notifications as $notification)
                  <li class="list-group-item">
                    <h6>{{ $notification->subject }}</h6>
                    <p>
                      {{ $notification->content }}
                    </p>
                    <p class="small text-right">
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
                    <h6>{{ $msg_item->subject }}</h6>
                    <p>
                      {{ $msg_item->content }}
                    </p>
                    <p class="small text-right">
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
                    <h6>{{ $msg_item->subject }}</h6>
                    <p>
                      {{ $msg_item->content }}
                    </p>
                    <p class="small text-right">
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
