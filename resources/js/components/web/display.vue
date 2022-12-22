<template>
<div class="">
<div class="container-fluid m-0 p-0 bg-light">
    <div class="row m-0">
    <div class="col-10 m-0 p-0 m-auto text-center">
       <img  onclick="location.href='/app/pos/portal'" src="/assets/images/banner.gif" class="img-fluid rounded" style="" alt="Image loading...">
    </div>
        </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'display',
    data (){
    return{
    alertTitle: '',
    alertMsg: '',
    showOverlay: false,
      slides: [
        {'img': '', 'title': '', 'tag':'', 'description': '', 'link': '', 'content': '', 'btntxt': ''},
        ],
    }
    }
}
</script>