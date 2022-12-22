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
             <h5 class="mt-2 ms-0 text-success"> <span v-text="pageName" onclick="history.back()" role="button"></span>  <span class="text-muted"> > New account</span> </h5>
        </div>
        </div>
        <div class="col-md-7 d-flex justify-content-end dropdown pe-1">
        <div class="mt-1 mb-2">
        
        <button type="button" class="btn btn-outline-primary" onclick="location.href='upload'"> Batch <i class="bi bi-upload"></i></button>
</div>
</div>
</div>

<div class="row">
<div class="col-12 m-0 p-0">
    <div class="m-1 border rounded-3">
    <div class="row">
    <div class="col-md-12">
        <div class="m-3 mt-1">
            <form @submit.prevent="validateForm" id="formChange">
            <fieldset class="border p-2 pt-0">
                <legend class="w-auto" style="float: none; padding: inherit;"><small>Create</small></legend>
            <div class="row">
            <div class="col-md-12">
            </div>

        <div class="col-md-4">
                <div class="m-1 mt-3">
                <label for="personal_id">Personal ID  <span class="text-muted">(Optional)</span></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi-key"></i></span>
                    <input type="text" v-model="parameters.personal_id" minlength="6" maxlength="200" id="personal_id" class="shadow-none form-control form-control-md form-control-sm-lg" placeholder="Personal ID" :disabled="disabled">
                </div>
                <span class="text-danger" for="" v-if="errors.personal_id && errors.personal_id != ''"><small> <span v-text="errors.personal_id[0]"></span> </small></span>
                </div>
            </div>

    <div class="col-md-4 mt-1">
        <div class="m-1 mt-3">
                   <label for="lastname">Last Name<sup title="Required field">*</sup></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi-person"></i></span>
                    <input type="text" v-model="parameters.lastname" @keyup="noSpace('lastname')" id="lastname" minlength="3" maxlength="200" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Last Name/Surname" :disabled="disabled">
                </div>
                <span class="text-danger" for="" v-if="errors.lastname && errors.lastname != ''"><small> <span v-text="errors.lastname[0]"></span> </small></span>
                </div>
        </div>

        <div class="col-md-4">
                <div class="m-1 mt-3">
                   <label for="firstname">First Name<sup title="Required field">*</sup></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi-person"></i></span>
                    <input type="text" v-model="parameters.firstname" @keyup="noSpace('firstname')" minlength="3" maxlength="200" id="firstname" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Firstname" :disabled="disabled">
                </div>
               <span class="text-danger" for="" v-if="errors.firstname && errors.firstname != ''"><small> <span v-text="errors.firstname[0]"></span> </small></span>
                </div>
        </div>

        <div class="col-md-4">
                <div class="m-1 mt-3">
                <label for="othername">Other name </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi-person"></i></span>
                    <input type="text" v-model="parameters.othername" @keyup="noSpace('othername')" minlength="0" maxlength="200" id="othername" class="shadow-none form-control form-control-md form-control-sm-lg" placeholder="Other Name" :disabled="disabled">
                </div>
                <span class="text-danger" for="" v-if="errors.othername && errors.othername != ''"><small> <span v-text="errors.othername[0]"></span> </small></span>
                </div>
        </div>
        <div class="col-md-4">
                <div class="m-1 mt-3">
                <label for="email">Email<sup title="Required field">*</sup></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi-mailbox"></i></span>
                    <input type="email" v-model="parameters.email_one" minlength="10" maxlength="100" id="email" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Email address" :disabled="disabled">
                </div>
                <span class="text-danger" for="" v-if="errors.email_one && errors.email_one != ''"><small> <span v-text="errors.email_one[0]"></span> </small></span>
                </div>
            </div>

        <div class="col-md-4">
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
        
            <div class="col-md-4">
                <div class="m-1 mt-3">
                <label for="gender_id">Gender<sup title="Required field">*</sup></label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi-person"></i></span>
                    <select class="shadow-none form-control form-control-md form-control-sm-lg" v-model="parameters.gender_id" id="gender_id" required :disabled="disabled">
                       <option disabled value="" selected>Select</option>
                    <option :value="d.id" v-for="(d, index) in genders" :key="index" v-text="d.gender_name"></option>
                    </select>
                    </div>
                  <span class="text-danger" for="" v-if="errors.gender_id && errors.gender_id != ''"><small> <span v-text="errors.gender_id[0]"></span> </small></span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="m-1 mt-3">
                <label for="dob">Date of birth<sup title=""></sup></label>
                <div class="row">
                <div class="col-4">
                <div class="input-group">
                    <select class="shadow-none form-control form-control-md form-control-sm-lg" v-model="parameters.dob" id="dob" :disabled="disabled">
                       <option disabled value="" selected>Day</option>
                    <option :value="d" v-for="(d, index) in dob_list" :key="index" v-text="d"></option>
                    </select>
                </div>
                </div>
                <div class="col-4 ps-1">
                <div class="input-group">
                    <select class="shadow-none form-control form-control-md form-control-sm-lg" v-model="parameters.mob" id="mob" :disabled="disabled">
                    <option disabled value="" selected>Month</option>
                    <option :value="d.dm" v-for="(d, index) in mob_list" :key="index" v-text="d.m"></option>
                    </select>
                    </div>
                    </div>
                <div class="col-4 ps-1">
                <div class="input-group">
                    <input type="number" v-model="parameters.yob" @keyup="noSpace('yob')" min="1900" :max="max_year" minlength="4" maxlength="4" id="yob" class="shadow-none form-control form-control-md form-control-sm-lg" placeholder="Year" :disabled="disabled">
                    </div>
                </div>
                    </div>
                  <span class="text-danger" for="" v-if="errors.yob && errors.yob != ''"><small> <span v-text="errors.yob[0]"></span> </small></span>
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
import phonecodes from '../json/phoneCode'
export default {
    name: 'admin_new',
    props: ['server_record', 'server_message'],
    data (){
        return{
        pageName: 'Admin',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: this.server_record,
        button: 'Create',
        btntxt: 'Create',
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
        this.getGenders();
        }, 
    methods:{

    resetForm: function(){
        this.validated = false;
        this.disabled = false;
        for(var key in this.parameters){
            this.parameters[key]=''
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
        if(this.validated) {
            this.sendPost()
            this.validated = false
            this.disabled = false;
        }else if(!this.validated) {
            this.disabled = true;
            this.validated = true;
            this.button = "Continue";
            this.button = "Continue"
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
        axios.post('/admin/create', form).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            $("#alertPrimary").toast('show')
            setTimeout(function(){
            window.location.href=response['data'].data.redirect
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
 

    },


    }
</script>