<template>
<div class="position-absolute w-100 h-100">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
 <!-- -->


<div class="container-fluid menuheader border-bottom borderStyle">
<div class="row">
<div class="col-md-12">
<nav class="navbar navbar-expand-lg">
<span class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<i class="bi bi-list" style="font-size: 2rem; color: black;"></i>
</span>
<a class="navbar-brand p-0 m-0 me-3 ms-md-2 text-success" style="color:#f8b818;" href="/app/"><img src="/assets/icons/logo.jpg" class="logoSize" alt="logo"> &nbsp; {{settings.site_name}}</a>
<ul class="navbar-nav p-0 m-3 mb-0 mt-0 d-md-none">
    <li class="nav-item"> <a href="/app/contactus" class="text-dark"> <i class="bi bi-question-circle" role="img" aria-label="Help" style="font-size: 1.6rem;"></i> <span class="d-md-none"></span>  </a>  </li>
</ul>
<div class="collapse navbar-collapse" id="navbar">
<div class="pb-1 mt-2 menudivider"></div>
    <ul class="navbar-nav m-0 p-0 ms-auto">
        <li class="nav-item m-3 mb-md-0 mt-md-0 me-md-3 pt-2" v-for="(d, index) in menus" :key="index"> <a href="/apps/"  class="text-dark">{{d['linkText']}} </a> </li>
    </ul>
    <ul class="navbar-nav m-0 p-0 ms-auto">
         <li class="nav-item"> <a href="/app/contactus" class="text-dark"> <i class="bi bi-question-circle" role="img" aria-label="Help" style="font-size: 1.6rem;"></i> <span class="d-md-none"></span>  </a>  </li>
    </ul>
</div>

</nav>
</div>
</div>
</div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="m-0 p-0">
          <slot></slot>
        </div>
      </div>
    </div>
  </div>

<!-- footer -->
<footer class="mt-5"></footer>
</div>
</template>


<script>
import appsettings from '/storage/settings/app.json'
export default {
  name: "auth_header",
        data(){
        return {
        settings: appsettings,
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
        submit: 'Create',
        submittxt:'Create',
        opacity:'',
        record:false,
        responseStatus: '',
        norecord: '',
        checked: true,
        ifUserHasAccess:true,
        surname: '',
        menus: []
        }
        },

        mounted(){
        
        },
        methods:{

        },

}
</script>