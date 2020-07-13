@extends('layouts.front')

@section('content')

<div class="main-frame">
  <div class="block-info">
    <div class="top-panel">
      <a href="#" class="logo"><img src="/images/01.svg" alt=""></a>
      <span>MyRWAV</span>
    </div>
    <span class="inform">To complete an RWAV form you need to have a MyRWAV account.  Login or register below:</span>
    <div class="tabs-area">
      <ul class="tabs inner">
        <li><a href="#tab01">LOGIN</a></li>
        <li><a href="/register" class="link-tab">REGISTER</a></li>
      </ul>
      <div class="tab-area">
        <div id="tab01" class="tab-area inner ui-state-active">
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="text-holder">
              <span class="label">Email</span>
              <div class="text-frame">
                <input id="email" type="text" class="@error('email') error @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
            <div class="text-holder">
              <span class="label">Password</span>
              <div class="text-frame">
                <input id="password" type="password" class="@error('password') error @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>
            <button type="submit" class="submit">LOGIN</button>
            <div class="aligncenter">
              <span>Forgot your password? <a href="{{ route('password.request') }}">Click here to reset</a>.</span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
jQuery(document).ready(function($) {
  $(".link-tab").unbind('click');
});
</script>
@endpush