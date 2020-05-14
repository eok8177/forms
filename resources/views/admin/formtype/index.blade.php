@extends('admin.layout')

@section('content')

<div class="page-header row justify-content-between">
  <h5>Form Types</h5>
  <a href="{{ route('admin.form-type.create') }}" class="btn btn-light"><i class="fa fa-plus-square"></i> @lang('message.new_formtype')</a>
</div>

<div class="position-relative">
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Name</th>
          <th scope="col" class="text-center">Actions</th>
        </tr>
      </thead>
      @foreach($form_types as $form_type)
        <tr data-id="{{$form_type->id}}">
          <td>
            <a href="{{ route('admin.form-type.edit', $form_type->id) }}" class="btn" style="color: {{$form_type->color}}">{{$form_type->name}}</a>
          </td>
          <td class="text-center">
            <a href="{{ route('admin.form-type.edit', $form_type->id) }}" class="btn fa fa-pencil" title="Edit"></a>
            @if($form_type->forms()->count() == 0)
              <a href="{{ route('admin.form-type.destroy', $form_type->id) }}" class="btn fa fa-trash-o delete" title="Delete"></a>
            @endif
          </td>
        </tr>

      @endforeach
    </table>
  </div>
</div>


@endsection
