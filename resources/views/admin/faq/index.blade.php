@extends('admin.layout')

@section('content')

<div class="page-header row justify-content-between">
  <h5>FAQ`s</h5>
  <a href="{{ route('admin.faq.create') }}" class="btn btn-light"><i class="fa fa-plus-square"></i> @lang('message.create')</a>
</div>

<div class="position-relative">
  <div class="table-responsive">
    <table class="table table-hover sorted_table">
      <thead>
        <tr>
          <th scope="col" class="col-md-10">Question</th>
          <th scope="col" class="col-md-2 text-center">Actions</th>
        </tr>
      </thead>
      @foreach($faqs as $faq)
        <tr data-id="{{$faq->id}}">
          <td><a href="{{ route('admin.faq.edit', ['faq'=>$faq->id]) }}" class="btn">{{$faq->question}}</a></td>
          <td class="text-center">
            <a href="{{ route('admin.faq.edit', ['faq'=>$faq->id]) }}" class="btn fa fa-pencil" title="Edit"></a>
            <a href="{{ route('admin.faq.destroy', ['faq'=>$faq->id]) }}" class="btn fa fa-trash-o delete" title="Delete"></a>
            <a href="{{route('admin.ajax.status', ['id' => $faq->id, 'model' => 'Faq', 'field' => 'show'])}}" class="status btn fa fa-{{$faq->show ? 'check-circle' : 'times-circle'}}" title="Toggle Show"></a>
          </td>
        </tr>

      @endforeach
    </table>
  </div>
</div>


@endsection


@push('scripts')
<script type="text/javascript">
  $(function  () {

    var group = $('.sorted_table').sortable({
      containerSelector: 'table',
      itemPath: '> tbody',
      itemSelector: 'tr',
      placeholder: '<tr class="placeholder"/>',
      onDrop: function ($item, container, _super) {
        var data = group.sortable("serialize").get()[0];
        // console.log(data);

        $.ajax({
            data: {order:data},
            type: 'PUT',
            dataType: 'json',
            url: '{{route('admin.ajax.reorder',['model'=>'Faq'])}}'
        });

        _super($item, container);
      }
    });

  });
</script>
@endpush

@push('styles')
<style type="text/css">
  body.dragging, body.dragging * {
    cursor: move !important;
  }
  .dragged {
    position: absolute;
    opacity: 0.8;
    z-index: 2000;
    background: #FFF;
  }
  .sorted_table .placeholder {
    position: relative;
  }
  .sorted_table .placeholder:before {
    content: "";
    position: absolute;
    width: 0;
    height: 0;
    border: 5px solid transparent;
    border-left-color: red;
    margin-top: -5px;
    left: 0;
    border-right: none;
  }
</style>
@endpush