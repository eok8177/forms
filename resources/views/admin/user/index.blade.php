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


<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">@lang('message.name')</th>
        <th scope="col">@lang('message.email')</th>
        <th scope="col" class="text-center">@lang('message.role')</th>
        <th scope="col" class="col-md-2 text-center">@lang('message.loged_at')</th>
        <th scope="col" class="col-md-2 text-center">@lang('message.actions')</th>
        <th></th>
      </tr>
    </thead>
    @foreach($users as $user)
      <tr>
        <td><a href="{{ route('admin.user.edit', ['user'=>$user->id]) }}" class="btn">{{$user->login}}</a></td>
        <td><a href="{{ route('admin.user.edit', ['user'=>$user->id]) }}" class="btn">{{$user->email}}</a></td>
        <td class="text-center"><a href="{{ route('admin.user.edit', ['user'=>$user->id]) }}" class="btn">{{$user->role}}</a></td>
        <td class="text-center"><a href="{{ route('admin.user.edit', ['user'=>$user->id]) }}" class="btn">{{$user->last_logged_in}}</a></td>
        <td class="text-center">
          <a href="{{ route('admin.user.edit', ['user'=>$user->id]) }}" class="btn fa fa-pencil"></a>
          @if($user->id != Auth::user()->id && Auth::user()->super_admin_to >= date("Y-m-d H:i:s"))
          <a href="{{ route('admin.user.destroy', ['user'=>$user->id]) }}" class="btn fa fa-trash-o delete"></a>
          @endif
        </td>
        <td>
          @if ($user->email_verified_at == NULL && $user->role == 'manager')
          <button href="{{route('admin.user.sendemail', ['id' => $user->id])}}" class="sendemail btn fa fa-envelope-o" title="Send Verification Email"></button>
          @endif
        </td>
      </tr>

    @endforeach
  </table>
</div>

@endsection