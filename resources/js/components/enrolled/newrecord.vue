<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<div class="container-fluid">
<div class="modal fade" id="newRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newRoleModalLabel" aria-hiden="true">
<div class="modal-dialog ps-md-3 pe-md-3">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="newRoleModalLabel" v-html="pageName"></h5>
        <button type="button" class="btn-close" @click="deleted=false" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<div class="container-fluid">
        <div class="row">
        <div class="col-md-5 ps-1">
        <div class="mt-1 mb-2">
             <h5 class="mt-2 ms-0 text-success">Create </h5>
        </div>
        </div>
</div>
<div class="row">
<div class="col-12 m-0 p-0">
    <div class="m-1 border rounded-3">
 <div class="row">
        <div class="col-md-12">
        <div class="alert m-1 alert-info border-0 p-1 ps-2 pe-2 m-3 mb-2 mt-2 text-center" role="alert" v-if="alertMsg!=''">
        <small class="" v-text="alertMsg"></small>
        </div>
        </div>
    </div>

    <div class="row">
    <div class="col-md-12">
        <div class="m-3 mt-1">
            <form @submit.prevent="validateForm" id="formChange">
            <div class="row">
        <div class="col-md-12 mt-1">
            <div class="m-1 mt-3">
            <label for="group" class="text-muted">Group</label>
            <select v-model="parameters.group_id" class="form-control shadow-none" required id="group" :disabled="disabled">
                <option value="" selected>Select</option>
                <option v-for="(d, index) in groupList" :value="d.id" :key="index" v-text="d.group_name"></option>
            </select>
        </div>
        </div>

    <div class="col-md-12 mt-1">
            <div class="m-1 mt-3">
            <label for="link" class="text-muted">Link </label>
            <div class="input-group">
            <span class="input-group-text"><i class="bi bi-link"></i></span>
            <input list="icons" v-model="parameters.access_permission_id" class="form-control shadow-none" id="link" placeholder="Type or Select" required :disabled="disabled">
            <datalist id="icons">
                <option v-for="(d, index) in linkList" :value="d.id" :key="index" v-text="d.routeLink"></option>
            </datalist>
        </div>
    </div>
    </div>
        <div class="col-md-12 mt-1">
            <div class="m-1 mt-3">
            <label for="target" class="text-muted">Open link in</label>
            <select v-model="parameters.link_target" class="form-control shadow-none" required id="target" :disabled="disabled">
                    <option value="" selected>Select</option>
                    <option value="_self">Same tab</option>
                    <option value="_blank">Another tab</option>
                    <option value="_window">Another window</option>
                </select>
    </div>
    </div>
    <div class="col-md-12">
        <div class="m-1 mt-3">
        <button type="submit" class="btn btn-success shadow-none float-end ms-1"><i class="bi-save"></i> <span v-text="button"></span> </button>         
        <span v-if="validated" @click="cancelBtn" class="btn btn-danger float-end ms-1"><i class="bi-x fs-6"></i> Cancel  </span>         
        </div>
    </div>
    </div>
        </form>

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

<!-- New -->

</div>
    </div>


</template>

<script>
import icons from '/storage/json/icons.json'
export default {
    name: 'Enrolled_new',
    props: ['server_record', 'server_message'],
    data (){
        return{
        pageName: 'Enrolled',
        icons: icons.list,
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
        groupList: [],
        linkList: [],
        disabled: false,
        validated: false,
        formNote: '',
        genders: [],
        parameters:{
            group_id: '',
            access_permission_id: '',
            link_target: '_self',
        },
        errors: [this.parameters],
        form_success: [],
    }
    },

    created(){
       this.getGroups();
       this.getLinks();
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

    getGroups: function(){
            $(".toaster").toast('hide')
            this.showOverlay=true;
            axios.get('/adminmenugroup/list', {params:this.parameters}).then(response => {
                this.button=this.btntxt;
                this.showOverlay=false;
                this.errors = '';
                if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
                this.groupList = response['data'].data.info
                }else if(response['data'].data.status=='norecord'){
                this.groupList = ''
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

        getLinks: function(){
            $(".toaster").toast('hide')
            this.showOverlay=true;
            axios.get('/access/list', {params:this.parameters}).then(response => {
                this.button=this.btntxt;
                this.showOverlay=false;
                this.errors = '';
                if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
                this.linkList = response['data'].data.info
                }else if(response['data'].data.status=='norecord'){
                this.linkList = ''
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
        axios.post('/enrolled/create', form).then(response => {
                this.button=this.btntxt;
                this.showOverlay=false;
                this.errors = '';
        if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
                this.deleted = true
                this.alertMsg=response['data'].data.msg;
                setTimeout(function(){
                  window.location.reload();
                }, 2000)
                }else if(response['data'].data.status=='failed'){
                this.alertMsg=response['data'].data.msg;
                }else{
                this.alertMsg=response['data'].data.msg;
                }

            }).catch(error => {
                    this.button=this.btntxt;
                    this.showOverlay=false;
                    this.errors = '';
                if(error.response != undefined && error.response.status==422){
                    this.errors = error.response.data.errors;
                    this.alertMsg='Something went wrong! Kindly confirm and try again.'
                } else if(error.response != undefined && error.response.status==419){
                    this.alertMsg='This page has been inactive for long, Kindly refresh and try again.';
                }else if(error.response != undefined && error.response.status==500){
                    this.alertMsg='Internal server error! Please refresh and try again or report this error.';
                }else{
                    this.alertMsg='Access restricted or Network error! Please refresh and try again or report this error.';
                }
            })
        },

    },


    }
</script>