<template>
<div class="bg-light-eee" style="">

<banner> </banner>

<joinus> </joinus>

<whatisnew> </whatisnew>

<courses-slideshow></courses-slideshow>

<solution> </solution>

<tawkto> </tawkto>
</div>
</template>

<script>
import appsettings from '/storage/settings/app.json'
export default {
  name: 'home',
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

    }
    },

    created(){
    }, 
    methods:{
    },


    }
</script>