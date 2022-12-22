<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<notification :alertTitle="alertTitle" :alertMsg="alertMsg"></notification> 
<div class="container-fluid">
    <server-alert :server_message="server_message" />
    <a href="#" id="topLink"></a>
    <div class="row">
        <div class="col-md-5 ps-2">
        <div class="mt-1 mb-2">
            <h5 class="mt-2 ms-0 text-muted"><i class="bi bi-chevron-left" onclick="history.back()" title="Go back" role="button"></i> <span v-text="pageName"></span></h5>
        </div>
        </div>
        
<div class="col-md-7 d-flex justify-content-end dropdown pe-3">
        <div class="mt-1 mb-2">
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 content">
    <div class="m-1 border rounded-3">
    <div class="row">
        <div class="col-md-10">
        <div class="m-3 mb-1">
            <h5 class="display-7">Account</h5>
            <p class="text-muted">Manage personal information such as basic information (Name, date of birth and others), contact, security settings and other activities.</p>
        </div>
        </div>
        <div class="col-md-2 p-2 text-center">
        <div class="">
                 <div class="text-center">
                     <figure>
                     <img :src="userProfilePassport" class="rounded-circle" height="120" width="120" alt="Passport">
                    <figcaption class="mt-1 text-success" role="button" data-bs-toggle="modal" data-bs-target="#UserPassportModal"> <u>Change</u> </figcaption>
                    </figure>
                </div>
        </div>
        </div>
    </div>

        </div>
        </div>
    </div>

<div class="row">
<div class="col-md-12 content">
    <div class="m-1 border rounded-3">
    <div class="row">
        <div class="col-md-12">
        <div class="m-3">
        </div>
        </div>
    <div class="col-md-12">
        <div class="m-3 mt-1">
            <div class="list-group">
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>Account Status</small></p></div>
            <div class="col-md-6"><p class="text-capitalize p-1 m-0" v-html="info.status_name"></p></div>
            <div class="col-md-3">
            <button type="button" class="btn btn-success float-end" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="bi bi-chevron-double-down"></i></button>
        <div class="dropdown-menu w-75 mt-0 pt-0" style="width: 200px !important;">
        <ul class="list-unstyled pb-1 border-bottom" onclick="event.stopPropagation()">
        <li class="mb-2">
        <p class="align-items-center ps-2 p-1 mb-0 collapsed dropdown-item" data-bs-toggle="collapse" data-bs-display="static" data-bs-target="#drop1" aria-expanded="false">
        <i class="bi bi-lock me-1"></i> <span>Manage</span> <i class="bi bi-chevron-down float-end"></i></p>
        <div class="collapse" id="drop1">
        <ul class="btn-toggle-nav ms-2 list-unstyled fw-normal pb-1 small">
        <li class="p-1"> <i class="bi bi-chevron-down"></i> <span>Update status</span> </li>
        <li class="p-1">
            <select v-model="parameters.status" class="form-control shadow-none" @change="manageStatus()">
                <option value="" selected>Select</option>
                <option v-for="(d, index) in statuses" :value="d.id" :key="index" v-text="d.status_name "></option>
            </select>
        </li>
        </ul>
        </div>
        </li>
    </ul>
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

<div class="row">
<div class="col-md-12 content">
    <div class="m-1 border rounded-3">
    <div class="row">
        <div class="col-md-12">
        <div class="m-3">
        </div>
        </div>
    <div class="col-md-12">
        <div class="m-3 mt-1">
            <div class="list-group">
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>Role</small></p></div>
            <div class="col-md-6"><p class="text-capitalize p-1 m-0" v-html="info.role_name? info.role_name : 'Not assigned'"></p></div>
            <div class="col-md-3">
            <button type="button" class="btn btn-success float-end" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="bi bi-chevron-double-down"></i></button>
        <div class="dropdown-menu w-75 mt-0 pt-0" style="width: 200px !important;">
        <ul class="list-unstyled pb-1 border-bottom" onclick="event.stopPropagation()">
        <li class="mb-2">
        <p class="align-items-center ps-2 p-1 mb-0 collapsed dropdown-item" data-bs-toggle="collapse" data-bs-display="static" data-bs-target="#drop1" aria-expanded="false">
        <i class="bi bi-lock me-1"></i> <span>Manage</span> <i class="bi bi-chevron-down float-end"></i></p>
        <div class="collapse" id="drop1">
        <ul class="btn-toggle-nav ms-2 list-unstyled fw-normal pb-1 small">
        <li class="p-1"> <i class="bi bi-chevron-down"></i> <span>Update status</span> </li>
        <li class="p-1">
            <select v-model="parameters.role" class="form-control shadow-none" @change="updateRole()">
                <option value="" selected>Select</option>
                <option v-for="(d, index) in listRole" :value="d.id" :key="index" v-text="d.role_name "></option>
            </select>
        </li>
        </ul>
        </div>
        </li>
    </ul>
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


<div class="row">
<div class="col-md-12 content">
    <div class="m-1 border rounded-3">
    <div class="row">
        <div class="col-md-12">
        <div class="m-3">
            <h5 class="display-7">Basic info</h5>
        </div>
        </div>
    <div class="col-md-12">
        <div class="m-3 mt-1">
            <div class="list-group">
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>NAME</small></p></div>
            <div class="col-md-6"><p class="text-capitalize p-1 m-0" v-html="info.lastname+' '+info.firstname+' '+info.othername"></p></div>
            <div class="col-md-3"><p class="text-capitalize p-1 m-0"><a class="btn-link" :href="'../edit/name/'+info.generated_id"><span class="text-success float-end"> <u>Modify</u> </span></a></p></div>
        </div>
        </div>
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>BIRTHDAY</small></p></div>
            <div class="col-md-6"><p class="text-capitalize p-1 m-0" v-html="info.date_of_birth ? info.date_of_birth : '<i class=text-danger>None</i>'"></p></div>
            <div class="col-md-3"><p class="text-capitalize p-1 m-0"><a class="btn-link" :href="'../edit/dob/'+info.generated_id"><span class="text-success float-end"> <u>Modify</u> </span></a></p></div>
        </div>
        </div>
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>GENDER</small></p></div>
            <div class="col-md-6"><p class="text-capitalize p-1 m-0" v-html="info.gender_name ? info.gender_name : '<i class=text-danger>None</i>' "></p></div>
            <div class="col-md-3"><p class="text-capitalize p-1 m-0"><a class="btn-link" :href="'../edit/gender/'+info.generated_id"><span class="text-success float-end"> <u>Modify</u> </span></a></p></div>
        </div>
        </div>
        </div>  
        </div>
        </div>
    </div>

        </div>
        </div>
</div>


<div class="row">
<div class="col-md-12 content">
    <div class="m-1 border rounded-3">
    <div class="row">
        <div class="col-md-12">
        <div class="m-3">
            <h5 class="display-7">Contact address</h5>
        </div>
        </div>
    <div class="col-md-12">
        <div class="m-3 mt-1">
            <div class="list-group">
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>State/Country</small></p></div>
            <div class="col-md-6"><p class="text-capitalize p-1 m-0" v-html="(info.state_name ? info.state_name : '<i class=text-danger>None</i>') +' / '+ (info.country_name ? info.country_name : '<i class=text-danger>None</i>')"></p></div>
            <div class="col-md-3"></div>
        </div>
        </div>
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>Address</small></p></div>
            <div class="col-md-6"><p class="text-capitalize p-1 m-0" v-html="info.address_one ? info.address_one : '<i class=text-danger>None</i>'"></p></div>
            <div class="col-md-3"></div>
        </div>
        </div>
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6"></div>
            <div class="col-md-3"><p class="text-capitalize p-1 m-0"><a a class="btn-link" :href="'../edit/contactaddress/'+info.generated_id"><span class="text-success float-end"> <u>Update</u> </span></a></p></div>
        </div>
        </div>
        </div>  
        </div>
        </div>
    </div>

        </div>
        </div>
    </div>

<div class="row">
<div class="col-md-12 content">
    <div class="m-1 border rounded-3">
    <div class="row">
        <div class="col-md-12">
        <div class="m-3">
            <h5 class="display-7">Account security</h5>
        </div>
        </div>
    <div class="col-md-12">
        <div class="m-3 mt-1">
            <div class="list-group">
        <div class="list-group-item">
           <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>ACCOUNT ID</small></p></div>
            <div class="col-md-6"><p class="text-lowercase p-1 m-0" v-html="(parameters.personal_id ? parameters.personal_id: '<i class=text-danger>None</i>')"></p></div>
            <div class="col-md-3"></div>
        </div>
        </div>
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>Email</small></p></div>
            <div class="col-md-6"><p class="text-lowercase p-1 m-0" v-html="(info.email_one ? info.email_one: '<i class=text-danger>None</i>')+ '<br/>' + (info.email_two ? info.email_two:'')"></p></div>
            <div class="col-md-3"><p class="text-capitalize p-1 m-0"></p></div>
        </div>
        </div>
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>Phone Number</small></p></div>
            <div class="col-md-6">
                <p class="text-capitalize p-1 m-0" v-html="(info.phone_code? info.phone_code:'') + (info.phone_one ? info.phone_one : '<i class=text-danger>None</i>')"></p>
                <p class="text-capitalize p-1 m-0" v-if="info.phone_two" v-html="info.phone_two ? info.phone_two : ''"></p>
            </div>
            <div class="col-md-3"><p class="text-capitalize p-1 m-0"><a class="btn-link" :href="'../edit/phone/'+info.generated_id"><span class="text-success float-end"> <u>Update</u> </span></a></p></div>
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
export default {
    name: 'admin_manage',
    props: ['server_record', 'server_message'],
    data (){
        return{
        pageName: 'Admin',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        selectedRecord: [],
        info: this.server_record,
        inDisplay: 1,
        startNumber: 0,
        endNumber: 20,
        maximumRow: 20,
        rowSelected: '',
        totalRecord: [],
        progress: null,
        button: 'Proceed',
        btntxt: 'Proceed',
        record:false,
        responseStatus: '',
        errors: [],
        usersession: [],
        category_list: [],
        filterlist: '',
        search: '',
        checked: true,
        list_id: [],
        get_list_array: '0',
        listStatus: '',
        listRole: '',
        selectToggleValue: '',
        isChecked: false,
        selectDefault: "Select",
        counter: '0',
        disabled: false,
        validated: false,
        search: '',
        checks: [],
        statuses: [],
        userProfilePassport: '/assets/icons/avatar.png',
        parameters:{
            personal_id: '',
            id: '',
            role: '',
            status: '',
        },
    }
    },

    created(){
        this.getStatus();
        this.getRole();
        this.parameters.personal_id = this.info.personal_id
        this.parameters.role = this.info.role_id
        this.userProfilePassport = this.info.file_url ? this.info.file_url : this.userProfilePassport
    },

    computed:{

    },
    mounted(){

    },
        
    methods:{
    
      getStatus: function(){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        axios.get('/status/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
            this.statuses = response['data'].data.info
            }else if(response['data'].data.status=='norecord'){
            this.statuses = ''
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

     getRole: function(){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        axios.get('/role/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
            this.listRole = response['data'].data.info
            }else if(response['data'].data.status=='norecord'){
            this.listRole = ''
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

    manageStatus: function(){
        if(this.parameters.role == '') {
            $("#alertDanger").toast('show')
            this.alertMsg="No item(s) selected!";
            return false;
        }
        this.alertMsg=''
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.parameters.id = this.info.generated_id
        axios.get('/admin/manage/status', {params:this.parameters}).then(response => {
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

    updateRole: function(){
        if(this.parameters.role == '') {
            $("#alertDanger").toast('show')
            this.alertMsg="No item(s) selected!";
            return false;
        }
        this.alertMsg=''
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.parameters.id = this.info.generated_id
        axios.get('/admin/role/update', {params:this.parameters}).then(response => {
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

        }


    }
</script>