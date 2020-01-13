@extends('admin.layout')

@section('content')
<div class="page-header row justify-content-between">
  <h2>@lang('message.users')</h2>

  <div class="form">
    <form action="{{route('admin.user.sadmin')}}" method="POST" class="input-group">
      @csrf
      <input type="password" class="form-control" name="password" placeholder="Password">
      <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="submit">Set super admin</button>
      </div>
    </form>
  </div>
</div>


<div class="table-responsive">
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">@lang('message.actions')</th>
        <th scope="col">@lang('message.name')</th>
        <th scope="col">@lang('message.email')</th>
        <th scope="col">@lang('message.role')</th>
      </tr>
    </thead>
    @foreach($users as $user)
      <tr>
        <td>
          <a href="{{ route('admin.user.edit',    ['user'=>$user->id]) }}" class="btn fa fa-pencil"></a>
          @if($user->id != Auth::user()->id)
          <a href="{{ route('admin.user.destroy', ['user'=>$user->id]) }}" class="btn fa fa-trash-o delete"></a>
          @endif
        </td>
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->role}}</td>
      </tr>

    @endforeach
  </table>
</div>

@endsection