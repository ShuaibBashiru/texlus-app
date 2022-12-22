<template>
<div class="position-absolute w-100 h-100 bg-lightblue">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <flyout-notification />
   <div class="container-fluid">
       <div class="row mt-5" v-if="authenticationStatus">
           <div class="col-md-6 m-auto text-center mt-5">
            <div class="mt-5">
                <p class="display-6 text-primary"><small><strong v-html="message"></strong></small></p>
            </div>
            <div class="spinner-border text-primary p-5 mt-5 bg-light" role="status">
            <span class="">/</span>
            </div>
           </div>
       </div>
          <div class="row mt-5" v-else>
           <div class="col-md-5 m-auto text-center">
             <div class="" role="status">
                <p class="display-2 text-danger">
                    <i class="bi bi-exclamation-diamond text-danger"></i> 
                 </p>
                     <p class="display-6 text-danger">Oops! We are sorry for any incovenience.</p>
            </div>
            <div class="mt-2">
                <p class="lead text-danger"><small><strong v-text="alertMsg"></strong></small></p>
            </div>
            <div class="p-5 mt-2" role="status">
                <a href="/app/logout" class="btn btn-warning">Go Back!</a>
            </div>
           </div>
       </div>
   </div>

    </div>
</template>
<script>
import appsettings from '/storage/settings/app.json'
export default {
    name: 'authentication',
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
        authenticationStatus: true,
        errors: [],
        message: 'Please wait for an authentication to complete...',
        parameters: {
            id: ''
        }
   
    }
},

created(){
    this.authenticate();
},
    methods:{
    authenticate(){
          $(".toaster").toast('hide')
          this.alertMsg = '';
          const form = new FormData();
          for(var key in this.parameters){
            form.append(key, this.parameters[key])
          }
          axios.post('/auth/authenticate', form).then(response => {
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
              setTimeout(function(){
              window.location.href=response['data'].data.redirect
              }, 3000)
              }else{
                this.alertMsg = response['data'].data.msg
                this.authenticationStatus = false;
            }
        }).catch(error => {
              this.authenticationStatus = false;
              this.alertMsg = 'Network error!. Please log in again or report this error using one of our support channels.';
        })
    },
    },

}
</script>