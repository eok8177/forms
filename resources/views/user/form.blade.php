@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h2>{{$form->title}}</h2>
      <form-gui-component class="py-2 px-2 bg-white"
        :form="{{$form->config ?? 'null'}}" 
        :formid="{{$form->form_id}}"
        :userid="{{Auth::user()->id ?? 0}}" >
      </form-gui-component>
    </div>
  </div>
</div>

@endsection