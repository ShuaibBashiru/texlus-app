<template>
<div class="">
    <b-overlay class="position-fixed w-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />  

    <div class="text-center position-absolute end-50 top-50" v-if="loader">
        <div class="spinner-border text-warning" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

<div class="container-fluid mt-4">
<div class="row">
<div class="col-md-11 m-auto">
<server-alert :server_message="server_message" />
</div>
</div>
</div>

<div class="container-fluid pb-4 mb-2" v-if="info.length>0">
<div class="row">
<div class="col-md-11 m-auto">
<div class="row mt-2">
<div class="col-md-12">
    <p class="lead mt-1 text-center fade-para"> <span class=""> <small></small> </span> </p>
</div>
<div class="col-md-12">
<div class="card border-primary m-1 m-md-2">
        <div class="card-body">
    <div class="row">
        <div class="col-md-5 mt-2 mb-2">
        <img :src="info[0].display_media" class="img-fluid rounded" :style="'width:'+info[0].media_width+info[0].media_measure+';'+'height:'+info[0].media_height+'px;'" alt="No media">
        </div>

        <div class="col-md-7 mt-2 mb-2">
        <h5 class="text-primary"> <span style="line-height:1.25; letter-spacing: 1px;" v-html="info[0].item_title"></span></h5>
        <p class="fade-para"> <small> <span class="fw-bold"></span> <span class="" v-html="info[0].item_summary?info[0].item_summary:''"> </span></small> </p>
       <div class="row">
        <div class="col">
            <p class="text-primary" v-text="info[0].discount>0? info[0].discount+'% Discount off':'....'"></p>
            <p class="text-primary strikethrough">
            Fee: 
            <span class="text-decoration-line-through text-muted" v-text="info[0].original_price ? valueConverter(info[0].original_price) : ''"></span> &nbsp;
            <span v-text="info[0].display_price<1? 'Free' : valueConverter(info[0].display_price)"></span>
            </p>

        </div>
        <div class="col-12 mt-3">
            <button @click="enrolCourse" class="btn btn-primary btn-sm float-end"> Enrol course </button>
        </div>
       </div>
        </div>
    </div>

</div>
</div>
</div>
</div>

</div>
</div>

<!-- End row -->
<div class="row">
<div class="col-md-11 m-auto">
<div class="row mt-4">
<div class="col-md-12">
<div class="card m-1 ps-2 pe-2">
        <div class="card-body">
    <div class="row">

        <div class="col-md-4 p-1">
            <div class="p-3 border rounded">
        <h6 class="fw-bold"> <i class="bi bi-clock-history"></i> <span>Duration</span> </h6>
        <p class="text-muted"><small v-text="info[0].durations ? info[0].durations:''"></small></p>
            </div>
        </div>
        <div class="col-md-2 p-1">
            <div class="p-3 border rounded">
            <h6 class="fw-bold"> <i class="bi bi-soundwave"></i> <span>Language</span> </h6>
            <p class="text-muted">
                <small v-text="info[0].language_title ? info[0].language_title:'English'"></small>
            </p>
            </div>
        </div>
     <div class="col-md-2 p-1">
            <div class="p-3 border rounded">
                    <h6 class="fw-bold"> <i class="bi bi-person-video2"></i> <span>Class Mode</span> </h6>
                    <p class="text-muted"><small v-text="info[0].class_mode ? info[0].class_mode:'Not specified'"></small></p>
            </div>
        </div>

     <div class="col-md-4 p-1">
            <div class="p-3 border rounded">
                    <h6 class="fw-bold"> <i class="bi bi-bar-chart"></i> <span>Beginner Level</span> </h6>
                    <p class="text-muted"><small v-text="info[0].beginner_level ? info[0].beginner_level:'Not specified'"></small></p>
            </div>
    </div>

     <div class="col-md-4 p-1">
        <div class="p-3 border rounded">
            <div class="row">
                <div class="col"><small class="fw-bold">From: </small> <small v-text="info[0].startDate ? info[0].startDate:''"></small></div>
                <div class="col"><small class="fw-bold">To: </small> <small v-text="info[0].endDate ? info[0].endDate:''"></small></div>
            </div>
        </div>
        </div>
    
    </div>
</div>
</div>
</div>
</div>

</div>
</div>

<!-- End row -->
<div class="row">
<div class="col-md-11 m-auto">
<div class="row mt-4">
<div class="col-md-12">
<div class="card m-1 ps-2 pe-2">
        <div class="card-body">
    <div class="row">

        <div class="col-md-8 p-1">
            <div class="p-3 pt-0 rounded">
        <h5 class="fw-bold"> <i class="bi bi-card-text"></i> <span>About the course</span> </h5>
        <hr/>
        <p class="text-muted"><span v-html="info[0].contents ? info[0].contents:''"></span></p>
            </div>
        </div>
        <div class="col-md-4 p-1">
            <div class="p-3 border rounded">
            <h6 class="fw-bold"> <i class="bi bi-soundwave"></i> <span>Special Offers</span> </h6>
            <ul class="list-group">
                <li class="list-group-item" v-if="info[0].discount>0"><i class="bi bi-chevron-double-right pe-2"></i><span v-text="info[0].discount>0? info[0].discount+'% Discount off':'....'"></span></li>
                <li class="list-group-item"><i class="bi bi-chevron-double-right pe-2"></i>Support & mentorship</li>
                <li class="list-group-item"><i class="bi bi-chevron-double-right pe-2"></i>Free guide materials</li>
                <li class="list-group-item"><i class="bi bi-chevron-double-right pe-2"></i>Assignments and Quizzes</li>
                <li class="list-group-item"><i class="bi bi-chevron-double-right pe-2"></i>Projects</li>
                <li class="list-group-item"><i class="bi bi-chevron-double-right pe-2"></i>Portfolio guide</li>
                <li class="list-group-item"><i class="bi bi-chevron-double-right pe-2"></i>Jobs recommendation</li>
            </ul>
     
            </div>
        </div>
    
    </div>
</div>
</div>
</div>
</div>

</div>
</div>
<div class="row">
<div class="col-md-11 m-auto">
<hr/>
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
export default {
    name: 'course-selected',
    props: ['server_record', 'server_message'],
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
        loader: false,
        errors: [],
        settings: '',
        content_header: {
            header_title: "Explore More...",
            header_text: '',
        },
        info: [this.server_record],
        content: {
            item_title: '',
            item_summary: '',
            display_media: '',
            media_width: '',
            media_height: '',
            media_measure: '',
            read_more_status: '',
            read_more_type: '',
            read_more_title: '',
            item_link: ''
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
        this.getAppSettings();
        // this.getInfo();
    }, 
    methods:{
    getAppSettings: function(){
        fetch('/storage/settings/app.json')
        .then((response) => response.json())
        .then((data) => {
           this.settings = data;
        });
     },
    valueConverter: function(amount){
        var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'NGN',
        })
        return formatter.format(amount);
    },

    getRecord: function(){

    },
    getInfo: function(){
        this.loader = true;
        var category = this.parameters.category
        axios.get('/api/course/info', {params:this.parameters}).then(response => {
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

// Enrol course

enrolCourse: function(){
        $(".toaster").toast('hide')
        this.button='Please wait...';
        this.showOverlay=true;
        this.alertMsg = '';
        const form = new FormData();
        for (var key in this.parameters){
        form.append(key, this.parameters[key])
        }
        axios.post('/course/enrol', form).then(response => {
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