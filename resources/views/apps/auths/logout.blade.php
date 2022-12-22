@extends('layouts.menuHeader')
@section('pageTitle', 'Log out')
@section('content')
   <logout :server_message="{{ session('message') ?? $message ?? json_encode('') }}"></logout>
@endsection('content')