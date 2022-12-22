<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg"/>  
<div class="container-fluid mt-3 pb-5 bg-lightblue" v-if="info.length>0">
<div class="row">
<div class="col-md-10 m-auto">
<div class="row mt-4">
<div class="col-md-12 m-auto">
   <h1 class="fw-bolder text-center" style="line-height:1.25; letter-spacing: 1px; font-size: 2em;">
    <span v-html="content_header.header_title"></span>
   </h1>
    <p class="lead mt-3 text-center fade-para fs-5"> <span class="" v-html="content_header.header_text"> </span> </p>
</div>
<div class="col-md-12 mt-4">
    <div class="row">
    <div class="col-md-7">
        <div class="m-1 shadow">
        <img :src="info[0].display_media" class="rounded img-fluid grow" :style="'width:'+info[0].media_width+info[0].media_measure+';'+'max-height:'+info[0].media_height+'px;'" alt="">
        </div>
    </div>
        <div class="col-md-5">
        <div class="m-1">
            <h4 class="fw-bolder" v-html="info[0].post_title" style="line-height:1.25; letter-spacing: 1px; font-size: 1.8em;"></h4>
            <p class="lead mt-2 fade-para fs-6"> <span class="" v-html="info[0].post_summary"> </span> </p>
            <section v-if="info[0].read_more_status==1" class="mt-3">
            <a :href="info[0].post_link" style="text-underline-position: under;" class="float-start" v-if="info[0].read_more_type=='TextLink'"> <u><span v-text="info[0].read_more_title"></span></u>  </a>
            <a :href="info[0].post_link" class="btn btn-primary float-start" v-else v-text="info[0].read_more_title">  </a>
        </section>
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
import appsettings from '/storage/settings/app.json'
export default {
  name: 'solution',
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
        errors: [],
        settings:appsettings,
        content_header:{
            header_title: "Solutions",
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
            category: 'Solutions',
        },
    }
    },

    created(){
        this.getInfo();
    }, 
    methods:{
    getInfo: function(){
        var category = this.parameters.category
        axios.get('/api/post/info/'+category, {params:this.parameters}).then(response => {
            this.errors = '';
            if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
            this.info = response['data'].data.info
            }else if(response['data'].data.status=='norecord'){
            this.category_list = ''
            this.alertMsg=''
            }else{
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
            }
        }).catch(error => {
            this.errors = '';
            this.alertMsg='Something went wrong while fetching some content, please refresh and try again or report this error.';
            $("#alertDanger").toast('show')
        })
    },
    },


    }
</script>