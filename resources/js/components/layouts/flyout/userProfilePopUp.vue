<template>
<div class="">

<div class="modal fade" id="profilePopUp" data-bs-keyboard="false" tabindex="-1" aria-labelledby="profilePopUpLabel" aria-hidden="true">
  <div class="modal-dialog float-end me-3">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profilePopUpLabel">Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="row">
        <div class="col-3">
            <img :src="userProfilePassport" class="rounded-circle grow border" width="80" height="80" alt="Passport">
        </div>
        <div class="col-9 pt-3 ps-4">
          <h6 class="mb-0 pb-0"><span v-text="usersession['lastname'] + ' ' + usersession['firstname'] +' '+ usersession['othername']"></span> </h6>
          <p class="mt-0 pt-0 text-muted"> <small v-text="usersession['email_one']"> </small> </p>
        </div>
        </div>
        <div class="row">
        <div class="col-md-12 mt-3">
           <a :href="'/app/account/manage/'+usersession['generated_id']"><p class="p-1 border text-center border-secondary rounded rounded-pill">Manage your account</p></a>
        </div>
        <div class="col-12">
           <div class="list-group">
                 <a href="/app/account/profile" class="list-group-item text-muted list-group-item-action"> <i class="bi bi-person pe-2"></i> My Profile </a>
            </div>
        </div>
       </div>
      </div>
      <div class="modal-footer">
            <a href="/app/logout" class="float-start text-muted mr-auto text-nowrap"> <i class="bi bi-power pe-2"></i> Sign out </a>
      </div>
    </div>
  </div>
</div>


</div>
</template>

<script>

export default {
    name: 'adminProfilePopUp',
    data(){
        return {
        settings: '',
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
    this.getAppSettings();
     this.getSessionData();
     this.sessionActivity();
     this.getPassport();

    },
    mounted(){
    this.userRecord();
    },
  methods:{
    getAppSettings: function(){
        fetch('/storage/settings/app.json')
        .then((response) => response.json())
        .then((data) => {
           this.settings = data;
        });
    },
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