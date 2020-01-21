@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.user') <small>{{ $user->login }}</small></h2>

{!! Form::open(['route' => ['admin.user.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

    <div class="form-group">
      <label for="name">@lang('message.loged_at'): {{$user->last_logged_in}}</label>
    </div>

  @include('admin.user.form')
{!! Form::close() !!}

@endsection