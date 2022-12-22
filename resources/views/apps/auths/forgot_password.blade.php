@extends('layouts.menuHeader')
@section('pageTitle', 'Forgot password')
@section('content')
   <forgot-password :server_message="{{ session('message') ?? $message ?? json_encode('') }}"></forgot-password>
@endsection('content')