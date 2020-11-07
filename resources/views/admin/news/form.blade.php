<div class="form-group">
  <label for="name">{{Lang::get('message.title')}}</label>
  {!! Form::textarea('title', $news->title, ['class' => 'form-control', 'rows' => '1']) !!}
</div>

<div class="form-group">
  <label for="name">External link</label>
  {!! Form::textarea('url', $news->url, ['class' => 'form-control', 'rows' => '1']) !!}
</div>

<div class="form-group">
  <label>Image</label>
  <div id="holder"><img src="/resize/175/88/?img={{ urlencode($news->image) }}"></div>
  <a id="lfm" data-input="thumbnail" data-preview="holder" class="lfm btn btn-sm btn-outline-primary mt-2">
    <i class="fa fa-picture-o"></i> Выбрать
  </a>
  <a id="delete-image" class="btn btn-sm btn-outline-danger {{($news->image) ? '' : 'hidden'}} mt-2">
    <i class="fa fa-trash-o"></i> Удалить
  </a>
  <input id="thumbnail" class="form-control" type="hidden" name="image" value="{{ $news->image }}">

  <div class="text-muted">Recomended image size 240x188px</div>
</div>


<div class="form-group">
  <label for="name">{{Lang::get('message.preview')}}</label>
  {!! Form::textarea('preview', $news->preview, ['class' => 'form-control editor']) !!}
</div>

<div class="custom-control custom-checkbox mb-2">
  {!! Form::hidden('show', 0) !!}
  {!! Form::checkbox('show', 1, $news->show, ['class' => 'custom-control-input', 'id' => 'show']) !!}
  <label for="show" class="custom-control-label">Show</label>
</div>

<div class="form-group">
  <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
</div>
