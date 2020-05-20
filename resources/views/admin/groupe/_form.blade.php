<div class="form-group">
  <label for="title">Group name</label>
  <input type="text" class="form-control" name="name" value="{{$group->name}}">
</div>
<br />
<div class="form-group">
<label>Managers</label>
@foreach($managers as $manager)
  <div class="custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" 
      id="manager_{{$manager->id}}"
      name="managers[]"
      value="{{$manager->id}}"
      @if($group->managers->contains('id', $manager->id))
        checked="checked"
      @endif
    >
    <label class="custom-control-label" for="manager_{{$manager->id}}">{{$manager->last_name}} {{$manager->first_name}} <small>[{{$manager->email}}]</small></label>
  </div>
@endforeach
</div>
