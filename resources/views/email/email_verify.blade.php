@extends('email.layout')

@section('content')

<h1>Hello, {{$user->first_name}} {{$user->last_name}}!</h1>

<p>Please click the button below to verify your email address.</p>

<a target="_blank" rel="noopener noreferrer" href="{{$url}}" class="button-primary">Verify Email Address</a>

<p>If you did not create an account, no further action is required.</p>

<p>Regards, {{ config('app.name', 'Laravel') }}</p>

<hr>

<p>If you’re having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser: <a style="word-break: break-all;" href="{{$url}}">{{$url}}</a></p>

@endsection