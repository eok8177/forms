@extends('manager.layout')

@section('content')

<div class="page-header row justify-content-between">
  <h5></h5>
  <div>
  @if($app->status == 'submitted' && $app->to_be_approved == 1)
    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#rejectModal" title="Approv or Reject Entry">Take action</button>
  @endif
  </div>
</div>

<div class="dashboard-area tabs-area">
  <h2>{{$app->form->title}} &nbsp;&nbsp;&nbsp;<small>{{$app->user->first_name}} {{$app->user->last_name}}</small></h2>
  <form-view-component class="py-2 px-2 bg-white"
        :form="{{$app->config ?? 'null'}}" >
  </form-view-component>
</div>


<!-- Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel">Approve Response</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open(['route' => ['manager.responseStatus', $app->id], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="modal-body">
          <div class="form-group">
            <label for="rejectText">Enter the reason</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="status" value="-1" class="btn btn-outline-danger">Reject</button>
          <button type="submit" name="status" value="1" class="btn btn-outline-success">Accept</button>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  const DATE_FORMAT = '{{$settings['date_format'] ?? 'false'}}';
  const KEY_MAP = '{{$settings['key_map'] ?? 'false'}}';
</script>
@endpush

@push('styles')
<style>
  .main-holder #content {z-index: auto;}
  .dashboard-area {
    position: relative;
    z-index: 1;
  }
</style>
@endpush