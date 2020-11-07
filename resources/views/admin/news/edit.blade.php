@extends('admin.layout')

@section('content')
<h2 class="page-header">News: <small>{{ $news->title }}</small></h2>

{!! Form::open(['route' => ['admin.news.update', $news->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
  @include('admin.news.form')
{!! Form::close() !!}

@endsection