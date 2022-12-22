@extends('layouts.menuHeader')
@section('pageTitle', 'Change Password')
@section('content')
   <change-password :server_message="{{ session('message') ?? $message ?? json_encode('') }}" :server_record="{{ session('record') ?? $record ?? json_encode('') }}"></change-password>
@endsection('content')