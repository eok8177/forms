@extends('layouts.app')

@section('content')

<div class="container">
  <h2 class="page-header">{{$user->first_name}} {{$user->last_name}}</h2>

  <div class="row">
    <div class="col-md-10">
      TODO PUT here my Apps
    </div>
	@include('user.parts.sidebar', ['class_col' => 'col-md-2', 'slug' => 'my-apps'])
  </div>
</div>



@endsection