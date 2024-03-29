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
  <link media="all" rel="stylesheet" type="text/css" href="{{ asset('vendor/jquery-ui/css/datepicker.css') }}" >
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

    @yield('wrap')

    <footer id="footer">
      <div class="footer-holder">
        <a href="https://www.rwav.com.au/" class="footer-logo"><img src="/images/01.svg" alt=""></a>
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
        <span>
<ul class="social_media show">
    <li><a href="https://www.facebook.com/RWAVictoria" target="_blank" class="facebook" title="Follow us on Facebook"><i class="fa fa-facebook"></i></a></li>
    <li><a href="https://twitter.com/RWAVictoria" target="_blank" class="twitter" title="Follow us on Twitter"><i class="fa fa-twitter"></i></a></li>
    <li><a href="https://www.linkedin.com/company/657176" target="_blank" class="linkedin" title="Follow us on Linkedin"><i class="fa fa-linkedin"></i></a></li>
    <li><a href="https://www.instagram.com/rwavictoria/" target="_blank" class="linkedin" title="Follow us on Instagram"><i class="fa fa-instagram"></i></a></li>
</ul>

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
