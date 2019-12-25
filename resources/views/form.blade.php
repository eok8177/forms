@extends('layouts.app')

@section('content')

<div class="container">

  <h2>{{$form->title}}</h2>

  @if($form->shedule == 0)
    <form-gui-component class="py-2 px-2 bg-white"
      :form="{{$form->config ?? 'null'}}" 
      :formid="{{$form->form_id}}"
      :userid="{{Auth::user()->id ?? 0}}" >
  </form-gui-component>
  @elseif($form->start_date > date('Y-m-d H:i:s'))
    <div class="text">{!! $form->pending_msg !!}</div>
  @elseif($form->end_date < date('Y-m-d H:i:s'))
    <div class="text">{!! $form->expired_msg !!}</div>
  @endif

</div>

@endsection