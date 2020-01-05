
<div class="form-group">
  <label for="title">{{Lang::get('message.title')}}</label>
  <input type="text" name="title" value="{{$page->title}}" class="form-control">
</div>

<div class="form-group">
	<label for="title">Description</label>
  {!! Form::textarea('description', $page->description, ['class' => 'form-control', 'rows' => '2']) !!}
</div>

<div class="form-group mt-4">
  <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
</div>

