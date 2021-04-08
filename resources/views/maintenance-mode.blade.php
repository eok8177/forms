@extends('layouts.front')

@section('wrap')

<div class="main">
    <div>
        <img src="/images/rwav-logo-08-2018.png" />
    </div>

    <div class="message" style="padding: 30px 40px; max-width: 600px; margin: 0 auto; text-align: center; font-size: 20px; line-height: normal;">
        {!! $message !!}
    </div>
    
</div>

@endsection

@push('styles')
<style>
body {
background-color: white;
}
</style>
@endpush