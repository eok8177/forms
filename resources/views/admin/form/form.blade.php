
<div class="form-group">
  <label for="title">{{Lang::get('message.title')}}</label>
  <input type="text" name="title" value="{{$form->title}}" class="form-control">
</div>

<div class="form-group">
	<label for="title">Description</label>
  {!! Form::textarea('description', $form->description, ['class' => 'form-control']) !!}
</div>

<div class="custom-control custom-checkbox custom-control-inline">
  {!! Form::hidden('is_active', 0) !!}
  {!! Form::checkbox('is_active', 1, $form->is_active, ['class' => 'custom-control-input', 'id' => 'is_active']) !!}
  <label for="is_active" class="custom-control-label">{{Lang::get('message.active')}}</label>
</div>

<div class="custom-control custom-checkbox custom-control-inline">
  {!! Form::hidden('is_trash', 0) !!}
  {!! Form::checkbox('is_trash', 1, $form->is_trash, ['class' => 'custom-control-input', 'id' => 'is_trash']) !!}
  <label for="is_trash" class="custom-control-label">{{Lang::get('message.trash')}}</label>
</div>

<div class="form-group mt-4">
  <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
</div>

