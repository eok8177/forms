@extends('layouts.user')

@section('content')

<div class="dashboard-area tabs-area">
  <h2>{{$app->form->name}}</h2>

@if($app->shedule == 0)
  <form-view-component class="py-2 px-2 bg-white"
    :form="{{$app->config ?? 'null'}}">
</form-view-component>
@elseif($app->start_date > date('Y-m-d H:i:s'))
  <div class="text">{!! $app->pending_msg !!}</div>
@elseif($app->end_date < date('Y-m-d H:i:s'))
  <div class="text">{!! $app->expired_msg !!}</div>
@endif

</div>

@endsection

@push('scripts')
<script>
  const DATE_FORMAT = '{{$settings['date_format'] ?? 'false'}}';
  const KEY_MAP = '{{$settings['key_map'] ?? 'false'}}';
  window.FIRST_NAME = '{{$user->first_name ?? false}}';
  window.LAST_NAME = '{{$user->last_name ?? false}}';
  window.EMAIL = '{{$user->email ?? false}}';
</script>
@endpush
