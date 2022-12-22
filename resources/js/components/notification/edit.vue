<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<div class="container-fluid">
<div class="modal fade" id="editRecordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editRecordModalLabel" aria-hiden="true">
<div class="modal-dialog ps-md-3 pe-md-3">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" v-html="pageName"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<div class="container-fluid">
        <div class="row">
        <div class="col-md-5 ps-1">
        <div class="mt-1 mb-2">
             <h5 class="mt-2 ms-0 text-success">Create </h5>
        </div>
        </div>
</div>
<div class="row">
<div class="col-12 m-0 p-0">
    <div class="m-1 border rounded-3">
         <div class="row">
        <div class="col-md-12">
        <div class="alert m-1 alert-info border-0 p-1 ps-2 pe-2 m-3 mb-2 mt-2 text-center" role="alert" v-if="alertMsg!=''">
        <small class="" v-text="alertMsg"></small>
        </div>
        </div>
    </div>
    <div class="row">
    <div class="col-md-12">
        <div class="m-3 mt-1">
            <form @submit.prevent="validateForm" id="formChange">
                <p class="text-info text-center m-0 p-0 d-none" v-text="getId"></p>
            <div class="row">
    <div class="col-md-12 mt-1">
        <div class="m-1 mt-3">
                   <label for="title" class="text-muted">Title</label>
                <div class="input-group">
                    <input type="text" v-model="parameters.title" @keyup="oneSpace('title')" id="title" minlength="3" maxlength="200" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Enter here" :disabled="disabled">
                </div>
                <span class="text-danger" for="" v-if="errors.title && errors.title != ''"><small> <span v-text="errors.title[0]"></span> </small></span>
                </div>
  </div>
    <div class="col-md-12 mt-1">
    <div class="m-1 mt-3">
                <label for="descriptions" class="text-muted">Message</label>
            <div class="input-group">
                <textarea v-model="parameters.descriptions" @keyup="oneSpace('descriptions')" id="descriptions" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Enter here" :disabled="disabled"></textarea>
            </div>
            <span class="text-danger" for="" v-if="errors.descriptions && errors.descriptions != ''"><small> <span v-text="errors.descriptions[0]"></span> </small></span>
    </div>
  </div>
    <div class="col-md-12 mt-1">
        <div class="m-1 mt-3">
                   <label for="expire_date" class="text-muted">Expire date</label>
                <div class="input-group">
                    <input type="date" v-model="parameters.expire_date" @keyup="oneSpace('expire_date')" id="expire_date" minlength="3" maxlength="200" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Enter here" :disabled="disabled">
                </div>
                <span class="text-danger" for="" v-if="errors.expire_date && errors.expire_date != ''"><small> <span v-text="errors.expire_date[0]"></span> </small></span>
        </div>
  </div>
    <div class="col-md-12 mt-1">
    <div class="m-1 mt-3">
            <label for="recipientOption" class="text-muted">Recipient</label>
        <div class="input-group">
            <select v-model="recipientOption" @change="updateRecipient" @keyup="oneSpace('recipientOption')" id="recipientOption" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Enter here" :disabled="disabled">
                <option value="">Select</option>
                <option value="All">All</option>
                <option value="Recipient">Recipient ID</option>
                <option value="None">None</option>
            </select>
        </div>
        </div>
  </div>
      <div class="col-md-12 mt-1" v-if="recipientOption=='Recipient'">
        <div class="m-1 mt-3">
                   <label for="recipientname" class="text-muted">Recipient Email</label>
                <div class="input-group">
                    <input type="email" v-model="parameters.recipient" @keyup="oneSpace('recipient')" id="recipient" minlength="3" maxlength="200" class="shadow-none form-control form-control-md form-control-sm-lg" required placeholder="Enter here" :disabled="disabled">
                </div>
                <span class="text-danger" for="" v-if="errors.recipient && errors.recipient != ''"><small> <span v-text="errors.recipient[0]"></span> </small></span>
                </div>
  </div>
    <div class="col-md-12">
        <div class="m-1 mt-3">
        <button type="submit" class="btn btn-success shadow-none float-end ms-1"><i class="bi-save"></i> <span v-text="button"></span> </button>         
        <span v-if="validated" @click="cancelBtn" class="btn btn-danger float-end ms-1"><i class="bi-x fs-6"></i> Cancel  </span>         
        </div>
    </div>
    </div>
        </form>

        </div>
    </div>
        </div>
        </div>
        </div>
    </div>
</div>
      </div>
      </div>
      </div>
      </div>

<!-- New -->

</div>
    </div>


</template>

<script>
export default {
    name: 'Notification_Edit',
    props: ['recordId', 'timeInterval'],
    data (){
        return{
        pageName: 'Notification',
        error_message: '',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: [],
        button: 'Update',
        btntxt: 'Update',
        usersession: [],
        category_list: [],
        checked: true,
        isChecked: false,
        selectDefault: "Select",
        counter: '0',
        statuses: [],
        disabled: false,
        validated: false,
        formNote: '',
        genders: [],
        recipientOption: 'All',
        setTimeInterVal: '',
        parameters:{
            generated_id: '',
            title: '',
            descriptions: '',
            recipient: 'All',
            expire_date: '',

        },
        errors: [this.parameters],
        form_success: [],
    }
    },
    computed:{
        getId:function(){
            this.parameters.generated_id = this.recordId;
            this.setTimeInterVal = this.timeInterval;
            this.getRecord()
            return true;
        },
    },
   
    methods:{
    fillInputs: function(){
        this.parameters.title = this.info.title? this.info.title:''
        this.parameters.descriptions = this.info.descriptions? this.info.descriptions:''
        this.parameters.recipient = this.info.recipient? this.info.recipient:''
        this.parameters.expire_date = this.info.expire_date? this.info.expire_date:''
        this.recipientOption = this.info.recipient=='All'? 'All' : 'Recipient'
        
    },
    
    resetForm: function(){
        this.validated = false;
        this.disabled = false;
        for(var key in this.parameters){
            this.parameters[key]=''
        }
    },

  checkIfChanged: function(){
        var hasChanged = 0
        var nochange = 0
        var counter = 0
        for(var key in this.parameters){
            this.parameters[key] = this.parameters[key]==null? '': this.parameters[key]
            this.info[key] = this.info[key]==null? '': this.info[key]
            counter += 1
            if(typeof this.info[key] == 'undefined' || typeof this.parameters[key] == 'undefined'){
                nochange += 1
            }else{
                if (this.parameters[key].toString() != this.info[key].toString()) {
                    hasChanged += 1
                }else{
                    nochange += 1 
                }
            }

        }
        if(hasChanged > 0){
            return true;
        }else{
           return false;

        }
    },
    cancelBtn: function(){
            this.validated = false
            this.disabled = false
            this.button = this.btntxt
   },

    updateRecipient: function(){
        if(this.recipientOption == 'All'){
            this.parameters.recipient = "All"
        }else{
            this.parameters.recipient = ""
        }
   },
   validateForm: function(){
        this.errors = '';
        if(!this.checkIfChanged()) {
            this.validated = false
            this.disabled = false;
            this.alertMsg='You have not made any changes on this page.'
        }else if(this.validated && this.checkIfChanged()) {
            this.sendPost()
            this.validated = false
            this.disabled = false;
        }else if(!this.validated && this.checkIfChanged()){
            this.disabled = true;
            this.validated = true;
            this.button = "Continue";
        }else{
            this.validated = false
            this.disabled = false;
            this.alertMsg='Kindly complete the required field(s)'
        }

    },
    
    oneSpace: function(key){
            var string = this.parameters[key]
            var newString = string.replace(/^\s+|\s+$/gm, ' ')
            this.parameters[key] = newString
    },

    sendPost: function(){
        this.button='Please wait...';
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.alertMsg = '';
        const form = new FormData();
        for (var key in this.parameters){
        form.append(key, this.parameters[key])
        }
        axios.post('/notification/update', form).then(response => {
                this.button=this.btntxt;
                this.showOverlay=false;
                this.errors = '';
        if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
                this.deleted = true
                this.alertMsg=response['data'].data.msg;
                setTimeout(function(){
                  window.location.reload();
                }, 2000)
                }else if(response['data'].data.status=='failed'){
                this.alertMsg=response['data'].data.msg;
                }else{
                this.alertMsg=response['data'].data.msg;
                }

            }).catch(error => {
                    this.button=this.btntxt;
                    this.showOverlay=false;
                    this.errors = '';
                if(error.response != undefined && error.response.status==422){
                    this.errors = error.response.data.errors;
                    this.alertMsg='Something went wrong! Kindly confirm and try again.'
                } else if(error.response != undefined && error.response.status==419){
                    this.alertMsg='This page has been inactive for long, Kindly refresh and try again.';
                }else if(error.response != undefined && error.response.status==500){
                    this.alertMsg='Internal server error! Please refresh and try again or report this error.';
                }else{
                    this.alertMsg='Access restricted or Network error! Please refresh and try again or report this error.';
                }
            })
        },

    getRecord: function(){
    if (this.parameters.generated_id != ''){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        axios.get('/notification/record/'+this.parameters.generated_id).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
            this.info = response['data'].data.info
            this.error_message='';
            this.fillInputs();
            $("#editRecordModal").modal('show')
            }else if(response['data'].data.status=='norecord'){
            this.info = ''
            this.error_message=response['data'].data.msg;
            }else{
            this.error_message=response['data'].data.msg;
            }
        }).catch(error => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            this.error_message='Something went wrong! Please refresh and try again or report this error.'
        })
        }
    },


    },


    }
</script>