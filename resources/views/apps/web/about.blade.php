@extends('layouts.landing')
@section('pageTitle', 'About')
@section('content')

<div class="container-fluid">
        <div class="row">
                <div class="col-md-12 p-0 m-0">
                    <menu-header></menu-header>
                </div>
        </div>
        
        <div class="row mt-5">
        <!-- Body component(s) -->
            <div id="contentPanel" class="col-md-12 p-0 mt-5">
            <div class="">
           <about :server_message="{{ session('message') ?? $message ?? json_encode('') }}"></about>
           <web-footer></web-footer>
        </div>
</div>
   </div>

</div>


@endsection('content')