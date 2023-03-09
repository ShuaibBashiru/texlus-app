@extends('layouts.backend')
@section('pageTitle', 'Edit')
@section('content')
   <!-- Please note that, these are just default components, 
    any of these can me replaced and modified as the case may be -->
    <div class="container-fluid">
        <div class="row">
            <!-- Header Component -->
                <div class="col-md-12 p-0 m-0">
                    <header-backend-general></header-backend-general>
                </div>
        </div>
        
        <div class="row">
                <!-- Sidebar component -->
           <div id="togglePanel" class="col-2">
              <sidebar-backend-menu></sidebar-backend-menu>
        </div>
           
        <!-- Body component(s) -->
            <div id="contentPanel" class="col-md-10 p-0 mt-5">
            <div class="mb-5 mt-4">
                <back-button-user :server_message="{{ session('message') ?? $message ?? json_encode('') }}" :server_record="{{ session('record') ?? $record ?? json_encode('') }}"></back-button-user>
                <div class="row m-0">
                    <div class="col-md-4">
                    <user-menu-list :server_message="{{ session('message') ?? $message ?? json_encode('') }}" :server_record="{{ session('record') ?? $record ?? json_encode('') }}"/>
                    </div>
                    <div class="col-md-8 ps-0">
                    <edit_user_name :server_message="{{ session('message') ?? $message ?? json_encode('') }}" :server_record="{{ session('record') ?? $record ?? json_encode('') }}"></edit_user_name>
                    </div>
                </div>
           
        </div>

       </div>

   </div>

</div>

@endsection('content')