@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.new_form')</h2>

{!! Form::open(['route' => ['admin.form.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  
  <div class="form-group">
    <label for="name">{{Lang::get('message.name')}}</label>
    <input type="text" name="name" value="{{$form->name}}" class="form-control" required>
  </div>

  <div class="form-group">
    <label for="title">{{Lang::get('message.title')}}</label>
    <input type="text" name="title" value="{{$form->title}}" class="form-control" required>
  </div>

  <div class="form-group">
    <label for="title">Description</label>
    {!! Form::textarea('description', $form->description, ['class' => 'form-control', 'rows' => '2']) !!}
  </div>

    {!! Form::hidden('draft', 1) !!}

  <div class="custom-control custom-checkbox custom-control-inline">
    {!! Form::hidden('is_trash', 0) !!}
    {!! Form::checkbox('is_trash', 1, $form->is_trash, ['class' => 'custom-control-input', 'id' => 'is_trash']) !!}
    <label for="is_trash" class="custom-control-label">{{Lang::get('message.trash')}}</label>
  </div>

  <div class="form-group mt-4">
    <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
  </div>


{!! Form::close() !!}

@endsection