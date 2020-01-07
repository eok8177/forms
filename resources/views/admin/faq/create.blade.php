@extends('admin.layout')

@section('content')
<h2 class="page-header">FAQ</h2>

{!! Form::open(['route' => ['admin.faq.store'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
  @include('admin.faq.form')
{!! Form::close() !!}

@endsection