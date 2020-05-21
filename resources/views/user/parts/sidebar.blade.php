<div class="{{$class_col ?? 'col-md-2'}}">
    <div class="list-group">
	  <a class="list-group-item list-group-item-action {{$slug=='my-apps' ? 'active': ''}}" href="/user">Dashboard</a>
	  <a class="list-group-item list-group-item-action {{$slug=='my-details' ? 'active' : ''}}" href="/user/edit">My Details</a>
	  <a class="list-group-item list-group-item-action {{$slug=='security' ? 'active' : ''}}" href="/user/security">Security</a>
	  <a class="list-group-item list-group-item-action" href="#">Grants</a>
	  <a class="list-group-item list-group-item-action" href="#">Help</a>
	  <a class="list-group-item list-group-item-action" href="#">Contact</a>
	  <a class="list-group-item list-group-item-action" href="https://www.rwav.com.au/" target="_blank">Back to RWAV</a>
    </div>
</div>