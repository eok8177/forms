@extends('admin.layout')

@section('content')
<div class="page-header row justify-content-between">
  <h2>@lang('message.users')</h2>

@if (Auth::user()->super_admin_to < date("Y-m-d H:i:s"))
  <div class="form">
    <form action="{{route('admin.user.sadmin')}}" method="POST" class="input-group">
      @csrf
      <input type="password" class="form-control" name="password" placeholder="Password">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">Set admin's privileges</button>
      </div>
    </form>
  </div>
@endif
</div>


  <div class="row border-top border-bottom py-1 my-2 font-weight-bold align-items-center">
    <div class="col">@lang('message.name')</div>
    <div class="col">@lang('message.email')</div>
    <div class="col text-center">
      <div class="dropdown">
        <a class="btn btn-outline-secondary btn-sm dropdown-toggle" href="#" role="button" id="dropdownRoles" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $role ? $roles[$role] : __('message.role') }}</a>
        <div class="dropdown-menu" aria-labelledby="dropdownRoles">
          <a class="dropdown-item" href="{{ route('admin.user.index') }}">All</a>
          @foreach($roles as $id => $name)
            <a class="dropdown-item" href="{{ route('admin.user.index', ['role' => $id]) }}">{{$name}}</a>
          @endforeach
        </div>
      </div>
    </div>
    <div class="col-md-2 text-center">@lang('message.loged_at')</div>
    <div class="col-md-2 text-center">@lang('message.actions')</div>
    <div class="col-md-2 text-center">@lang('message.email_verified')</div>
  </div>
@foreach($users as $user)
  <div class="row border-bottom mb-2 align-items-center">
    <div class="col"><a href="{{ route('admin.user.edit', ['user'=>$user->id]) }}" class="btn">{{$user->login}}</a></div>
    <div class="col"><a href="{{ route('admin.user.edit', ['user'=>$user->id]) }}" class="btn">{{$user->email}}</a></div>
    <div class="col text-center"><a href="{{ route('admin.user.edit', ['user'=>$user->id]) }}" class="btn">{{$user->role}}</a></div>
    <div class="col-md-2 text-center"><a href="{{ route('admin.user.edit', ['user'=>$user->id]) }}" class="btn">{{$user->last_logged_in}}</a></div>
    <div class="col-md-2 text-center">
      <a href="{{ route('admin.user.edit', ['user'=>$user->id]) }}" class="btn fa fa-pencil"></a>
      @if($user->id != Auth::user()->id && Auth::user()->super_admin_to >= date("Y-m-d H:i:s"))
      <a href="{{ route('admin.user.destroy', ['user'=>$user->id]) }}" class="btn fa fa-trash-o delete"></a>
      @endif
    </div>
    <div class="col-md-2 text-center">
      @if ($user->email_verified_at == NULL && $user->role == 'manager')
      <button href="{{route('admin.user.sendemail', ['id' => $user->id])}}" class="sendemail btn fa fa-envelope-o" title="Send Verification Email"></button>
      @endif
      <a href="{{route('admin.ajax.setTime', ['id' => $user->id, 'model' => 'User', 'field' => 'email_verified_at'])}}" class="status btn fa fa-{{$user->email_verified_at == NULL ? 'times-circle' : 'check-circle'}}" title="Toggle Email verified"></a>
    </div>
  </div>
@endforeach


@endsection