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
             <h5 class="mt-2 ms-0 text-primary"> <span v-text="pageName" onclick="history.back()" role="button"></span>  <span class="text-muted"> > Edit </span> </h5>
        </div>
        </div>
        <div class="col-md-7 pe-3">
        <div class="mt-1 mb-2">
        <a href="../list" type="button" class="float-end ms-2"> <u> All media </u> </a>
</div>
</div>
</div>

<div class="row">

<div class="col-md-5">
<div class="mt-1 border rounde pb-2">

<div class="row ps-2 pe-2 m-0 mt-2">
            <div class="col-md-12 p-1">
            <label for="media_type" class="text-muted">Media Type</label>
            <div class="input-group">
            <select v-model="parameters.media_type" id="media_type" class="form-control form-control-sm shadow-none">
                <option value="Image">Image</option>
                <option value="Video">Video</option>
            </select>
            </div>
        </div>
</div>
<div class="row ps-2 pe-2 m-0 mt-2">
<div class="col-12 p-1">
    <input type="file" id="file" @change="onFileSelected" class="form-control shadow-none d-none" accept=".png, .jpg, .webp, .gif, .mp4, .mkv">
    <div class="m-1 w-100">
    <label class="text-muted w-100" for="file" role="button">
        <span class=""><em>Click to pick a media file</em></span> 
        <br clear="all">
        <img v-if="parameters.media_type=='Image'" :src="mediaFile" class="border rounded" :style="'width:'+parameters.media_width+parameters.media_measure+';'+'height:'+parameters.media_height+'px;'" alt="">
        <video v-else :src="mediaFile" controls="true" class="border rounded" :style="'width:'+parameters.media_width+parameters.media_measure+';'+'height:'+parameters.media_height+'px;'" alt=""></video>
    </label>
        <br clear="all">
        <span class="float-start" style="text-underline-position: under;" role="button" @click="clearImage"><em><u>Clear media</u></em></span> 
        <br/> <p class="text-danger" v-html="errors.upload_file ? errors.upload_file[0]: ''"></p>
    </div>
</div>
</div>

</div>
</div>



<div class="col-md-7">
<div class="mt-1 border rounded">
<div class="row m-0">
<div class="col-12">
    <div class="m-2">
<form method="post" enctype="multipart/form-data">
        <div class="form-group mt-3">
                <label for="title" class="text-dark" title="required">Title (Optional) <sup></sup></label>
            <textarea id="title" placeholder="Media title" class="form-control mt-1 mb-1" @keyup="oneSpace('media_title')" v-model="parameters.media_title" rows="1"></textarea>
        </div>

        <div class="form-group mt-3">
     <div class="row mt-3">
        <div class="col-md-4">
            <label for="width" class="text-muted">Width</label>
            <div class="input-group">
            <input type="number" id="width" min="10" @keyup="checkNotANumber('media_width')" v-model="parameters.media_width" class="form-control form-control-sm shadow-none" placeholder="Image width">
            </div>
        </div>
        <div class="col-md-4">
            <label for="height" class="text-muted">Height</label>
            <div class="input-group">
            <input type="number" id="height" min="10" @keyup="checkNotANumber('media_height')" v-model="parameters.media_height" class="form-control form-control-sm shadow-none" placeholder="Image height">
            </div>
        </div>
        <div class="col-md-4">
            <label for="media_measure" class="text-muted"></label>
            <div class="input-group">
            <select v-model="parameters.media_measure" id="media_measure" class="form-control form-control-sm shadow-none">
                <option value="px">Pixcel</option>
                <option value="%">Pecentage</option>
            </select>
            </div>
        </div>
    </div>
    </div>        
    </form> 
    </div>
</div>
</div>

<div class="row p-2">
    <div class="col-12 mt-2">
 <button type="submit" @click="validatePost" class="btn btn-primary shadow-none float-end ms-1"><i class="bi-save"></i> <span v-text="button"></span> </button>         
    <span v-if="validated" @click="cancelBtn" class="btn btn-danger float-end ms-1"><i class="bi-x fs-6"></i> Cancel  </span>         
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
    name: 'Media_Edit',
    props: ['server_record', 'server_message'],
    data (){
        return{
        pageName: 'Media',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: this.server_record,
        button: 'Save media',
        btntxt: 'Save media',
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
        mediaFile: '/assets/icons/nomedia.png',
        selectedFile: '',
        parameters:{
            media_title: 'No title',
            media_link: '',
            media_type: 'Image',
            media_height: '160',
            media_width: '160',
            media_measure: 'px',
            generated_id: '',
            status_id: 0,
        },
        
        errors: [this.parameters],
        form_success: [],
    }
    },

    created(){
        this.getCategory();
        this.getRecord();
        },

    methods:{
    getRecord: function(){
        this.parameters.generated_id = this.info.generated_id
        this.parameters.media_title = this.info.media_title
        this.parameters.media_height = this.info.media_height
        this.parameters.media_width = this.info.media_width
        this.parameters.media_measure = this.info.media_measure
        this.parameters.media_type = this.info.media_type
        this.parameters.generated_id = this.info.generated_id
        this.parameters.status_id = this.info.status_id
        this.mediaFile = this.info.media_link ? this.info.media_link : this.mediaFile
        this.parameters.media_link = this.info.media_link ? this.info.media_link : ''

    },

    generateLink: function(){
        let hostname = location.origin;
        let title = this.parameters.media_title
        let category_name = '';
        for (let index = 0; index < this.category_list.length; index++) {
            if (this.parameters.category_id == this.category_list[index].id){
            category_name = this.category_list[index].category_name;
            }
        }
        let url = hostname+'/media/'+category_name+'/'+title;
        this.parameters.post_link = url.toString().toLowerCase();
    },
    resetForm: function(){
        this.validated = false;
        this.disabled = false;
        for(var key in this.parameters){
            this.parameters[key]=''
        }
    },

   cancelBtn: function(){
            this.validated = false
            this.disabled = false
            this.button = this.btntxt
   },

   validatePost: function(){
        this.errors = '';
       if(this.selectedFile=="" && this.parameters.media_link=="") {
            this.validated = false
            this.disabled = false;
            this.alertMsg='Kindly select the media file.';
            $("#alertDanger").toast('show')
            return false;
        }else if(!this.validated) {
            this.disabled = true;
            this.validated = true;
            this.button = "Continue";
            this.button = "Continue"
        }else{
            this.sendPost()
            this.validated = false
            this.disabled = false;
        }

    },
 
    checkNotANumber: function(key){
            var string = this.parameters[key]
            var newString = string==NaN ? '160' : string
            this.parameters[key] = newString
    },
    oneSpace: function(key){
            var string = this.parameters[key]
            var newString = string.replace(/^\s+|\s+$/gm, ' ')
            this.parameters[key] = newString
    },

    onFileSelected: function(event){
        $(".toaster").toast('hide')
          try {
            this.errors = '';
            this.alertMsg = '';
            this.selectedFile = event.target.files[0];
            this.mediaFile = URL.createObjectURL(event.target.files[0]);
            this.disabled = this.mediaFile==''? true:false
          } catch (error) {
            this.selectedFile = '';
            this.disabled = this.mediaFile==''? true:false
            return false
          }
        },

    clearImage: function(){
            this.selectedFile = '';
            this.parameters.media_link = '';
            this.mediaFile = '/assets/icons/nomedia.png';
        },

    sendPost: function(){
        $(".toaster").toast('hide')
        this.button='Please wait...';
        this.showOverlay=true;
        this.alertMsg = '';
        const form = new FormData();
        for (var key in this.parameters){
        form.append(key, this.parameters[key])
        }
        if (this.selectedFile!='') {
        form.append('upload_file', this.selectedFile, this.selectedFile.name)
        }else{
            form.append('upload_file', '')
        }
        axios.post('/media/update', form).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            $("#alertPrimary").toast('show')
            this.disabled = true;
            setTimeout(function(){
                  window.location.reload();
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

    getCategory: function(){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        axios.get('/postcategory/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
            this.category_list = response['data'].data.info
            }else if(response['data'].data.status=='norecord'){
            this.category_list = ''
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