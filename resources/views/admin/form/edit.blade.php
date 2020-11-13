@extends('admin.layout')

@section('content')
<div class="page-header row justify-content-between">
  <h2>@lang('message.form') <small>{{ $form->title }}</small></h2>

  <div>
      <a class="btn fa fa-gear" href="{{route('admin.form.setting',$form->id)}}" title="Settings"></a>
      <a class="btn fa fa-envelope-o" href="{{route('admin.form.email',$form->id)}}" title="Email Notification"></a>
  </div>
</div>



<form-builder-component :formdata="{{$form->config ?? 'null'}}" :formid="{{$form->id}}"></form-builder-component>

@endsection

@push('scripts')
<script>
  function preview() {
    window.open('/form/{{$form->slug}}', '_blank');
  }
</script>

<script>
  const DATE_FORMAT = '{{$settings['date_format'] ?? 'false'}}';
  const KEY_MAP = '{{$settings['key_map'] ?? 'false'}}';
</script>
@endpush