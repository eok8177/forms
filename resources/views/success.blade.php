@extends('layouts.user')

@section('content')

<h1>Form submitted</h1>
<div class="text">{!! $form->confirm_text !!}</div>

@endsection