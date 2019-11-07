@extends('admin.layout')

@section('content')
<h5>Entry</h5>


<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Value</th>
      </tr>
    </thead>
    @foreach($entries as $entry)
      <tr>
        <td>{{$entry->name}}</td>
        <td>{{$entry->value}}</td>
      </tr>

    @endforeach
  </table>
</div>

@endsection
