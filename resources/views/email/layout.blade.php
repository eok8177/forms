<html xmlns="http://www.=w3.org/1999/xhtml">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" cont=ent="text/html; charset="UTF-8">
  <style>
    .wrapper {
      background-color: #edf2f7;
    }
    .header {
      padding: 25px 0;
      text-align: center;
    }
    .header a {
      color: #3d4852;
      font-size: 19px;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
    }
    .body {
      background-color: #edf2f7;
      border-bottom: 1px solid #edf2f7;
      border-top: 1px solid #edf2f7;
      text-align: center;
      padding: 20px;
      background-color: #fff;
      max-width: 576px;
    }
    .footer {
      color: #b0adc5;
      font-size: 12px;
      text-align: center;
      padding: 32px;
    }
    .button-primary {
      border-radius: 4px;
      color: #fff;
      display: inline-block;
      overflow: hidden;
      text-decoration: none;
      background-color: #2d3748;
      border-bottom: 8px solid #2d3748;
      border-left: 18px solid #2d3748;
      border-right: 18px solid #2d3748;
      border-top: 8px solid #2d3748;
      box-sizing: border-box;
    }
  </style>
</head>

<body>

  <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="3" class="header"><a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a></td>
    </tr>

    <tr>
      <td>&nbsp;</td>
      <td class="body" width="576px">
        @yield('content')
      </td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td colspan="3" class="footer">
        <p>2020 {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
      </td>
    </tr>
  </table>

</body>
</html>
