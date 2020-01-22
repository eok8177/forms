@extends('admin.layout')

@section('content')
<h2 class="page-header">Form Type</h2>

{!! Form::open(['route' => ['admin.form-type.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}

    <div class="form-group">
      <label for="title">Name</label>
      <input type="text" class="form-control" name="name" value="{{$form_type->name}}">
    </div>
    <div class="form-group mt-4">
      <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
    </div>

{!! Form::close() !!}

@endsection