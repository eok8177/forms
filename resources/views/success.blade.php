@extends('layouts.user')

@section('content')

<h1>Your form is submitted</h1>
<div class="text">{!! $form->confirm_text !!}</div>

@endsection