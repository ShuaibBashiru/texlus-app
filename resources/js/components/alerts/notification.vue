<template>
    <div>
    <div class="toast-container position-fixed top-0 toaster end-0 p-3" style="z-index: 999998;">
    <div class="toast toaster bg-primary text-white fade hide" data-bs-autohide="false" role="alert" id="alertPrimary" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-primary text-white">
            <strong class="me-auto"><i class="bi-info-circle"></i> <span v-if="alertTitle==undefined || alertTitle==''" v-html="setTitlePrimary"></span> <span v-else v-html="alertTitle"></span>  </strong>
            <small></small>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" v-html="alertMsg">
        </div>
    </div>

    <div class="toast toaster bg-success text-white fade hide" data-bs-autohide="false" role="alert" id="alertSuccess" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto"><i class="bi-info-circle"></i> <span v-if="alertTitle==undefined || alertTitle==''" v-html="setTitleSuccess"></span> <span v-else v-html="alertTitle"></span>  </strong>
            <small></small>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" v-html="alertMsg">
        </div>
    </div>

    <div class="toast toaster bg-info text-white fade hide" data-bs-autohide="false" role="alert" id="AlertInfo" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-info text-white">
            <strong class="me-auto"><i class="bi-info-circle"></i> <span v-if="alertTitle==undefined || alertTitle==''" v-html="setTitleInfo"></span> <span v-else v-html="alertTitle"></span>  </strong>
            <small></small>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" v-html="alertMsg">
        </div>
    </div>

    <div class="toast toaster bg-warning text-white fade hide" data-bs-autohide="false" role="alert" id="alertWarning" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-warning text-white">
            <strong class="me-auto"><i class="bi-info-circle"></i> <span v-if="alertTitle==undefined || alertTitle==''" v-html="setTitleWarning"></span> <span v-else v-html="alertTitle"></span>  </strong>

            <small></small>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" v-html="alertMsg">
        </div>
    </div>

    <div class="toast toaster bg-danger text-white fade hide" data-bs-autohide="false" role="alert" id="alertDanger" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-danger text-white">
            <strong class="me-auto"><i class="bi-info-circle"></i> <span v-if="alertTitle==undefined || alertTitle==''" v-html="setTitleDanger"></span> <span v-else v-html="alertTitle"></span>  </strong>
            <small></small>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" v-html="alertMsg">
        </div>
    </div>

    <div class="toast toaster bg-default text-dark fade hide" data-bs-autohide="false" role="alert" id="alertDefault" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-default text-dark">
            <strong class="me-auto"><i class="bi-info-circle"></i> <span v-if="alertTitle==undefined || alertTitle==''" v-html="setTitleDefault"></span> <span v-else v-html="alertTitle"></span>  </strong>
            <small></small>
            <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body" v-html="alertMsg">
        </div>
    </div>

    </div>

    </div>
</template>
<script>
export default {
    props: ['alertTitle', 'alertMsg'],
    name: 'notification',
data(){
  return{
    setTitlePrimary: 'Successful',
    setTitleSuccess: 'Successful',
    setTitleInfo: 'Message',
    setTitleWarning: 'Error!',
    setTitleDanger: 'Error!',
    setTitleDefault: 'Message',

  }

},
  methods: {
  }
}
</script>