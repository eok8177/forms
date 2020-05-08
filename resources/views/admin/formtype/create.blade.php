@extends('admin.layout')

@section('content')
<h2 class="page-header">New Form Type</h2>

{!! Form::open(['route' => ['admin.form-type.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}

  @include('admin.formtype._form')

  <div class="form-group mt-4">
    <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
  </div>

{!! Form::close() !!}

@endsection