@extends('layouts.app')

@section('content')

<div class="container">
  <h2 class="page-header">{{$user->first_name}} {{$user->last_name}}</h2>

  <div class="row">
    <div class="col-md-10">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Action</th>
              <th scope="col">Form Name</th>
              <th scope="col">Date</th>
            </tr>
          </thead>
          @foreach($apps as $app)
            <tr>
              <td>
                @if($app->sent == 1)
                Form already sent
                @else
                <a href="{{ route('user.form', $app->id) }}" class="btn">Edit</a>
                <a href="{{ route('user.form.destroy', $app->id) }}" class="btn fa fa-trash-o delete"></a>
                @endif
              </td>
              <td>{{$app->form->title}}</td>
              <td>{{$app->updated_at}}</td>
            </tr>

          @endforeach
        </table>
      </div>
    </div>
	@include('user.parts.sidebar', ['class_col' => 'col-md-2', 'slug' => 'my-apps'])
  </div>
</div>



@endsection