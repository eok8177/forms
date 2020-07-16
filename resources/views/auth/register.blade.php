@extends('layouts.auth')

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
        <li><a href="#tab02">REGISTER</a></li>
        <li><a href="/login" class="link-tab">LOGIN</a></li>
      </ul>
      <div class="tab-area">
        <div id="tab02" class="tab-area inner">
          <form role="form" method="POST" action="{{ url('/register') }}">
          @csrf
            <div class="text-holder">
              <span class="label">First Name</span>
              <div class="text-frame">
                @if(!empty($first_name))
                <input id="first_name" type="text" class="{{ $errors->has('first_name') ? ' error' : '' }}" name="first_name" value="{{$first_name}}" required>
                @else
                <input id="first_name" type="text" class="{{ $errors->has('first_name') ? ' error' : '' }}" name="first_name" value="{{ old('first_name') }}" required>
                @endif

                @if ($errors->has('first_name'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </div>
                @endif
              </div>
            </div>
            <div class="text-holder">
              <span class="label">Last Name</span>
              <div class="text-frame">
                @if(!empty($last_name))
                <input id="last_name" type="text" class="{{ $errors->has('last_name') ? ' error' : '' }}" name="last_name" value="{{$last_name}}" required>
                @else
                <input id="last_name" type="text" class="{{ $errors->has('last_name') ? ' error' : '' }}" name="last_name" value="{{ old('last_name') }}" required>
                @endif

                @if ($errors->has('last_name'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </div>
                @endif
              </div>
            </div>
            <div class="text-holder">
              <span class="label">E-Mail Address</span>
              <div class="text-frame">
                @if(!empty($email))
                <input id="email" type="text" class="{{ $errors->has('email') ? ' error' : '' }}" name="email" value="{{$email}}" required>
                @else
                <input id="email" type="text" class="{{ $errors->has('email') ? ' error' : '' }}" name="email" value="{{ old('email') }}" required>
                @endif

                @if ($errors->has('email'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                @endif
              </div>
            </div>
            <div class="text-holder">
              <span class="label">Login</span>
              <div class="text-frame">
                <input id="login" type="text" class="{{ $errors->has('login') ? ' error' : '' }}" name="login" value="{{ old('login') }}" required>

                @if ($errors->has('login'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('login') }}</strong>
                    </div>
                @endif
              </div>
            </div>
            <div class="text-holder">
              <span class="label">Password</span>
              <div class="text-frame">
                <input
                        type="password"
                        class="{{ $errors->has('password') ? ' error' : '' }}"
                        name="password"
                        required
                >
                @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </div>
                @endif
              </div>
            </div>
            <div class="text-holder">
              <span class="label">Confirm Password</span>
              <div class="text-frame">
                <input
                        type="password"
                        class="{{ $errors->has('password_confirmation') ? ' error' : '' }}"
                        name="password_confirmation"
                        required
                >
                @if ($errors->has('password_confirmation'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </div>
                @endif
              </div>
            </div>
            <button class="submit">Register</button>

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