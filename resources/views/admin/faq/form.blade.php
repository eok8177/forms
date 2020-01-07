<div class="form-group">
  <label for="name">{{Lang::get('message.question')}}</label>
  {!! Form::textarea('question', $faq->question, ['class' => 'form-control', 'rows' => '1']) !!}
</div>

<div class="form-group">
  <label for="name">{{Lang::get('message.answer')}}</label>
  {!! Form::textarea('answer', $faq->answer, ['class' => 'form-control', 'rows' => '2']) !!}
</div>

<div class="custom-control custom-checkbox mb-2">
  {!! Form::hidden('show', 0) !!}
  {!! Form::checkbox('show', 1, $faq->show, ['class' => 'custom-control-input', 'id' => 'show']) !!}
  <label for="show" class="custom-control-label">Show</label>
</div>


<div class="form-group">
  <input type="submit" value="{{Lang::get('message.save')}}" class="btn btn-secondary">
</div>

@push('styles')
  <style type="text/css">
    .autofeel-hack {
      position: absolute;
      top: -999px;
    }
  </style>
@endpush