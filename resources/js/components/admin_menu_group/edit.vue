<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<div class="container-fluid">
<div class="modal fade" id="editRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hiden="true">
<div class="modal-dialog ps-md-3 pe-md-3">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="editRoleModalLabel" v-html="pageName"></h5>
        <button type="button" class="btn-close" @click="deleted=false" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<div class="container-fluid">
        <div class="row">
        <div class="col-md-5 ps-1">
        <div class="mt-1 mb-2">
             <h5 class="mt-2 ms-0 text-success">Update </h5>
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
            <label for="group_name" class="text-muted">Title</label>
            <div class="input-group">
                <input type="text" v-model="parameters.group_name" @keyup="oneSpace('group_name')" id="group_name" minlength="3" maxlength="100" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Enter here" :disabled="disabled">
            </div>
            <span class="text-danger" for="" v-if="errors.group_name && errors.group_name != ''"><small> <span v-text="errors.group_name[0]"></span> </small></span>
            </div>
        </div>
        <div class="col-md-12 mt-1">
            <div class="m-1 mt-3">
            <label for="group_name" class="text-muted">Bar</label>
            <select v-model="parameters.menu_bar" class="form-control shadow-none" required :disabled="disabled">
            <option value="" selected>Select</option>
            <option value="Admin Sidebar">Admin Sidebar</option>
            <option value="Admin TopMenu">Top Menu</option>
            <option value="Web Menu">Web Menu</option>
        </select>
    </div>
    </div>
    <div class="col-md-12 mt-1">
            <div class="m-1 mt-3">
            <label for="group_name" class="text-muted">Icons</label>
         <div class="input-group">
            <span class="input-group-text"><i :class="parameters.group_icon"></i></span>
            <input list="icons" v-model="parameters.group_icon" class="form-control shadow-none" placeholder="Type or Select" required :disabled="disabled">
            <datalist id="icons">
                <option v-for="(d, index) in icons" :value="d.value" :key="index" v-text="d.iconName"></option>
            </datalist>
        </div>
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
import icons from '../json/icons.json'
export default {
    name: 'AdminMenuGroup_Edit',
    props: ['server_record', 'server_message'],
    data (){
        return{
        pageName: 'Admin Menu Group',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: this.server_record,
        icons: icons.list,
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
        genders: [],
        parameters:{
            group_name: '',
            menu_bar: '',
            group_icon: '',
            generated_id: '',
        },
        errors: [this.parameters],
        form_success: [],
    }
    },

    created(){
         this.getRecords();
        }, 
    methods:{
        getRecords: function(){
            this.parameters.group_name = this.info.group_name;
            this.parameters.menu_bar = this.info.menu_bar;
            this.parameters.group_icon = this.info.group_icon;
            this.parameters.generated_id = this.info.generated_id
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
        this.errors = '';
        if(!this.checkIfChanged()) {
            this.validated = false
            this.disabled = false;
            this.alertMsg='You have not made any changes on this page.'
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
            this.alertMsg='Kindly complete the required field(s)'
        }

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
        axios.post('/adminmenugroup/update', form).then(response => {
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