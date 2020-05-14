@extends('admin.layout')

@section('content')

<div class="page-header row justify-content-between">
  <h5>Form Groups</h5>
  <a href="{{ route('admin.group.create') }}" class="btn btn-light"><i class="fa fa-plus-square"></i> @lang('message.new_formgroup')</a>
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
      @foreach($groups as $group)
        <tr data-id="{{$group->id}}">
          <td>
            <a href="{{ route('admin.group.edit', $group->id) }}" class="btn">{{$group->name}}</a>
          </td>
          <td class="text-center">
            <a href="{{ route('admin.group.edit', $group->id) }}" class="btn fa fa-pencil" title="Edit"></a>
            @if($group->empty())
              <a href="{{ route('admin.group.destroy', $group->id) }}" class="btn fa fa-trash-o delete" title="Delete"></a>
            @endif
          </td>
        </tr>

      @endforeach
    </table>
  </div>
</div>


@endsection
