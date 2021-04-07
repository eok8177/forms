@extends('admin.layout')

@section('content')
<div class="page-header row justify-content-between">
    <h5>Settings</h5>
</div>

{!! Form::open(['route' => ['admin.settings.update'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
    @foreach($settings as $item)

    @if($item->key == 'maintenance_mode')<hr />@endif

    <div class="form-group row">
      <label class="col-sm-2 col-form-label">{{$item->name}}
        @if($item->key == 'maintenance_mode')
        <br /><small>access code: {{$maintenance_secret}}</small>
        @endif
      </label>
      <div class="col-sm-10">
        @if($item->key == 'maintenance_mode')
          {!! Form::checkbox('maintenance_mode', $item->value, $item->value == 1) !!}
        @elseif ($item->key == 'maintenance_text')
          <div class="form-group">
            {!! Form::textarea('maintenance_text', $item->value, ['class' => 'form-control editor']) !!}
          </div>
        @elseif($item->key == 'date_format')
          {!! Form::select('date_format', $dateFormats, $item->value, ['class' => 'custom-select']) !!}
        @else
            <input type="text" class="form-control" name="{{$item->key}}" value="{{$item->value}}">
        @endif
      </div>
    </div>
    @endforeach

    <div class="form-group mt-4">
      <input type="submit" value="{{Lang::get('message.update')}}" class="btn btn-secondary">
    </div>
{!! Form::close() !!}

@endsection
