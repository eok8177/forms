@extends('admin.layout')

@section('content')
<h5>Responses</h5>


<div class="__table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">
          <div class="dropdown">
            <a class="btn btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownForms" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $select_forms[$form_id] }}</a>

            <div class="dropdown-menu" aria-labelledby="dropdownForms">
              @foreach($select_forms as $id => $item)
                <button class="dropdown-item" onclick="setId({{$id}})">{{$item}}</button>
              @endforeach
            </div>
          </div>
        </th>
    <th scope="col" class="col-md-3 text-center">
      <div class="btn-group">
        <input type="text" id="datetimepicker1" class="form-control datetimepicker-input"
          data-toggle="datetimepicker"
          data-target="#datetimepicker1"
          placeholder="Date from"
          value="{{$from}}">
        <input type="text" id="datetimepicker2" class="form-control datetimepicker-input"
          data-toggle="datetimepicker"
          data-target="#datetimepicker2"
          placeholder="Date to"
          value="{{$to}}">
        <button class="btn btn-outline-info" onclick="setDate()">Filter</button>
      </div>
    </th>
    <th scope="col" class="col-md-1">
      <div class="dropdown">
        <a class="btn btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownStatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $status }}</a>

        <div class="dropdown-menu" aria-labelledby="dropdownStatus">
          <button class="dropdown-item" onclick="setStatus('All Statuses')">All Statuses</a>
          <button class="dropdown-item" onclick="setStatus('draft')">Draft</a>
          <button class="dropdown-item" onclick="setStatus('submitted')">Submitted</a>
          <button class="dropdown-item" onclick="setStatus('rejected')">Rejected</a>
          <button class="dropdown-item" onclick="setStatus('accepted')">Accepted</a>
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
        <h5 class="modal-title" id="rejectModalLabel">Reject Response: <span id="modalTitle"></span></h5>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />

<script>
  $(function () {

    var format = 'YYYY-MM-DD';

    $('#datetimepicker1').datetimepicker({
      format: format,
      date: moment($('#datetimepicker1').val(), format).toDate()
    });
    $('#datetimepicker2').datetimepicker({
      format: format,
      date: moment($('#datetimepicker2').val(), format).toDate()
    });

    $('body').on('click', '.rejectBtn', function(){
      let id = $(this).attr('data-item');
      let title = $(this).attr('data-title');
      $('#rejectId').val(id);
      $('#modalTitle').text(title);
    });
  });

  var url = "{{ route('admin.responses') }}";
  var id = "{{$form_id}}";
  var status = "{{$status}}";
  var from = "{{$from}}";
  var to = "{{$to}}";

  function setDate() {
    from = $('#datetimepicker1').val();
    to = $('#datetimepicker2').val();
    filter();
  }
  function setId(val) {
    id = val;
    filter();
  }
  function setStatus(val) {
    status = val;
    filter();
  }
  function filter() {
    url = url + '?id='+id+'&status='+status;
    if(from) url = url+'&from='+from;
    if(to) url = url+'&to='+to;
    window.location.href = url;
  }
</script>
@endpush