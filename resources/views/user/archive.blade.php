@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    @include('user.parts.sidebar', ['class_col' => 'col-md-2', 'slug' => 'my-archive'])
    <div class="col-md-10">
	@if ($apps->count() > 0)
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Type</th>
              <th scope="col">Details</th>
              <th scope="col">Status</th>
              <th scope="col">Date</th>
            </tr>
          </thead>
          @foreach($apps as $app)
            <tr>
              <td>{{$app->form->type}}</td>
              <td>{{$app->form->title}}</td>
              <td>
                @if($app->status == 'accepted')
                <div class="dropdown">
                  <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="approv_{{$app->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$app->status}}</button>
                  <div class="dropdown-menu" aria-labelledby="approv_{{$app->id}}">
                    @foreach($app->approvs as $approv)
                    <div class="dropdown-item">
                      <span class="small d-block">{{ date('Y-m-d H:i', strtotime($approv->created_at)) }}</span>
                      <p>{{$approv->notes}}</p>
                    </div>
                    @endforeach
                  </div>
                </div>
                @else
                  {{$app->status}}
                @endif
              </td>
              <td>{{ date('Y-m-d H:i', strtotime($app->updated_at)) }}</td>
            </tr>

          @endforeach

        </table>
      </div>
      @else
          @lang('message.no_records').
      @endif
    </div>

  </div>

</div>



@endsection