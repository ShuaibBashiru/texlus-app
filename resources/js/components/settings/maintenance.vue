<template>
<div class="position-absolute w-100 h-100 bg-lightblue">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <!-- <flyout-notification /> -->
   <div class="container-fluid">
       <div class="row mt-5">
           <div class="col-md-5 m-auto text-center">
            <div class="" role="status">
                <p class="display-2 text-danger">
                    <i class="bi bi-exclamation-diamond text-danger"></i> 
                 </p>
                     <p class="display-6 text-danger">Oops! We are sorry for any incovenience.</p>
            </div>
            <div class="mt-2">
                <p class="lead text-danger"><small><strong v-text="server_message?server_message: message"></strong></small></p>
            </div>
            <div class="p-5 mt-2" role="status">
                <a href="/" class="btn btn-warning">Go Back!</a>
            </div>
           </div>
       </div>
   </div>

    </div>
</template>
<script>
import appsettings from '/storage/settings/app.json'
export default {
    name: 'maintenance',
    props: ['server_message'],
    
data(){
    return{
        settings: appsettings,
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        notification: '',
        info: [],
        progress: null,
        record:false,
        responseStatus: '',
        errors: [],
        message: 'Site currently under maintenance or upgrade. Please try again later or report this error using one of our support channels.',
   
    }
},

created(){
},
    methods:{

    },

}
</script>