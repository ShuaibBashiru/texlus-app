@extends('layouts.backend')
@section('pageTitle', 'Create account')
@section('content')
<signup :server_message="{{ session('message') ?? $message ?? json_encode('') }}"></signup>
@endsection('content')