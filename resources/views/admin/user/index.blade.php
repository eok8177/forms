@extends('admin.layout')

@section('content')
<h2 class="page-header">@lang('message.users')</h2>

<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">@lang('message.actions')</th>
        <th scope="col">@lang('message.avatar')</th>
        <th scope="col">@lang('message.name')</th>
        <th scope="col">@lang('message.email')</th>
        <th scope="col">@lang('message.role')</th>
      </tr>
    </thead>
    @foreach($users as $user)
      <tr>
        <td>
          <a href="{{ route('admin.user.edit',    ['user'=>$user->id]) }}" class="btn fa fa-pencil"></a>
          <a href="{{ route('admin.user.destroy', ['user'=>$user->id]) }}" class="btn fa fa-trash-o delete"></a>
        </td>
        <td><img src="{{$user->avatar}}" style="width: 40px;"></td>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->role}}</td>
      </tr>

    @endforeach
  </table>
</div>

@endsection