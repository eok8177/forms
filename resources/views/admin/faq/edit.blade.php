@extends('admin.layout')

@section('content')
<h2 class="page-header">FAQ: <small>{{ $faq->question }}</small></h2>

{!! Form::open(['route' => ['admin.faq.update', $faq->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
  @include('admin.faq.form')
{!! Form::close() !!}

@endsection