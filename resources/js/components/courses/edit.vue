<template>
<div class="">
<b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<notification :alertTitle="alertTitle" :alertMsg="alertMsg" />
<div class="container-fluid">
<server-alert :server_message="server_message" />
<a href="#" id="topLink"></a>

<div class="modal fade" id="editorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editorModalLabel" aria-hiden="true">
<div class="modal-dialog modal-dialog-scrollable modal-lg  ps-md-3 pe-md-3">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="" v-html="'Source code'"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md">
            <textarea v-if="!preview" v-model="sourcecode" contenteditable="true" id="codeEditor" class="w-100 textAreadEditor" rows="50" height="600" spellcheck="false">
            </textarea> 
            <div v-else v-html="sourcecode">
            </div>
      </div>
      </div>
      </div>

      </div>
      <div class="modal-footer">
                <button class="btn btn-sm btn-primary float-start me-2" @click="showCode">Source code</button>
                <button class="btn btn-sm btn-outline-primary me-2" @click="previewChanges">Preview changes</button>
                <button class="btn btn-sm btn-primary me-4" @click="saveSouceCode">Save changes</button>
      </div>
      </div>
      </div>
      </div>


    <div class="row">
        <div class="col-md-5 ps-2">
        <div class="mt-1 mb-2">
             <h5 class="mt-2 ms-0 text-primary"> <span v-text="pageName" onclick="history.back()" role="button"></span>  <span class="text-muted"> > Edit</span> </h5>
        </div>
        </div>
        <div class="col-md-7 pe-3">
        <div class="mt-1 mb-2">
        <a href="../list" type="button" class="float-end ms-2"> <u> View records </u> </a>
</div>
</div>
</div>

<div class="row">
    <!-- Here -->
<div class="col-md-12">
<form method="post" enctype="multipart/form-data" @submit.prevent="validatePost"> 
<div class="row">

<div class="col-md-7">
<div class="mt-1 border rounded">
<div class="row m-0">
<div class="col-12">
    <div class="m-2">
        <div class="form-group mt-2">
                <label for="title" class="text-dark" title="required">Category <sup>*</sup></label>
             <select v-model="parameters.category_id" class="form-control shadow-none" required>
                <option value="" selected>Select</option>
                <option v-for="(d, index) in category_list" :value="d.id" :key="index" v-text="d.category_name "></option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="title" class="text-dark" title="required">Title <sup>*</sup></label>
            <textarea id="title" placeholder="Enter your content title" class="form-control mt-1 mb-1" @keyup="oneSpace('item_title')" v-model="parameters.item_title" rows="1" required></textarea>
            <span class="text-danger" for="" v-if="errors.item_title && errors.item_title != ''"><small> <span v-text="errors.item_title[0]"></span> </small></span>
        </div>
               
        <div class="form-group col mt-3">
            <label for="summary" class="text-dark" title="required">Summary <sup></sup></label>
            <textarea id="summary" placeholder="Enter your content summary" class="form-control mt-1 mb-1" @keyup="oneSpace('item_summary')" v-model="parameters.item_summary" rows="3"></textarea>
            <span class="text-danger" for="" v-if="errors.item_summary && errors.item_summary != ''"><small> <span v-text="errors.item_summary[0]"></span> </small></span>
        </div>
        <div class="form-group col mt-3">
     <div class="row mt-3">
        <div class="col-md-6 mt-3">
            <label for="original_price" class="text-muted w-100">Price </label>
            <div class="input-group">
            <input type="number" id="original_price" min="10" @change="checkNotANumber('original_price')" v-model="parameters.original_price" class="form-control form-control-sm shadow-none" placeholder="Price" required @keyup="calculateDiscount">
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <label for="discount" class="text-muted">Discount (%)</label>
            <div class="input-group">
            <input type="number" id="discount" min="10" @change="checkNotANumber('discount')" v-model="parameters.discount" class="form-control form-control-sm shadow-none" placeholder="Discount" @keyup="calculateDiscount" required>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <label for="display_price" class="text-muted w-100">Display Price </label>
            <div class="input-group">
            <input type="number" id="display_price" min="10" @keyup="checkNotANumber('display_price')" v-model="parameters.display_price" class="form-control form-control-sm shadow-none" placeholder="Price" required readonly>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <label for="durations" class="text-muted">Duration</label>
            <div class="input-group">
            <input type="text" id="durations" min="10" @keyup="oneSpace('durations')" v-model="parameters.durations" class="form-control form-control-sm shadow-none" placeholder="Duration" required>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <label for="class_mode" class="text-muted">Training Mode</label>
            <div class="input-group">
            <select v-model="parameters.class_mode" id="class_mode" class="form-control form-control-sm shadow-none" required>
                <option value="Online">Online</option>
                <option value="Physical">Physical</option>
                <option value="Online | Physical">Online | Physical</option>
            </select>
            </div>
        </div>
        
        <div class="col-md-6 mt-3">
            <label for="startDate" class="text-muted">Start date</label>
            <div class="input-group">
            <input type="date" id="startDate" min="10" v-model="parameters.startDate" class="form-control form-control-sm shadow-none" placeholder="Start date" required>
            </div>
        </div>
       <div class="col-md-6 mt-3">
            <label for="endDate" class="text-muted">End date</label>
            <div class="input-group">
            <input type="date" id="endDate" min="10" v-model="parameters.endDate" class="form-control form-control-sm shadow-none" placeholder="Start date" required>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <label for="beginner_level" class="text-muted">Level</label>
            <div class="input-group">
            <input type="text" id="beginner_level" min="10" @keyup="oneSpace('beginner_level')" v-model="parameters.beginner_level" class="form-control form-control-sm shadow-none" placeholder="Duration" required>
            </div>
        </div>

        <div class="col-md-6 mt-3">
            <label for="language_title" class="text-muted">Language</label>
            <div class="input-group">
            <input type="text" id="language_title" min="10" @keyup="oneSpace('language_title')" v-model="parameters.language_title" class="form-control form-control-sm shadow-none" placeholder="Duration" required>
            </div>
        </div>

    </div>
        </div>

        <div class="form-group mt-3">
        <div class="row">
        <div class="col-md-6">
            <label for="display-img" class="float-start text-dark">
            <input class="form-check-input" id="display-img" type="checkbox" v-model="parameters.display_media_status" true-value="1" false-value="0"> 
                Enable display media </label>
    </div>        
    </div>   
     <div class="row mt-3" v-if="parameters.display_media_status==1">
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
    <div class="row mt-3">
        <div class="col-md-6">
       <p class="text-dark m-0"> Landing page content </p>
        </div>
        <div class="col-md-6">
            <label for="more" class="float-end text-primary">
            <input class="form-check-input" id="more" type="checkbox" v-model="parameters.read_more_status" true-value="1" false-value="0"> 
        Enable
        </label>
        </div>
    </div>
<hr>
     <div class="row mt-3" v-if="parameters.read_more_status==1">
        <div class="col-md-6">
            <label for="read_more_type" class="text-muted">Link Type</label>
            <div class="input-group">
            <select v-model="parameters.read_more_type" id="read_more_type" class="form-control form-control-sm shadow-none">
                <option value="Button">Button</option>
                <option value="TextLink">Text link</option>
            </select>
            </div>
            <span class="text-danger" for="" v-if="errors.read_more_type && errors.read_more_type != ''"><small> <span v-text="errors.read_more_type[0]"></span> </small></span>
        </div>
        <div class="col-md-6">
            <label for="read_more_title" class="text-muted">Title</label>
            <div class="input-group">
            <input type="text" id="read_more_title" min="10" @keyup="oneSpace('read_more_title')" v-model="parameters.read_more_title" class="form-control form-control-sm shadow-none" placeholder="Read more text">
            </div>
            <span class="text-danger" for="" v-if="errors.read_more_title && errors.read_more_title != ''"><small> <span v-text="errors.read_more_title[0]"></span> </small></span>
        </div>
    </div>

    </div>        
        <div class="form-group col mt-3" v-if="parameters.read_more_status==1">
        <button type="button" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#editorModal" @click="getSourceCode">Source code</button>
        <VueEditor id="editor" v-model="parameters.contents" class="w-100 editor"/>
        <span class="text-danger" for="" v-if="errors.contents && errors.contents != ''"><small> <span v-text="errors.contents[0]"></span> </small></span>
        </div>
    </div>
</div>
</div>

</div>
</div>


<div class="col-md-5">
<div class="mt-1 border rounde pb-2">
    <div class="row ps-2 pe-2">
<div class="col-12">
    <div class="m-1 border-bottom">
        <p class="text-muted m-0 mb-1 p-0">Preview</p>
    </div>
</div>
</div>

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

<div class="row ps-2 pe-2 m-0" v-if="parameters.display_media_status==1">
<div class="col-12 p-1">
    <input type="file" id="file" @change="onFileSelected" class="form-control shadow-none d-none" accept=".png, .jpg, .webp, .gif, .mp4, .mkv, .ppt, .pdf, .doc, .docx">
    <div class="m-1 w-100">
       <label class="text-muted w-100" for="file" role="button">
        <span class=""><em>Click to pick a media file</em></span> 
        <br clear="all">
        <img v-if="parameters.media_type=='Image'" :src="mediaFile" class="rounded" :style="'width:'+parameters.media_width+parameters.media_measure+';'+'height:'+parameters.media_height+'px;'" alt="">
        <video v-else :src="mediaFile" controls="true" class="rounded" :style="'width:'+parameters.media_width+parameters.media_measure+';'+'height:'+parameters.media_height+'px;'" alt=""></video>
    </label>
        <br clear="all">
        <span class="float-start" style="text-underline-position: under;" role="button" @click="clearImage"><em><u>Clear media</u></em></span> 
        <br/> <p class="text-danger" v-html="errors.upload_file ? errors.upload_file[0]: ''"></p>
    </div>
</div>
</div>

<div class="row ps-2 mt-3">
<div class="col">
    <div class="m-1">
        <h5 class="fw-bolder ps-1 pe-2" v-html="parameters.item_title"></h5>
        <p class="ps-1 pe-2"> <span class="truncate truncate_4" v-html="parameters.item_summary"> </span> 
        <section v-if="parameters.read_more_status==1" class="mt-3">
        <a href="#" style="text-underline-position: under;" class="float-start" v-if="parameters.read_more_type=='TextLink'"> <u><span v-text="parameters.read_more_title"></span></u>  </a>
        <a href="#" class="btn btn-primary float-start" v-else v-text="parameters.read_more_title">  </a>
        </section>
        </p>
    </div>
</div>
</div>

<div class="row ps-2">
<div class="col-12" v-if="parameters.read_more_status==1">
    <div class="m-1">
        <hr>
        <p> <span class="" v-html="parameters.contents"> </span> </p>
    </div>
</div>

 <div class="col-md-12">
    <hr>
        <div class="m-1 mt-3">
<div class="row">
    <div class="col-12">
       <div class="form-group mt-3">
        <div class="row">
            <div class="col"><label for="link" class="text-dark" title="required"> Generate or paste a link </label></div>
            <div class="col"><button type="button" class="btn btn-primary btn-sm float-end m-1 mb-3" @click="generateLink">Generate</button></div>
        </div>
        </div>
        <div class="form-group">
        <textarea id="link" placeholder="Post link" class="form-control mt-1 mb-1" v-model="parameters.item_link" rows="1"></textarea>
        <span class="text-danger" for="" v-if="errors.item_link && errors.item_link != ''"><small> <span v-text="errors.item_link[0]"></span> </small></span>
        </div>
    </div>
    <div class="col-12 mt-2">
        <label for="status" class="float-start text-primary">
        <input class="form-check-input" id="status" type="checkbox" v-model="parameters.status_id" true-value="1" false-value="0"> 
        Publish Immediately
        </label>
    </div>
    <div class="col-12 mt-2">
    <button type="submit" class="btn btn-primary shadow-none float-end ms-1"><i class="bi-save"></i> <span v-text="button"></span> </button>         
    <span v-if="validated" @click="cancelBtn" class="btn btn-danger float-end ms-1"><i class="bi-x fs-6"></i> Cancel  </span>         
    </div>
</div>
</div>
</div>

</div>
</div>
</div>
</div>

</form> 
</div>
<!-- Here -->
</div>

</div>
</div>

</template>
<script>
import phonecodes from '/storage/json/phoneCode'
export default {
    name: 'Course_Edit',
    props: ['server_record', 'server_message'],
    data (){
        return{
        pageName: 'Course',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: this.server_record,
        button: 'Update post',
        btntxt: 'Update post',
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
        sourcecode: '',
        preview: false,
        mediaFile: '/assets/icons/nomedia.png',
        selectedFile: '',
        parameters:{
            media_link: '',
            generated_id: '',
            item_title: '',
            item_summary: '',
            contents: '',
            item_link: '',
            media_height: '160',
            media_width: '160',
            media_type: 'Image',
            media_measure: 'px',
            generated_id: '',
            read_more_status: 1,
            read_more_title: 'Learn more',
            read_more_type: 'TextLink',
            display_media_status: 1,
            original_price: 0,
            display_price: 0,
            discount: 0,
            durations: '',
            class_mode: 'Physical',
            beginner_level: 'No prior experienced required',
            language_title: 'English',
            startDate: '',
            endDate: '',
            status_id: 0,
            category_id: '',
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
        this.parameters.item_title = this.info.item_title
        this.parameters.item_summary = this.info.item_summary ? this.info.item_summary:''
        this.parameters.contents = this.info.contents ? this.info.contents : ''
        this.parameters.media_height = this.info.media_height
        this.parameters.media_width = this.info.media_width
        this.parameters.media_measure = this.info.media_measure
        this.parameters.media_type = this.info.media_type
        this.parameters.generated_id = this.info.generated_id
        this.parameters.read_more_status = this.info.read_more_status
        this.parameters.read_more_title = this.info.read_more_title
        this.parameters.item_link = this.info.item_link
        this.parameters.read_more_type = this.info.read_more_type
        this.parameters.display_media_status = this.info.display_media_status
        this.parameters.status_id = this.info.status_id
        this.parameters.category_id = this.info.category_id
        this.parameters.original_price = this.info.original_price
        this.parameters.discount = this.info.discount
        this.parameters.display_price = this.info.display_price
        this.parameters.durations = this.info.durations
        this.parameters.class_mode = this.info.class_mode
        this.parameters.startDate = this.info.startDate
        this.parameters.endDate = this.info.endDate
        this.parameters.language_title = this.info.language_title
        this.parameters.beginner_level = this.info.beginner_level
        this.mediaFile = this.info.display_media ? this.info.display_media : this.mediaFile
        this.parameters.media_link = this.info.display_media ? this.info.display_media : ''
    },

    getSourceCode: function(){
        this.sourcecode = this.parameters.contents
    },
    saveSouceCode: function(){
        this.parameters.contents = this.sourcecode
    },
    previewChanges: function(){
        this.preview = true;
    },
    showCode: function(){
        this.preview = false;
    },
    calculateDiscount: function(){
        var discounted = 0;
        var discount = parseInt(this.parameters.discount);
        var price = parseFloat(this.parameters.original_price);
        discounted = (price/100) * discount
        this.parameters.display_price = price - discounted

    },
    generateLink: function(){
        let hostname = location.origin;
        let title = this.parameters.item_title
        let category_name = '';
        for (let index = 0; index < this.category_list.length; index++) {
            if (this.parameters.category_id == this.category_list[index].id){
            category_name = this.category_list[index].category_name;
            }
        }
        let url = hostname+'/course/'+category_name+'/'+title;
        this.parameters.item_link = url.toString().toLowerCase();
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
        if(this.parameters.title=="" || this.parameters.category_id=="") {
            this.validated = false
            this.disabled = false;
            this.parameters.item_link = ''
            this.alertMsg='Kindly fill the category and content title.'
            $("#alertDanger").toast('show')
            return false;
        }else if(this.parameters.display_media_status==1 && this.parameters.media_link=='' && this.selectedFile=="") {
            this.validated = false
            this.disabled = false;
            this.alertMsg='Kindly select the display media or uncheck the box to disable it.'
            $("#alertDanger").toast('show')
            return false;
        }else if(this.parameters.read_more_status==1 && this.parameters.item_link=="") {
            this.validated = false
            this.disabled = false;
            this.alertMsg='Kindly generate or paste a navigation link or disable landing page.'
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
        axios.post('/course/update', form).then(response => {
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
        axios.get('/coursecategory/list', {params:this.parameters}).then(response => {
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