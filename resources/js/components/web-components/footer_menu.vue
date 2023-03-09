<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />  
<div class="container-fluid pt-4" style="background-color:#1b1b1b;">
<div class="row p-0">
<div class="col-md-12">
    <div class="row p-0">
        <div class="col-md-6">
            <div class="row p-0">
                <div class="col-md-12">
    <div class="m-1">
        <ul class="nav">
            <li class="nav-item"><a href="/" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;">Home</a></li>
            <li class="nav-item"><a href="/aboutus" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;">About Us</a></li>
            <li class="nav-item"><a href="/contactus" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;">Contact Us</a></li>
            <li class="nav-item"><a href="/terms" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;">Terms & Privacy</a></li>
        </ul>
    </div>
</div>

<div class="col-md-12">
    <div class="m-1">
        <h6 class="text-light ms-3">Contact</h6>
        <ul class="nav flex-column">
            <li class="nav-item"><a :href="'tel:'+settings.phone_one" class="nav-link text-light link-size-14" style="opacity:0.7;"><i class="bi bi-phone"></i> <span v-text="settings.phone_one"></span></a></li>
            <li class="nav-item"><a :href="'mailto:'+settings.email_one" class="nav-link text-light link-size-14" style="opacity:0.7;"><i class="bi bi-inbox"></i> <span v-text="settings.email_one"></span></a></li>
        </ul>
    </div>
</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row p-0">
        <div class="col-md-12">
        <div class="m-1 float-end">
        <h6 class="text-light ms-3">Connect with us</h6>
            <ul class="nav ms-4">
                <li class="nav-item"><a :href="settings.linkedin" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;"><i class="bi bi-linkedin"></i></a></li>
                <li class="nav-item"><a :href="settings.twitter" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;"><i class="bi bi-twitter"></i></a></li>
                <li class="nav-item"><a :href="settings.youtube" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;"><i class="bi bi-youtube"></i></a></li>
                </ul>
        </div>
        </div>
            </div>

        </div>
    </div>
</div>
</div>
<div class="row p-0">
    <div class="col-md-12">
        <div class="m-1">
       <p class="text-light text-center link-size-12 mt-3 pb-0" style="opacity:0.7;"> &copy; <span v-text="settings.copyright"></span> </p>
       <p class="text-light text-center link-size-12 mt-3 pb-0" style="opacity:0.7;"> <em><small class="me-4"><a href="https://www.freepik.com/" class="text-light" style="opacity:0.7;">Credit: Images from Freepik</a></small></em></p>
    </div>
    </div>
</div>


</div>
</div>
</template>

<script>
export default {
  name: 'footer_menu',
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
        content: {
        },
    }
    },

    created(){
        this.getAppSettings();
    }, 
    methods:{
    getAppSettings: function(){
        fetch('/storage/settings/app.json')
        .then((response) => response.json())
        .then((data) => {
           this.settings = data;
        });
     },
    },


    }
</script>