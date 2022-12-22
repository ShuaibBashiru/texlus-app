@extends('layouts.backend')
@section('pageTitle', 'Page Not Foun - 4040')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 p-0 mt-5 m-auto">
            <div class="mb-5 mt-3">
           <page_not_found :server_message="{{ session('message') ?? $message ?? json_encode('') }}"></page_not_found>
        </div>
       </div>
   </div>
</div>
@endsection('content')