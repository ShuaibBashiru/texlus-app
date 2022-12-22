<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />  
<div class="container-fluid mt-3 pb-5 bg-lightblue" v-if="info.length>0">
<div class="row">
<div class="col-md-11 m-auto">
<div class="row mt-4">
<div class="col-md-12 m-auto">
   <h1 class="fw-bolder" style="line-height:1.25; letter-spacing: 1px; font-size: 2em;">
    <span v-html="content_header.header_title"></span>
   </h1>
</div>
<div class="col-md-12">
    <div class="row">
        <Vslick v-if="info.length>0" v-bind="itemscroll">
        <div class="col-4 mt-3 d-flex position-relative" v-for="(d, index) in info" :key="index">
        <div class="m-1 me-4">
        <img :src="d.display_media" class="rounded img-fluid border" :style="'width:'+d.media_width+d.media_measure+';'+'min-height:'+d.media_height+'px;'" alt="No media">
            <h5 class="fw-bolder mt-3" v-html="d.post_title" style="line-height:1.25; letter-spacing: 1px; font-size: 1.2em;"></h5>
            <p class="lead mt-2 fade-para fs-6 truncate truncate_3"><span class="" v-html="d.post_summary"> </span> </p>
        <section v-if="d.read_more_status==1" class="mt-3">
            <a :href="d.post_link" style="text-underline-position: under;" class="float-start stretched-link" v-if="d.read_more_type=='TextLink'"> <u><span v-text="d.read_more_title"></span></u>  </a>
            <a :href="d.post_link" class="btn btn-primary float-start stretched-link" v-else v-text="d.read_more_title">  </a>
        </section>
    </div>
        </div>
        </Vslick>
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
import Vslick from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
import appsettings from '/storage/settings/app.json'
export default {
  name: 'courses',
    components:{
        Vslick
    },
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
            header_title: "Essential skills",
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
            category: 'Web development',
        },
        itemscroll:{
            arrows: true,
            dots: true,
            rows:1,
            slidesToShow:4,
            slidesToScroll:1,
            swipe:true,
            swipeToSlide:true,
            useCSS:true,
            autoplay:true,
            centerMode:true,
            centerPadding:'10',
            responsive: [
        {
            breakpoint: 1024,
            settings: {
            slidesToShow: 3,
            slidesToScroll: 2
            }
        },

        {
            breakpoint: 767,
            settings: {
            slidesToShow: 2,
            slidesToScroll: 2
            }
        },
        {
            breakpoint: 639,
            settings: {
            slidesToShow: 1,
            slidesToScroll: 1
            }
        },
        ]
            },
    }
    },

    created(){
        this.getInfo();
    }, 
    methods:{
    getInfo: function(){
        var category = this.parameters.category
        axios.get('/api/course/info/'+category, {params:this.parameters}).then(response => {
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