@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.form') <small>{{ $form->name }}</small></h2>

{!! Form::open(['route' => ['admin.form.email.store', $form->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

  <div class="form-group">
    <label>Email subject</label>
    <input type="text" name="subject" value="{{$form->email->subject}}" class="form-control">
  </div>

  <div class="form-group">
    <label>From Name</label>
    <input type="text" name="from_name" value="{{$form->email->from_name}}" class="form-control">
  </div>

  <div class="form-group">
    <label>From Email</label>
    <input type="text" name="from_email" value="{{$form->email->from_email}}" class="form-control">
  </div>

  <div class="form-group">
    <label>Reply To</label>
    <input type="text" name="reply_to" value="{{$form->email->reply_to}}" class="form-control">
  </div>

  <div class="form-group">
    <label>Send To</label>
    <input type="text" name="send_to" value="{{$form->email->send_to}}" class="form-control">
  </div>

  <div class="form-group mt-3">
    <label>Message</label>
    {!! Form::textarea('message', $form->email->message, ['class' => 'form-control editor', 'rows' => '2']) !!}
  </div>

  <div class="form-group mt-4">
    <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
  </div>


{!! Form::close() !!}

@endsection

@push('scripts')
@endpush