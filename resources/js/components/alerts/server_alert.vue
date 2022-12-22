<template>
    <div>
<section v-if="server_message">
      <div class="row">
            <div class="col-md-12" v-if="server_message.type='error' && server_message.info!=''">
            <div class="alert text-center alert-danger pt-2 pb-2 border-0 alert-dismissible fade show" role="alert">
            <span class="" v-html="server_message.info"></span>
            <span type="button" class="btn-close pt-1" data-bs-dismiss="alert" aria-label="Close"></span>
            </div>
            </div>
            <div class="col-md-12" v-else-if="server_message.type='info' && server_message.info!=''">
            <div class="alert text-center alert-info pt-2 pb-2 border-0 alert-dismissible fade show" role="alert">
            <span class="" v-html="server_message.info"></span>
            <span type="button" class="btn-close pt-1" data-bs-dismiss="alert" aria-label="Close"></span>
            </div>
            </div>
            <div class="col-md-12" v-else-if="server_message.type='success' && server_message.info!=''">
            <div class="alert text-center alert-primary pt-2 pb-2 border-0 alert-dismissible fade show" role="alert">
            <span class="" v-html="server_message.info"></span>
            <span type="button" class="btn-close pt-1" data-bs-dismiss="alert" aria-label="Close"></span>
            </div>
            </div>
            <div v-else></div>
      </div>
</section>
 
    </div>
</template>
<script>
export default {
    name: 'server-alert',
    props: ['server_message']
}
</script>