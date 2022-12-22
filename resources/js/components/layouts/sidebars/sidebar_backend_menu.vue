<template>
<div class="">
        <div class="container-fluid">
        <div class="row">
        <div id="togglePanel_1" class="col-2 mt-5 sidebar border-end p-0">
        <div class="wrapper pt-1 mt-2">
        <div class="row">
        <div class="col-md-12">

    <div class="accordion accordion-flush" id="accordionCollapseMenu">
    <div class="accordion-item p-3">
          <a href="/" class="" target="_blank"><i class="bi bi-globe"></i> <span class="toggleHide ps-1"> Visit site </span> </a>
      </div>

      <div class="accordion-item" v-for="(d, index) in menuList" :key="index">
        <h2 class="accordion-header" :id="'headingMenu'+index">
          <button class="accordion-button collapsed shadow-none ms-0 ps-3 pe-2" type="button" data-bs-toggle="collapse" :data-bs-target="'#collapseMenu'+index" aria-expanded="true" :aria-controls="'collapse'+index">
          <i :class="d.icon+' me-2'"></i> <span class="toggleHide" v-html="d.title"></span>
          </button>
        </h2>
        <div :id="'collapseMenu'+index" class="accordion-collapse collapse" :aria-labelledby="'headingMenu'+index" data-bs-parent="#accordionCollapseMenu">
          <div class="accordion-body toggleHide">
          <ul class="btn-toggle-nav list-unstyled fw-normal p-0 m-0 small" v-for="(d, index) in d.info" :key="index">
                <li class="p-0 m-0"> <a class="link-dark nav-link" :href="'/'+d.linkName" :target="d.link_target"><i class="bi bi-link"></i> <span v-text="d.menuName"></span>  </a></li>
              </ul>
          </div>
        </div>
      </div>

    <div class="accordion-item p-3">
          <a href="/app/logout" class=""><i class="bi bi-power"></i> <span class="toggleHide"> Log out </span> </a>
      </div>
      </div>

        </div>
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
    name: 'sidebar_backend',
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
        sidebarMenu: [
          // Sample
          {'id': 1, 'title':'Account', 'info': [{'id':2, 'menuName': 'My profile', 'linkName': 'account/profile'}, {'id':2, 'menuName': 'Sign out', 'linkName': 'logout'}], 'tag':'', 'description':'', 'img':'', 'link':'', 'linkText':'', 'content':'', 'icon':'bi bi-person-circle', 'target':''},
        ],
     
        }
        },

  created(){
     this.getSessionData();
     this.getMenus();

    },

  methods:{
   getSessionData: function(){
       try {
         if (this.$session.get('usersession')!=undefined && this.$session.get('usersession')!='') {
            this.usersession = this.$session.get('usersession')
         }else{
            this.alertMsg='Something went wrong! Please log out and log in again to continue.'
            $("#alertDanger").toast('show')
         }
          } catch (error) {
            this.alertMsg='Error connecting! Please log out and log in again to continue.'
            $("#alertDanger").toast('show')

          }
    },

     getMenus: function(){
            $(".toaster").toast('hide')
            this.showOverlay=true;
            axios.get('/adminmenu/menulist', {params:this.parameters}).then(response => {
                this.showOverlay=false;
                this.errors = '';
                if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
                this.menuList = response['data'].data.info
                this.sortMenus();
                }else if(response['data'].data.status=='norecord'){
                this.menuList = ''
                }else{
                this.alertMsg='';
                }
            }).catch(error => {
                this.showOverlay=false;
                this.alertMsg=''
            })
        },
        
        sortMenus: function(){
        const menu_group = _.groupBy(this.menuList, menuList => menuList.group_name);
        var menuList = [];
        var counter = 0;
        for(var key in menu_group){
          counter += 1;
          var subList = [];
          let group_icon = '';
          for(let i=0; i < menu_group[key].length; i++){
            group_icon = menu_group[key][i].group_icon;
            if (menu_group[key][i].group_name===key) {
            var temPSubList = [{'id':i, 'menuName': menu_group[key][i].menu_title, 
            'linkName': menu_group[key][i].routeLink, 'target': menu_group[key][i].link_target}]
            subList.push(temPSubList[0])
            }
          }
          var list = [{'id': counter, 'title': key, 'info': subList, 'icon': group_icon}]
          menuList.push(list[0]);
          subList = [];
          this.menuList = menuList

          }

        },

    }

}
</script>