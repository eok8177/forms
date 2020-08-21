@extends('layouts.auth')

@section('content')
<div class="main-frame">
  <div class="block-info">
    <div class="top-panel">
      <a href="/" class="logo"><img src="/images/01.svg" alt=""></a>
      <span>MyRWAV</span>
    </div>
    <h1>{{ __('Verify Your Email Address') }}</h1>

    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif

    <span class="inform">{{ __('Before proceeding, please check your email for a verification link.') }}</span>
    <span class="inform">{{ __('If you did not receive the email') }}</span>

    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="submit">{{ __('click here to request another') }}</button>
    </form>

  </div>
</div>
@endsection
