@extends('admin.front_layout')

@section('content')

<div class="d-flex mb-3 justify-content-between">
  <h5></h5>
  <div>
  @if($app->approvs->count())
    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#historyModal" title="History approvs">History</button>
  @endif
  </div>
</div>

<div class="dashboard-area tabs-area">
  <h2>{{$app->form->title}} &nbsp;&nbsp;&nbsp;<small>{{$app->user->first_name}} {{$app->user->last_name}}</small></h2>
  <form-view-component class="py-2 px-2 bg-white"
        :form="{{$app->config ?? 'null'}}" >
  </form-view-component>
</div>


<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="historyModalLabel">History</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          @foreach($app->approvs as $approv)
          <tr>
            <td>{{$approv->created_at}}</td>
            <td>{{$approv->status == '-1' ? 'Rejected' : 'Accepted'}}</td>
            <td>{{$approv->notes}}</td>
          </tr>
          @endforeach
        </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">Close</button>
      </div>
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