<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<div class="container-fluid">
    <server-alert :server_message="server_message" />
    <a href="#" id="topLink"></a>
        <div class="row">
    <div class="row mt-3">
        <div class="col-md-8 m-auto ps-2">
            <h2 class="display-3 text-center text-danger"> Restricted! </h2>
            <p class="lead text-center mt-4">Your Access is restricted from using this module. You can use other links to navigate.</p>
            </div>
    </div>

    <div class="row">
        <div class="col-md-12">
                <div class="text-center">
                <button type="button" class="m-2 btn btn-outline-primary" onclick="history.back()"> <i class="bi-arrow-90deg-left"></i> Back</button>
                </div>
        </div>
    </div>



</div>

    </div>
</div>
</template>

<script>
import appsettings from '/storage/settings/app.json';
export default {
    name: 'No_Acces',
    props: ['server_message'],
    data (){
        return{
        pageName: 'No Access',
        settings: appsettings,
        showOverlay: false,
        info: [],
    }
    },
    }
</script>