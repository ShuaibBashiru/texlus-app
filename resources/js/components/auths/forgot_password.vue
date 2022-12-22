<template>
<div class="bg p-0 m-0">
  <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<notification :alertTitle="alertTitle" :alertMsg="alertMsg"></notification>
<div class="">
<div class="container-fluid mt-5">
<div class="row d-flex justify-content-center p-0 mt-2">
    <div class="col-md-5 mt-2 ps-md-5 pe-md-5">
      <server-alert :server_message="server_message" />
     <div class="wrap-img text-center">
    <a class="navbar-brand p-0 m-0" href="#"><img :src="settings.logo_link" class="img-responsive rounded logoSize2"  alt="image"> <br/> <span class="fs-4 text-white" v-text="settings.site_name"></span> </a>
     </div>
  <form @submit.prevent="verifyEmail" role="form" class="p-2"> 
    <div class="m-1 mt-3">
  <div class="form-row p-4 border bg-light pt-2 pb-4 rounded">
    <div class="form-group mt-4 col">
      <h5>Verify account's email</h5>
        <p class="text-muted"><small>For account security purpose, enter your user account's email address and we will send you a password reset link to continue.</small></p>
    <div class="input-group mt-2">
      <input type="email" class="form-control shadow-none p-2 shadow-none" v-model="parameters.email_id" placeholder="Enter your account's email" id="email_id" required maxlength="50" minlength="11">
    </div>
    <small class="text-danger" v-if="errors.email_id" v-text="errors.email_id[0]"></small>
    </div>

      <div class="form-group mt-4 col">
     <div class="row">
       <div class="col-md-12">
         <button type="submit" name="login" class="btn btn-primary w-100 border-0 pt-2 pb-2" v-text="button" :disabled="disabled"></button></div>
     </div>
    </div>

  </div>
  </div>
</form>

<div class="row">
  <div class="col-12">
    <div class="row">
      <div class="col-12 text-center">
        <p><a href="/signin" class="text-light linkUnderlineHover text-center" style="opacity:0.7;">Return to login</a></p>
    </div>
    </div>
  </div>
</div>

  <div>
  </div>
  </div>

    </div>
</div>


</div>

</div>
</template>
<script>
import appsettings from '/storage/settings/app.json'
export default {
  name: 'account_forgotpassword',
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
      btntxt: 'Verify email',
      button: 'Verify email',
      record:false,
      responseStatus: '',
      errors: [],
      disabled: false,
      parameters:{
        email_id: '',
        pwd: '',
       },
      toggle:null,
      pass_type:'password',
         }

},
created(){
},

methods:{

        verifyEmail: function(){
          this.button='Please wait...';
          $(".toaster").toast('hide')
          this.showOverlay=true;
          this.alertMsg = '';
          this.disabled=true
          const form = new FormData();
          for(var key in this.parameters){
            form.append(key, this.parameters[key])
          }
          axios.post('/password_reset', form).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
              this.alertMsg=response['data'].data.msg;
              $("#alertPrimary").toast('show')
              this.disabled=true
              }else if(response['data'].data.status=='failed'){
              this.disabled=false
              this.alertMsg=response['data'].data.msg;
              $("#alertDanger").toast('show')
              }else{
              this.disabled=false
              this.alertMsg=response['data'].data.msg;
              $("#alertDanger").toast('show')
            }
        }).catch(error => {
              this.disabled=false
              this.button=this.btntxt;
              this.showOverlay=false;
              this.errors = '';
            if(error.response != undefined && error.response.status==422){
              this.errors = error.response.data.errors;
              this.alertMsg='Wrong detail(s) supplied, kindly confirm and try again.'
              $("#alertDanger").toast('show')
           } else if(error.response != undefined && error.response.status==419){
              this.alertMsg='This page has been inactive for long! Please reload this page or wait a few seconds while we reload this page to continue.'
              $("#alertDanger").toast('show')
              setTimeout(function(){
              window.location.reload()
              }, 3000)
           }else if(error.response != undefined && error.response.status==500){
              this.alertMsg='Internal server error! Please refresh and try again or report this error.';
              $("#alertDanger").toast('show')
           }else{
              this.alertMsg='Access restricted or Network error! Please refresh and try again or report this error.';
              $("#alertDanger").toast('show')
            }
        

        })
    },


},
// End of methods
}
</script>
