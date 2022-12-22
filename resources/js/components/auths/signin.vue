<template>
<div class="bg">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg"></notification>
<div class="">
<div class="container-fluid mt-5">
<div class="row d-flex justify-content-center p-0 mt-2">
    <div class="col-md-5 mt-2 ps-md-5 pe-md-5">
      <server-alert :server_message="server_message" />
     <div class="wrap-img text-center">
    <a class="navbar-brand p-0 m-0" href="#"><img :src="settings.logo_link" class="img-responsive rounded logoSize2" alt="Logo"> <br/> <span class="fs-4 text-white" v-text="settings.site_name"></span> </a>
     </div>
  <form @submit.prevent="signIn" role="form" class="p-2"> 
    <div class="m-1 mt-3">
  <div class="form-row p-4 border bg-light pt-2 pb-4 rounded">
    <p class="text-center display-7 mt-3 text-muted">LOGIN</p>
    <div class="form-group mt-3 col">
        <label for="userid" class="text-muted pb-2">Email</label>
       <div class="input-group">
        <small class="input-group-text bg-light border-end-0">
           <small style=""> <i class="bi-envelope-open" style="font-size: 1.2rem;"></i> </small>
        </small>
      <input type="email" class="form-control shadow-none p-2 border-start-0 shadow-none" v-model="parameters.userid" placeholder="Enter your email" id="userid" required maxlength="50" minlength="11" :disabled="disabled">
    </div>
    <small class="text-danger" v-if="errors.userid" v-text="errors.userid[0]"></small>
    </div>
    <div class="form-group mt-4 col">
        <label for="pwd" class="text-muted pb-2">Password</label>
        <small class="float-end pb-2"><a href="/forgotpassword" class="">Reset password</a></small>
      <div class="input-group">
          <small class="input-group-text bg-light border-end-0">
        <label class="form-check-label" for="pwd">
        <small style=""> <i class="bi-key" style="font-size: 1.2rem;"></i> </small>
        </label>
        </small>
        <input :type="pass_type" class="form-control shadow-none border-start-0" v-model="parameters.pwd" placeholder="Enter password" id="pwd" required maxlength="50" minlength="3" :disabled="disabled" autocomplete="true">
      </div>
    <small class="text-danger" v-if="errors.pwd" v-text="errors.pwd[0]"></small>
    </div>

<div class="row">
      <div class="form-group mt-5 col">
     <div class="row">
       <div class="col-md-12">
         <button type="submit" name="login" class="btn btn-primary w-100 border-0 pt-2 pb-2" v-text="button" :disabled="disabled"></button></div>
     </div>
    </div>
    </div>

  </div>
  </div>
</form>

<div class="row">
  <div class="col-12">
    <p class="text-center text-light">I do not have an Account? <a href="/app/signup" class="text-primary text-light linkUnderlineHover"> Sign up </a></p>
    </div>
  <div class="col-12">
        <p class="text-center"><a href="/" class="text-light linkUnderlineHover" style="opacity:0.7;">Home</a></p>
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
  name: 'account_signin',
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
      btntxt: 'Log in',
      button: 'Log in',
      record:false,
      responseStatus: '',
      isDisabled: false,
      errors: [],
      disabled: false,
      parameters:{
        userid: '',
        pwd: '',
       },
      toggle:null,
      pass_type:'password',
         }

},
created(){
},

methods:{
      signIn(){
          this.button='Please wait...';
          $(".toaster").toast('hide')
          this.showOverlay=true;
          this.alertMsg = '';
          this.disabled=true
          const form = new FormData();
          for(var key in this.parameters){
            form.append(key, this.parameters[key])
          }
          axios.post('/login', form).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
              this.alertMsg=response['data'].data.msg;
              $("#alertPrimary").toast('show')
              this.$session.start()
              this.$session.set('usersession', response['data'].data.userInfo)
              setTimeout(function(){
              window.location.href=response['data'].data.redirect
              }, 3000)
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
    showpassword: function(){
      if(this.toggle=="yes"){
      this.pass_type = 'text'
      }else{
      this.pass_type = 'password'
      }
    },
   

},
// End of methods
}
</script>
