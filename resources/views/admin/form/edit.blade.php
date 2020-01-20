@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.form') <small>{{ $form->title }}</small></h2>

<form-builder-component :formdata="{{$form->config ?? 'null'}}" :formid="{{$form->id}}"></form-builder-component>

@endsection