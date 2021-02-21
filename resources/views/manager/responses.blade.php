@extends('manager.layout')

@section('content')

<div class="dashboard-area tabs-area">

    <h2>Responses</h2>
    <div class="tab-content">

      <div class="container-fluid pt-md-3">
        <div class="btn-group">
          <input type="text" id="search" class="form-control"
            placeholder="Name Surname   Form name"
            value="{{$search}}">
          <button class="btn btn-outline-info" onclick="searchByName()">Search</button>
        </div>

        <div class="row border-top border-bottom py-1 my-2 font-weight-bold align-items-center">
          <div class="col-md-2"></div>
          <div class="col-md-3">
            <div class="dropdown">
              <a class="btn btn-outline-info dropdown-toggle" href="#" role="button" id="dropdownForms" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $select_forms[$form_id] }}</a>

              <div class="dropdown-menu" aria-labelledby="dropdownForms">
                @foreach($select_forms as $id => $item)
                  <button class="dropdown-item" onclick="setId({{$id}})">{{$item}}</button>
                @endforeach
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="btn-group mr-3">
              <input type="text" id="datetimepicker1" class="form-control datetimepicker-input"
                data-toggle="datetimepicker"
                data-target="#datetimepicker1"
                placeholder="Date from"
                style="width: 120px"
                value="{{$from}}">
              <input type="text" id="datetimepicker2" class="form-control datetimepicker-input"
                data-toggle="datetimepicker"
                data-target="#datetimepicker2"
                placeholder="Date to"
                style="width: 120px"
                value="{{$to}}">
              <button class="btn btn-outline-info" onclick="setDate()">Filter</button>
            </div>
          </div>
          <div class="col-md-2 text-center">
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
          </div>
        </div>

        <div class="row border-bottom py-1 my-2 font-weight-bold align-items-center">
          <div class="col-md-2">Type</div>
          <div class="col-md-3">ID - Details</div>
          <div class="col-md-2">User</div>
          <div class="col-md-2">Date</div>
          <div class="col-md-2 text-center">Status</div>
          <div class="col-md-1 text-center">Actions</div>
        </div>

        @foreach($apps as $app)
          <div class="row border-bottom mb-2 justify-content-center h-100">
            <div class="col-md-2">
              <span class="w-100 h-100 d-flex justify-content-center align-items-center" style="background-color: {{$app->form->types->color}}; color: #fff;">{{$app->form->type}}</span>
            </div>
            <div class="col-md-3">
                {{$app->id}} - {{$app->form->title}} <span class="text-muted">{!! @$app->additional_field !!}</span>
            </div>
            <div class="col-md-2">{{$app->user->first_name}} {{$app->user->last_name}}</div>
            <div class="col-md-2">{{$app->created_at}}</div>
            <div class="col-md-2 text-center">
              @if($app->status == 'submitted' && $app->to_be_approved == 1)
                For Review
              @elseif($app->status == 'rejected')
                Rejected
              @elseif($app->status == 'draft')
                Draft
              @elseif($app->status == 'accepted')
                Accepted
              @else
                Submitted
              @endif
            </div>
            <div class="col-md-1 text-center">
              @if($app->has_alert)
                <i class="fa fa-exclamation-triangle" aria-hidden="true" title="{{$app->has_alert}}"></i>
              @endif
              @if($app->status == 'submitted' || $app->status == 'accepted' || $app->status == 'rejected' || $app->to_be_approved == 0)
                <a href="{{ route('manager.response', $app->id) }}" class="btn fa fa-eye" target="_blank" title="View Response in new Tab"></a>
              @endif
            </div>
          </div>
        @endforeach

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


    $('#search').keypress(function (e) {
     var key = e.which;
     if(key == 13)  // the enter key code
      {
        searchByName();
        return false;
      }
    });

  });

  var url = "{{ route('manager.responses') }}";
  var id = "{{$form_id}}";
  var status = "{{$status}}";
  var from = "{{$from}}";
  var to = "{{$to}}";
  var search = "{{$search}}";

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
  function searchByName() {
    search = $('#search').val();
    filter();
  }

  function filter() {
    url = url + '?id='+id+'&status='+status;
    if(from) url = url+'&from='+from;
    if(to) url = url+'&to='+to;
    if(search) url = url+'&search='+search;
    window.location.href = url;
  }
</script>
@endpush