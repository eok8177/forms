@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row">
    @include('user.parts.sidebar', ['class_col' => 'col-md-2', 'slug' => 'my-apps'])
    <div class="col-md-10">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Type</th>
              <th scope="col">Details</th>
              <th scope="col">Status</th>
              <th scope="col">Date</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          @foreach($apps as $app)
            <tr>
              <td>{{$app->form->type}}</td>
              <td>{{$app->form->title}}</td>
              <td>
                @if($app->status == 'rejected')
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
              <td>
                @if($app->status == 'draft' || $app->status == 'rejected')
                  <a href="{{ route('user.form', $app->id) }}" class="btn">Edit</a>
                  <a href="{{ route('user.form.destroy', $app->id) }}" class="btn fa fa-trash-o delete"></a>
                @endif
              </td>
            </tr>

          @endforeach

          @foreach($dataMars as $obj)
            <tr>
              <td>{{$obj->Type}}</td>
              <td></td>
              <td>{{$obj->Status}}</td>
              <td>{{ date('Y-m-d H:i', strtotime($obj->Date)) }}</td>
              <td></td>
            </tr>
          @endforeach
        </table>
      </div>
    </div>

  </div>

  {{-- <pre>{{ print_r($test, true) }}</pre> --}}

  <!-- <pre>{{ print_r($dataMars, true) }}</pre> -->
</div>



@endsection