@extends('admin.layout')

@section('content')
<div class="page-header row justify-content-between">
    <h5>Settings</h5>
</div>

{!! Form::open(['route' => ['admin.settings.update'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
    @foreach($settings as $item)
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">{{$item->name}}</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="{{$item->key}}" value="{{$item->value}}">
      </div>
    </div>
    @endforeach

    <div class="form-group mt-4">
      <input type="submit" value="{{Lang::get('message.update')}}" class="btn btn-secondary">
    </div>
{!! Form::close() !!}

@endsection
