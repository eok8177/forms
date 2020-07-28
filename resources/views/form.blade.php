@extends('layouts.user')

@section('content')

<div class="dashboard-area tabs-area">

  @if($form)
  <h2>{{$form->title}}{{$form->draft ? ' [draft]' : ''}}</h2>

    @if(!$form->active())
      <div class="text">{{Lang::get('message.not_active_msg')}}</div>
    @elseif($form->shedule == 1 && $form->start_date > date('Y-m-d H:i:s'))
      <div class="text">{!! $form->pending_msg !!}</div>
    @elseif($form->shedule == 1 && $form->end_date < date('Y-m-d H:i:s'))
      <div class="text">{!! $form->expired_msg !!}</div>
    @else
      <form-gui-component class="py-2 px-2 bg-white"
        :form="{{$form->config ?? 'null'}}" 
        :formid="{{$form->id}}"
        :appid="0"
        :userid="{{Auth::user()->id ?? 0}}" >
      </form-gui-component>
    @endif
  @else
    <div class="text">{{Lang::get('message.not_active_msg')}}</div>
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