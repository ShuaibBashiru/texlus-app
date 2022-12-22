<template>
  <div class="bg position-absolute w-100 h-100">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
                
        <div class="container mb-5">
            <div class="row mt-5">
                <div class="col-md-8 m-auto ps-2">
                     <div class="m-md-4 mt-5">
                    <h2 class="display-3 text-center text-muted"> 404 - Page not found! </h2>
                    <p class="lead text-center mt-4">We're sorry, we couldn't find the page you requested. 
                        but you can use other links to navigate to other 
                        pages that may be helpful. If you feel something is
                         missing, please contact us. </p>
                     </div>
                    </div>
            </div>

           <div class="row">
                <div class="col-md-12">
                     <div class="text-center">
                     <button type="button" class="m-2 btn btn-outline-primary" @click="$router.go('-1')"> <i class="bi-arrow-90deg-left"></i> Back</button>
                     </div>
                </div>
            </div>
        </div>

    </div>
</template>

<style>
.lead{
  color: #0a010196;
font-size: 18px;

}
</style>
<script>
import appsettings from '/storage/settings/app.json'
export default {
  name: 'PageNotFound',
    data (){
    return{
        settings:appsettings,
        showOverlay: false,
        info: [],
    }
    },

    }
</script>