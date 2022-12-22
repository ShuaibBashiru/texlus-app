<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
      <notification :alertTitle="alertTitle" :alertMsg="alertMsg" /> 
<div class="container-fluid menuheader pb-2 p-0 pb-1 pt-1 m-0 p-0" style="border-top:3px solid #0e6efd; border-bottom:1px solid #eee;">
<div class="row p-0 m-0 mt-2 ps-md-1 pe-md-1">
<div class="col-md-12">
<nav class="navbar navbar-expand-lg p-0">
<a class="navbar-brand p-0 m-0 me-3 ms-md-2" style="" href="/"><img :src="settings.logo_link" :width="settings.logoWidth" :height="settings.logoHeight" class="logoSize rounded" alt="logo"> <span v-html="settings.site_name"></span> </a>

<ul class="nav m-0 p-0 ms-auto">
<li class="nav-item navbar-toggler me-0 pe-2" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<i class="bi bi-list" style="font-size: 1.8rem; color: black;"></i> </li>
</ul>

<div class="collapse navbar-collapse" id="navbar">
<div class="pb-1 mt-2 menudivider"></div>
    <ul class="navbar-nav m-0 p-0 ms-auto">
        <li class="nav-item size-14 p-2"> <a href="/courses-pricing" class="text-dark linkUnderlineHover"> COURSES & PRICING </a> </li>
        <li class="nav-item size-14 p-2"> <a href="/help" class="text-dark linkUnderlineHover">  <i class="bi bi-question-circle" role="button" aria-label="Help"></i> Help </a> </li>
    </ul>
</div>

</nav>
</div>

<div class="col-md-12">
<nav class="navbar navbar-expand-lg p-0">
<div class="collapse navbar-collapse" id="navbar">
<div class="pb-1 mt-2 menudivider"></div>
    <ul class="navbar-nav m-0 p-0 ms-2">
        <li class="nav-item m-0 p-2 btn-group fade-link">
            <a href="/aboutus" class="linkUnderlineHover text-dark me-2"> <span> About Us </span> </a>
        </li>
        <li class="nav-item m-0 p-2 btn-group" v-for="(d, index) in menuList" :key="index">
            <a href="#" class="linkUnderlineHover text-dark me-2" data-bs-toggle="dropdown" :data-bs-target="'#c'+d.id" aria-expanded="false"> 
            <span v-text="d.title"></span> 
             <i class="bi bi-chevron-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-width border fade ps-3 pe-3 p-2 bg-light shadow" :id="'c'+d.id">
            <ul class="btn-toggle-nav list-unstyled p-0 m-0">
            <li class="nav-item border-bottom mt-2" v-for="(d, index) in d.info" :key="index"> 
                <a class="link-dark nav-link linkHover" :href="d.linkName" :target="d.link_target">
                    <h6 class=""> <span class="bi bi-link"> </span> <span v-text="d.menuName"></span></h6>
                <p class="mt-0 pt-0 mb-0 text-muted"><small v-html="d.descriptions"></small></p>
                </a>
            </li>
            </ul>
            </div>
        </li>
        
        <li class="nav-item m-0 p-2 btn-group me-3 fade-link">
            <a href="/contactus" class="linkUnderlineHover text-dark me-2"> <span> Contact Us </span> </a>
        </li>
    </ul>

    <ul class="navbar-nav m-0 p-0 ms-auto">
        <li class="nav-item m-0 p-2"> <a href="/app/signup" class="btn btn-primary"> <span class="size-13">CREATE AN ACCOUNT</span> </a> </li>
        <li class="nav-item m-0 p-2"> <a href="/signin" class="btn btn-outline-primary"> <span class="size-13">SIGN IN</span> </a> </li>
    </ul>
</div>


</nav>
</div>

</div>

</div>

</div>
</template>


<script>
import appsettings from '/storage/settings/app.json'
export default {
  name: "menu_header",
  props: ['server_message'],
        data(){
        return {
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        notification: '',
        info: [],
        progress: null,
        btntxt: 'Log in',
        button: 'Log in',
        record: false,
        errors: [],
        settings: appsettings,
        menuList: [
        ]
        }
        },

        mounted(){
        this.getMenus();
        },
        methods:{
        getMenus: function(){
            $(".toaster").toast('hide')
            axios.get('/api/menu', {params:this.parameters}).then(response => {
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
            'linkName': menu_group[key][i].routeLink, 'descriptions': menu_group[key][i].descriptions, 'target': menu_group[key][i].link_target}]
            subList.push(temPSubList[0])
            }
          }
          var list = [{'id': counter, 'title': key, 'info': subList, 'icon': group_icon}]
          menuList.push(list[0]);
          subList = [];
          this.menuList = menuList

          }

        },

        },

}
</script>