@extends('layouts.menuHeader')
@section('pageTitle', 'Authentication')
@section('content')
   <authentication :server_message="{{ session('message') ?? $message ?? json_encode('') }}"></authentication>
@endsection('content')