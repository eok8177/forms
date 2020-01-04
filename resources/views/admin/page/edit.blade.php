@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.page') <small>{{ $page->title }}</small></h2>

{!! Form::open(['route' => ['admin.page.update', $page->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
  @include('admin.page.form')
{!! Form::close() !!}

@endsection