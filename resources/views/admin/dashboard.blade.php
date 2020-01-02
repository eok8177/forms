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
            <a class="btn btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownForms" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $select_forms[$form_id] }}</a>
			
            <div class="dropdown-menu" aria-labelledby="dropdownForms">
              @foreach($select_forms as $id => $item)
                <a class="dropdown-item" href="{{ route('admin.dashboard', ['status' => $status, 'id' => $id]) }}">{{$item}}</a>
              @endforeach
            </div>
          </div>
        </th>
        <th scope="col">Date</th>
        <th scope="col">
          <div class="dropdown">
            <a class="btn btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownStatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $status }}</a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownStatus">
              <a class="dropdown-item" href="{{ route('admin.dashboard', ['id' => $form_id, 'status' => 'Status']) }}">All</a>
              <a class="dropdown-item" href="{{ route('admin.dashboard', ['id' => $form_id, 'status' => 'draft']) }}">Draft</a>
              <a class="dropdown-item" href="{{ route('admin.dashboard', ['id' => $form_id, 'status' => 'submitted']) }}">Submitted</a>
              <a class="dropdown-item" href="{{ route('admin.dashboard', ['id' => $form_id, 'status' => 'rejected']) }}">Rejected</a>
              <a class="dropdown-item" href="{{ route('admin.dashboard', ['id' => $form_id, 'status' => 'accepted']) }}">Accepted</a>
            </div>
          </div>
        </th>
      </tr>
    </thead>
    @foreach($entries as $entry)
      <tr>
        <td>
          @if($entry->status == 'submitted' || $entry->status == 'accepted' || $entry->status == 'rejected')
            <a href="{{ route('admin.entry', ['entry' => $entry->entry_id]) }}" class="btn fa fa-eye" target="_blank" title="View Entry in new Tab"></a>
          @endif
          @if($entry->status == 'submitted')
            <a href="{{ route('admin.entryStatus', ['entry' => $entry->entry_id, 'status' => 'accepted']) }}" class="btn fa fa-check-square-o" title="Accept Entry"></a>
            <a href="{{ route('admin.entryStatus', ['entry' => $entry->entry_id, 'status' => 'rejected']) }}" class="btn fa fa-thumbs-o-down" title="Reject Entry"></a>
          @endif
        </td>
        <td>{{$select_forms[$entry->form_id]}}</td>
        <td>{{$entry->created_at}}</td>
        <td>{{$entry->status}}</td>
      </tr>

    @endforeach
  </table>
</div>

@endsection
