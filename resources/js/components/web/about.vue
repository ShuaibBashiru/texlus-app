<template>
<div class="">

<aboutus> </aboutus>
<br/>

<team> </team>
<br/>

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