@extends('layouts.app')

@section('content')

<div class="container">

  @if($form->shedule == 0)
    <form-gui-component class="py-2 px-2 bg-white"
      :form="{{$form->config ?? 'null'}}" 
      :formid="{{$form->form_id}}"
      :appid="{{$form->id}}"
      :userid="{{Auth::user()->id ?? 0}}" >
  </form-gui-component>
  @elseif($form->start_date > date('Y-m-d H:i:s'))
    <div class="text">{!! $form->pending_msg !!}</div>
  @elseif($form->end_date < date('Y-m-d H:i:s'))
    <div class="text">{!! $form->expired_msg !!}</div>
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