<aside id="sidebar">
  <span href="" class="logo">MYRWAV</span>
  <nav id="nav">
    <ul>
      <li class="{{ request()->is('*user') ? 'active' : '' }}"><a href="{{ route('user.index') }}">DASHBOARD</a></li>
      <li><a href="https://www.rwav.com.au/grants-2020/">APPLY FOR GRANTS</a></li>
      <li class="{{ request()->is('*grants') ? 'active' : '' }}"><a href="{{ route('user.grants') }}">Grants Applications</a></li>
      @outreach
      <li class="{{ request()->is('*outreachservices') ? 'active' : '' }}"><a href="{{ route('user.outreachservices') }}">Outreach Services</a></li>
      @endoutreach
      <li class="{{ request()->is('*edit*') ? 'active' : '' }}"><a href="{{ route('user.edit') }}">PROFILE</a></li>
      <li class="{{ request()->is('*faq*') ? 'active' : '' }}"><a href="{{ route('user.faq') }}">HELP</a></li>
      <li class=""><a href="https://www.rwav.com.au/">BACK TO RWAV</a></li>
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