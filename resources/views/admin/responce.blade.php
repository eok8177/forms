@extends('admin.layout')

@section('content')
<h5>Responces</h5>


<div class="__table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">
          <div class="dropdown">
            <a class="btn btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownForms" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $select_forms[$form_id] }}</a>
			
            <div class="dropdown-menu" aria-labelledby="dropdownForms">
              @foreach($select_forms as $id => $item)
                <a class="dropdown-item" href="{{ route('admin.responces', ['status' => $status, 'id' => $id]) }}">{{$item}}</a>
              @endforeach
            </div>
          </div>
        </th>
		<th scope="col" class="col-md-3 text-center">Date</th>
        <th scope="col" class="col-md-1">
          <div class="dropdown">
            <a class="btn btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownStatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $status }}</a>
          
            <div class="dropdown-menu" aria-labelledby="dropdownStatus">
              <a class="dropdown-item" href="{{ route('admin.responces', ['id' => $form_id, 'status' => 'All Statuses']) }}">All Statuses</a>
              <a class="dropdown-item" href="{{ route('admin.responces', ['id' => $form_id, 'status' => 'draft']) }}">Draft</a>
              <a class="dropdown-item" href="{{ route('admin.responces', ['id' => $form_id, 'status' => 'submitted']) }}">Submitted</a>
              <a class="dropdown-item" href="{{ route('admin.responces', ['id' => $form_id, 'status' => 'rejected']) }}">Rejected</a>
              <a class="dropdown-item" href="{{ route('admin.responces', ['id' => $form_id, 'status' => 'accepted']) }}">Accepted</a>
            </div>
          </div>
        </th>
		<th scope="col" class="col-md-2 text-center">Actions</th>
      </tr>
    </thead>
    @foreach($entries as $entry)
      <tr>
        <td><a href="{{ route('admin.entry', ['entry' => $entry->entry_id]) }}" class="btn">{{$select_forms[$entry->form_id]}}</a></td>
        <td class="text-center">{{$entry->created_at}}</td>
        <td>{{$entry->status}}</td>
        <td class="text-center">
          @if($entry->status == 'submitted' || $entry->status == 'accepted' || $entry->status == 'rejected' || $entry->to_be_approved == 0)
            <a href="{{ route('admin.entry', ['entry' => $entry->entry_id]) }}" class="btn fa fa-eye" target="_blank" title="View Entry in new Tab"></a>
          @endif
          @if($entry->status == 'submitted' && $entry->to_be_approved == 1 && $user->role == 'manager')
            <a href="{{ route('admin.entryStatus', ['entry' => $entry->entry_id, 'status' => 'accepted']) }}" class="btn fa fa-thumbs-o-up" title="Accept Entry"></a>
            <button type="button" class="btn fa fa-thumbs-o-down rejectBtn" data-toggle="modal" data-target="#rejectModal" data-item="{{$entry->id}}" data-title="{{$select_forms[$entry->form_id]}}" title="Reject Entry"></button>
          @endif
        </td>
      </tr>

    @endforeach
  </table>
</div>

<!-- Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel">Reject Responce: <span id="modalTitle"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open(['route' => ['admin.entryReject'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="modal-body">
          <div class="form-group">
            <label for="rejectText">Enter the reason</label>
            <textarea name="rejection" class="form-control" id="rejectText" data-id="" rows="3"></textarea>
            <input type="hidden" name="id" id="rejectId">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Confirm Reject</button>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  $(function () {
    $('body').on('click', '.rejectBtn', function(){
      let id = $(this).attr('data-item');
      let title = $(this).attr('data-title');
      $('#rejectId').val(id);
      $('#modalTitle').text(title);
    });
  });
</script>
@endpush