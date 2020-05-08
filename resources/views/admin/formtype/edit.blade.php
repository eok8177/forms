@extends('admin.layout')

@section('content')
<h2 class="page-header">Form Type: <small>{{ $form_type->name }}</small></h2>

{!! Form::open(['route' => ['admin.form-type.update', $form_type->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

  @include('admin.formtype._form')

  <div class="form-group mt-4">
    <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
  </div>

{!! Form::close() !!}

@endsection