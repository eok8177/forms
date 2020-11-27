<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@900&family=Work+Sans:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

  <!-- Styles -->
  <link media="all" rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}" >
  <link media="all" rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}?dev={{time()}}" >
  <link media="all" rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}?dev={{time()}}" >

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-152798417-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-152798417-1');
  </script>
  <script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
  <style>
    .main-holder:after {pointer-events: none;}
    .invalid-feedback {color: #d0021b;}
  </style>
  @stack('styles')
</head>

<body>
  <div class="wrapper-holder" id="app">

    <div class="main">
      <div class="main-holder pr-xl-4">

        <aside id="sidebar">
          <a href="/" class="logo">MYRWAV</a>
          <nav id="nav">
            <ul>

              <li class="mb-2 {{ request()->is('*responses') ? 'active' : '' }}">
                <a href="{{ route('admin.responses') }}">
                    <i class="fa fa-file-text-o"></i> <span class="d-none d-md-inline">@lang('message.responses')</span>
                </a>
              </li>

              @if(Auth::user()->role == 'admin')
              <li class="mb-2 {{ request()->is('*form*') ? 'active' : '' }}">
                <a href="{{route('admin.form.index')}}"><i class="fa fa-list-alt"></i> @lang('message.forms')</a>
              </li>


                <li class="mb-2">
                  <a href="{{ route('admin.group.index') }}" class="ml-2"><i class="fa fa-list"></i> @lang('message.formgroups')</a>
                </li>

                <li class="mb-2">
                  <a href="{{ route('admin.form-type.index') }}" class="ml-2"><i class="fa fa-list"></i> @lang('message.formtypes')</a>
                </li>

                <li class="mb-2 {{ request()->is('*faq*') ? 'active' : '' }}">
                  <a href="{{route('admin.faq.index')}}"><i class="fa fa-question-circle-o"></i> Faq</a>
                </li>

                <li class="mb-2">
                  <a href="{{route('admin.user.index')}}"><i class="fa fa-users"></i> @lang('message.users')</a>
                </li>


                <li class="mb-2">
                  <a href="{{ route('admin.user.edit', ['user' => Auth::user()->id]) }}" class=""><i class="fa fa-gear"></i> @lang('message.profile')</a>
                </li>

                <li class="mb-2">
                  <a class="" href="{{route('admin.settings')}}"><i class="fa fa-cogs"></i> @lang('message.settings')</a>
                </li>


              @endif

              <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

    <footer id="footer">
      <div class="footer-holder">
        <a href="/" class="footer-logo"><img src="/images/01.svg" alt=""></a>
        <div class="columns">
          <div class="column">
            <span class="heading">Rural Workforce Agency Victoria</span>
            <address>
            Level 6, Tower 4, World Trade Centre
            18 - 38 Siddeley Street,
            Melbourne Vic 3005
            </address>
            <span class="copy">&copy; 2020 RWAV. All Rights Reserved.</span>
          </div>
          <div class="column">
            <span class="heading">Contact RWAV</span>
            <a href="" class="mail">rwav@rwav.com.au</a>
            <div class="tel-holder">
              <span class="tel">P: +61 3 9349 7800</span>
              <span class="tel">F: +61 3 9820 0401</span>
            </div>
            <a href="" class="link">Privacy Policy</a>
          </div>
        </div>
      </div>

      <div class="column">
        <span class="heading">Find us on social media:</span>
        <span><a href="/" class="logo-link">RWAVictoria</a></span>
      </div>
    </footer>

  </div>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}?dev={{time()}}"></script>
  <script src="{{ asset('js/jquery-ui.js') }}"></script>
  <script src="{{ asset('js/slick.min.js') }}"></script>
  <script src="{{ asset('js/global.js') }}"></script>

  <script>
    $(function () {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      //Delete record
        $('.delete').on('click', function (e) {
          if (!confirm('Are you sure you want to delete?')) return false;
        e.preventDefault();
          $.post({
            type: 'DELETE',  // destroy Method
            url: $(this).attr("href")
          }).done(function (data) {
            console.log(data);
            location.reload(true);
          });
        });
    });
  </script>

  @stack('scripts')
</body>
</html>
