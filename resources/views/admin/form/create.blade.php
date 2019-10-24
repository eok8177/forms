@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.new_form')</h2>

{!! Form::open(['route' => ['admin.form.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  @include('admin.form.form')
{!! Form::close() !!}

@endsection