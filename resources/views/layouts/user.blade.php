@extends('layouts.front')

@section('wrap')
<div class="main">
  <div class="main-holder pr-xl-4">

    @include('user.parts.sidebar')

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