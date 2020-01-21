@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.user') <small>{{ $user->login }}</small></h2>

{!! Form::open(['route' => ['admin.user.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
  @include('admin.user.form')
{!! Form::close() !!}

@endsection