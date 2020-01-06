@extends('admin.layout')

@section('content')
<div class="page-header row justify-content-between">
<h5>{{ $trash == 0 ? __('message.forms_all') : __('message.forms_trashed') }}</h5>
  <a href="{{ route('admin.form.create') }}" class="btn btn-light"><i class="fa fa-plus-square"></i> @lang('message.create')</a>
</div>

<div class="table-responsive">

  <form class="input-group mb-3" action="{{ route('admin.form.index') }}" method="get">

    <a class="btn btn-outline-secondary mr-5" href="{{ route('admin.form.index', ['trash' => 1-$trash ]) }}"> Show {{ $trash==0 ? __('message.forms_trashed') : __('message.forms_all')}}</a>

    <input type="text" class="form-control" placeholder="Search ..." name="search">
    <div class="input-group-append">
      <button class="btn btn-outline-secondary" type="submit" >Search</button>
    </div>
  </form>

@if ($total_records > 0)
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">@lang('message.id')</th>
        <th scope="col">@lang('message.actions')</th>
        <th scope="col">@lang('message.title')</th>
        <th scope="col">@lang('message.active')</th>
        <th scope="col">@lang('message.trash')</th>
      </tr>
    </thead>
    @foreach($forms as $form)
      <tr>
	  	<td>{{$form->id}}</td>
        <td>
          <a href="{{ route('admin.form.edit',    $form->id) }}" class="btn fa fa-pencil" title="Edit"></a>
          {{-- <a href="{{ route('admin.form.destroy', $form->id) }}" class="btn fa fa-trash-o delete"></a> --}}
          <a class="btn fa fa-gear" href="{{route('admin.form.setting',$form->id)}}" title="Setings"></a>
          <a class="btn fa fa-envelope-o" href="{{route('admin.form.email',$form->id)}}" title="Email Notification"></a>
          <a class="btn fa fa-eye" href="{{route('front.form',$form->id)}}" target="_blank" title="Open Form in new window"></a>
        </td>
        <td>{{$form->title}}</td>
        <td>
            <a href="{{route('admin.ajax.status', ['id' => $form->id, 'model' => 'Form', 'field' => 'is_active'])}}" class="status btn fa fa-{{$form->is_active ? 'check-circle' : 'times-circle'}}" title="Toggle Active"></a>
        </td>
        <td>
          <a href="{{route('admin.ajax.status', ['id' => $form->id, 'model' => 'Form', 'field' => 'is_trash'])}}" class="status btn fa fa-{{$form->is_trash ? 'check-circle' : 'times-circle'}}" title="Toggle trash"></a>
        </td>
      </tr>

    @endforeach
  </table>
@else
	@lang('message.no_records').
@endif
</div>

{{ $forms->appends(request()->except('page'))->links('admin.parts.pagination') }}

@endsection