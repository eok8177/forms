@extends('email.layout')

@section('content')

<h1>Hello, {{$user->first_name}} {{$user->last_name}}!</h1>

<p>You are receiving this email because we received a password reset request for your account.</p>

<a target="_blank" rel="noopener noreferrer" href="{{$url}}?email={{$user->email}}" class="button-primary">Reset Password</a>

<p>This password reset link will expire in 60 minutes.</p>

<p>If you did not request a password reset, no further action is required.</p>

<p>Regards, {{ config('app.name', 'Laravel') }}</p>

<hr>

<p>If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: <a style="word-break: break-all;" href="{{$url}}?email={{$user->email}}">{{$url}}?email={{$user->email}}</a></p>

@endsection