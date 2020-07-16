@extends('layouts.user')

@section('content')
<div class="dashboard-area tabs-area">
  <h2>Your dashboard</h2>
  <ul class="tabs">
    <li class="tab01"><a href="#tab01">drafts</a></li>
    <li><a href="#tab02">submited</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab01" class="tab-area">

        @if ($apps->count() > 0)
          <div class="table-holder">
            <table>
              <thead>
                <tr>
                  <th><span class="sort">TYPE</span></th>
                  <th>DETAILS</th>
                  <th><span class="sort">status</span></th>
                  <th><span class="sort">date</span></th>
                  <th>actions</th>
                </tr>
              </thead>
              <tbody>
              @foreach($apps as $app)
                <tr>
                  <td>
                    <span class="title">{{$app->form->type}}</span>
                  </td>
                  <td>
                    <strong>{{$app->form->title}}</strong>
                  </td>
                  <td>
                    @if($app->status == 'rejected')
                      {{$app->status}}

                        @foreach($app->approvs as $approv)
                          <small>( {{$approv->notes}} )</small>
                        @endforeach

                    @else
                      {{$app->status}}
                    @endif
                  </td>
                  <td>
                    <span class="date">{{ date('Y-m-d H:i', strtotime($app->updated_at)) }}</span>
                  </td>
                  <td>
                    <div class="btns">
                    @if($app->status == 'draft' || $app->status == 'rejected')
                      <a href="{{ route('user.form', $app->id) }}" class="btn style01">Edit</a>
                      <a href="{{ route('user.form.destroy', $app->id) }}" class="btn delete">DELETE</a>
                    @endif
                    </div>
                  </td>
                </tr>

              @endforeach
              </tbody>
            </table>
          </div>
          @else
              @lang('message.no_records').
          @endif


      <ul class="paging">
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li class="next"><a href="#">next</a></li>
      </ul>
    </div>
  </div>




</div>

@include('user.parts.informBlock')
@endsection