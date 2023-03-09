<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg"/> 
<div class="text-center position-absolute end-50 top-50" v-if="loader">
        <div class="spinner-border text-warning" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div> 
<div class="container-fluid mt-3 pb-5 bg-lightblue" v-if="info.length>0">
<div class="row">
<div class="col-md-12 m-auto">
<div class="row mt-4">
<div class="col-md-12 m-auto">
   <h1 class="fw-bolder text-" style="line-height:1.25; letter-spacing: 1px; font-size: 2em;">
    <span v-html="info[0].post_title"></span>
   </h1>
</div>
</div>
<div class="row mt-2">
<div class="col-md-3 mt-2">
<ul class="list-group" role="button">
  <li class="list-group-item active" aria-current="true">Outlines</li>
  <li class="list-group-item list-group-item-primary" @click="findElement('Welcome')">Welcome</li>
  <li class="list-group-item list-group-item-success" @click="findElement('What Information Do We Collect')">What Information Do We Collect?</li>
  <li class="list-group-item list-group-item-primary" @click="findElement('When and With Whom Do We Share Your Personal Information')">When and With Whom Do We Share Your Personal Information?</li>
  <li class="list-group-item list-group-item-success" @click="findElement('Do We Use Cookies and Other Tracking Technologies')">Do We Use Cookies and Other Tracking Technologies?</li>
  <li class="list-group-item list-group-item-primary" @click="findElement('How Do We Handle Your Social Logins')">How Do We Handle Your Social Logins?</li>
  <li class="list-group-item list-group-item-success" @click="findElement('How Long Do We Keep Your Information')">How Long Do We Keep Your Information?</li>
  <li class="list-group-item list-group-item-primary" @click="findElement('How Do We Keep Your Information Safe')">How Do We Keep Your Information Safe?</li>
  <li class="list-group-item list-group-item-success" @click="findElement('What Are Your Privacy Rights')">What Are Your Privacy Rights?</li>
  <li class="list-group-item list-group-item-primary" @click="findElement('Controls For Do-Not-Track Features')">Controls For Do-Not-Track Features</li>
  <li class="list-group-item list-group-item-success" @click="findElement('Do We Make Updates To This Notice')">Do We Make Updates To This Notice?</li>
  <li class="list-group-item list-group-item-primary" @click="findElement('Acceptable Use Policy')">Acceptable Use Policy</li>
  <li class="list-group-item list-group-item-success" @click="findElement('How Can You Review, Update, Or Delete the Data We Collect From You')">How Can You Review, Update, Or Delete the Data We Collect From You?</li>
  <li class="list-group-item list-group-item-primary" @click="findElement('How Can You Contact Us About This Notice')">How Can You Contact Us About This Notice?</li>
</ul>
</div>
<div class="col-md-9 mt-4">
    <div class="row">
        <div class="col-md-11 m-auto">
        <div class="m-1">
            <div class="mt-2 text-justify"> <span class="" v-html="info[0].post_body"> </span> </div>
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
  name: 'terms',
    data (){
    return{
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        notification: '',
        info: [],
        progress: null,
        record:false,
        responseStatus: '',
        loader: false,
        errors: [],
        settings: '',
        content_header:{
            header_title: "Terms and Privacy",
            header_text: "",
        },
        content: {
            post_title: '',
            post_summary: '',
            display_media: '',
            media_width: '',
            media_height: '',
            media_measure: '',
            read_more_status: '',
            read_more_type: '',
            read_more_title: '',
            post_link: ''
        },
        parameters: {
            title: '',
            category: 'Terms',
        },
    }
    },

    created(){
        this.getAppSettings();
        this.getInfo();
    }, 
    methods:{
    getAppSettings: function(){
        fetch('/storage/settings/app.json')
        .then((response) => response.json())
        .then((data) => {
           this.settings = data;
        });
     },
    getInfo: function(){
        this.loader = true;
        var category = this.parameters.category
        axios.get('/api/post/info/'+category, {params:this.parameters}).then(response => {
            this.errors = '';
            if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
            this.info = response['data'].data.info
            this.loader = false;
            }else if(response['data'].data.status=='norecord'){
            this.category_list = ''
            this.alertMsg=''
            this.loader = false;
            }else{
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
            this.loader = false;
            }
        }).catch(error => {
            this.errors = '';
            this.alertMsg='Something went wrong while fetching some content, please refresh and try again or report this error.';
            $("#alertDanger").toast('show')
            this.loader = false;
        })
    },
    findElement: function(element){
        $(window).scrollTop($("*:contains("+element+"):last").offset().top);

    }
    },


    }
</script>