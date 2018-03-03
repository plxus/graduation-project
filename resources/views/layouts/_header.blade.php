<nav class="navbar navbar-fixed-top navbar-inverse">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}">知所</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <!-- <ul class="nav navbar-nav">
      <li><a href="{{ route('home') }}">知所</a></li>
    </ul> -->
    <form class="navbar-form navbar-left">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="搜索你感兴趣的内容">
      </div>
      <button type="submit" class="btn btn-default">搜索</button>
    </form>
    <ul class="nav navbar-nav">
      <li><a href="{{ route('about') }}">关于</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      @if (Auth::check())
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="" title="用户头像"> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">登录为 {{ $user->name }}</li>
            <li role="separator" class="divider"></li>
            <li><a href="#">个人主页</a></li>
            <li><a href="#">我的收藏</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">设置</a></li>
            <li><a href="#">注销</a></li>
          </ul>
        </li>
      @else
        <li><a href="{{ route('signup') }}">注册</a></li>
        <li><a href="#">登录</a></li>
      @endif
      </ul>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
  </div>
</nav>
