@extends('layouts.app')

@section('content')

<div class="container">
  <h1>Form submitted</h1>
  <div class="text">{!! $form->confirm_text !!}</div>
</div>

@endsection