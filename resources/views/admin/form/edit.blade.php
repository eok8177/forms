@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.form') <small>{{ $form->title }}</small></h2>

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