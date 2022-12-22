@extends('layouts.menuHeader')
@section('pageTitle', 'Sign in')
@section('content')
   <signin :server_message="{{ session('message') ?? $message ?? json_encode('') }}"></signin>
@endsection('content')