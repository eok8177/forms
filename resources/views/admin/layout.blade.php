<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/admin.css') }}?dev={{time()}}" rel="stylesheet">
  @stack('styles')
  <script>
    <!-- FontAwesome settings -->
    FontAwesomeConfig = {
      showMissingIcons: false
    }
  </script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-152798417-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-152798417-1');
  </script>
  <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
</head>

<body>

  <div id="app" class="">

    {{-- Navigation --}}
    <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top">
      <div class="container-fluid">

        <div class="navbar-nav flex-row">

          <button type="button" class="menu-toggler nav-link" onclick="document.getElementById('app').classList.toggle('menu-closed');"><span class="navbar-toggler-icon"></span></button>

          <a class="nav-link" href="{{ route('admin.responses') }}">
            <i class="fa fa-file-text-o"></i> <span class="d-none d-md-inline">@lang('message.responses')</span>
          </a>

          @if(Auth::user()->role == 'admin')

          <a class="nav-link {{ request()->is('*form*') ? 'active' : '' }}" href="{{route('admin.form.index')}}"><i class="fa fa-list-alt"></i> @lang('message.forms')</a>

          <a class="nav-link {{ request()->is('*faq*') ? 'active' : '' }}" href="{{route('admin.faq.index')}}"><i class="fa fa-question-circle-o"></i> Faq</a>

          <a class="nav-link {{ request()->is('*news*') ? 'active' : '' }}" href="{{route('admin.news.index')}}"><i class="fa fa-newspaper-o"></i> News</a>

          @endif

        </div>

        <ul class="navbar-nav flex-row">
          <li class="nav-item">
            <a href="/" class="nav-link"><i class="fa fa-home"></i> @lang('message.to_site')</a>
          </li>

          <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-user"></i> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
              @if (Auth::user()->super_admin_to >= date("Y-m-d H:i:s"))
                <span class="small text-danger">[super admin]</span>
              @endif
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a href="{{ route('admin.user.edit', ['user' => Auth::user()->id]) }}" class="dropdown-item"><i class="fa fa-gear"></i> @lang('message.profile')</a>

              <div class="dropdown-divider"></div>
              @if(Auth::user()->role == 'admin')

              <h6 class="dropdown-header">@lang('message.users')</h6>

              <a class="dropdown-item" href="{{route('admin.user.create')}}"><i class="fa fa-user"></i> @lang('message.create')</a>
              <a class="dropdown-item" href="{{route('admin.user.index')}}"><i class="fa fa-users"></i> @lang('message.users')</a>

              <div class="dropdown-divider"></div>

              <a class="dropdown-item" href="{{route('admin.settings')}}"><i class="fa fa-cogs"></i> @lang('message.settings')</a>

              <div class="dropdown-divider"></div>
              @endif

              <a href="{{ route('logout') }}" class="dropdown-item"
                 onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  <i class="fa fa-sign-out"></i> @lang('message.logout')
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
            </div>
          </li>

        </ul>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

      </div>

        {{-- SIDEBAR --}}
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <div class="navbar-nav flex-column side-nav">

            <a class="nav-link" href="{{ route('admin.responses') }}">
                <i class="fa fa-file-text-o"></i> <span class="d-none d-md-inline">@lang('message.responses')</span>
            </a>

            @if(Auth::user()->role == 'admin')
              <a class="nav-item nav-link {{ request()->is('*form*') ? 'active' : '' }}" href="{{route('admin.form.index')}}"><i class="fa fa-list-alt"></i> @lang('message.forms')</a>

              <a href="{{ route('admin.group.index') }}" class="nav-item nav-link ml-2"><i class="fa fa-list"></i> @lang('message.formgroups')</a>
              <a href="{{ route('admin.form-type.index') }}" class="nav-item nav-link ml-2"><i class="fa fa-list"></i> @lang('message.formtypes')</a>


              <a class="nav-item nav-link {{ request()->is('*faq*') ? 'active' : '' }}" href="{{route('admin.faq.index')}}"><i class="fa fa-question-circle-o"></i> Faq</a>

              <a class="nav-item nav-link {{ request()->is('*news*') ? 'active' : '' }}" href="{{route('admin.news.index')}}"><i class="fa fa-newspaper-o"></i> News</a>

              <a class="nav-item nav-link" href="{{route('admin.user.index')}}"><i class="fa fa-users"></i> @lang('message.users')</a>

              <a href="{{ route('admin.user.edit', ['user' => Auth::user()->id]) }}" class="nav-item nav-link"><i class="fa fa-gear"></i> @lang('message.profile')</a>

              <a class="nav-item nav-link" href="{{route('admin.apilogs')}}"><i class="fa fa-lightbulb-o"></i> @lang('message.apilogs')</a>
              <a class="nav-item nav-link" href="{{route('admin.settings')}}"><i class="fa fa-cogs"></i> @lang('message.settings')</a>

              <a href="{{ route('logout') }}" class="nav-item nav-link"
                 onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  <i class="fa fa-sign-out"></i> @lang('message.logout')
              </a>

            @endif

            <small class="text-muted p-4 mt-auto">Laravel v{{ Illuminate\Foundation\Application::VERSION }}<br> PHP v{{ PHP_VERSION }}</small>
          </div>
        </div>
    </nav>

    {{--  PAGE  --}}
    <div id="page-wrapper">
      <div class="container-fluid pt-md-3">

        <div class="flash-message">
          @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has($msg))
              <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
          @endforeach

          @if (count($errors) > 0)
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
        </div>

        @yield('content')

      </div>{{-- /.container-fluid --}}
    </div>

    <a href="#app" class="btn btn-info d-none"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
  </div>

  {{--  FOOTER  --}}

<!-- Scripts -->
<script src="{{ asset('js/admin.js') }}?dev={{time()}}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>
<script src="{{ asset('vendor/laravel-filemanager/js/lfm.js') }}"></script>
<script src="{{ asset('vendor/jquery-sortable.min.js') }}"></script>
@stack('scripts')

</body>
</html>
