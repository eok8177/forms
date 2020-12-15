@extends('email.layout')

@section('content')

<h1>Hello!</h1>

<div style="text-align: left;">

    <div>
        <b>User ID: </b>
        {{ $msg->user_id }}
    </div>

    <div>
        <b>From IP: </b>
        {{ $msg->ip_address }}
    </div>

    <div>
        <b>User Agent: </b>
        {{ $msg->user_agent }}
    </div>

    <div>
        <b>Payload: </b>
        <pre>
            {{ print_r(json_decode($msg->payload, true)) }}
        </pre>
    </div>
</div>



@endsection