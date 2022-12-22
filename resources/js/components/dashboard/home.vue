<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />
    <a href="#" id="topLink"></a>
  <div class="container-fluid">
    <server-alert :server_message="server_message" />

    <div class="row">
        <div class="col-md-12 content">
           <div class="row">
            <div class="col-md">
            <h5 class="ms-0 text-primary"> <i class="bi bi-bar-chart-line"></i> Dashboard</h5>
            </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-12 mb-1 text-left">
                  <h5 class="mt-1">Welcome, <span class="text-muted" v-html="usersession['firstname']">!</span></h5>
              </div>
            </div>

            <hr class="mt-1"/>
            
      <!-- Chart -->
      <div class="row mt-3">
            <div class="col-md-12">
              <!-- Chart component here -->
                    <sales-chart-daily />
            </div>
            </div>
            
      <!-- Chart -->
      <div class="row mt-3">
            <div class="col-md-12">
              <!-- Chart component here -->
                    <sales-chart />
            </div>
            </div>

        <div class="row mt-3">
            <div class="col-md-12">
              <!-- Chart component here -->
                    <user-chart />
            </div>
            </div>


        <div class="row mt-3">
            <div class="col-md-12">
              <!-- Chart component here -->
                    <admin-chart />
            </div>
            </div>
    </div>
          <!-- End content -->
     </div>
    </div>
</div>
</template>

<style scoped>

</style>

<script>
export default {
  name: 'account_dashboard',
  props: ['server_message'],
  data (){
    return{
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: [],
        progress: null,
        btntxt: 'Log in',
        button: 'Log in',
        errors: [],
        usersession: [],
        dashboardItems: [
        ],
    }
  },

  created(){
    this.setSession()
  },
  mounted(){
  },
  methods:{
    setSession: function(){
       try {
         if (this.$session.get('usersession')!=undefined && this.$session.get('usersession')!='') {
            this.usersession = this.$session.get('usersession')
         }else{
            this.alertMsg='Something went wrong!. Please log out and log in to continue.'
            $("#alertDanger").toast('show')

         }
          } catch (error) {
            this.alertMsg='Error connecting!. Please log out and log in to continue.'
            $("#alertDanger").toast('show')

          }
    },


},


    }
</script>