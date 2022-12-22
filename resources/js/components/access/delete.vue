<template>
<div class="">
<div class="container-fluid">
    <div class="m-1 border rounded-3">
    <div class="row">
        <div class="col-md-12">
        <div class="m-3 mb-1">
            <h5 class="display-7 text-danger">Trash</h5>
            <p class="text-warning">Warning! Please be certain of this action before you proceed.</p>
        </div>
        </div>
        </div>
    <div class="row">
    <div class="col-md-12">
        <div class="m-3 mt-1">
            <div class="list-group">
        <div class="list-group-item">
        <div class="row">
            <div class="col-md-9"><p class="p-1 m-0 text-danger"><small>This action is irreversible, there is no going back once you delete.</small></p></div>
            <div class="col-md-3"><button class="btn btn-outline-danger float-end" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete record</button></div>
        </div>
        </div>
        </div>  
        </div>
        </div>
        </div>
    </div>

<div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hiden="true">
<div class="modal-dialog ps-md-3 pe-md-3">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="deleteModalLabel">Delete!</h5>
        <button type="button" class="btn-close" @click="deleted=false" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-1 m-0 text-danger"><small>This action is irreversible, are you sure you want to delete this?</small></p>
      <div class="alert alert-primary border-0" role="alert">
  <h6 class="" v-text="'Name: '+ (info? info.routeLink : '') "></h6>
  <h6 class="" v-text="'Description: '+ (info? info.descriptions : '') "></h6>
</div>
  <div class="alert alert-info border-0 p-1 ps-2 pe-2 text-center" role="alert" v-if="alertMsg!=''">
        <small class="" v-text="alertMsg"></small>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" @click="deleted=false" data-bs-dismiss="modal"> Go back </button>
        <button type="button" class="btn btn-danger" @click="trashItem()" v-text="button" v-if="deleted==false"></button>
      </div>
    </div>
  </div>
</div>
</div>
</div>
</template>

<script>
export default {
  name: 'Access_Delete',
  props: ['server_record', 'server_message'],
  data (){
    return{
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: this.server_record,
        progress: null, 
        btntxt: 'Yes, delete',
        button: 'Yes, delete',
        errors: [],
        usersession: [],
        deleted: false,
        warning: 'This action is irreversible, do you really want to delete this record?',
        parameters:{
            routeLink: '',
            id: '',
        },
      }
    },

  methods:{
    trashItem: function(){
            this.showOverlay=false;
            this.alertMsg = '';
            this.parameters.routeLink = this.info.routeLink
            this.parameters.id = this.info.generated_id
            this.button = "Please wait..."
            axios.delete('/access/trash', {params:this.parameters}).then(response => {
                this.button=this.btntxt;
                this.showOverlay=false;
                this.errors = '';
                 if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
                this.$session.set('deleted', true)
                this.deleted = true
                this.alertMsg=response['data'].data.msg;
                setTimeout(function(){
                  window.location.href=response['data'].data.redirect
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