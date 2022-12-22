<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />  
<div class="container-fluid mt-3 pb-5" v-if="info.length>0">
<div class="row">
<div class="col-md-11 m-auto">
<div class="row mt-4">
<div class="col-md-12 m-auto">
   <h1 class="fw-bolder text-left ms-md-4" style="line-height:1.25; letter-spacing: 1px; font-size: 2em;">
    <span v-html="content_header.header_title"></span>
   </h1>
    <p class="lead mt-1 text-center fade-para"> <span class=""> <small></small> </span> </p>
</div>
<div class="col-md-12 mt-2">
    <div class="row">
        <Vslick v-if="info.length>0" v-bind="itemscroll">
        <div class="col-md-4 mt-4 d-flex position-relative grow" v-for="(d, index) in info" :key="index">
        <div class="m-2 m-md-3 me-md-4 mt-2 mb-2 border bg-light rounded">
        <span class="badge end-50 top-0 position-absolute rounded bg-primary p-2" v-text="d.discounted_price==0? 'Free' : valueConverter(d.discounted_price)"></span>
        <img :src="d.display_media" class="img-fluid rounded" :style="'width:'+d.media_width+d.media_measure+';'+'height:'+d.media_height+'px;'" alt="No media">
        <h5 class="mt-3 mb-0 p-2 text-primary"> <small><i class="bi bi-star-fill"></i></small> <span style="line-height:1.25; letter-spacing: 1px;" v-html="d.post_title"></span></h5>
        <p class="p-2 fade-para truncate truncate_2"> <small> <span class="fw-bold"></span> <span class="" v-html="d.post_summary?d.post_summary:''"> </span></small> </p>
       <div class="row p-2">
        <div class="col-md-12">
            <p class="float-start"> <i class="bi bi-calender"></i><small v-text="d.durations ? d.durations:''"></small></p>
        </div>
        <div class="col">
            <a :href="d.post_link" style="" class="float-start stretched-link"></a>
            <p class="text-primary float-start" v-text="d.discount+'% Discount'"></p>
            <!-- <section v-if="d.read_more_status==1" class="">
                    <a :href="d.post_link" style="text-underline-position: under;" class="float-start stretched-link" v-if="d.read_more_type=='TextLink'"> <u><span v-text="d.read_more_title"></span></u>  </a>
                    <a :href="d.post_link" class="btn btn-outline-primary btn-sm float-start stretched-link" v-else v-text="d.read_more_title">  </a>
            </section> -->
        </div>
        <div class="col">
            <p class="text-primary float-end" v-text="'Class: '+d.class_mode"></p>
        </div>
       </div>
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
  name: 'courses-slideshow',
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
            header_title: "Explore the essential skills.",
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
            category: 'Skills',
        },
        itemscroll:{
            arrows: true,
            dots: true,
            rows:1,
            slidesToShow:3,
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
            slidesToShow: 2,
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
    valueConverter: function(amount){
        var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'NGN',
        })
        return formatter.format(amount);
    },

    getInfo: function(){
        var category = this.parameters.category
        axios.get('/api/course/info', {params:this.parameters}).then(response => {
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