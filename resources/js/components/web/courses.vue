<template>
<div class="bg-light-eee" style="">

<essential-course> </essential-course>

</div>
</template>

<script>
import appsettings from '/storage/settings/app.json'
export default {
  name: 'courses',
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