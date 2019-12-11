@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
{{--     <div class="col-sm-2">
      <ul class="nav flex-column">
        @foreach($forms as $item)
        <li class="nav-item">
          <a class="nav-link" href="{{route('front.form',$item->id)}}">{{$item->title}}</a>
        </li>
        @endforeach
      </ul>
    </div> --}}
    <div class="col-sm-12">
      <h2>{{$form->title}}</h2>
      <form-gui-component class="py-2 px-2 bg-white"
        :form="{{$form->config ?? 'null'}}" 
        :formid="{{$form->id}}"
        :userid="{{Auth::user()->id ?? 0}}" >
      </form-gui-component>
    </div>
  </div>
</div>

@endsection