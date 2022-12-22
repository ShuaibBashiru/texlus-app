<template>
    <div>
<section v-if="message">
      <div class="row">
            <div class="col-md-12">
            <div class="alert text-center alert-danger pt-2 pb-2 border-0 alert-dismissible fade show" role="alert">
            <span class="" v-html="message"></span>
            </div>
            </div>
      </div>
</section>
 
    </div>
</template>
<script>
export default {
    name: 'error-alert',
    props: ['message'],

}
</script>