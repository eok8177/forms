@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.form') <small>{{ $form->name }}</small></h2>

{!! Form::open(['route' => ['admin.form.update', $form->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

  <div class="custom-control custom-checkbox custom-control-inline">
    {!! Form::hidden('shedule', 0) !!}
    {!! Form::checkbox('shedule', 1, $form->shedule, ['class' => 'custom-control-input', 'id' => 'shedule']) !!}
    <label for="shedule" class="custom-control-label">Shedule form</label>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Shedule form start Date/Time</label>
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
        <label>Shedule form end Date/Time</label>
          <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
              <input name="end_date" value="{{$form->end_date}}" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker2"/>
              <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
          </div>
      </div>
    </div>
  </div>

  <div class="custom-control custom-checkbox custom-control-inline">
    {!! Form::hidden('login_only', 0) !!}
    {!! Form::checkbox('login_only', 1, $form->login_only, ['class' => 'custom-control-input', 'id' => 'login_only']) !!}
    <label for="login_only" class="custom-control-label">Require user to be logged in</label>
  </div>

  <div class="form-group mt-3">
    <label>Confirmation text</label>
    {!! Form::textarea('confirm_text', $form->confirm_text, ['class' => 'form-control', 'rows' => '2']) !!}
  </div>

  <div class="form-group">
    <label>Redirect URL</label>
    <input type="text" name="redirect_url" value="{{$form->redirect_url}}" class="form-control">
  </div>


  <div class="form-group mt-4">
    <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
  </div>


{!! Form::close() !!}

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
  });
</script>
@endpush