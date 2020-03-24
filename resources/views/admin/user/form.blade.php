
<input type="text" name="" class="autofeel-hack">
<input type="password" name="" class="autofeel-hack">

    <div class="form-group">
      <label for="name">{{Lang::get('message.username')}}</label>
      <input type="text" name="login" value="{{$user->login}}" class="form-control" {{$readonly ? 'readonly' : ''}}>
    </div>

    <div class="form-group">
      <label for="name">{{Lang::get('message.first_name')}}</label>
      <input type="text" name="first_name" value="{{$user->first_name}}" class="form-control" {{$readonly ? 'readonly' : ''}}>
    </div>

    <div class="form-group">
      <label for="name">{{Lang::get('message.last_name')}}</label>
      <input type="text" name="last_name" value="{{$user->last_name}}" class="form-control" {{$readonly ? 'readonly' : ''}}>
    </div>

    <div class="form-group">
      <label for="email">{{Lang::get('message.email')}}</label>
      <input type="text" name="email" value="{{$user->email}}" class="form-control" {{$readonly ? 'readonly' : ''}}>
    </div>

  @if(!$readonly)
    @if(Auth::user()->role == 'admin')
    <div class="form-group">
      <label for="role">{{Lang::get('message.role')}}</label>
      {!! Form::select('role', ['user' => 'Applicant', 'manager' => 'Manager', 'admin' => 'Admin'], $user->role, ['class' => 'form-control']) !!}
    </div>
    @endif
    <hr>


    <div class="form-group">
      <label for="">{{Lang::get('message.new_password')}}</label>
      <input type="password" name="password" class="form-control">
    </div>
  @endif
@if(Auth::user()->role == 'admin' && $user->role == 'manager')
    <hr>
    <div class="d-flex justify-content-start mt-3">
      <div class="pr-3"><label>Form Groups</label></div>
      <div class="px-3">
        @foreach($groups as $group)
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="group_{{$group->id}}"
            name="groups[]"
            value="{{$group->id}}"
            @if($user->groups->contains('id', $group->id))
              checked="checked"
            @endif
            >
          <label class="form-check-label" for="group_{{$group->id}}">{{$group->name}}</label>
        </div>
        @endforeach
      </div>
    </div>
@endif

<div class="custom-control custom-checkbox mb-3 border-top border-bottom">
  {!! Form::hidden('email_verified', 0) !!}
  {!! Form::checkbox('email_verified', 1, $user->email_verified_at != NULL, ['class' => 'custom-control-input', 'id' => 'email_verified']) !!}
  <label for="email_verified" class="custom-control-label">Email verified</label>
</div>

@if (Auth::user()->super_admin_to >= date("Y-m-d H:i:s"))
<div class="form-group">
  <label for="api_token">{{Lang::get('message.api_token')}}</label>
  <div class="d-flex">
    <input type="text" name="api_token" id="api_token" value="{{$user->api_token}}" class="form-control" readonly>
    <button type="button" class="btn btn-sm btn-outline-secondary text-nowrap" onclick="token(60);">Generate new key</button>
  </div>
</div>
@endif


  <div class="form-group">
      <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
  </div>




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
  function token(length) {
     var result           = '';
     var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
     var charactersLength = characters.length;
     for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
     }

     $('#api_token').val(result);
  }
</script>
@endpush