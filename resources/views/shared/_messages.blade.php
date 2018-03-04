@foreach (['danger', 'warning', 'success', 'info'] as $msg)
  @if(session()->has($msg))
    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        <div class="alert alert-{{ $msg }}" role="alert">
          {{ session()->get($msg) }}  {{--  获取相应的会话内容  --}}
        </div>
      </div>
    </div>
  @endif
@endforeach
