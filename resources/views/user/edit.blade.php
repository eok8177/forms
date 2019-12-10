@extends('layouts.app')

@section('content')

<div class="container">
  <h2 class="page-header">{{$user->first_name}} {{$user->last_name}}</h2>

  <div class="row">
    <div class="col-md-10">
        {!! Form::open(['route' => ['user.update'], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

          <input type="text" name="" class="autofeel-hack">
          <input type="password" name="" class="autofeel-hack">

          <div class="form-group">
            <label for="name">{{Lang::get('message.first_name')}}</label>
            <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control">
          </div>

          <div class="form-group">
            <label for="name">{{Lang::get('message.last_name')}}</label>
            <input type="text" name="last_name" value="{{$user->last_name}}" class="form-control">
          </div>

          <div class="form-group">
            <label for="email">{{Lang::get('message.email')}}</label>
            <input type="text" name="email" value="{{$user->email}}" class="form-control">
          </div>

          <hr>

          <div class="form-group">
            <label for="">{{Lang::get('message.new_password')}}</label>
            <input type="password" name="password" class="form-control">
          </div>

          <div class="form-group">
            <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
          </div>
        {!! Form::close() !!}
    </div>
    <div class="col-md-2">
        <div class="list-group">
          <a class="list-group-item list-group-item-action" href="/user">My Apps</a>
          <a class="list-group-item list-group-item-action" href="/user/edit">My details</a>
        </div>
    </div>
  </div>
</div>


@endsection

@push('styles')
<style type="text/css">
  .autofeel-hack {
    position: absolute;
    top: -999px;
  }
</style>
@endpush