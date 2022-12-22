@extends('layouts.backend')
@section('pageTitle', 'Actions')
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
                
           <user_passport :server_record="{{ session('record') ?? $record ?? json_encode('') }}"> </user_passport>
           <manage_user :server_message="{{ session('message') ?? $message ?? json_encode('') }}" :server_record="{{ session('record') ?? $record ?? json_encode('') }}"></manage_user>
           <delete_user :server_record="{{ session('record') ?? $record ?? json_encode('') }}"> </delete_user>
    </div>

       </div>

   </div>

</div>

@endsection('content')