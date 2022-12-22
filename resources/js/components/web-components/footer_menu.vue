<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />  
<div class="container-fluid pt-3" style="background-color:#1b1b1b;">
<div class="row p-0 m-0">
<div class="col-md-8">
    <div class="m-1">
        <ul class="nav">
            <li class="nav-item"><a href="/" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;">Home</a></li>
            <li class="nav-item"><a href="/aboutus" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;">About Us</a></li>
            <li class="nav-item"><a href="/contactus" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;">Contact Us</a></li>
            <li class="nav-item"><a href="/terms" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;">Terms & Privacy</a></li>
        </ul>
    </div>
</div>

<div class="col-md-4 d-flex justify-content-end">
    <div class="m-1">
        <ul class="nav">
            <li class="nav-item"><a :href="settings.linkedin" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;"><i class="bi bi-linkedin"></i></a></li>
            <li class="nav-item"><a :href="settings.twitter" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;"><i class="bi bi-twitter"></i></a></li>
            <li class="nav-item"><a :href="settings.youtube" class="nav-link text-light link-size-14 linkUnderlineHover" style="opacity:0.7;"><i class="bi bi-youtube"></i></a></li>
        </ul>
    </div>
</div>

</div>

<div class="row p-0 m-0">
<div class="col-md-5">
        <div class="m-1">
        <h6 class="text-light ms-3">Contact</h6>
        <ul class="nav flex-column">
            <li class="nav-item"><a :href="'tel:'+settings.phone_one" class="nav-link text-light link-size-14" style="opacity:0.7;"><i class="bi bi-phone"></i> <span v-text="settings.phone_one"></span></a></li>
            <li class="nav-item"><a :href="'mailto:'+settings.email_one" class="nav-link text-light link-size-14" style="opacity:0.7;"><i class="bi bi-inbox"></i> <span v-text="settings.email_one"></span></a></li>
        </ul>
    </div>
</div>
<div class="col-md-7 d-md-flex justify-content-end">
    <div class="m-1">
       <p class="text-light link-size-12 mt-3 pb-0" style="opacity:0.7;"> &copy; <span v-text="settings.copyright"></span></p>
    </div>
</div>

</div>
<div class="row p-0 m-0">
<div class="col-md-12">
        <div class="m-1">
            <em><small class="float-end"><a href="https://www.freepik.com/" class="text-light" style="opacity:0.7;">Images credit: Freepik</a></small></em>
</div>
</div>
</div>
</div>
</div>
</template>

<script>
import appsettings from '/storage/settings/app.json'
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
        errors: [],
        settings:appsettings,
        content: {
        },
    }
    },

    created(){
    }, 
    methods:{
    },


    }
</script>