@extends('admin.layout')

@section('content')
<h2 class="page-header">Form Group: <small>{{ $group->name }}</small></h2>

{!! Form::open(['route' => ['admin.group.update', $group->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

  @include('admin.groupe._form')

  <div class="form-group mt-4">
    <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
  </div>

{!! Form::close() !!}

@endsection