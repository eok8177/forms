@extends('admin.layout')

@section('content')
<h5>Dashboard</h5>


<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Responses</th>
        <th scope="col">Form</th>
      </tr>
    </thead>
    @foreach($entries as $entry)
      <tr>
        <td><a href="{{ route('admin.entry', $entry->entry_id) }}" class="btn">{{$entry->entry_id}}</a></td>
        <td>{{$forms[$entry->form_id]}}</td>
      </tr>

    @endforeach
  </table>
</div>

@endsection
