@extends('admin.layout')

@section('content')

<div class="page-header row justify-content-between">
	<h5>Pages</h5>
</div>

<div class="table-responsive">
	<table class="table table-hover">
	<thead>
      <tr>
        <th scope="col">@lang('message.id')</th>
		<th scope="col">@lang('message.actions')</th>
        <th scope="col">@lang('message.title')</th>
    </tr>
	</thead>
	@foreach($pages as $page)
	<tr>
		<td>{{$page->id}}</td>
		<td>
			<a href="{{ route('admin.page.edit', $page->id) }}" class="btn fa fa-pencil" title="Edit"></a>
		</td>
		<td>{{$page->title}}</td>
	</tr>
    @endforeach
  </table>
</div>


@endsection
