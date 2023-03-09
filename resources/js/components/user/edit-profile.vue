<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
  <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />     
<div class="container-fluid p-0">
    <server-alert :server_message="server_message" />
    <a href="#" id="topLink"></a>

<div class="row">
<div class="col-md-12">
    <div class="m-1 border rounded-3">
    <div class="row">
    <div class="col-md-12">
        <div class="m-3 mt-1">

  <form @submit.prevent="validateForm" id="formChange">
            <fieldset class="border p-2 pt-0">
                <legend class="w-auto" style="float: none; padding: inherit;"><small>Profile</small></legend>
            <div class="row">
            <div class="col-md-12">
            </div>

    <div class="col-md-6">
        <div class="m-1 mt-3">
                   <label for="lastname">Last Name<sup title="Required field">*</sup></label>
                <div class="input-group">
                    <input type="text" v-model="parameters.lastname" @keyup="noSpace('lastname')" id="lastname" minlength="3" maxlength="200" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Last name" :disabled="disabled">
                </div>
                <span class="text-danger" for="" v-if="errors.lastname && errors.lastname != ''"><small> <span v-text="errors.lastname[0]"></span> </small></span>
                </div>
        </div>

        <div class="col-md-6">
                <div class="m-1 mt-3">
                   <label for="firstname">First Name<sup title="Required field">*</sup></label>
                <div class="input-group">
                    
                    <input type="text" v-model="parameters.firstname" @keyup="noSpace('firstname')" minlength="3" maxlength="200" id="firstname" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="First name" :disabled="disabled">
                </div>
               <span class="text-danger" for="" v-if="errors.firstname && errors.firstname != ''"><small> <span v-text="errors.firstname[0]"></span> </small></span>
                </div>
        </div>

        <div class="col-md-6">
                <div class="m-1 mt-3">
                <label for="othername">Other name  <span class="text-muted">(Optional)</span></label>
                <div class="input-group">
                    
                    <input type="text" v-model="parameters.othername" @keyup="noSpace('othername')" minlength="0" maxlength="200" id="othername" class="shadow-none form-control form-control-md form-control-sm-lg" placeholder="Other name" :disabled="disabled">
                </div>
                <span class="text-danger" for="" v-if="errors.othername && errors.othername != ''"><small> <span v-text="errors.othername[0]"></span> </small></span>
                </div>
        </div>

   <div class="col-md-6">
                <div class="m-1 mt-3">
                <label for="othername">Gender<span class="text-muted"></span></label>
                <div class="input-group">
                    <select class="shadow-none form-control form-control-md form-control-sm-lg" v-model="parameters.gender_id" id="gender_id" required :disabled="disabled">
                       <option disabled value="" selected>Select</option>
                    <option :value="d.id" v-for="(d, index) in genders" :key="index" v-text="d.gender_name"></option>
                    </select>
                    </div>
                  <span class="text-danger" for="" v-if="errors.gender_id && errors.gender_id != ''"><small> <span v-text="errors.gender_id[0]"></span> </small></span>
                </div>
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
            <input type="text" @change="validatePhone('phone_one')" v-model="parameters.phone_one" @keyup="noSpace('phone_one')" minlength="7" maxlength="15" id="phone_one" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Phone number" readonly :disabled="disabled">
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
        <label for="">Date of birth</label>
        <div class="row">
        <div class="col-md-4">
        <div class="input-group mt-2">
        <label for="dob" class="input-group-text">Day<sup title=""></sup></label>
            <select class="shadow-none form-control form-control-md form-control-sm-lg" v-model="parameters.dob" id="dob" :disabled="disabled" required>
                <option disabled value="" selected>Day</option>
            <option :value="d" v-for="(d, index) in dob_list" :key="index" v-text="d"></option>
            </select>
        </div>
        </div>
        <div class="col-md-4">
        <div class="input-group mt-2">
        <label for="dob" class="input-group-text">Month<sup title=""></sup></label>
            <select class="shadow-none form-control form-control-md form-control-sm-lg" v-model="parameters.mob" id="mob" :disabled="disabled" required>
            <option disabled value="" selected>Month</option>
            <option :value="d.dm" v-for="(d, index) in mob_list" :key="index" v-text="d.m"></option>
            </select>
            </div>
            </div>
        <div class="col-md-4">
        <div class="input-group mt-2">
        <label for="dob" class="input-group-text">Year<sup title=""></sup></label>
            <input type="number" v-model="parameters.yob" @keyup="noSpace('yob')" min="1900" :max="max_year" minlength="4" maxlength="4" id="yob" class="shadow-none form-control form-control-md form-control-sm-lg" placeholder="Year" :disabled="disabled" required>
            </div>
        </div>
            </div>
            <span class="text-danger" for="" v-if="errors.yob && errors.yob != ''"><small> <span v-text="errors.yob[0]"></span> </small></span>
        </div>
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
                    <textarea class="shadow-none form-control form-control-md form-control-sm-lg" placeholder="Home/Office address" v-model="parameters.address_one" id="address_one" :disabled="disabled" autocomplete="off">
                    </textarea>
                    </div>
                  <span class="text-danger" for="" v-if="errors.address_one && errors.address_one != ''"><small> <span v-text="errors.address_one[0]"></span> </small></span>
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
import phonecodes from '/storage/json/phoneCode'
export default {
    name: 'user_name_edit',
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
        genders: [],
        countries: [],
        states: [],
        cities: [],
        max_year: new Date().getFullYear() - 16,
        userProfilePassport: '/assets/icons/avatar.png',
        phoneCodes: phonecodes.codes,
        parameters:{
            lastname: '',
            firstname: '',
            othername: '',
            gender_id: '',
            phone_one: '',
            phone_two: '',
            phone_code: '+234',
            yob: '',
            mob: '',
            dob: '',
            country_id: '161',
            state_id: '306',
            address_one: '',
            generated_id: '',
        },
        mob_list: [
                {"dm":'01', 'm':'January'}, {"dm":'02', 'm':'February'},
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
        this.getRecords();
        this.getGenders();
        this.getCountry();
    },

    mounted() {
            // this.getState();
    },
    methods:{
    getGenders: function(){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        axios.get('/genders/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
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
            this.errors = '';
            this.alertMsg='Something went wrong! Please refresh and try again or report this error.'
            $("#alertDanger").toast('show')
        })
    },
    getRecords: function(){
        this.userProfilePassport = this.info.file_url ? this.info.file_url : this.userProfilePassport;
        this.parameters.generated_id = this.info.generated_id
        this.parameters.lastname = this.info.lastname
        this.parameters.firstname = this.info.firstname
        this.parameters.othername = this.info.othername
        this.parameters.generated_id = this.info.generated_id
        this.parameters.gender_id = this.info.gender_id==0? '' : this.info.gender_id
        this.parameters.generated_id = this.info.generated_id
        this.parameters.phone_one = this.info.phone_one
        this.parameters.phone_two = this.info.phone_two
        this.parameters.phone_code = this.info.phone_code
        this.parameters.dob = this.info.dob==0? '' : this.info.dob
        this.parameters.mob = this.info.mob==0? '' : this.info.mob
        this.parameters.yob = this.info.yob==0? '' : this.info.yob
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
     getCountry: function(){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        axios.get('/country/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
            this.countries = response['data'].data.info
            this.getState();
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
    sendPost: function(){
        this.button='Please wait...';
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.alertMsg = '';
        const form = new FormData();
        for (var key in this.parameters){
        form.append(key, this.parameters[key])
        }
        axios.post('/user/profile/update', form).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
        if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            $("#alertPrimary").toast('show')
            setTimeout(function(){
            window.location.reload()
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