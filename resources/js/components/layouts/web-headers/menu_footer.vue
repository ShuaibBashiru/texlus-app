
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
import appsettings from '/storage/settings/app.json'

export default {
    name: "menu_footer",
        data(){
        return {
        settings: appsettings,
        
        }
        },

       
}
</script>