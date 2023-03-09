<template>
<div class="">
<div class="container-fluid">
    <div class="row">
        <div class="col-5 ps-0">
        <div class="mt-1">
            <a :href="'../../manage/'+info.generated_id"><h5 class="mt-2 ms-0 text-muted" title="Go back" role="button"><i class="bi bi-chevron-left"></i> <span>Back</span></h5></a>
        </div>
        </div>
        
<div class="col-7 d-flex justify-content-end dropdown pe-3">
<div class="mt-1">
      <h5 class="mt-2 ms-0 text-muted"> <span v-text="pageName"></span></h5>
</div>
</div>
<div class="col-12 p-0 ps-1 pe-1">
  <hr class="m-0">
</div>
</div>

    </div>
    </div>
</template>

<script>
export default {
    name: 'back-button',
    props: ['server_record', 'server_message'],
    data (){
        return{
        pageName: 'User',
        info: this.server_record,
        
    }
    },

    created(){
       
    },

    computed:{

    },
    mounted(){

    },
        
    methods:{
      

        }


    }
</script>