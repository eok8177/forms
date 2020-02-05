@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.form') <small>{{ $form->name }}</small></h2>

{!! Form::open(['route' => ['admin.form.email.store', $form->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

  @foreach($types as $type => $typeName)

  <div class="custom-control custom-checkbox mb-2">
    <input name="{{$type}}[active]" type="hidden" value="0">
    <input id="active_{{$type}}" name="{{$type}}[active]" type="checkbox" value="1" class="custom-control-input" {{$form_emails[$type]->active ? 'checked' : ''}}>
    <label for="active_{{$type}}" class="custom-control-label" data-toggle='collapse' data-target='#collapseType_{{$type}}'>{{$typeName}}</label>
  </div>
  <hr>

  <div id='collapseType_{{$type}}' class='collapse {{$form_emails[$type]->active ? 'show' : ''}}'>

    <div class="form-group">
      <label>From Name</label>
      <input type="text" name="{{$type}}[from_name]" value="{{$form_emails[$type]->from_name}}" class="form-control">
    </div>

    <div class="form-group">
      <label>From Email</label>
      <input type="text" name="{{$type}}[from_email]" value="{{$form_emails[$type]->from_email}}" class="form-control">
    </div>

    <div class="form-group">
      <label>Send To</label>
      <input type="text" name="{{$type}}[send_to]" value="{{$form_emails[$type]->send_to}}" class="form-control">
    </div>

    <div class="form-group">
      <label>Email subject</label>
      <input type="text" name="{{$type}}[subject]" value="{{$form_emails[$type]->subject}}" class="form-control subject">
      <div class="btn-group py-2">
        <small class="form-text text-muted mr-2">You can use macro:</small> 
        <button class="subject btn btn-sm btn-light" data-macro="{form_title}">{form_title}</button>
      </div>
    </div>

    <div class="form-group mt-3">
      <label>Email Body</label>
      <textarea name="{{$type}}[message]" class="form-control editor client_message" rows="2">{{$form_emails[$type]->message}}</textarea>
      <div class="btn-group py-2">
        <small class="form-text text-muted mr-1">You can use </small> 
        <div class="dropdown">
          <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="clientMacros_{{$type}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Macro`s</button>
          <div class="dropdown-menu" aria-labelledby="clientMacros_{{$type}}">
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
    </div>
    <hr>
  </div>

  @endforeach

  <div class="form-group mt-4">
    <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
  </div>

{!! Form::close() !!}

@endsection

@push('scripts')
<script>
  $(function () {
    $('button.subject').on('click',function(e){
      e.preventDefault();
      let field = $(this).closest('.form-group').find('input.subject');
      let text = field.val();
      text = text + ' ' + $(this).attr('data-macro') + ' ';
      field.val(text);
    });

    $('button.client_message').on('click',function(e){
      e.preventDefault();
      let field = $(this).closest('.form-group').find('textarea.client_message');
      let text = field.val();
      text = text + ' ' + $(this).attr('data-macro') + ' ';
      field.val(text);
    });
  });
</script>
@endpush