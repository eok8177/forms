@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.form') <small>{{ $form->name }}</small></h2>

{!! Form::open(['route' => ['admin.form.email.store', $form->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

  <div class="form-group">
    <label>Email subject</label>
    <input type="text" name="subject" id="subject" value="{{$form->email->subject}}" class="form-control">
    <div class="btn-group py-2">
      <small class="form-text text-muted mr-2">You can use macro:</small> 
      <button class="subject btn btn-sm btn-light" data-macro="{form_title}">{form_title}</button>
    </div>
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
    <label>Admin notification</label>
    {!! Form::textarea('admin_message', $form->email->admin_message, ['class' => 'form-control editor', 'rows' => '2']) !!}
  </div>

  <div class="form-group mt-3">
    <label>User notification</label>
    {!! Form::textarea('client_message', $form->email->client_message, ['class' => 'form-control editor', 'rows' => '2', 'id' => 'client_message']) !!}
  </div>

  <div class="btn-group py-2">
    <small class="form-text text-muted mr-1">You can use </small> 
    <div class="dropdown">
      <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="clientMacros" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Macro`s</button>
      <div class="dropdown-menu" aria-labelledby="clientMacros">
        @foreach($form->fields as $section => $fields)
          <h6 class="dropdown-header">{{$section}}</h6>
          @foreach($fields as $field => $label)
            <button class="client_message dropdown-item" data-macro="[{{$field}}:{{$label}}]">{{$label}}</button>
          @endforeach
          <div class="dropdown-divider"></div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="form-group mt-4">
    <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
  </div>


{!! Form::close() !!}

@endsection

@push('scripts')
<script>
  $(function () {
    $('.subject').on('click',function(e){
      e.preventDefault();
      let text = $('#subject').val();
      text = text + ' ' + $(this).attr('data-macro') + ' ';
      $('#subject').val(text);
    });

    $('.client_message').on('click',function(e){
      e.preventDefault();
      let text = $('#client_message').val();
      text = text + ' ' + $(this).attr('data-macro') + ' ';
      $('#client_message').val(text);
    });
  });
</script>
@endpush