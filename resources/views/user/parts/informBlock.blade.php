@php
    $news = \App\News::front();
@endphp

<div class="inform-blocks">
  <div class="block">
    <h2 class="color">LATEST RWAV NEWS</h2>
    <div class="slider-holder">
      <div class="news slick-slider">
        @foreach($news as $item)
        <div class="block-new">
          <div class="img-holder">
            <img src="/resize/240/188/?img={{ urlencode($item->image) }}" alt="{{$item->title}}">
          </div>
          <div class="description">
            <span class="heading">{{$item->title}}</span>
            <div>{!! $item->preview !!}</div>
            <a href="{{$item->url}}" target="_blank">Read More</a>
          </div>
        </div>
        @endforeach

      </div>
      <div class="btns">
        <a href="#" class="prev">prev</a>
        <a href="#" class="next">next</a>
      </div>
    </div>
  </div>
  <div class="block">
    <h2 class="color">DO YOU HAVE FEEDBACK?</h2>
    <div class="box">
      <form action="#">
        <textarea id="text" cols="30" rows="10"></textarea>
        <div id="ok" style="display: none;color: #5087c8;">Thank You for feedback</div>
        <div id="error" style="display: none; color: red;"></div>
        <button id="btn_send" class="submit" onclick="sendMail();">submit</button>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
  window.sendMail = function() {
      let text = $('#text').val();
      let user = {{auth()->user()->id}};

      if (text != '') {
          $.post("/api/feedback-email", {
              user: user,
              text: text
          }, function(res) {
            console.log(res);
            if (res.status == 'OK') {
              $('#error').hide();
              $('#ok').show();
              $('#text').val('');
              $('#btn_send').attr('disabled', true);
            } else {
              $('#error').text(res.error).show();
              $('#ok').hide();
            }
          });
      }
  }
</script>
@endpush