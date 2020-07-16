@extends('layouts.front')

@section('wrap')
<div class="main">
  <div class="main-holder">

    @include('user.parts.sidebar')

    <div id="content">

        <div class="info-panel">
          <span><strong>Welcome back Sergey!</strong> You have <a href="#">five grant applications</a> that need action.</span>
          <span class="close">close</span>
        </div>

        @yield('content')

    </div>
  </div>
</div>
@endsection