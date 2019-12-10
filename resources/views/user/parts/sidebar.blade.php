<div class="{{$class_col ?? 'col-md-2'}}">
    <div class="list-group">
      <a class="list-group-item list-group-item-action {{$slug=='my-apps' ? 'active': ''}}" href="/user">My Applications</a>
      <a class="list-group-item list-group-item-action {{$slug=='my-details' ? 'active' : ''}}" href="/user/edit">My Details</a>
    </div>
</div>