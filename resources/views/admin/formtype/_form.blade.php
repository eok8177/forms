<div class="form-group">
  <label for="title">Name</label>
  <input type="text" class="form-control" name="name" value="{{$form_type->name}}">
</div>

<div class="form-group">
  <label for="name">Description</label>
  {!! Form::textarea('description', $form_type->description, ['class' => 'form-control editor']) !!}
</div>

<label>Color form name</label>
<div class="form-group">
  @foreach($colors as $color)
    <div class="color-radio">
      <input class="color-radio-input" type="radio" 
        id="color_{{$color}}"
        name="color"
        value="{{$color}}"
        @if($form_type->color == $color)
          checked="checked"
        @endif
      >
      <label class="color-radio-label" style="background: {{$color}};" for="color_{{$color}}"></label>
    </div>
  @endforeach
</div>

@push('styles')
<style>
  .color-radio {
    display: inline-flex;
    padding: 2px;
  }
  .color-radio-input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }
  .color-radio-label {
    position: relative;
    width: 50px;
    height: 40px;
    border-radius: 4px;
    cursor: pointer;
  }
  .color-radio-label:before, .color-radio-label:after {
    content: '';
    position: absolute;
    left: 0; right: 0;
    top: 0; bottom: 0;
    margin: auto;
  }
  .color-radio-input:checked~.color-radio-label:before {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: #fff;
  }
  .color-radio-input:checked~.color-radio-label:after {
    content: "\f00c";
    font-family: FontAwesome;
    text-align: center;
    line-height: 40px;
  }
</style>
@endpush