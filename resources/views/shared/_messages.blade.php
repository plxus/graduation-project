@foreach (['danger', 'warning', 'success', 'info'] as $msg)
  @if(session()->has($msg))
    <div class="row">
      <div class="col-md-offset-2 col-md-8">
        <div class="alert alert-{{ $msg }} alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          {{ session()->get($msg) }}  {{--  获取相应的会话内容  --}}
        </div>
      </div>
    </div>
  @endif
@endforeach
