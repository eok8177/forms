@extends('layouts.app')

@section('content')

<div class="container">
  <h2 class="page-header">{{$user->first_name}} {{$user->last_name}}</h2>

  <div class="row">
    @include('user.parts.sidebar', ['class_col' => 'col-md-2', 'slug' => 'security'])
    <div class="col-md-10">

		{!! Form::open(['route' => ['user.update_security'], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

		<div class="form-group">
            <label for="">{{Lang::get('message.old_password')}}</label>
            <input type="password" id="old_password" name="old_password" class="form-control">
        </div>

        <div class="form-group">
          <label for="">{{Lang::get('message.new_password')}}</label>
            <input type="password" id="password" name="password" class="form-control">
          </div>

          <div class="form-group">
            <label for="">{{Lang::get('message.re_password')}}</label>
            <input type="password" id="re_password" name="re_password" class="form-control">
		  </div>

		  <div class="form-group">
            <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
          </div>
        {!! Form::close() !!}
		  
    </div>

  </div>
</div>



@endsection