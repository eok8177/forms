@extends('layouts.user')

@section('content')

<div class="dashboard-area tabs-area">
  <h2>Help</h2>

  <div class="accordion tab-content" id="accordion">
    @foreach($faqs as $faq)
    <div class="pb-2">
      <h2 id="heading-{{$faq->id}}" class="mb-0 ml-0 px-2 btn-collapse text-left" type="button" data-toggle="collapse" data-target="#collapse-{{$faq->id}}" aria-expanded="false" aria-controls="collapse-{{$faq->id}}">
        {!! $faq->question !!}
      </h2>

      <div id="collapse-{{$faq->id}}" class="collapse" aria-labelledby="heading-{{$faq->id}}" data-parent="#accordion">
        <div class="py-2">{!! $faq->answer !!}</div>
      </div>
    </div>
    @endforeach
  </div>


</div>

@endsection