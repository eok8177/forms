@extends('layouts.user')

@section('content')
<div class="dashboard-area tabs-area">

  <h2>Contact RWAV</h2>
  <ul class="tabs-style">
    <li class="active"><span>SEND US A MESSAGE</span></li>
  </ul>

  <div class="tab-content">

    <div class="row">
      <div class="col-md-6">
        <p><b>Rural Workforce Agency Victoria</b></p>
        <p>Level 6, Tower 4, World Trade Centre</p>
        <p>18 – 38 Siddeley Street,</p>
        <p>Melbourne VIC 3005</p>
        <p>E: rwav@rwav.com.au</p>
        <p>P: +61 3 9349 7800</p>
        <p>F: +61 3 9820 0401</p>
      </div>
      <div class="col-md-6">
        <div id="map" class="map-responsive">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.603780617808!2d144.95150951580533!3d-37.82274867975089!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642ccfada529f%3A0xc7ae9fd60c02a716!2sRural%20Workforce%20Agency%20Victoria!5e0!3m2!1suk!2sua!4v1596045292894!5m2!1suk!2sua" width="740" height="350" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
      </div>
    </div>


    <h3 class="title-wide">SEND US A MESSAGE</h3>

    {!! Form::open(['route' => ['user.contact'], 'method' => 'POST', 'class' => 'form-horizontal']) !!}

      <div class="row">
        <div class="col-md-6">
          <div class="row form-group">
            <label class="col-sm-2 col-form-label">{{Lang::get('message.first_name')}}</label>
            <div class="col-sm-10">
              <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control @error('first_name') is-invalid @enderror">
              @error('first_name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row form-group">
            <label class="col-sm-2 col-form-label">{{Lang::get('message.last_name')}}</label>
            <div class="col-sm-10">
              <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control @error('last_name') is-invalid @enderror">
              @error('last_name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          </div>
        </div>
      </div>

      <div class="row form-group">
        <label class="col-sm-2 col-form-label">{{Lang::get('message.email')}}</label>
        <div class="col-sm-10">
          <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
          @error('email')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">{{Lang::get('message.message')}}</label>
        <textarea type="text" name="message" value="{{ old('message') }}" class="form-control @error('message') is-invalid @enderror"></textarea>
        @error('message')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
      </div>






      <div class="form-group btns">
        <input type="submit" value="{{Lang::get('message.send')}}" class="btn style01">
      </div>
    {!! Form::close() !!}

  </div> <!-- .tab-content -->

</div> <!-- .dashboard-area -->

@include('user.parts.informBlock')

@endsection

@push('styles')
<style>
  .map-responsive{
      overflow:hidden;
      padding-bottom:56.25%;
      position:relative;
      height:0;
  }
  .map-responsive iframe{
      left:0;
      top:0;
      height:100%;
      width:100%;
      position:absolute;
  }
</style>
@endpush