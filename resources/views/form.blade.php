@extends('layouts.app')

@section('content')

<div class="container">

  @if($form)
  <h2>{{$form->title}}{{$form->draft ? ' [draft]' : ''}}</h2>

    @if($form->draft == 1 || $form->is_trash == 1)
      <div class="text">{{Lang::get('message.not_active_msg')}}</div>
    @elseif($form->shedule == 1 && $form->start_date > date('Y-m-d H:i:s'))
      <div class="text">{!! $form->pending_msg !!}</div>
    @elseif($form->shedule == 1 && $form->end_date < date('Y-m-d H:i:s'))
      <div class="text">{!! $form->expired_msg !!}</div>
    @else
      <form-gui-component class="py-2 px-2 bg-white"
        :form="{{$form->config ?? 'null'}}" 
        :formid="{{$form->id}}"
        :userid="{{Auth::user()->id ?? 0}}" >
      </form-gui-component>
    @endif
  @else
    <div class="text">{{Lang::get('message.not_active_msg')}}</div>
  @endif

</div>

@endsection