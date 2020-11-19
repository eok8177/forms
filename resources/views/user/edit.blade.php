@extends('layouts.user')

@section('content')
<div class="dashboard-area tabs-area">

    <h2>Profile</h2>
    <div class="tab-content">

        {!! Form::open(['route' => ['user.update'], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

          <input type="text" name="" class="autofeel-hack">
          <input type="password" name="" class="autofeel-hack">

          <div class="form-group">
            <label for="name">{{Lang::get('message.first_name')}}</label>
            <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="name">{{Lang::get('message.last_name')}}</label>
            <input type="text" name="last_name" value="{{$user->last_name}}" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="email">{{Lang::get('message.email')}}</label>
            <input type="text" readonly value="{{$user->email}}" class="form-control">
          </div>

          <p>&nbsp;</p>

          <div class="form-group">
            <label for="">{{Lang::get('message.old_password')}}</label>
            <input type="password" id="old_password" name="old_password" class="form-control">
          </div>

          <div class="form-group">
            <label for="">{{Lang::get('message.new_password')}}</label>
            <input type="password" id="password" name="password" class="form-control">
          </div>

          <div class="form-group">
            <label for="">{{Lang::get('message.re_password')}}</label>
            <input type="password" id="re_password" name="re_password" class="form-control">
          </div>

          <div class="form-group btns">
            <input type="submit" value="{{Lang::get('message.save')}}" class="btn style01">
          </div>
        {!! Form::close() !!}

    </div> <!-- .tab-content -->

</div> <!-- .dashboard-area -->


@endsection

@push('styles')
<style type="text/css">
  .autofeel-hack {
    position: absolute;
    top: -999px;
  }
</style>
@endpush

@push('scripts')
  <script>
    $(function () {
      var old_password = document.getElementById("old_password")
        , password = document.getElementById("password")
        , re_password = document.getElementById("re_password");

      function validatePassword(){
        if(old_password.value.length > 0 && password.value != re_password.value) {
          re_password.setCustomValidity("Passwords Don't Match");
        } else {
          re_password.setCustomValidity('');
        }
      }

      old_password.onchange = validatePassword;
      password.onchange = validatePassword;
      re_password.onkeyup = validatePassword;
    });
  </script>
@endpush