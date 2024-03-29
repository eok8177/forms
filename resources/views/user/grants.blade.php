@extends('layouts.user')

@section('content')

<div class="dashboard-area tabs-area">

    <h2>Grants Applications</h2>
    
    <p style="text-align: right; margin-right: 16px;">
      <a href="https://www.rwav.com.au/grants-2020/public/" class="btn style01" style="font-size: 14px;">Apply for Grants</a>
    </p>
    
    <ul class="tabs">
    <li class="tab01"><a href="#tab01">Drafts</a></li>
    <li><a href="#tab02">Submitted</a></li>
  </ul>

  <div class="tab-content">
    <div id="tab01" class="tab-area" style="display: none;">
      @if ($apps->count() > 0)
          <div class="table-holder adaptive-table" id="sortTable">
            <table>
              <thead>
                <tr>
                  <th><span class="sort" data-tab="0" data-order="type">TYPE</span></th>
                  <th>DETAILS</th>
                  <th><span class="sort" data-tab="0" data-order="status">status</span></th>
                  <th><span class="sort" data-tab="0" data-order="date">Last Saved</span></th>
                  <th>actions</th>
                </tr>
              </thead>
              <tbody>
              @foreach($apps as $app)
                <tr>
                  <td>
                    <span class="title" style="background-color: {{$app->form->types->color}}">{{$app->form->type}}</span>
                  </td>
                  <td>
                    <strong>{{$app->form->title}} {!! $app->additional_field !!}</strong>
                  </td>
                  <td class="inline-block">
                    <span class="hide-lg"><strong>Status:</strong></span>
                    @if($app->status == 'rejected')
                      Review Resubmit
                    @elseif($app->status == 'draft')
                      Draft
                    @else
                      Submitted
                    @endif
                  </td>
                  <td class="inline-block">
                    <span class="hide-lg"><strong>Date:</strong></span>
                    <span class="date">{{ date('d/m/Y H:i', strtotime($app->updated_at)) }}</span>
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
    </div>
    <div id="tab02" class="tab-area" style="display: none;">
      @if ($submitted->count() > 0)
          <div class="table-holder adaptive-table" id="sortTable">
            <table>
              <thead>
                <tr>
                  <th><span class="sort" data-tab="1" data-order="type">TYPE</span></th>
                  <th>DETAILS</th>
                  <th><span class="sort" data-tab="1" data-order="status">status</span></th>
                  <th><span class="sort" data-tab="1" data-order="date">date</span></th>
                  <th>actions</th>
                </tr>
              </thead>
              <tbody>
              @foreach($submitted as $s_app)
                <tr>
                  <td>
                    <span class="title" style="background-color: {{$s_app->form->types->color}}">{{$s_app->form->type}}</span>
                  </td>
                  <td>
                    <strong>{{$s_app->form->title}} {!! $s_app->additional_field !!}</strong>
                  </td>
                  <td class="inline-block">
                    <span class="hide-lg"><strong>Status:</strong></span>
                      @if($s_app->status == 'rejected')
                        Review Resubmit
                      @elseif($s_app->status == 'draft')
                        Draft
                      @else
                        Submitted
                      @endif
                  </td>
                  <td class="inline-block">
                    <span class="hide-lg"><strong>Date:</strong></span>
                    <span class="date">{{ date('d/m/Y H:i', strtotime($s_app->updated_at)) }}</span>
                  </td>
                  <td>
                    <div class="btns">
                      <a href="{{ route('user.formView', $s_app->id) }}" class="btn style01">View</a>
                    </div>
                  </td>
                </tr>
              @endforeach

              @if (!(empty($dataMars)))
              @foreach(@$dataMars as $obj)
                <tr>
                  <td>{{$obj->Type}}</td>
                  <td></td>
                  <td>{{$obj->Status}}</td>
                  <td>{{ date('Y/m/d H:i', strtotime($obj->Date)) }}</td>
                  <td></td>
                </tr>
              @endforeach
              @endif

              </tbody>
            </table>
          </div>
          @else
              @lang('message.no_records').
          @endif
    </div>
  </div>

</div>

@endsection

@push('scripts')
<style>
  .sort {cursor: pointer;}
</style>
<script>
$(function () {
  let urlParams = new URLSearchParams(window.location.search);
  let orderQuery = urlParams.get('order');
  let dirQuery = urlParams.get('dir');
  let dir = 'asc';
  let prevTab = {{ request()->get('tab', 0) }};

  $("#sortTable .sort").each(function(i, el) {
    let $el = $(el);
    if (orderQuery == $el.data('order') && dirQuery == 'desc') {
      $el.addClass('desc');
    }
    $el.click(function() {
      if (orderQuery == $el.data('order') && prevTab ==$el.data('tab')) {
        if (dirQuery == 'asc') {
          dir = 'desc';
        }
      }
      window.location.href = window.location.pathname+"?"+$.param({'order': $el.data('order'),'dir': dir, 'tab': $el.data('tab')});
    });
  });

  $( ".tabs-area" ).tabs({
    active: prevTab
  });
});
</script>
@endpush