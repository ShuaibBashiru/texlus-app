<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />  
<div class="container-fluid mt-3 pb-5" v-if="info.length>0">
<div class="row">
<div class="col-md-11 m-auto">
<div class="row mt-4">
<div class="col-md-12 m-auto">
   <h1 class="fw-bolder text-center" style="line-height:1.25; letter-spacing: 1px; font-size: 2em;">
    <span v-html="content_header.header_title"></span>
   </h1>
    <p class="lead mt-3 text-center fade-para"> <span class=""> <small></small> </span> </p>
</div>
<div class="col-md-12 mt-4">
    <div class="row" v-if="info.length>0" v-bind="itemscroll">
        <div class="col-md-3 mt-4" v-for="(d, index) in info" :key="index">
        <div class="m-1 me-4 text-center">
        <img :src="d.display_media" class="rounded-circle img-fluid border grow" :style="'width:140px; height:140px;'" alt="No media">
            <h5 class="fw-bolder mt-3 text-center" v-html="d.post_title" style="line-height:1.25; letter-spacing: 1px; font-size: 1.2em;"></h5>
            <p class="lead mt-2 fade-para fs-6 text-center"><span class="" v-html="d.post_summary"> </span> </p>
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
<style>

.slick-prev:before {
    color: #000000;
}
.slick-next:before {
    color: #000000;
}
</style>
<script>
import appsettings from '/storage/settings/app.json'
export default {
  name: 'Team',
    data (){
    return{
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        notification: '',
        progress: null,
        record:false,
        responseStatus: '',
        errors: [],
        settings:appsettings,
        content_header: {
            header_title: "Our Team",
            header_text: '',
        },
        info: [],
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
            category: 'Team',
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