


<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
  <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />  
<div class="container-fluid">
    <server-alert :server_message="server_message" />
    <a href="#" id="topLink"></a>
        <div class="row">
        <div class="col-md-5 ps-2">
        <div class="mt-1 mb-2">
            <h5 class="mt-2 ms-0"> <span class="bi bi-chevron-left" onclick="history.back()" role="button"></span> <span>Manage</span><span class="text-muted">/Admin </span> </h5>
        </div>
        </div>
        <div class="col-md-7 d-flex justify-content-end dropdown pe-1">
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
                <legend class="w-auto" style="float: none; padding: inherit;"><small>Contact Address</small></legend>
            <div class="row">
            <div class="col-md-12">
            </div>

        <div class="col-md-6">
                <div class="m-1 mt-3">
                <label for="country_id">Country <sup title=""></sup></label>
                <div class="input-group">
                    <select class="shadow-none form-control form-control-md form-control-sm-lg" v-model="parameters.country_id" @change="getState()" id="country_id" required :disabled="disabled">
                       <option disabled value="" selected>Select</option>
                       <option value="-1">Not Applicable</option>
                    <option :value="d.id" v-for="(d, index) in countries" :key="index" v-text="d.country_name"></option>
                    </select>
                    </div>
                  <span class="text-danger" for="" v-if="errors.country_id && errors.country_id != ''"><small> <span v-text="errors.country_id[0]"></span> </small></span>
                </div>
        </div>
     <div class="col-md-6">
                <div class="m-1 mt-3">
                <label for="state_id">State <sup title=""></sup></label>
                <div class="input-group">
                    <select class="shadow-none form-control form-control-md form-control-sm-lg" v-model="parameters.state_id" id="state_id" required :disabled="disabled">
                       <option disabled value="" selected>Select</option>
                       <option value="-1">Not Applicable</option>
                    <option :value="d.id" v-for="(d, index) in states" :key="index" v-text="d.state_name"></option>
                    </select>
                    </div>
                  <span class="text-danger" for="" v-if="errors.state_id && errors.state_id != ''"><small> <span v-text="errors.state_id[0]"></span> </small></span>
                </div>
        </div>

        <div class="col-md-12">
                <div class="m-1 mt-3">
                <label for="address_one">Home/Office Address <sup title=""></sup></label>
                <div class="input-group">
                    <textarea class="shadow-none form-control form-control-md form-control-sm-lg" placeholder="Home/Office address" v-model="parameters.address_one" id="address_one" :disabled="disabled">
                    </textarea>
                    </div>
                  <span class="text-danger" for="" v-if="errors.address_one && errors.address_one != ''"><small> <span v-text="errors.address_one[0]"></span> </small></span>
                </div>
        </div>
    <div class="col-md-12">
        <div class="m-1 mt-3">
        <button type="submit" class="btn btn-success shadow-none float-end ms-1"><i class="bi-save"></i> <span v-text="button"></span> </button>         
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
export default {
    name: 'admin_contact_edit',
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
        countries: [],
        states: [],
        cities: [],
        userProfilePassport: '/assets/icons/avatar.png',
        parameters:{
            country_id: '161',
            state_id: '306',
            address_one: '',
            generated_id: '',
        },
    }
    },

    created(){
        this.getCountry();
    }, 
    mounted(){
        this.getRecords();
        this.getState();
        this.userProfilePassport = this.info.file_url ? this.info.file_url : this.userProfilePassport;

    },
    methods:{

    getRecords: function(){
        this.parameters.generated_id = this.info.generated_id
        this.parameters.country_id = this.info.country_id == 0 ? this.parameters.country_id : this.info.country_id
        this.parameters.state_id = this.info.state_id == 0 ? this.parameters.state_id : this.info.state_id
        this.parameters.address_one = this.info.address_one
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
            $("#alertDanger").toast('show')
            this.alertMsg='You have not made any changes on this page. To go back, click on the Back button above.'
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
        axios.post('/admin/contactaddress/update', form).then(response => {
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
  
     getCountry: function(){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        axios.get('/country/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
            this.countries = response['data'].data.info
            }else if(response['data'].data.status=='norecord'){
            this.countries = ''
            this.alertMsg=''
            }else{
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
            }
        }).catch(error => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            this.alertMsg='Something went wrong! Please refresh and try again or report this error.'
            $("#alertDanger").toast('show')
        })
    },
     getState: function(){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        axios.get('/state/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
            this.states = response['data'].data.info
            }else if(response['data'].data.status=='norecord'){
            this.states = ''
            this.alertMsg=''
            }else{
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
            }
        }).catch(error => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            this.alertMsg='Something went wrong! Please refresh and try again or report this error.'
            $("#alertDanger").toast('show')
        })
    },

    },


    }
</script>