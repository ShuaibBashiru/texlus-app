@extends('layouts.menuHeader')
@section('pageTitle', 'Under Maintenance')
@section('content')
   <maintenance :server_message="{{ session('message') ?? $message ?? json_encode('') }}"></maintenance>
@endsection('content')