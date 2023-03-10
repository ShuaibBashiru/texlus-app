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
                
           <statuses_manage :server_message="{{ session('message') ?? $message ?? json_encode('') }}" :server_record="{{ session('record') ?? $record ?? json_encode('') }}"></statuses_manage>
           <statuses_edit :server_record="{{ session('record') ?? $record ?? json_encode('') }}"> </statuses_edit>
           <statuses_delete :server_record="{{ session('record') ?? $record ?? json_encode('') }}"> </statuses_delete>
    </div>

       </div>

   </div>

</div>

@endsection('content')