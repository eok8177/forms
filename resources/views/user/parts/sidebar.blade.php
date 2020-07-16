<aside id="sidebar">
  <a href="/" class="logo">MYRWAV</a>
  <nav id="nav">
    <ul>
      <li class="{{ request()->is('*user') ? 'active' : '' }}"><a href="{{ route('user.index') }}">DASHBOARD</a></li>
      <li class="{{ request()->is('*edit*') ? 'active' : '' }}"><a href="{{ route('user.edit') }}">PROFILE</a></li>
      <li class="{{ request()->is('*archive*') ? 'active' : '' }}"><a href="{{ route('user.archive') }}">GRANTS</a></li>
      <li class=""><a href="#">HELP</a></li>
      <li class=""><a href="#">CONTACT</a></li>
      <li class=""><a href="/">BACK TO RWAV</a></li>
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