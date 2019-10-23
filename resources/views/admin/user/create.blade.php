@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.new_user')</h2>

{!! Form::open(['route' => ['admin.user.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  @include('admin.user.form')
{!! Form::close() !!}

@endsection