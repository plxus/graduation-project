@extends('layouts.default')

@section('title', $user->name)

@section('content')
<h1>用户主页</h1>
{{ $user->name }} - {{ $user->email }}
@stop
