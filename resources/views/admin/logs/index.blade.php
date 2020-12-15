@extends('admin.layout')

@section('content')

<div class="page-header row justify-content-between">
  <h5>API Logs</h5>
</div>

<div class="position-relative">
  <div class="table-responsive">
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Method</th>
          <th scope="col">Payload</th>
          <th scope="col">Response</th>
          <th scope="col">Date</th>
        </tr>
      </thead>
      @foreach($logs as $item)
        <tr>
          <td>{{$item->method}}</td>

          <td>
            <button class="btn btn-outline-secondary" type="button" data-toggle="collapse" data-target="#collapse_{{$item->id}}" aria-expanded="false" aria-controls="collapse_{{$item->id}}">
              Payload
            </button>
            <div class="collapse" id="collapse_{{$item->id}}">
              {{$item->payload}}
            </div>
          </td>

          <td>
            <button class="btn btn-outline-secondary" type="button" data-toggle="collapse" data-target="#collapse_2_{{$item->id}}" aria-expanded="false" aria-controls="collapse_2_{{$item->id}}">
              Response
            </button>
            <pre class="collapse" id="collapse_2_{{$item->id}}">
              {{print_r(json_decode($item->response, true))}}
            </pre>
          </td>

          <td>{{$item->created_at}}</td>
        </tr>
      @endforeach
    </table>
  </div>
</div>


@endsection
