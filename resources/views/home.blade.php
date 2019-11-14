@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-sm-2">
      <ul class="nav flex-column">
        {{-- @foreach($forms as $item)
        <li class="nav-item">
          <a class="nav-link" href="{{route('front.form',$item->id)}}">{{$item->title}}</a>
        </li>
        @endforeach --}}
      </ul>
    </div>
    <div class="col-sm-10"><h1>Forms</h1></div>
  </div>
  
</div>



@endsection