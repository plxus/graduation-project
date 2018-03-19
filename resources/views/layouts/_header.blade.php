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
      <form action="#" class="navbar-form navbar-left" method="get">
        <div class="form-group">
          <input type="text" class="form-control" name="search_keywords" placeholder="搜索你感兴趣的内容">
        </div>
        <button type="submit" class="btn btn-default">搜索</button>
      </form>
      <ul class="nav navbar-nav">
        <li><a href="{{ route('about') }}">关于</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        @auth
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-plus"></i>&nbsp;<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('repositories.create') }}">新建知识清单</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle navbar-avatar" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="{{ $user->gravatar('56') }}" alt="{{ $user->name.'_avatar' }}" class="img-rounded navbar-avatar" width="28px"/>&nbsp;<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-header">登录为 {{ $user->name }}</li>
              <li role="separator" class="divider"></li>
              <li><a href="{{ route('users.show', $user->id) }}">个人主页</a></li>
              <li><a href="#">我的收藏</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="{{ route('users.edit', $user->id) }}">设置</a></li>
              <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">注销</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </li>
        @else
          <li><a href="{{ route('register') }}">注册</a></li>
          <li><a href="{{ route('login') }}">登录</a></li>
        @endauth
      </ul>
      <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
  </div>
</nav>
