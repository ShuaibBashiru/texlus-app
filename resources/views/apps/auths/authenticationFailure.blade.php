@extends('layouts.menuHeader')
@section('pageTitle', 'Authentication failed')
@section('content')
   <authentication-failure :server_message="{{ session('message') ?? $message ?? json_encode('') }}"></authentication-failure>
@endsection('content')