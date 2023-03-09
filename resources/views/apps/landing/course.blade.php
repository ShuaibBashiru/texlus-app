@extends('layouts.landing')
@section('pageTitle', 'Course')
@section('content')

<div class="container-fluid">
        <div class="row">
                <div class="col-md-12 p-0 m-0">
                @if (session()->has('adminSessionData'))
                        <menu-header-auth></menu-header-auth>
                @else
                        <menu-header></menu-header>
                @endif
                </div>
        </div>

        <br clear="all/">
        <div class="row mt-5">
        <!-- Body component(s) -->
            <div id="contentPanel" class="col-md-12 p-0 mt-5">
            <div class="">
                <course-selected :server_message="{{ session('message') ?? $message ?? json_encode('') }}" :server_record="{{ session('record') ?? $record ?? json_encode('') }}"></course-selected>
                <courses :server_message="{{ session('message') ?? $message ?? json_encode('') }}"></courses>
           <web-footer></web-footer>
        </div>
</div>
   </div>

</div>


@endsection('content')