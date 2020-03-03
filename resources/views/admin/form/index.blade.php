@extends('admin.layout')

@section('content')
<div class="page-header row justify-content-between">
<h5>{{ $trash == 0 ? __('message.forms_all') : __('message.forms_trashed') }}</h5>
  <div>
    <a href="{{ route('admin.group.index') }}" class="btn btn-light"><i class="fa fa-list"></i> @lang('message.formgroups')</a>
    <a href="{{ route('admin.form-type.index') }}" class="btn btn-light"><i class="fa fa-list"></i> @lang('message.formtypes')</a>
    <a href="{{ route('admin.form.create') }}" class="btn btn-light"><i class="fa fa-plus-square"></i> @lang('message.create')</a>
  </div>
</div>



  <form class="input-group mb-3" action="{{ route('admin.form.index') }}" method="get">

    <a class="btn btn-outline-secondary mr-5" href="{{ route('admin.form.index', ['trash' => 1-$trash ]) }}"> Show {{ $trash==0 ? __('message.forms_trashed') : __('message.forms_all')}}</a>

    <input type="text" class="form-control" placeholder="Search ..." name="search" value="{{$search}}">
    <div class="input-group-append">
      <button class="btn btn-outline-secondary" type="submit" >Search</button>
    </div>
  </form>

@if ($forms->count() > 0)

    <div class="row border-top border-bottom py-1 my-2 font-weight-bold align-items-center">
      <div class="col">@lang('message.name')</div>
      <div class="col text-center">
        <div class="dropdown">
          <a class="btn btn-outline-secondary btn-sm dropdown-toggle" href="#" role="button" id="dropdownTypes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $form_type_id > 0 ? $form_types[$form_type_id] : __('message.type') }}</a>

          <div class="dropdown-menu" aria-labelledby="dropdownTypes">
            @foreach($form_types as $id => $name)
              <a class="dropdown-item" href="{{ route('admin.form.index', ['form_type_id' => $id, 'trash' => $trash ]) }}">{{$name}}</a>
            @endforeach
          </div>
        </div>
      </div>
      <div class="col-md-3 text-center">@lang('message.actions')</div>
    </div>
    @foreach($forms as $form)
      <div class="row border-bottom mb-2">

        <div class="col d-flex align-items-center">
            <a href="{{ route('admin.form.edit', $form->id) }}" class="text-body" title="Edit">{{$form->name}}{{$form->draft ? ' [draft]' : ''}}</a>
        </div>

        <div class="col text-center"><a href="{{ route('admin.form.edit', $form->id) }}" class="btn" title="Edit">{{$form->type}}</a></div>

        <div class="col-md-3 text-left">
          <a href="{{ route('admin.form.copy', $form->id) }}" class="btn fa fa-files-o" title="Duplicate Form"></a>
          <a href="{{ route('admin.form.edit', $form->id) }}" class="btn fa fa-pencil" title="Edit"></a>
          <a href="{{route('admin.ajax.status', ['id' => $form->id, 'model' => 'Form', 'field' => 'draft'])}}" class="status btn fa fa-{{$form->draft ? 'check-circle' : 'times-circle'}} reload" title="Toggle Draft"></a>
          <a class="btn fa fa-gear" href="{{route('admin.form.setting',$form->id)}}" title="Setings"></a>
          <a class="btn fa fa-envelope-o" href="{{route('admin.form.email',$form->id)}}" title="Email Notification"></a>
          <a class="btn fa fa-eye" href="{{route('front.form',$form->slug)}}" target="_blank" title="Open Form in new window"></a>

          @if(!$form->has_apps)
            <a href="{{route('admin.ajax.status', ['id' => $form->id, 'model' => 'Form', 'field' => 'is_trash'])}}" class="status btn fa fa-{{$form->is_trash ? 'trash-o' : 'trash-o'}} reload" title="Toggle trash"></a>
          @endif
        </div>

      </div>

    @endforeach

@else
	@lang('message.no_records').
@endif


{{ $forms->appends(request()->except('page'))->links('admin.parts.pagination') }}

@endsection