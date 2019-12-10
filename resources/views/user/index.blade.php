@extends('layouts.app')

@section('content')

<div class="container">
  <h2 class="page-header">{{$user->first_name}} {{$user->last_name}}</h2>

  <div class="row">
    <div class="col-md-10">
      TODO PUT here my Apps
    </div>
    <div class="col-md-2">
      <div class="list-group">
        <a class="list-group-item list-group-item-action" href="/user">My Apps</a>
        <a class="list-group-item list-group-item-action" href="/user/edit">My details</a>
      </div>
    </div>
  </div>
</div>



@endsection