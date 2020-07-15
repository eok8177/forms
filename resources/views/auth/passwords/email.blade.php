@extends('layouts.front')

@section('content')
<div class="main-frame">
  <div class="block-info">
    <div class="top-panel">
      <a href="/" class="logo"><img src="/images/01.svg" alt=""></a>
      <span>MyRWAV</span>
    </div>
    <span class="inform">{{ __('Reset Password') }}</span>
    @if (session('status'))
        <span class="inform">
            {{ session('status') }}
        </span>
    @endif
    <div class="tabs-area">
      <div class="tab-area">
        <div id="tab01" class="tab-area inner ui-state-active">
          <form method="POST" action="{{ url('/password/email') }}">
            @csrf
            <div class="text-holder">
              <span class="label">E-Mail Address</span>
              <div class="text-frame">
                <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            </div>

            <button type="submit" class="submit">
                {{ __('Send Password Reset Link') }}
            </button>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
