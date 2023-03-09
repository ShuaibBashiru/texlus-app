
<template>
    <div id="footer" class="container-fluid border-top position-fixed bottom-0 bg-light start-0 end-0">
<div class="row text-secondary">

<div class="col-md-12 border-top">
   <div class="text-center pt-2 pb-2">
       <small> Copyright &copy; {{settings.year}} {{settings.copyright}} </small>
   </div>

</div>
</div>
</div>
</template>

<script>

export default {
    name: "menu_footer",
        data(){
        return {
        settings: '',
        
        }
        },
    created(){
        this.getAppSettings();
    },
    methods: {
        getAppSettings: function(){
        fetch('/storage/settings/app.json')
        .then((response) => response.json())
        .then((data) => {
           this.settings = data;
        });
    },
    }
    }
</script>