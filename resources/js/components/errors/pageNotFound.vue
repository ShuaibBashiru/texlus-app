<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
      <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />        
<div class="container-fluid">
    <server-alert :server_message="server_message" />
    <a href="#" id="topLink"></a>
        <div class="row">
    <div class="row mt-3">
        <div class="col-md-8 m-auto ps-2">
            <h2 class="display-3 text-center text-danger"> 404! <br/> Page not found. </h2>
            <p class="lead text-center mt-4">We're sorry, we couldn't find the page you requested for. 
                but you can use other links to navigate to other 
                pages that may be helpful. If you feel like something is
                    missing, please contact us. </p>

            </div>
    </div>

    <div class="row">
        <div class="col-md-12">
                <div class="text-center">
                <button type="button" class="m-2 btn btn-outline-primary" onclick="history.back()"> <i class="bi-arrow-90deg-left"></i> Back</button>
                </div>
        </div>

            <h6 class="text-center text-muted mt-5" v-text="settings.site_name">  </h6>

    </div>



</div>

    </div>
</div>
</template>

<script>
import appsettings from '/storage/settings/app.json';
export default {
    name: 'PageNotFound',
    props: ['server_message'],
    data (){
        return{
        pageName: 'Page Not Found',
        settings: appsettings,
        showOverlay: false,
        info: [],
    }
    },
    }
</script>