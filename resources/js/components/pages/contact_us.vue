<template>
  <div class="bg position-absolute w-100 h-100">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
                
        <div class="container mb-5">
            <div class="row mb-md-5">
                <div class="col-md-12 ps-2">
                     <div class="m-md-4 mt-5">
                    <h2 class="display-3"> Hi, how can we help? </h2>
                     </div>
                    </div>
            </div>

                   <div class="row">
        <div class="col-md-6">
                   <div class="m-md-4 mt-5">
                        <h3>Help & Support</h3>
                    <p class="lead">Have questions or need to report an issue of any of our services, suggestions or enquiries? We've got you covered. </p>
                <a class="nav-link ps-0" :href="'mailto:' + settings['email_one']"><button class="btn btn-outline-primary">Write us a message</button></a>
               </div>
                </div>

                <div class="col-md-6">
             <div class="m-md-4 mt-5">
                <h3>Contacts</h3>
                <p class="lead"></p>
                <a class="nav-link ps-0" :href="'mailto:'+settings['email_one']">Email:  {{settings['email_one']}}</a>
                <a class="nav-link ps-0" :href="'mailto:'+settings['email_two']">Email:  {{settings['email_two']}}</a>
                <a class="nav-link ps-0" :href="'tel:'+settings['phone_one']">Phone: {{settings['phone_one']}}</a>
                <a class="nav-link ps-0" :href="'tel:'+settings['phone_two']">Phone: {{settings['phone_two']}}</a>
             </div>
                </div>
            </div>
        <div class="row">
                <div class="col-md-6">
                  <div class="m-md-4 mt-5">
                        <h3> Address </h3>
                    <p class="lead">
                    {{settings['address']}}</p>
                  </div>
                </div>


                   <div class="col-md-6">
                     <div class="mt-md-5 mt-4">
                     <button type="button" class="m-2 btn btn-outline-primary float-end" @click="$router.go('-1')"> <i class="bi-arrow-90deg-left"></i> Back</button>
                     </div>
                </div>
            </div>


        </div>
          

    </div>
</template>

<style>
.lead{
  color: #0a010196;
font-size: 18px;

}
</style>
<script>
import appsettings from '/storage/settings/app.json'
export default {
  name: 'contact_us',
    data (){
        return{
        settings:appsettings,
        Alert: 'hide',
        alertTitle: '',
        showOverlay: false,
        auth_check: false,
        usersession: '',
        userdata:'',
        token: '',
        isValidated: false,
        errorBox: 'd-none',
        AlertColor: 'text-primary',
        alertMsg: '',
        
        notification: '',
        alertmodal: '',
        info: [],
        classname: '',
        classnamemodal: '',
        submit: 'Submit',
        submittxt:'Submit',
 
        opacity:'',
        record:false,
        responseStatus: '',
        norecord: '',
    }
    },

    created(){
    }, 
    methods:{
    },


    }
</script>