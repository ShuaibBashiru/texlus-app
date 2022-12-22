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
             <h5 class="mt-2 ms-2 text-primary"> <span v-text="pageName" role="button"> </span>  </h5>
        </div>
        </div>
        <div class="col-md-7 pe-3">
        <div class="mt-1 mb-2">
</div>
</div>
</div>

<div class="row">
    <div class="col-12">
<form @submit.prevent="confirmAction" enctype="multipart/form-data">
<div class="row">
<div class="col-md-7">
<div class="mt-1 border rounded">
<div class="row m-0">
<div class="col-12">
    <div class="m-2">
        <div class="form-group border-bottom mt-3">
            <h5 class="">Site Info</h5>
        </div>
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Company Name</label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('company_name')" v-model="parameters.company_name">
            <span class="text-danger" for="" v-if="errors.company_name && errors.company_name != ''"><small> <span v-text="errors.company_name[0]"></span> </small></span>
        </div>   
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Site Name <sup>*</sup></label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('site_name')" v-model="parameters.site_name" required>
            <span class="text-danger" for="" v-if="errors.site_name && errors.site_name != ''"><small> <span v-text="errors.site_name[0]"></span> </small></span>
        </div>
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Site Slogan</label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('slogan')" v-model="parameters.slogan">
            <span class="text-danger" for="" v-if="errors.slogan && errors.slogan != ''"><small> <span v-text="errors.slogan[0]"></span> </small></span>
        </div>

        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Description</label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('descriptions')" v-model="parameters.descriptions">
            <span class="text-danger" for="" v-if="errors.descriptions && errors.descriptions != ''"><small> <span v-text="errors.descriptions[0]"></span> </small></span>
        </div>
        <div class="form-group border-bottom mt-3">
            <h5 class="">Mailing Info</h5>
        </div>
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Mailing Address</label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('mailing_address')" v-model="parameters.mailing_address">
            <span class="text-danger" for="" v-if="errors.mailing_address && errors.mailing_address != ''"><small> <span v-text="errors.mailing_address[0]"></span> </small></span>
        </div>
   
        <div class="form-group border-bottom mt-3">
            <h5 class="">Contact</h5>
        </div>
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Email </label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('email_one')" v-model="parameters.email_one">
            <span class="text-danger" for="" v-if="errors.email_one && errors.email_one != ''"><small> <span v-text="errors.email_one[0]"></span> </small></span>
        </div>   
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Another Email</label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('email_two')" v-model="parameters.email_two">
            <span class="text-danger" for="" v-if="errors.email_two && errors.email_two != ''"><small> <span v-text="errors.email_two[0]"></span> </small></span>
        </div>

         <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Phone Number </label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('phone_one')" v-model="parameters.phone_one">
            <span class="text-danger" for="" v-if="errors.phone_one && errors.phone_one != ''"><small> <span v-text="errors.phone_one[0]"></span> </small></span>
        </div>   
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Another phone</label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('phone_two')" v-model="parameters.phone_two">
            <span class="text-danger" for="" v-if="errors.phone_two && errors.phone_two != ''"><small> <span v-text="errors.phone_two[0]"></span> </small></span>
        </div>

       <div class="form-group border-bottom mt-3">
            <h5 class="">Search Enginer</h5>
        </div>

        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">SEO keywords </label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('key_words')" v-model="parameters.key_words">
            <span class="text-danger" for="" v-if="errors.key_words && errors.key_words != ''"><small> <span v-text="errors.key_words[0]"></span> </small></span>
        </div>  

        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Site Status </label>
           <select v-model="parameters.site_status" id="" class="form-control">
            <option value="Active">Active</option>
            <option value="Maintenance">Under maintenance</option>
            <option value="Temporary">Temporary</option>
            <option value="Upgrade">Upgrade</option>
           </select>
            <span class="text-danger" for="" v-if="errors.site_status && errors.site_status != ''"><small> <span v-text="errors.site_status[0]"></span> </small></span>
        </div>  

        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Site status description</label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('status_description')" v-model="parameters.status_description">
            <span class="text-danger" for="" v-if="errors.status_description && errors.status_description != ''"><small> <span v-text="errors.status_description[0]"></span> </small></span>
        </div>  
 
    </div>
</div>
</div>

</div>
</div>


<div class="col-md-5">
<div class="mt-1 border rounde pb-2">

<div class="row ps-2 pe-2 m-0">
<div class="col-12 p-1 text-center">
    <input type="file" id="file" @change="onFileSelected" class="form-control shadow-none d-none" accept=".png, .jpg">
    <div class="m-1 w-100">
       <label class="text-muted w-100" for="file" role="button">
        <span class=""><em>Click to pick site logo</em></span> 
        <br clear="all">
        <img :src="mediaFile" class="rounded" width="160" height="160" alt="">
    </label>
        <br clear="all">
        <span class="float-end" style="text-underline-position: under;" role="button" @click="clearImage"><em><u>Clear media</u></em></span> 
        <br/> <p class="text-danger" v-html="errors.upload_file ? errors.upload_file[0]: ''"></p>
    </div>
</div>

<div class="col-md-12">
     <div class="form-group border-bottom mt-3">
            <h5 class="">Address</h5>
        </div>
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Office Address</label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('office_address')" v-model="parameters.office_address">
            <span class="text-danger" for="" v-if="errors.office_address && errors.office_address != ''"><small> <span v-text="errors.office_address[0]"></span> </small></span>
        </div>
   
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">State </label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('state_name')" v-model="parameters.state_name">
            <span class="text-danger" for="" v-if="errors.state_name && errors.state_name != ''"><small> <span v-text="errors.state_name[0]"></span> </small></span>
        </div>   
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Country</label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('country_name')" v-model="parameters.country_name">
            <span class="text-danger" for="" v-if="errors.country_name && errors.country_name != ''"><small> <span v-text="errors.country_name[0]"></span> </small></span>
        </div>
        
         <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Copyright </label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('copyright')" v-model="parameters.copyright">
            <span class="text-danger" for="" v-if="errors.copyright && errors.copyright != ''"><small> <span v-text="errors.copyright[0]"></span> </small></span>
        </div>   
        
       <div class="form-group border-bottom mt-3">
            <h5 class="">Social media</h5>
        </div>
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Facebook</label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('facebook')" v-model="parameters.facebook">
            <span class="text-danger" for="" v-if="errors.facebook && errors.facebook != ''"><small> <span v-text="errors.facebook[0]"></span> </small></span>
        </div>
   
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">LinkedIn </label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('linkedin')" v-model="parameters.linkedin">
            <span class="text-danger" for="" v-if="errors.linkedin && errors.linkedin != ''"><small> <span v-text="errors.linkedin[0]"></span> </small></span>
        </div>   
        <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Youtube</label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('youtube')" v-model="parameters.youtube">
            <span class="text-danger" for="" v-if="errors.youtube && errors.youtube != ''"><small> <span v-text="errors.youtube[0]"></span> </small></span>
        </div>
        
         <div class="form-group mt-3">
            <label for="" class="text-dark" title="required">Twitter </label>
            <input id="" placeholder="Enter here" class="form-control mt-1 mb-1" @keyup="oneSpace('twitter')" v-model="parameters.twitter">
            <span class="text-danger" for="" v-if="errors.twitter && errors.twitter != ''"><small> <span v-text="errors.twitter[0]"></span> </small></span>
        </div> 
</div>
</div>

<div class="row ps-2">

 <div class="col-md-12">
    <hr>
        <div class="m-1 mt-3">
<div class="row">
<div class="col-12 mt-2">
 <button type="submit" class="btn btn-primary shadow-none float-end ms-1"><i class="bi-save"></i> <span v-text="button"></span> </button>         
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
</div>

</div>
</div>

</template>

<script>
import phonecodes from '../json/phoneCode'
export default {
    name: 'settings',
    props: ['server_record', 'server_message'],
    data (){
        return{
        pageName: 'Settings',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: this.server_record,
        button: 'Update site',
        btntxt: 'Update site',
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
            company_name: '',
            site_name: '',
            slogan: '',
            mailing_address: '',
            email_one: '',
            email_two: '',
            phone_one: '',
            phone_two: '',
            facebook: '',
            linkedin: '',
            youtube: '',
            twitter: '',
            office_address: '',
            state_name: '',
            country_name: '',
            copyright: '',
            media_type: 'logo',
            descriptions: '',
            key_words: '',
            site_status: 'Active',
            status_description: '',
            logo_link: '',
            generated_id: '',
        },
        
        errors: [this.parameters],
        form_success: [],
    }
    },

    created(){
        this.setRecord();
        },

    methods:{
    setRecord: function(){
        this.parameters.company_name = this.info.company_name ? this.info.company_name : '' 
        this.parameters.site_name = this.info.site_name ? this.info.site_name : '' 
        this.parameters.slogan = this.info.slogan ? this.info.slogan : '' 
        this.parameters.mailing_address = this.info.mailing_address ? this.info.mailing_address : '' 
        this.parameters.email_one = this.info.email_one ? this.info.email_one : '' 
        this.parameters.email_two = this.info.email_two ? this.info.email_two : '' 
        this.parameters.phone_one = this.info.phone_one ? this.info.phone_one : '' 
        this.parameters.phone_two = this.info.phone_two ? this.info.phone_two : '' 
        this.parameters.facebook = this.info.facebook ? this.info.facebook : '' 
        this.parameters.linkedin = this.info.linkedin ? this.info.linkedin : '' 
        this.parameters.youtube = this.info.youtube ? this.info.youtube : '' 
        this.parameters.twitter = this.info.twitter ? this.info.twitter : '' 
        this.parameters.office_address = this.info.office_address ? this.info.office_address : '' 
        this.parameters.state_name = this.info.state_name ? this.info.state_name : '' 
        this.parameters.country_name = this.info.country_name ? this.info.country_name : '' 
        this.parameters.copyright = this.info.copyright ? this.info.copyright : '' 
        this.parameters.descriptions = this.info.descriptions ? this.info.descriptions : '' 
        this.parameters.key_words = this.info.key_words ? this.info.key_words : '' 
        this.parameters.site_status = this.info.site_status ? this.info.site_status : '' 
        this.parameters.status_description = this.info.status_description ? this.info.status_description : '' 
        this.parameters.logo_link = this.info.logo_link ? this.info.logo_link : '' 
        this.mediaFile = this.info.logo_link ? this.info.logo_link : this.mediaFile
        this.parameters.generated_id = this.info.generated_id ? this.info.generated_id : '' 
    },

    resetForm: function(){
        this.validated = false;
        this.disabled = false;
        for(var key in this.parameters){
            this.parameters[key]=''
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
            this.mediaFile = '/assets/icons/nomedia.png';
            this.parameters.logo_link = '';
        },

   validatePost: function(){
        this.errors = '';
        if(this.parameters.site_name=="") {
            this.alertMsg='Site name is required.'
            $("#alertDanger").toast('show')
            return false;
        }else {
           return true;
        }

    },
 
  confirmAction: function(){
    if(this.validatePost()){
    swal({
        title: "Confirm!",
        text: "Do you want to continue?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        closeOnClickOutside: false,
        })
        .then((willDelete) => {
        if (willDelete) {
            this.sendPost();
        }
    });
    }else{
        this.alertMsg='Kindly complete the required field.'
        $("#alertDanger").toast('show')
        return false;
    }

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
        axios.post('/settings/create', form).then(response => {
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




    },

    }
</script>