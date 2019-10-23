
<input type="text" name="" class="autofeel-hack">
<input type="password" name="" class="autofeel-hack">


<div class="row">
  <div class="col-lg-8">
    <div class="form-group">
      <label for="name">{{Lang::get('message.name')}}</label>
      <input type="text" name="name" value="{{$user->name}}" class="form-control">
    </div>

    <div class="form-group">
      <label for="email">{{Lang::get('message.email')}}</label>
      <input type="text" name="email" value="{{$user->email}}" class="form-control">
    </div>

    <div class="form-group">
      <label for="role">{{Lang::get('message.role')}}</label>
      {!! Form::select('role', ['user' => 'User', 'admin' => 'Admin'], $user->role, ['class' => 'form-control']) !!}
    </div>
    <hr>

    <div class="form-group">
      <label for="">{{Lang::get('message.new_password')}}</label>
      <input type="password" name="password" class="form-control">
    </div>
  </div>

  <div class="col-lg-4">
    <div class="form-group">
      <label>@lang('message.avatar')</label>
      <div class="image-lfm">
        <img id="avatarPreview" class="image-src" style="margin-top:15px;max-height:100px;" src="{{ $user->avatar }}">
        <div class="mt-1">
          <a data-input="avatarInput" data-preview="avatarPreview" class="lfm btn btn-light text-primary">
            <i class="fa fa-picture-o"></i> @lang('message.select')
          </a>
          <a id="delete-image" class="delete-image btn btn-light text-danger {{($user->avatar) ? '' : 'd-none'}}">
            <i class="fa fa-trash"></i> @lang('message.delete')
          </a>
        </div>


        <input id="avatarInput" class="form-control image-input" type="hidden" name="avatar" value="{{ $user->avatar }}">
      </div>
    </div>
  </div>
</div>

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