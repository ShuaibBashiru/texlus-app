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
        settings: '',

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