@extends('layouts.front')

@section('wrap')
<div class="main">
  <div class="main-holder pr-xl-4">

    <aside id="sidebar">
      <a href="" class="logo">MYRWAV</a>
      <nav id="nav">
        <ul>
          <li class="{{ request()->is('*manager') ? 'active' : '' }}"><a href="{{ route('manager.responses') }}">Responses</a></li>

          <li class="{{ request()->is('*edit*') ? 'active' : '' }}"><a href="{{ route('manager.user.edit', auth()->user()->id) }}">PROFILE</a></li>

          <li class="">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
          </li>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </ul>
      </nav>
    </aside>

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