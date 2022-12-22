<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
  <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />     
<div class="container-fluid">
    <server-alert :server_message="server_message" />
    <a href="#" id="topLink"></a>
        <div class="row">
        <div class="col-md-5">
        <div class="mt-1 mb-2">
            <h5 class="mt-2 ms-0"> <span class="bi bi-chevron-left" onclick="history.back()" role="button"></span> <span>Manage</span><span class="text-muted">/User </span> </h5>
        </div>
        </div>
        <div class="col-md-7 d-flex justify-content-end dropdown">
        <div class="mt-1 mb-2">
        
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
    <div class="m-1 border rounded-3">
    <div class="row">
        <div class="col-md-10">
        <div class="m-3 mb-1">
            <h5 class="display-7 ft-weight-light">Account <i class="bi bi-chevron-right"></i> <span class="text-capitalize p-1 m-0 text-secondary" v-html="(info.lastname)? info.lastname+' '+info.firstname+' '+info.othername : ''"> </span></h5>
            <p class="text-muted">NB: Any changes made here will reflect on this account's activities, please be certain of this action before you proceed.</p>
        </div>
        </div>
        <div class="col-md-2 p-2">
        <div class="m-3">
                 <div class="text-center">
                     <figure>
                     <img :src="userProfilePassport" class="rounded-circle" height="120" width="120" alt="Passport">
                    </figure>
                </div>
        </div>
        </div>
    </div>
        </div>
        </div>
    </div>


<div class="row">
<div class="col-md-12">
    <div class="m-1 border rounded-3">
    <div class="row">
    <div class="col-md-12">
        <div class="m-3 mt-1">
  <form @submit.prevent="validateForm" id="formChange">
            <fieldset class="border p-2 pt-0">
                <legend class="w-auto" style="float: none; padding: inherit;"><small>Contact lines</small></legend>
            <div class="row">
            <div class="col-md-12">
            </div>

      <div class="col-md-6">
                <div class="m-1 mt-3">
                <label for="phone_code">Phone Number<sup title="Required field">*</sup></label>
                <div class="row">
                    <div class="col-4 pe-1">
                <div class="input-group">
                    <select class="shadow-none form-control form-control-md form-control-sm-lg" v-model="parameters.phone_code" id="phone_code" required :disabled="disabled">
                    <option disabled value="" selected>Code</option>
                    <option :value="d['mcode']" v-for="(d, index) in phoneCodes" :key="index" v-text="d.name + ' ' +d.mcode"></option>
                    </select>
                    </div>
                    </div>
                <div class="col-8 ps-0">
                <div class="input-group">
                    <input type="text" @change="validatePhone('phone_one')" v-model="parameters.phone_one" @keyup="noSpace('phone_one')" minlength="7" maxlength="15" id="phone_one" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Phone number" :disabled="disabled">
                    </div>
                </div>
                    </div>
                  <span class="text-danger" for="" v-if="errors.phone_one && errors.phone_one != ''"><small> <span v-text="errors.phone_one[0]"></span> </small></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="m-1 mt-3">
                <div class="row">
                <div class="col-12">
                <label for="phone_two">Additional <span class="text-muted">(Optional)</span><sup title=""></sup></label>
                <div class="input-group">
                    <input type="text" @change="validatePhone('phone_two')" v-model="parameters.phone_two" @keyup="noSpace('phone_two')" minlength="7" maxlength="15" id="phone_two" class="shadow-none form-control form-control-md form-control-sm-lg" placeholder="Additional contact" :disabled="disabled">
                    </div>
                </div>
                    </div>
                  <span class="text-danger" for="" v-if="errors.phone_two && errors.phone_two != ''"><small> <span v-text="errors.phone_two[0]"></span> </small></span>
                </div>
            </div>
    <div class="col-md-12">
        <div class="m-1 mt-3">
        <button type="submit" class="btn btn-primary shadow-none float-end ms-1"><i class="bi-save"></i> <span v-text="button"></span> </button>         
        <span v-if="validated" @click="cancelBtn" class="btn btn-danger float-end ms-1"><i class="bi-x fs-6"></i> Cancel  </span>         
        </div>
    </div>
    </div>
    </fieldset>
    </form>

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
import phonecodes from '../json/phoneCode'
export default {
    name: 'user_phone_edit',
    props: ['server_record', 'server_message'],
    data (){
        return{
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: this.server_record,
        button: 'Update',
        btntxt: 'Update',
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
        errors: [],
        form_success: [],
        phoneCodes: phonecodes.codes,
        userProfilePassport: '/assets/icons/avatar.png',
        parameters:{
            phone_one: '',
            phone_two: '',
            phone_code: '+234',
            generated_id: '',
        },
    }
    },

    created(){
        this.getRecords();
        this.userProfilePassport = this.info.file_url ? this.info.file_url : this.userProfilePassport;

    }, 

    methods:{
    getRecords: function(){
        this.parameters.generated_id = this.info.generated_id
        this.parameters.phone_one = this.info.phone_one
        this.parameters.phone_two = this.info.phone_two
        this.parameters.phone_code = this.info.phone_code
    },
    resetForm: function(){
        this.validated = false;
        this.disabled = false;
        for(var key in this.parameters){
            this.parameters[key]=''
        }
    },

     checkIfChanged: function(){
        var hasChanged = 0
        var nochange = 0
        var counter = 0
        for(var key in this.parameters){
            this.parameters[key] = this.parameters[key]==null? '': this.parameters[key]
            this.info[key] = this.info[key]==null? '': this.info[key]
            counter += 1
            if(typeof this.info[key] == 'undefined' || typeof this.parameters[key] == 'undefined'){
                nochange += 1
            }else{
                if (this.parameters[key].toString() != this.info[key].toString()) {
                    hasChanged += 1
                }else{
                    nochange += 1 
                }
            }

        }
        if(hasChanged > 0){
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
    cancelBtn: function(){
            this.validated = false
            this.disabled = false
            this.button = this.btntxt
   },
   validateForm: function(){
        $(".toaster").toast('hide')
        this.errors = '';
        $(".toaster").toast('hide')
        if(!this.checkIfChanged()) {
            this.validated = false
            this.disabled = false;
            this.alertMsg='You have not made any changes on this page. To go back, click on the Back button above.'
            $("#alertDanger").toast('show')
        }else if(this.validated && this.checkIfChanged()) {
            this.sendPost()
            this.validated = false
            this.disabled = false;
        }else if(!this.validated && this.checkIfChanged()){
            this.disabled = true;
            this.validated = true;
            this.button = "Continue";
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
        axios.post('/user/phone/update', form).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
        if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            $("#alertPrimary").toast('show')
            setTimeout(function(){
            window.history.back()
            }, 2000)
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


    }
</script>