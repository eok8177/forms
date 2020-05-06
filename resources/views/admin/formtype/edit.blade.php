@extends('admin.layout')

@section('content')
<h2 class="page-header">Form Type: <small>{{ $form_type->name }}</small></h2>

{!! Form::open(['route' => ['admin.form-type.update', $form_type->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

  <div class="form-group">
    <label for="title">Name</label>
    <input type="text" class="form-control" name="name" value="{{$form_type->name}}">
  </div>
  <div class="form-group">
    <label for="name">Description</label>
    {!! Form::textarea('description', $form_type->description, ['class' => 'form-control editor']) !!}
  </div>
  <div class="form-group mt-4">
    <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
  </div>

{!! Form::close() !!}

@endsection