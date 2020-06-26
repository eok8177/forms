@extends('layouts.app')

@section('content')

<div class="container">

  <div class="list-group">
    @foreach($forms as $form)
    <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" href="{{route('front.form',$form->slug)}}">
      <span>
        {{$form->title}}
        <small><b> [{{$form->types->name}}]</b></small>
        @foreach($form->groups as $group)
        <small> [{{$group->name}}]</small>
        @endforeach
      </span>
      <span>
        @if(!$form->active())
          not Active
        @elseif($form->shedule == 1 && $form->start_date > date('Y-m-d H:i:s'))
          {!! $form->pending_msg !!}
        @elseif($form->shedule == 1 && $form->end_date < date('Y-m-d H:i:s'))
          {!! $form->expired_msg !!}
        @endif

        @if($form->login_only == 1)
        <i class="fa fa-lock" aria-hidden="true"></i>
        @endif
      </span>

    </a>
    @endforeach
  </div>

</div>

@endsection