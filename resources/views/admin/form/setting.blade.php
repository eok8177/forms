@extends('admin.layout')

@section('content')
<div class="page-header row justify-content-between">
  <h2>@lang('message.form_settings') <small>{{ $form->title }}</small></h2>

  <div>
      <a href="{{ route('admin.form.edit', $form->id) }}" class="btn fa fa-pencil {{$form->has_apps ? 'disabled' : ''}}" title="Edit"></a>
      <a class="btn fa fa-envelope-o" href="{{route('admin.form.email',$form->id)}}" title="Email Notification"></a>
  </div>
</div>

<div class="row">
  <div class="col-md-8">
    {!! Form::open(['route' => ['admin.form.update', $form->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

      <div class="form-group">
        <label for="name">{{Lang::get('message.name')}}</label>
        <input type="text" name="name" value="{{$form->name}}" class="form-control" {{$form->draft == 0 ? 'readonly' : ''}}>
      </div>

      @if($form->fields)
      <div class="form-group">
        <label>Additional field</label>
        <select class="form-control" name="additional_field">
        @foreach($form->fields as $section => $fields)
          <option disabled>--- {{$section}} ---</option>
          @foreach($fields as $field => $label)
            <option {{$form->additional_field == $field ? 'selected' : ''}} value="{{$field}}">{{$label}}</option>
          @endforeach
        @endforeach
        </select>
      </div>
      @endif

      <div class="form-group">
        <label for="title">{{Lang::get('message.title')}}</label>
        <input type="text" name="title" value="{{$form->title}}" class="form-control">
      </div>

      <div class="form-group">
        <label for="title">Description</label>
        {!! Form::textarea('description', $form->description, ['class' => 'form-control', 'rows' => '2']) !!}
      </div>

      <div class="custom-control custom-checkbox custom-control-inline">
        {!! Form::hidden('to_be_approved', 0) !!}
        {!! Form::checkbox('to_be_approved', 1, $form->to_be_approved, ['class' => 'custom-control-input', 'id' => 'to_be_approved']) !!}
        <label for="to_be_approved" class="custom-control-label">To be Approved/Rejected by admin</label>
      </div>

      <div class="custom-control custom-checkbox mb-2">
        {!! Form::hidden('shedule', 0) !!}
        {!! Form::checkbox('shedule', 1, $form->shedule, ['class' => 'custom-control-input', 'id' => 'shedule']) !!}
        <label for="shedule" class="custom-control-label" data-toggle='collapse' data-target='#collapseShedule'>Schedule form</label>
      </div>

      <div id='collapseShedule' class='collapse {{$form->shedule ? 'show' : ''}}'>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Schedule form start Date/Time</label>
                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                    <input type="text" name="start_date" value="{{$form->start_date}}" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Schedule form end Date/Time</label>
                <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                    <input name="end_date" value="{{$form->end_date}}" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2"/>
                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="form-group mt-3">
          <label>Form Pending Message</label>
          {!! Form::textarea('pending_msg', $form->pending_msg, ['class' => 'form-control', 'rows' => '3']) !!}
        </div>

        <div class="form-group mt-3">
          <label>Form Expired Message</label>
          {!! Form::textarea('expired_msg', $form->expired_msg, ['class' => 'form-control', 'rows' => '3']) !!}
        </div>
      </div>

      <div class="custom-control custom-checkbox custom-control-inline">
        {!! Form::hidden('login_only', 0) !!}
        {!! Form::checkbox('login_only', 1, $form->login_only, ['class' => 'custom-control-input', 'id' => 'login_only']) !!}
        <label for="login_only" class="custom-control-label">Require user to be logged in</label>
      </div>

      <div class="form-group mt-3">
        <label>Confirmation message on screen</label>
        {!! Form::textarea('confirm_text', $form->confirm_text, ['class' => 'form-control', 'rows' => '3']) !!}
      </div>

      <div class="form-group">
        <label>Redirect URL</label>
        <input type="text" name="redirect_url" value="{{$form->redirect_url}}" class="form-control">
      </div>

      <div class="d-flex justify-content-start mt-3">
        <div class="pr-3"><label>Form Groups</label></div>
        <div class="px-3">
          @foreach($groups as $group)
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="group_{{$group->id}}"
              name="groups[]"
              value="{{$group->id}}"
              @if($form->groups->contains('id', $group->id))
                checked="checked"
              @endif
              >
            <label class="form-check-label" for="group_{{$group->id}}">{{$group->name}}</label>
          </div>
          @endforeach
        </div>
      </div>


      <div class="d-flex justify-content-start mt-3">
        <div class="pr-3"><label>Form Type</label></div>
        <div class="px-3">
        {!! Form::select('form_type_id', $form_types, $form->form_type_id, ['class' => 'form-control']) !!}
        </div>
      </div>    


      <div class="form-group mt-4">
        <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
      </div>


    {!! Form::close() !!}
  </div>

  <div class="col-md-4">
    <h5>Labels <span class="text-muted"><---></span> Alias</h5>
    @foreach($form->getFieldsAlias() as $section => $fields)
      <h6 class="text-muted">{{$section}}</h6>
      @foreach($fields as $field)
        <p>{{$field['label']}} <span class="text-muted"><---></span> {{$field['alias']}}</p>
      @endforeach
    @endforeach
  </div>
</div>




@endsection

@push('scripts')
{{-- https://tempusdominus.github.io/bootstrap-4/ --}}
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
<script>
  $(function () {
      $('#datetimepicker1').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss'
      });
      $('#datetimepicker2').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss'
      });
      $("#datetimepicker1").on("change.datetimepicker", function (e) {
          $('#datetimepicker2').datetimepicker('minDate', e.date);
      });

      $('#collapseShedule').on('shown.bs.collapse', function () {
        $("#collapseShedule input, #collapseShedule textarea").prop('required',true);
      });
      $('#collapseShedule').on('hidden.bs.collapse', function () {
        $("#collapseShedule input, #collapseShedule textarea").prop('required',false);
      });
  });
</script>
@endpush