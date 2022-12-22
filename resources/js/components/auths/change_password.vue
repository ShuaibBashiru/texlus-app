<template>
<div class="bg p-0 m-0">
  <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<notification :alertTitle="alertTitle" :alertMsg="alertMsg"></notification>
<div class="container-fluid mt-3">
<div class="row d-flex justify-content-center p-0 mt-2">
    <div class="col-md-5 mt-2 ps-md-5 pe-md-5">
      <server-alert :server_message="server_message" />
    <div class="wrap-img text-center">
    <a class="navbar-brand p-0 m-0" href="#"><img :src="settings.logo_link" class="img-responsive rounded logoSize2"  alt="image"> <br/> <span class="fs-4 text-light" v-text="settings.site_name"></span> </a>
     </div>
      <form @submit.prevent="changePassword" role="form" class="p-2"> 
    <div class="m-1 mt-3">
  <div class="form-row p-4 border bg-light pt-2 pb-4 rounded">
    <div class="form-group mt-2 col text-center">
    <p class="lead"> <span v-text="'@'+info.firstname"></span><br> <span class="text-muted" v-text="info.user_email"></span></p>
    </div>
    <div class="form-group mt-0 col">
        <label for="pwd" class="text-muted pb-2">New password</label>
      <div class="input-group">
        <input :type="pass_type" class="form-control shadow-none" @change="confirmPassword" v-model="parameters.pwd" placeholder="Enter your new password" id="pwd" required maxlength="50" minlength="3">
        <label class="form-check-label input-group-text bg-light" for="showpass">
         <i class="bi-eye" style="font-size: 1.2rem;"></i> 
        </label>
      </div>
    <small class="text-danger" v-if="errors.pwd" v-text="errors.pwd"></small>
    </div>
    <div class="form-group mt-4 col">
        <label for="cpwd" class="text-muted pb-2">Confirm password</label>
      <div class="input-group">
        <input :type="pass_type" class="form-control shadow-none" @change="confirmPassword" v-model="parameters.confirmpwd" placeholder="Re-enter your new password" id="cpwd" required maxlength="50" minlength="3">
      </div>
    <small class="text-danger" v-if="errors.confirmpwd" v-text="errors.confirmpwd"></small>
    </div>

    <div class="form-group mt-2 col d-none">
    <input class="form-check-input d-none" type="checkbox" id="showpass" v-model="toggle" true-value="yes" false-value="no" @change="showpassword">
    </div>

    <div class="form-group mt-2 col">
        <small class="text-muted">
            Make sure it's at least 8 characters or more including a number, uppercase, lowercase letter and special symbol.
        </small>
    </div>

      <div class="form-group mt-3 col">
     <div class="row">
       <div class="col-md-12">
         <button type="submit" name="" class="btn btn-primary w-100 border-0 pt-2 pb-2" v-text="button" :disabled="disabled"></button></div>
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
</template>
<script>
import appsettings from '/storage/settings/app.json'
export default {
    name: 'account_changePassword',
    props: ['server_record', 'server_message'],
    data(){
      return{
          settings: appsettings,
          alertTitle: '',
          alertMsg: '',
          showOverlay: false,
          notification: '',
          info: this.server_record,
          progress: null,
          btntxt: 'Continue',
          button: 'Continue',
          record:false,
          responseStatus: '',
          disabled: true,
          errors: [],
          parameters:{
              user_email: '',
              pwd: '',
              confirmpwd: '',
              token: '',
              agree: '',
          },
          toggle: null,
          pass_type: 'password',
            }

    },
    created(){
      this.parameters.user_email = this.info.user_email
    },

    methods:{
      validatePassword: function(){
        this.disabled = true
        var password = this.parameters.pwd;
        if(password.search(/[A-Z]/) < 0 || password.search(/[a-z]/) < 0){
          this.errors.pwd="Uppercase and lowercase are required.";
          return false;
        }else if(password.search(/[0-9]/) < 0 || password.search(/[.!@#\$%\^&\*]/) < 0){
          this.errors.pwd="Must contain number(s) and special character(s).";
          return false;
        }else if(password.length < 8){
          this.errors.pwd="Must contain at least 8 characters long.";
          return false;
        }else{
          this.errors.pwd="";
          return true;
        }
        },

        validatePassword2: function(){
          this.disabled = true;
        if(this.parameters.pwd === this.parameters.confirmpwd){
          this.errors.pwd="";
          this.errors.confirmpwd="";
          return true;

        }else{
          this.disabled = true;
          this.errors.confirmpwd="Password do not match";
          return false;
        }
      },
        confirmPassword: function(){
          if(this.validatePassword() && this.validatePassword2()){
          this.disabled = false;
          }else{
          this.disabled = true;
          }
        },

      showpassword: function(){
      if(this.toggle=="yes"){
      this.pass_type = 'text'
      }else{
      this.pass_type = 'password'
      }
      },

      changePassword: function(){
        this.button='Please wait...';
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.alertMsg = '';
        const form = new FormData();
        for (var key in this.parameters){
        form.append(key, this.parameters[key])
        }
        axios.post('/password/change', form).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
        if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            $("#alertPrimary").toast('show')
            this.disabled = true;
            setTimeout(function(){
              window.location.href=response['data'].data.redirect
              }, 4000)
            }else if(response['data'].data.status=='failed'){
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
            }else{
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
            }
        }).catch(error => {
                this.button=this.btntxt;
                this.showOverlay=false;
            if(error.response != undefined && error.response.status==422){
                this.errors = error.response.data.errors;
                this.alertMsg='Something went wrong! Kindly confirm and correct the error(s) before you continue.'
                $("#alertDanger").toast('show')
            } else if(error.response != undefined && error.response.status==419){
                this.alertMsg='This page has been inactive for long, Kindly refresh and try again.';
                $("#alertDanger").toast('show')
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
