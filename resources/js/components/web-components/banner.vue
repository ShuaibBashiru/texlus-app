<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />  

    <div class="text-center position-absolute end-50 top-50" v-if="loader">
        <div class="spinner-border text-warning" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

<div class="container-fluid mt-3 side-bubble" v-if="info.length>0">
<div class="row pb-5">
    <div class="col-md-10 m-auto">
<div class="row mt-4">
    <div class="col-md-6">
       <div class="m-1 mt-md-3">
        <h1 class="fw-bolder" v-html="info[0].post_title" style="line-height:1.25; letter-spacing: 1px; font-size: 2.8em;"></h1>
        <p class="lead mt-2 fade-para"> <small><span class="" v-html="info[0].post_summary"> </span></small> </p>
        <a href="/courses" class="btn btn-primary mt-3"> <span class="size-13"> BROWSE COURSES</span> </a>
        <a href="/aboutus" class="btn btn-outline-primary mt-3"> <span class="size-13"> ABOUT TEXLUS </span> </a>
    </div>
</div>

<div class="col-md-6 mx-auto text-center">
    <div class="m-1">
        <img :src="info[0].display_media" class="img-fluid rounded-circle mt-4 mt-md-1" :style="'width:'+info[0].media_width+info[0].media_measure+'; '+'height:'+info[0].media_height+'px;'" alt="">
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
  name: 'banner',
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
            header_title: "",
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
            category: 'Single banner',
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
            this.loader = false;
            this.errors = '';
            this.alertMsg='Something went wrong while fetching some content, please refresh and try again or report this error.';
            $("#alertDanger").toast('show')
        })
    },
    
    },


    }
</script>