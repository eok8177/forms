@extends('admin.layout')

@section('content')

<div class="page-header row justify-content-between">
  <h5>API Logs</h5>
</div>

<div class="position-relative">
  <div class="table-responsive">
    <table class="table table-hover sorted_table">
      <thead>
        <tr>
          <th scope="col">Method</th>
        </tr>
      </thead>
      @foreach($logs as $item)
        <tr data-id="{{$item->id}}">
          <td>{{$item->method}}</td>
        </tr>
      @endforeach
    </table>
  </div>
</div>


@endsection
