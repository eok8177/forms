@extends('admin.layout')

@section('content')
<h2 class="page-header">News</h2>

{!! Form::open(['route' => ['admin.news.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  @include('admin.news.form')
{!! Form::close() !!}

@endsection