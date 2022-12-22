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
    <button type="button" class="btn btn-success" data-bs-toggle="dropdown" aria-expanded="false"> Download  <i class="bi bi-download"></i></button>
      <div class="dropdown-menu w-75 mt-0 pt-0" style="width: 200px !important;">
        <ul class="list-unstyled pb-1 border-bottom" onclick="event.stopPropagation()">
        <li class="mb-2">
        <p class="align-items-center ps-2 p-1 mb-0">
        <a class="text-dark" target="_blank" :href="'../profile/pdf/'+info.generated_id"><i class="bi bi-file-pdf me-1"></i> <span>Account profile </span></a>
        </p>
        </li>
    </ul>
  </div>
    <a :href="'../manage/'+info.generated_id" class="btn btn-outline-primary"> Update  <i class="bi bi-gear"></i></a>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12 content">
    <div class="m-1 border rounded-3">
    <div class="row">
        <div class="col-md-10">
        <div class="m-3 mb-1">
            <h5 class="display-7">Profile</h5>
            <p class="text-muted">Manage personal information such as basic information (Name, date of birth and others), contact, security settings and other activities.</p>
        </div>
        </div>
        <div class="col-md-2 p-2 text-center">
        <div class="">
                 <div class="text-center">
                     <figure class="mt-2">
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
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>ACCOUNT ID</small></p></div>
            <div class="col-md-9"><p class="text-uppercase p-1 m-0" v-html="(parameters.personal_id ? parameters.personal_id: '<i class=text-danger>None</i>')"></p></div>
        </div>
        </div>
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>NAME</small></p></div>
            <div class="col-md-9"><p class="text-capitalize p-1 m-0" v-html="info.lastname+' '+info.firstname+' '+info.othername"></p></div>
        </div>
        </div>
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>BIRTHDAY</small></p></div>
            <div class="col-md-9"><p class="text-capitalize p-1 m-0" v-html="info.date_of_birth ? info.date_of_birth : '<i class=text-danger>None</i>'"></p></div>
        </div>
        </div>
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>GENDER</small></p></div>
            <div class="col-md-9"><p class="text-capitalize p-1 m-0" v-html="info.gender_name ? info.gender_name : '<i class=text-danger>None</i>' "></p></div>
        </div>
        </div>
    
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>Email</small></p></div>
            <div class="col-md-9"><p class="text-lowercase p-1 m-0" v-html="(info.email_one ? info.email_one: '<i class=text-danger>None</i>')+ '<br/>' + (info.email_two ? info.email_two:'')"></p></div>
        </div>
        </div>
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>Phone Number</small></p></div>
            <div class="col-md-9">
                <p class="text-capitalize p-1 m-0" v-html="(info.phone_code? info.phone_code:'') + (info.phone_one ? info.phone_one : '<i class=text-danger>None</i>')"></p>
                <p class="text-capitalize p-1 m-0" v-if="info.phone_two" v-html="info.phone_two ? info.phone_two : ''"></p>
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
            <h5 class="display-7">Contact address</h5>
        </div>
        </div>
    <div class="col-md-12">
        <div class="m-3 mt-1">
            <div class="list-group">
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>State/Country</small></p></div>
            <div class="col-md-9"><p class="text-capitalize p-1 m-0" v-html="(info.state_name ? info.state_name : '<i class=text-danger>None</i>') +' / '+ (info.country_name ? info.country_name : '<i class=text-danger>None</i>')"></p></div>
        </div>
        </div>
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>Address</small></p></div>
            <div class="col-md-9"><p class="text-capitalize p-1 m-0" v-html="info.address_one ? info.address_one : '<i class=text-danger>None</i>'"></p></div>
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
    name: 'admin_profile',
    props: ['server_record', 'server_message'],
    data (){
        return{
        pageName: "Admin",
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
            status: '',
        },
    }
    },

    created(){
        this.parameters.personal_id = this.info.personal_id
        this.userProfilePassport = this.info.file_url ? this.info.file_url : this.userProfilePassport
    },

    computed:{

    },
    mounted(){

    },
        
    methods:{

        }


    }
</script>