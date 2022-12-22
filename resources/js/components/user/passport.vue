<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<div class="modal fade" id="UserPassportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="UserPassportModalLabel" aria-hiden="true">
<div class="modal-dialog ps-md-5 pe-md-5">
    <div class="modal-content bg-dark text-white">
      <div class="modal-body mt-0 p-3 pt-2">
       <div class="row mt-0 p-0">
        <div class="col-2 p-0 ps-2"><i class="bi bi-person fs-3 p-0 m-0"></i></div>
        <div class="col-8"><p class="text-center pt-2 fs-5">Account Profile</p></div>
        <div class="col-2 pt-1 pe-0"><i class="bi bi-x fs-3 p-0 m-0 float-end" data-bs-dismiss="modal" role="button" title="Close"></i></div>
       </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <h4 class="lead">Profile picture</h4>
          <p class="p-1 m-0 text-muted"><small>This profile picture is an identity to recognize you across account activities. Upload a valid picture for easy recognition.</small></p>
        </div>
      </div>
          <hr class="m-1" />
      <div class="row mt-3">
        <div class="col text-center">
          <div class="m-1">
            <div class="passport-dp rounded-circle m-auto" style="width:220px; height:220px;">
             <img :src="userProfilePassport" class="rounded-circle" style="width:220px; height:220px;" alt=" ">
          </div>
          </div>
        </div>
        <div class="col-12 text-center">
          <div class="m-1 mt-1">
            <div class="input-group">
                <input type="file" id="file" @change="onFileSelected" class="form-control shadow-none d-none" accept=".png, .jpg, .webp, .gif" required>
            </div>
            <span class="text-danger" for="" v-if="errors.upload_file && errors.upload_file != ''"><small> <i class="bi bi-x-circle-fill"></i> <span v-text="errors.upload_file[0]"></span> </small></span>
          </div>
      </div>
      </div>
        <div class="row">
        <div class="col-md-12">
          <div class="alert alert-info border-0 p-1 ps-2 pe-2 text-center" role="alert" v-if="alertMsg!=''">
            <small class="" v-text="alertMsg"></small>
          </div>
        </div>
      </div>
      <hr />
      <div class="row">
        <div class="col-md-12">
       <label for="file" class="btn btn-secondary float-start"><i class="bi bi-image"></i> Change </label> 
        <button type="button" class="btn btn-success float-end" @click="validateFile" :disabled="disabled"> <i class="bi bi-save"></i> <span v-text="button"></span> </button>
      </div>
      </div>
      </div>
       
    </div>
  </div>
</div>
</div>
</template>

<style scoped>
</style>

<script>
export default {
  name: 'user_passport_upload',
  props: ['server_record', 'server_message'],
  data (){
    return{
        pageName: 'Passport',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        notification: '',
        info: this.server_record,
        startNumber: 0,
        endNumber: 10,
        maximumRow: 10,
        rowSelected: '',
        totalRecord: [],
        progress: null,
        button: 'Save',
        btntxt: 'Save',
        record:false,
        responseStatus: '',
        usersession: [],
        category_list: [],
        progress: '0%',
        selectedFile: '',
        disabled: true,
        validated: false,
        errors: [],
        form_success: [],
        userProfilePassport: '/assets/icons/avatar.png',
        parameters:{
            categoryId: 1,
            upload_file: '',
            personal_id: '',
        },
      }
    },
    created(){
      this.parameters.personal_id = this.info.personal_id
      this.userProfilePassport = this.info.file_url ? this.info.file_url : this.userProfilePassport
    },

  methods:{
        onFileSelected: function(event){
          try {
            this.errors = '';
            this.alertMsg = '';
            this.selectedFile = event.target.files[0];
            this.userProfilePassport = URL.createObjectURL(event.target.files[0]);
            this.disabled = this.userProfilePassport==''? true:false
          } catch (error) {
            this.selectedFile = '';
            this.disabled = this.userProfilePassport==''? true:false
            return false
          }
        },

        validateFile: function(){
          if(this.selectedFile==''){
            this.alertMsg='Please select a valid file'
          }else{
            this.sendPost()
          }
        },

      sendPost: function(){
        this.button='Please wait...';
        this.showOverlay=true;
        this.alertMsg = '';
        const form = new FormData();
        for (var key in this.parameters){
        form.append(key, this.parameters[key])
        }
        form.append('upload_file', this.selectedFile, this.selectedFile.name)
        axios.post('/user/passport', form).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            this.disabled = true;
            setTimeout(function(){
                  window.location.reload()
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
                this.alertMsg='Something went wrong! Kindly confirm and correct the error(s) before you continue.';
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