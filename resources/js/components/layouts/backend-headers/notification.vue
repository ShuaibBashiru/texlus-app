<template>
<div class="">
<b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<div class="offcanvas offcanvas-end" tabindex="0" id="messageFlyout" aria-labelledby="messageFlyoutLabel">
<div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title" id="messageFlyoutLabel">Notifications <span class="badge position-relative rounded-pill bg-danger" v-text="info.length">
        </span></h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <div>
      <div class="row">
        <div class="col-md-12" v-if="info.length>0">
      <div class="accordion" id="accordionCollapseNotification">
        <div class="accordion-item" v-for="(d, index) in info" :key="index">
          <h2 class="accordion-header" :id="'headingNotification'+index">
            <button class="accordion-button collapsed shadow-none" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapseNotification'+index" aria-expanded="true" :aria-controls="'collapseNotification'+index" v-html="d.title">
            </button>
          </h2>
          <div :id="'collapseNotification'+index" class="accordion-collapse collapse" :aria-labelledby="'headingNotification'+index" data-bs-parent="#accordionCollapseNotification">
            <div class="accordion-body bg-primary text-light pb-4">
              <p class="" v-html="d.descriptions"></p>
              <p class="text-light float-end"><em class=""><small class="" v-html="d.date_created ? 'Posted: '+d.date_created : ''"></small></em></p>
            </div>
          </div>
        </div>
        </div>

        </div>
        <div class="col-md-12 mt-3" v-else>
          <p class="text-muted text-center">Your notification will appear hear if any.</p>
        </div>
        </div>


    </div>
</div>
</div>

</div>
</template>

<script>
import appsettings from '/storage/settings/app.json'
export default {
    name: 'notifications',
    data(){
        return {
        hideMenu: '',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        notification: '',
        info: [],
        progress: null,
        btntxt: '',
        button: '',
        record:false,
        responseStatus: '',
        errors: [],
        usersession: [],
        settings: appsettings,
        changes: '',
        menuList: [],
        parameters:{
            email_id: '',
        },
        }
        },

  created(){
      this.getSessionData();
      this.getList();
    },


  methods:{
  getSessionData: function(){
       try {
         if (this.$session.get('usersession')!=undefined && this.$session.get('usersession')!='') {
            this.usersession = this.$session.get('usersession')
            this.parameters.email_id = this.usersession['email_one']
         }else{
            this.alertMsg='Something went wrong! Please log out and log in again to continue.'
            $("#alertDanger").toast('show')
         }
          } catch (error) {
            this.alertMsg='Error connecting! Please log out and log in again to continue.'
            $("#alertDanger").toast('show')

          }
    },
     getList: function(){
            $(".toaster").toast('hide')
            axios.get('/api/notification/list', {params:this.parameters}).then(response => {
                this.errors = '';
                if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
                this.info = response['data'].data.info
                localStorage.setItem('notificationNumber', 0)
                localStorage.setItem('notificationNumber', this.info.length);
                }else if(response['data'].data.status=='norecord'){
                this.info = ''
                localStorage.setItem('notificationNumber', 0);
                }else{
                this.alertMsg='';
                }
            }).catch(error => {
                this.alertMsg=''
            })
        },
      


    }

}
</script>