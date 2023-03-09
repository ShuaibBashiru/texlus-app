<template>
<div class="bg-light-eee" style="">

<all-courses> </all-courses>

</div>
</template>

<script>

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