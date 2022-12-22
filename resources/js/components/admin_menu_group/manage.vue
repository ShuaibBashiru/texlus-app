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
        <div class="col-md-12">
        <div class="m-3">
            <h5 class="display-7">Info</h5>
        </div>
        </div>
    <div class="col-md-12">
        <div class="m-3 mt-1">
            <div class="list-group">
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-3"><p class="text-uppercase p-1 m-0 text-muted"><small>Name</small></p></div>
            <div class="col-md-6"><p class="text-capitalize p-1 m-0" v-html="info.group_name"></p></div>
            <div class="col-md-3"><p class="text-capitalize p-1 m-0"><a class="btn-link" href="#" data-bs-toggle="modal" data-bs-target="#editRoleModal"><span class="text-primary float-end"> <u>Edit</u> </span></a></p></div>
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
    name: 'AdminMenuGroup_Manage',
    props: ['server_record', 'server_message'],
    data (){
        return{
        pageName: 'Admin Menu Group',
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
        this.getStatus();
        this.parameters.personal_id = this.info.personal_id
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

    confirmStatusUpdate: function(){
        this.alertMsg=''
        if (this.parameters.status == '') {
            return false;
        }else if(this.parameters.status != '') {
            this.manageStatus()
            this.parameters.status = ''
        }else{
            this.parameters.status = ''
            $("#alertDanger").toast('show')
            this.alertMsg="No item(s) selected!"
        }
    },

    manageStatus: function(){
        this.alertMsg=''
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.parameters.id = this.info.generated_id
        axios.get('/adminmenugroup/manage/status', {params:this.parameters}).then(response => {
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