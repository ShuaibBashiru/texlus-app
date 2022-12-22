<template>
<div class="">
<b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<flyout-backend-menu />
<flyout-notification />
<div class="container-fluid border-bottom backendheader shadow-sm p-0 pb-1 pt-1 m-0 p-0">
<div class="row p-0 m-0">
<div id="" class="col-md-2 col-3 m-0 p-0">
<nav class="navbar navbar-expand-lg p-0 m-0 ps-2 pb-1">
  <ul class="nav p-0 w-100">
        <li class="nav-item w-100"> <a class="navbar-brand siteStyle p-0 m-0" href="/app/dashboard">
        <img :src="settings.logo_link" class="logoSize rounded mt-1"  alt=""> <span class=""> 
          <span v-text="settings.site_name" class="pt-2"></span> </span> </a>  <i class="bi bi-list text-primary float-end d-none d-md-block" id="toggleHideBtn" style="font-size: 1.6rem; color: black;"></i> </li>
  </ul>
</nav>
</div>

<div class="col m-0 p-0">
<nav class="navbar navbar-expand-lg p-0 m-0 me-2">
<ul class="nav">
</ul>
<ul class="nav m-0 p-0 ms-auto align-items-center dropstart">
        <li class="nav-item" data-bs-toggle="offcanvas" data-bs-target="#messageFlyout" aria-controls="messageFlyout"><a href="#" class="nav-link p-1 pe-2 position-relative">
        <i class="bi bi-bell fs-4"></i>
        <span class="badge end-0 top-0 position-absolute rounded-pill bg-danger" v-text="countNotification">
        </span>
        </a></li>
        <li class="nav-item p-1 pe-2 text-capitalize"> <span v-text="displayName"></span> </li>
        <li class="nav-item dropdown"><a href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false" id="profileDrop" class="nav-link p-1 pe-1"><div class="dp-small"><img :src="userProfilePassport" alt=""></div></a>
         <ul class="dropdown-menu dropdown-menu-dark p-3" style="min-width:320px;" aria-labelledby="profileDrop" onclick="event.stopPropagation()">
            <li class="p-2">
                 <div class="text-center w-100">
                  <figure>
                     <img :src="userProfilePassport" class="rounded-circle" width="150" height="150" alt="Passport"> <br clear="all/">
                  </figure>
                    <p class="m-0 p-1 mb-1"><span v-text="usersession['lastname'] + ' ' + usersession['firstname'] +' '+ usersession['othername']"></span></p>
                    <p class="m-0 p-1 text-muted fs-6 border border-secondary rounded rounded-pill"><span v-text="usersession['email_one']"></span></p>
                </div>
            </li>
            <hr />
            <li class="p-2"><a class="dropdown-item" href="/app/account/profile"><i class="bi bi-person"></i> My Profile</a></li>
            <li class="p-2"><a class="dropdown-item" :href="'/app/account/manage/'+usersession['generated_id']"><i class="bi bi-gear"></i> Manage Account </a></li>
            <hr />
            <li class="text-center p-2"><a class="dropdown-item border border-secondary rounded rounded-pill" href="/app/logout"><i class="bi bi-power border-secondary rounded rounded-pill"></i> Log Out </a></li>
          </ul>
        </li>
        <li class="nav-item d-md-none" data-bs-toggle="offcanvas" data-bs-target="#sideBarFlyout" aria-controls="sideBarFlyout"> <a href="#" class="nav-link p-1 pe-0"><i class="bi bi-list text-primary" style="font-size: 1.6rem; color: black;"></i></a></li>

</ul>

</nav>


</div>
</div>
</div>
</div>
</template>

<script>
import appsettings from '/storage/settings/app.json'
export default {
    name: 'backend_header',
    data(){
        return {
        settings: appsettings,
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
        usersession: [],
        countNotification: 0,
        displayName: '',
        changes: '',
        userProfilePassport: '/assets/icons/avatar.png',
        sidebarMenu: [
        ],
     
        }
        },

  created(){
     this.getSessionData();
     this.sessionActivity();
     this.getPassport();

    },
    mounted(){
    this.userRecord();
    },
  methods:{
    getNotification: function(){
      if (localStorage.getItem('notificationNumber')!=0) {
        this.countNotification = 0;
        this.countNotification = localStorage.getItem('notificationNumber');
      }else{
        this.countNotification = 0;
      }
    },
    encodeData: function(data){
        var decode = btoa(btoa(data));
        return decode;
    },
    getPassport: function(){
      this.userProfilePassport = this.usersession['file_url'] ? this.usersession['file_url'] : this.userProfilePassport;
    },
    toggleMenu: function(){
      if (this.hideMenu == "d-none") {
            this.hideMenu = "";
      }else{
            this.hideMenu = "d-none";
      }
    },
    userRecord: function(){
      var name =  this.usersession['firstname'] ? this.usersession['firstname'] : 'Error!';
      this.displayName = name;
    },
     getSessionData: function(){
       try {
         if (this.$session.get('usersession')!=undefined && this.$session.get('usersession')!='') {
            this.usersession = this.$session.get('usersession')
            this.getNotification();
         }else{
            window.location.href='/app/logout?msg=something went wrong'
         }
          } catch (error) {
              window.location.href='/app/logout?msg=something went wrong'

          }
    },
    sessionActivity: function(){
      setInterval(function(){
      try {
      if(document.cookie.split(';').some((item)=>item.trim().startsWith('usercookie='))){
          return true;
      }else{
            window.location.href='/app/logout?msg=session expired'
          }
    } catch (error) {
            window.location.href='/app/logout?msg=something went wrong'
          }
      },3000)

        },
    }

}
</script>