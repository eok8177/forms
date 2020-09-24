@extends('layouts.front')

@section('wrap')
<div class="main">
  @guest
  <div class="main-holder px-xl-4">
  @else
  <div class="main-holder pr-xl-4">

    @include('user.parts.sidebar')
  @endguest


    <div id="content">


          @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has($msg))
            <div class="info-panel alert-{{ $msg }}">
              <span>{!! Session::get($msg) !!}</span>
              <span class="close">close</span>
            </div>
            @endif
          @endforeach

        @yield('content')

    </div>
  </div>
</div>
@endsection