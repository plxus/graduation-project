@extends('layouts.default')

@section('title', '创建知识清单')

@section('content')
  <div class="container">
    <div class="row">
      <form action="{{ route('repositories.store') }}" method="POST">
        @include('shared._errors')
        {{ csrf_field() }}
        
      </form>
    </div>
  </div>
@stop
