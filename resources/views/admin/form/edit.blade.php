@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.form') <small>{{ $form->name }}</small></h2>

{!! Form::open(['route' => ['admin.form.update', $form->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
  @include('admin.form.form')
{!! Form::close() !!}

<hr>

<form-builder-component :formdata="{{$form->config ?? 'null'}}" :formid="{{$form->id}}"></form-builder-component>

@endsection