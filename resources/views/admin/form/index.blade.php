@extends('admin.layout')

@section('content')
<div class="page-header">
  <h2>@lang('message.forms')</h2>
  <div>
    <a href="{{ route('admin.form.create') }}" class="btn btn-light"><i class="fa fa-plus-square"></i> @lang('message.create')</a>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">@lang('message.actions')</th>
        <th scope="col">@lang('message.title')</th>
        <th scope="col">@lang('message.active')</th>
        <th scope="col">@lang('message.trash')</th>
      </tr>
    </thead>
    @foreach($forms as $form)
      <tr>
        <td>
          <a href="{{ route('admin.form.edit',    $form->id) }}" class="btn fa fa-pencil"></a>
          <a href="{{ route('admin.form.destroy', $form->id) }}" class="btn fa fa-trash-o delete"></a>
        </td>
        <td>{{$form->title}}</td>
        <td>
            <a href="{{route('admin.ajax.status', ['id' => $form->id, 'model' => 'Form', 'field' => 'is_active'])}}" class="status btn fa fa-{{$form->is_active ? 'check-circle' : 'times-circle'}}"></a>
        </td>
        <td>
          <a href="{{route('admin.ajax.status', ['id' => $form->id, 'model' => 'Form', 'field' => 'is_trash'])}}" class="status btn fa fa-{{$form->is_trash ? 'check-circle' : 'times-circle'}}"></a>
        </td>
      </tr>

    @endforeach
  </table>
</div>

@endsection