<template>
<div class="bg">
<b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<notification :alertTitle="alertTitle" :alertMsg="alertMsg" />
<div class="container-fluid">
    <server-alert :server_message="server_message" />
    <a href="#" id="topLink"></a>

<div class="row mt-3 mb-4">

<div class="col-md-8 bg-light m-auto rounded">
<div class="row">
<div class="col-md-5 p-1">
     <div class="m-1 rounded-3">
        <div class="row">
        <div class="col-md-12">
        <a class="navbar-brand p-2 m-0 mt-3" href="#"><img :src="settings.logo_link" class="img-fluid rounded logoSize" alt="Logo"> <span class="fs-4" v-text="settings.site_name"></span> </a>
        <div class="mt-4"></div>
        <h6 class="p-2">CREATE AN ACCOUNT</h6>
        <img :src="displayimage" class="img-fluid rounded w-100" alt="Logo">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <h6 class="fw-bold">1.  Account</h6>
                <p class="text-muted"> <small>Create an account to manage your activities</small> </p>
            </li>
        </ul>
         <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <h6 class="fw-bold">2.  Email validation</h6>
                <p class="text-muted"> <small>Validate your account via the link sent to your email address provided.</small> </p>
            </li>
        </ul> 
        </div> 
        </div>
     </div>
</div>

<div class="col-md-7 m-auto">
    <div class="">
        <div class="row">
    <div class="col-md-12 m-0 p-0" v-if="!accountStatus">
    <div class="m-1 border rounded-3 bg-light">
    <div class="row">
    <div class="col-md-12">
        <div class="m-3 mt-1">
            <form @submit.prevent="confirmSubmit" id="formChange">
            <fieldset class="border p-2 pt-0">
                <legend class="w-auto" style="float: none; padding: inherit;"><small><i class="bi bi-person"></i></small></legend>
        <div class="row">
            <div class="col-12">
            <p class="ps-2"> <small>Let's get you set up in a minute so you can manage your personal account and activities.</small></p>
            </div>
    <div class="col-md-6">
        <div class="m-1 mt-2 me-0">
                   <label for="lastname">Last Name<sup title="Required field">*</sup></label>
                <div class="input-group">
                    <input type="text" v-model="parameters.lastname" @keyup="noSpace('lastname')" id="lastname" minlength="3" maxlength="200" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Last Name">
                </div>
                <span class="text-danger" for="" v-if="errors.lastname && errors.lastname != ''"><small> <span v-text="errors.lastname[0]"></span> </small></span>
                </div>
        </div>

        <div class="col-md-6">
                <div class="m-1 mt-2 ms-0">
                   <label for="firstname">First Name<sup title="Required field">*</sup></label>
                <div class="input-group">
                    <input type="text" v-model="parameters.firstname" @keyup="noSpace('firstname')" minlength="3" maxlength="200" id="firstname" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="First name">
                </div>
               <span class="text-danger" for="" v-if="errors.firstname && errors.firstname != ''"><small> <span v-text="errors.firstname[0]"></span> </small></span>
                </div>
        </div>
        <div class="col-md-12">
                <div class="m-1 mt-3">
                <label for="email">Email<sup title="Required field">*</sup></label>
                <div class="input-group">
                    <input type="email" v-model="parameters.email_one" minlength="10" name="email_one" maxlength="100" id="email" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Email Address">
                </div>
                <span class="text-danger" for="" v-if="errors.email_one && errors.email_one != ''"><small> <span v-text="errors.email_one[0]"></span> </small></span>
                </div>
            </div>

        <div class="col-md-12">
                <div class="m-1 mt-3">
                <label for="phone_code">Phone Number<sup title="Required field">*</sup></label>
                <div class="row">
                    <div class="col-4 pe-1">
                <div class="input-group">
                    <select class="shadow-none form-control form-control-md form-control-sm-lg" v-model="parameters.phone_code" id="phone_code" required>
                    <option disabled value="" selected>Code</option>
                    <option :value="d['mcode']" v-for="(d, index) in phoneCodes" :key="index" v-text="d.name + ' ' +d.mcode"></option>
                    </select>
                    </div>
                    </div>
                <div class="col-8 ps-0">
                <div class="input-group">
                    <input type="text" @change="validatePhone('phone_one')" v-model="parameters.phone_one" @keyup="noSpace('phone_one')" minlength="7" maxlength="15" id="phone_one" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Phone number">
                    </div>
                </div>
                    </div>
                  <span class="text-danger" for="" v-if="errors.phone_one && errors.phone_one != ''"><small> <span v-text="errors.phone_one[0]"></span> </small></span>
                </div>
            </div>
        
<div class="col-12 mt-2">
<div class="row p-2">
    <div class="col-1">
    <input type="checkbox" id="agree" class="form-check" required>
    </div>
    <div class="col">
        <small> <label for="agree">By clicking the “Create your account” button, you agree to <span v-text="settings.site_name"></span>'s <a href="/terms">terms and privacy</a> of acceptable use.</label> </small>
    </div>

</div>
</div>
    <div class="col-md-12">
        <div class="m-1 mt-3">
        <button type="submit" class="btn btn-primary w-100 shadow-none float-end ms-1 mt-2" :disabled="disabled"><span v-text="button"></span> </button>
        </div>
    </div>
    </div>
            </fieldset>
            </form>

        </div>
    </div>
        </div>


<div class="row">
  <div class="col-12">
    <p class="text-center">Already have an Account? <a href="/signin" class="text-primary linkUnderlineHover"> Login </a></p>
    </div>
      <div class="col-12">
        <p class="text-center"><a href="/" class="linkUnderlineHover" style="opacity:0.7;">Home</a></p>
        </div>
    </div>
        </div>
        </div>

<!-- Feedback -->
<div class="col-12 text-center mt-5" v-else>
<div class="row">
    <div class="col-md-12 pt-4 p-3 m-auto bg-light border rounded">
        <p class="display-4"><i class="bi bi-check-square text-primary"></i></p>
        <h3 class="text-primary">Success!</h3>
        <!-- <p class="lead text-primary" v-html="alertMsg">
            Your account was created successfully. To continue, kindly click the link that was sent to the email provided to set your password.
        </p> -->
      <p class="lead text-primary">
            Your account was created successfully. To continue, kindly click the link that was sent to the email provided to set your password.
        </p>
    </div>
      <div class="col-12 mt-4">
        <p class="text-center"><a href="/" class="text-light linkUnderlineHover" style="opacity:0.7;">Home</a></p>
  </div>
</div>
</div>
    </div>
    </div>
</div>

</div>


</div>
</div>
</div>
</div>

</template>
<script>

import phonecodes from '/storage/json/phoneCode'
export default {
    name: 'signup',
    props: ['server_record', 'server_message'],
    data (){
        return{
        pageName: 'Account',
        settings: '',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: this.server_record,
        button: 'Create your account',
        btntxt: 'Create your account',
        usersession: [],
        category_list: [],
        checked: true,
        isChecked: false,
        selectDefault: "Select",
        counter: '0',
        statuses: [],
        disabled: false,
        validated: false,
        formNote: '',
        phoneCodes: phonecodes.codes,
        genders: [],
        max_year: new Date().getFullYear() - 6,
        pass_type: 'password',
        toggle: null,
        accountStatus: false,
        displayimage: '/assets/images/new-account.jpg',
        parameters:{
            personal_id: '',
            lastname: '',
            firstname: '',
            othername: '',
            email_one: '',
            phone_one: '',
            phone_code: '+234',
            gender_id: '',
            yob: '',
            mob: '',
            dob: '',
            pwd: '',
            generated_id: '',
        },
        errors: [this.parameters],
        form_success: [],
        mob_list: [
            {"dm":'01', 'm':'January'},{"dm":'02', 'm':'February'},
            {"dm":'03', 'm':'March'},{"dm":'04', 'm':'April'},
            {"dm":'05', 'm':'May'},{"dm":'06', 'm':'June'},
            {"dm":'07', 'm':'July'},{"dm":'08', 'm':'August'},
            {"dm":'09', 'm':'September'},{"dm":'10', 'm':'October'},
            {"dm":'11', 'm':'November'},{"dm":'12', 'm':'December'},
            ],
        dob_list: ['01', '02', '03', '04', '05', '06', 
        '07', '08', '09', '10', '11', '12', '13', '14',
        '15', '16', '17', '18', '19', '20', '21', '22',
        '23', '24', '25', '26', '27', '28', '29', '30',
        '31']
    }
    },

    created(){
        this.getAppSettings();
        // this.getGenders();
        },

    methods:{
    getAppSettings: function(){
        fetch('/storage/settings/app.json')
        .then((response) => response.json())
        .then((data) => {
           this.settings = data;
        });
    },
    resetForm: function(){
        this.validated = false;
        this.disabled = false;
        for(var key in this.parameters){
            this.parameters[key]=''
        }
    },

    showpassword: function(){
        if(this.toggle=="yes"){
        this.pass_type = 'text'
        }else{
        this.pass_type = 'password'
        }
        },


    validateForm: function(){
        if(this.parameters.lastname!='' && this.parameters.firstname!=''
         && this.parameters.firstname!=''
         && this.parameters.email_one!=''
         && this.parameters.phone_one!=''
         ){
            return true;
        }else{
            return false;
        }
    },

   validatePhone: function(phone){
    if(this.parameters[phone].startsWith(0) && this.parameters[phone].length > 1){
        var str=this.parameters[phone]
        this.parameters[phone]= str.replace(str.charAt(0), "")
    }
    },

   confirmSubmit: function(){
        $(".toaster").toast('hide')
         if(this.validateForm()){
            this.sendPost();
        }else{
            this.validated = false
            this.disabled = false;
            this.alertMsg='Kindly complete the required fields'
            $("#alertDanger").toast('show')
        }

    },
    
    cleanTextOnly: function(key){
            var string = this.parameters[key]
            var newString = string.replace(/^\s+|\s+$|[^a-zA-Z0-9.]/gm, ' ')
            this.parameters[key] = newString
    },
    noSpace: function(key){
            var str = this.parameters[key].toString()
            var newString = str.replace(/^\s+|\s+$/gm, '')
            this.parameters[key] = newString
    },
    oneSpace: function(key){
            var string = this.parameters[key]
            var newString = string.replace(/^\s+|\s+$/gm, ' ')
            this.parameters[key] = newString
    },
    sendPost: function(){
        this.button='Please wait...';
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.alertMsg = '';
        const form = new FormData();
        for (var key in this.parameters){
        form.append(key, this.parameters[key])
        }
        axios.post('/signup/create', form).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            this.accountStatus=true;
            this.verifyEmail();
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
                this.errors = '';
            if(error.response != undefined && error.response.status==422){
                this.errors = error.response.data.errors;
                this.alertMsg='Something went wrong! Kindly confirm and correct the error(s) before you continue.';
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

   getGenders: function(){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        axios.get('/genders/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
            this.genders = response['data'].data.info
            }else if(response['data'].data.status=='norecord'){
            this.genders = ''
            this.alertMsg=''
            }else{
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
            }
        }).catch(error => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.alertMsg='Something went wrong! Please refresh and try again or report this error.'
            $("#alertDanger").toast('show')
        })
    },

     verifyEmail: function(){
          this.button='Please wait...';
          $(".toaster").toast('hide')
          this.showOverlay=true;
          this.disabled=true
          const form = new FormData();
          for(var key in this.parameters){
            form.append(key, this.parameters[key])
          }
          axios.post('/password_reset_new', form).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
                this.disabled=true
              }else if(response['data'].data.status=='failed'){
              this.disabled=false
            //   this.alertMsg=response['data'].data.msg;
            //   $("#alertDanger").toast('show')
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
              this.alertMsg='Something went wrong in the process, Kindly use the forgotten password link to conitnue.'
              $("#alertDanger").toast('show')
           } else if(error.response != undefined && error.response.status==500){
              this.alertMsg='Internal server error! Please refresh and try again or report this error.';
              $("#alertDanger").toast('show')
           }else{
              this.alertMsg='Access restricted or Network error! Please refresh and try again or report this error.';
              $("#alertDanger").toast('show')
            }
        

        })
    },


    },


    }
</script>