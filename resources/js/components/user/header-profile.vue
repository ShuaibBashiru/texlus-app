<template>
<div class="">
<div class="row">
<div class="col-md-12">
    <div class="m-1 border rounded-3">
    <div class="row">
        <!--  -->
        <div class="col-md-10">
        <div class="m-3 mb-1">
            <h5 class="display-7 ft-weight-light">Account <i class="bi bi-chevron-right"></i> <span class="text-capitalize p-1 ps-0 m-0 text-secondary" v-html="(info.lastname)? info.lastname+' '+info.firstname+' '+info.othername : ''"> </span></h5>
            <p class="text-muted">NB: Any changes made here will reflect on this account's activities, please be certain of this action before you proceed.</p>
        </div>
        </div>
        <div class="col-md-2 p-2">
        <div class="m-3">
                 <div class="text-center">
                     <figure>
                     <img :src="userProfilePassport" class="rounded-circle" height="120" width="120" alt="Passport">
                    </figure>
                </div>
        </div>
        </div>
    </div>
        </div>
        </div>
    </div>

<!-- <div class="row">
<div class="col-md-12">
    <div class="m-1 border rounded-3">
  
  <nav class="navbar navbar-expand-lg rounded">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" :href="'../edit/name/'+info.generated_id"><button class="btn btn-sm m-1 btn-outline-primary"> Update name </button></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" :href="'../edit/name/'+info.generated_id"><button class="btn btn-sm m-1 btn-outline-primary"> Update email </button></a>
        </li>
      </ul>
      <span class="navbar-text">
      </span>
    </div>
  </div>
</nav>


        </div>
        </div>
    </div> -->

</div>

</template>

<script>
export default {
    name: 'headerProfile',
    props: ['server_record'],
    data (){
        return{
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: this.server_record,
        usersession: [],
        counter: '0',
        errors: [],
        form_success: [],
        userProfilePassport: '/assets/icons/avatar.png',
        parameters:{
            lastname: '',
            firstname: '',
            othername: '',
            generated_id: '',
        },
    }
    },

    created(){
        this.getRecords();
        this.userProfilePassport = this.info.file_url ? this.info.file_url : this.userProfilePassport;

    }, 

    methods:{
    getRecords: function(){
        this.parameters.generated_id = this.info.generated_id
        this.parameters.lastname = this.info.lastname
        this.parameters.firstname = this.info.firstname
        this.parameters.othername = this.info.othername
    },

    }


    }
</script>