@extends('admin.layout')

@section('content')
<h5>Dashboard</h5>


<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Responses</th>
        <th scope="col">
          <div class="dropdown">
            <a class="btn btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownForms" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Form</a>
            <div class="dropdown-menu" aria-labelledby="dropdownForms">
              @foreach($select_forms as $id => $item)
                <a class="dropdown-item" href="{{ route('admin.dashboard', ['id' => $id]) }}">{{$item}}</a>
              @endforeach
            </div>
          </div>
        </th>
        <th scope="col">Date</th>
      </tr>
    </thead>
    @foreach($entries as $entry)
      <tr>
        <td><a href="{{ route('admin.entry', $entry->entry_id) }}" class="btn">{{$entry->entry_id}}</a></td>
        <td>{{$forms[$entry->form_id]}}</td>
        <td>{{$entry->created_at}}</td>
      </tr>

    @endforeach
  </table>
</div>

@endsection
