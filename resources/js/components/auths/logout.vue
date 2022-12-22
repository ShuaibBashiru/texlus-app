<template>
<div class="position-absolute w-100 h-100 bg-lightblue">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
   <div class="container-fluid">
       <div class="row mt-5">
           <div class="col-md-5 m-auto text-center mt-5">
            <div class="mt-5">
                <p class="display-6 text-primary"><small><strong v-html="message"></strong></small></p>
            </div>
            <div class="spinner-border text-primary p-5 mt-5 bg-light" role="status">
            <span class="">/</span>
            </div>
           </div>
       </div>
   </div>

    </div>
</template>
<script>
export default {
    name: 'account_logout',
    props: ['server_message'],
data(){
    return{
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        notification: '',
        info: [],
        progress: null,
        btntxt: 'Log in',
        button: 'Log in',
        record:false,
        responseStatus: '',
        errors: [],
        message: 'Please wait a moment...',
   
    }
},

created(){
  this.logout()
},
    methods:{
    logout: function(){
        try {
        this.$session.destroy()
        $(".toaster").toast('hide')
        setTimeout(function(){
        window.location.href='/signin'
        },1000)
        } catch (error) {
        this.$session.destroy()
        $(".toaster").toast('hide')
        setTimeout(function(){
        window.location.href='/signin'
        },1000)
        }

        }
    },

}
</script>