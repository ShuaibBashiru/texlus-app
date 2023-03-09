<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
      <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />   

<div class="modal fade" id="UserAttachmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="UserAttachmentModalLabel" aria-hiden="true">
<div class="modal-dialog ps-md-5 pe-md-5">
    <div class="modal-content bg-dark text-white">
      <div class="modal-body mt-0 p-3 pt-2">
       <div class="row mt-0 p-0">
        <div class="col-2 p-0 ps-2"><i class="bi bi-file-fill fs-3 p-0 m-0"></i></div>
        <div class="col-8"><p class="text-center pt-2 fs-5">Attachments</p></div>
        <div class="col-2 pt-1 pe-0"><i class="bi bi-x fs-3 p-0 m-0 float-end" data-bs-dismiss="modal" role="button" title="Close"></i></div>
       </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <h4 class="lead">Warning!</h4>
          <p class="p-1 m-0 text-muted"><small>Upload an attachment not greater than 500kb in size. Only PNG, JPG, PDF file formats are allowed.</small></p>
        </div>
      </div>
          <hr class="m-1" />
      <div class="row mt-3">
        <div class="col">
          <div class="m-1">
            <p class="" v-text="selectedFile.name"></p>
            <div class="progress" v-if="selectedFile.name">
            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>
            <!-- <div class="passport-dp rounded-circle m-auto" style="width:220px; height:220px;">
             <img :src="userProfilePassport" class="rounded-circle" style="width:220px; height:220px;" alt=" ">
          </div> -->
          </div>
        </div>
        <div class="col-12 text-center">
          <div class="m-1 mt-1">
            <div class="input-group">
                <input type="file" id="fileAttach" @change="onFileSelected" class="form-control shadow-none d-none" accept=".png, .jpg, .webp, .gif" required>
            </div>
            <span class="text-danger" for="" v-if="errors.upload_file && errors.upload_file != ''"><small> <i class="bi bi-x-circle-fill"></i> <span v-text="errors.upload_file[0]"></span> </small></span>
          </div>
      </div>
      </div>
        <div class="row">
        <div class="col-md-12">
          <div class="alert alert-info border-0 p-1 ps-2 pe-2 text-center" role="alert" v-if="alertMsg!=''">
            <small class="" v-text="alertMsg"></small>
          </div>
        </div>
      </div>
      <hr />
      <div class="row">
        <div class="col-md-12">
       <label for="fileAttach" class="btn btn-secondary float-start"><i class="bi bi-image"></i> Choose file </label> 
        <button type="button" class="btn btn-success float-end" @click="validateFile" :disabled="disabled"> <i class="bi bi-save"></i> <span v-text="button"></span> </button>
      </div>
      </div>
      </div>
       
    </div>
  </div>
</div>    

<div class="container-fluid p-0">
    <server-alert :server_message="server_message" />
        <div class="row">
        <div class="col-md-5">
        <div class="mt-1 mb-2">
            <h5 class="mt-2 ms-0 text-muted"> <i class="bi bi-file"></i> <span v-text="pageName"></span></h5>
        </div>
        </div>
        <div class="col-md-7 d-flex justify-content-end dropdown">
        <div class="mt-1 mb-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#UserAttachmentModal">New <i class="bi bi-plus-circle"></i></button>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="bi bi-chevron-double-down"></i></button>
        <div class="dropdown-menu w-75 mt-0 pt-0" style="width: 200px !important;">
        <ul class="list-unstyled pb-1 border-bottom" onclick="event.stopPropagation()">
        <li class="mb-2">
        <p class="align-items-center ps-2 p-1 mb-0 collapsed dropdown-item" data-bs-toggle="collapse" data-bs-display="static" data-bs-target="#drop3" aria-expanded="false">
        <i class="bi bi-list-task me-1"></i> <span>Number of rows</span></p>
        <div class="collapse" id="drop3">
        <ul class="btn-toggle-nav ms-2 list-unstyled fw-normal pb-1 small">
        <li class="p-1">
            <select v-model="rowSelected" class="form-control shadow-none" @change="rowsToDisplay">
                <option value="" selected>Show</option>
                <option value="10">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="1000">1000</option>
                <option :value="info.length">All</option>
            </select>
        </li>
        </ul>
        </div>
        </li>

    </ul>
    
  </div>
  
</div>
</div>

</div>

<div class="row mt-2">
    <div class="col-md-12">
<div class="border p-2 rounded">
    <div class="input-group">
    <section v-if="search!=''" class="input-group-text"> <span v-text="info.length"></span> &nbsp; Result(s) </section>
    <input type="text" class="form-control shadow-none" @keyup="onSearch" placeholder="Enter your search here" v-model="search" :disabled="disabled">
    <span class="input-group-text" @click="clearSearch"> <i class="bi bi-x"></i> </span>
    </div>
</div>
</div>
</div>

    <section v-if="info.length > 0">
    <div class="row mt-1">
    <div class="col-md-12">
       <div class="row m-0 p-0 mt-2">
        <div class="col-6 m-0 p-0"><div class="m-1">
            <span class="fs-6" v-text="parameters.selectedList.length"></span>
                <span> Selected </span>
            </div></div>
        <div class="col-6 m-0 p-0">
                <div class="m-1 me-0 float-end">
                <button class="btn bi bi-chevron-left fw-bolder shadow-none ps-0" title="Show previous" @click="showLess" :disabled="startNumber==0? true : false">  </button>
                <span class="fs-6" v-text="(startNumber+1) + '-' + (endNumber>info.length? info.length:endNumber)"></span>
                <span> of </span>
                <span class="fs-6" v-text="totalRecord.length"></span>
                <button class="btn bi bi-chevron-right fw-bolder shadow-none pe-0" title="Show next" @click="showMore" :disabled="endNumber < info.length? false : true">  </button>
                </div>
        </div>
    </div>
    <div class="table-responsive">
    <table class="table table-hover table-bordered" id="listTable">
        <thead>
        <tr>
            <th scope="col-1" class="text-center"> <input type="checkbox" name="checkAll" v-model="selectToggleValue" @click="selectToggle"> </th>
            <th scope="col" class="text-truncate" @click="sortOrder('date_created')"> Title </th>
            <th scope="col" class="text-truncate" @click="sortOrder('date_created')"> Date Created </th>
            <th scope="col" class="text-truncate text-center" title="Action"> Trash </th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="(d, index) in info.slice(startNumber, endNumber)" :key="index">
            <td class="col-1 text-center"><input type="checkbox" id="" :value="d.generated_id" v-model="parameters.selectedList" name="checkbox" @change="checkBoxOnChange"></td>
            <td class=""><span class="" v-text="d.createdByName"></span></td>
            <td class=""><span class="" v-text="d.createdByName"></span></td>
            <td class="text-center">
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash text-light"></i></button>
            </td>
        </tr>
            
        </tbody>
    </table>
    </div>
    </div>
    </div>
</section>

<section v-else>
<div class="row">
<div class="col-md-6 m-auto">
     <p class="mt-2 text-center text-muted fs-5" v-html="responseStatus">  </p>
</div>
</div>
</section>
    </div>
</div>
</template>

<script>
import * as XLSX from 'xlsx';
export default {
    name: 'user_attachment',
   props: ['server_message', 'server_record'],
    data (){
        return{
        pageName: 'Attachments',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        notification: '',
        info: this.server_record,
        startNumber: 0,
        endNumber: 10,
        maximumRow: 10,
        rowSelected: '',
        totalRecord: [],
        search: '',
        progress: null,
        button: 'Save',
        btntxt: 'Save',
        record:false,
        responseStatus: '',
        usersession: [],
        category_list: [],
        progress: '0%',
        selectedFile: '',
        disabled: true,
        validated: false,
        errors: [],
        form_success: [],
        userProfilePassport: '/assets/icons/avatar.png',
        parameters:{
            categoryId: 1,
            upload_file: '',
            personal_id: '',
            selectedList: [],
            status: '',
        },
      }
    },

    created(){
    this.getRecords()
    },

    computed:{

    },
    mounted(){

    },
        
    methods:{
    encodeData: function(data){
        var decode = btoa(btoa(data));
        return decode;
    },
    exportToExcel: function(){
            if (this.info.length > 0) {
            var pageName = this.pageName
            var ext = '.xlsx'
            var upload_file = pageName+ext
            var d = new Date()
            upload_file = d.toDateString()+'_'+d.toLocaleTimeString()+'_'+upload_file
            var info = this.info
            for (let index = 0; index < info.length; index++) {
                delete info[index].generated_id
            }
            var worksheet = XLSX.utils.json_to_sheet(info)
            var workbook = XLSX.utils.book_new()
            XLSX.utils.book_append_sheet(workbook, worksheet, "Records")
            XLSX.writeFile(workbook, upload_file)
            }else{
            $("#alertDanger").toast('show')
            this.alertMsg = 'Empty record cannot be exported.'
            }
        },

    selectToggle: function(){
    var checkboxes = document.getElementsByName('checkbox');
    if(this.selectToggleValue == false){
        var newlist=[]
        $(checkboxes).each(function() {
            this.checked = true;
            newlist.push(this.value)                        
        });
        this.parameters.selectedList = newlist
    }else{
        $(checkboxes).each(function() {
            this.checked = false;
        });
        this.parameters.selectedList = []
      }
          },

    checkBoxOnChange: function(){
        if (this.parameters.selectedList.length < this.info.length) {
        this.selectToggleValue = false
        }else{
        this.selectToggleValue = true
        }
    },

    clearSearch: function(){
        this.search = ''
        this.info = this.totalRecord
        },
        
    sortOrder: function(column){
    try {
            this.info.sort((a, b) =>{
            let s1 = a[column].toString().toLowerCase()
            let s2 = b[column].toString().toLowerCase()
            return s1.localeCompare(s2);
        })
        } catch (error) {
            this.info = this.totalRecord
        }
        },

    onSearch: function(){
        try {
            this.unselectAll();
            this.startNumber = 0
            this.endNumber = parseInt(this.maximumRow)
            var newRecord = []
       for (let i = 0; i < this.totalRecord.length; i++) {
           if (
               this.totalRecord[i].personal_id.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1 ||
               this.totalRecord[i].lastname.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1 ||
               this.totalRecord[i].firstname.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1 ||
               this.totalRecord[i].othername.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1 ||
               this.totalRecord[i].email_one.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1 ||
               this.totalRecord[i].phone_one.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1 ||
               this.totalRecord[i].updated_at.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1
               ){
            newRecord.push(this.totalRecord[i]);
           }
       }
        this.info = newRecord
        this.startNumber = 0
        this.endNumber = parseInt(this.maximumRow)
        } catch (error) {
            this.info = this.totalRecord
        }
        },
    unselectAll: function(){
        this.parameters.selectedList = []
        this.selectToggleValue = false
        $(document.getElementsByName('checkbox')).each(function() {
        this.checked = false;
        });
    },
    rowsToDisplay: function(){
        if (this.rowSelected != '') {
        this.endNumber = parseInt(this.rowSelected)
        this.maximumRow = parseInt(this.rowSelected)
        }else{
        this.endNumber = 20
        this.maximumRow = 20
        }
        this.unselectAll();
    },
    showMore: function(){
        this.unselectAll();
        if ((this.info.length - this.endNumber) >= parseInt(this.maximumRow)) {
            this.startNumber = parseInt(this.startNumber) + parseInt(this.maximumRow)
            this.endNumber = parseInt(this.endNumber) + parseInt(this.maximumRow)
        }else if((this.info.length - this.endNumber) < parseInt(this.maximumRow) && (this.info.length - this.endNumber) > 0){
            var getRemain = this.info.length - this.endNumber
            this.startNumber = parseInt(this.startNumber-1) + (parseInt(this.maximumRow))
            this.endNumber = parseInt(this.endNumber) + getRemain
        }else{
           return false;
        }
    },

    showLess: function(){
        this.unselectAll();
        if(this.startNumber >= parseInt(this.maximumRow)) {
            this.startNumber = parseInt(this.startNumber) - parseInt(parseInt(this.maximumRow))
            this.endNumber = parseInt(this.endNumber) - parseInt(parseInt(this.maximumRow))
        }else{
            this.startNumber = 0
            this.endNumber = parseInt(this.maximumRow)
        }

    },

    getRecords: function(){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.search = ''
        axios.get('/user/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.info = response['data'].data.info
            this.totalRecord = response['data'].data.info
            this.selectToggleValue = false
            this.parameters.selectedList = []
            }else if(response['data'].data.status=='norecord'){
            this.responseStatus = response['data'].data.msg
            this.info = ''
            this.alertMsg=''
            }else{
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
            }
        }).catch(error => {
                this.button=this.btntxt;
                this.showOverlay=false;
                this.errors = '';
            if(error.response != undefined && error.response.status==422){
                this.errors = error.response.data.errors;
                this.alertMsg='Something went wrong! Kindly confirm and correct the error(s) before you continue.'
            $("#alertDanger").toast('show')
            } else if(error.response != undefined && error.response.status==419){
                this.alertMsg='This page has been inactive for long, Kindly refresh and try again.';
            $("#alertDanger").toast('show')
            }else if(error.response != undefined && error.response.status==500){
                this.alertMsg='Internal server error! Please refresh and try again or report this error.';
            $("#alertDanger").toast('show')
            }else{
                this.alertMsg='Access restricted or Network error! Please refresh and try again or report this error.';
            $("#alertDanger").toast('show')
            }
        })
    },

    getStatus: function(){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        axios.get('/api/status/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
            this.statuses = response['data'].data.info
            }else if(response['data'].data.status=='norecord'){
            this.statuses = ''
            this.alertMsg=''
            }else{
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
            }
        }).catch(error => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            this.alertMsg='Something went wrong! Please refresh and try again or report this error.'
            $("#alertDanger").toast('show')
        })
    },

       onFileSelected: function(event){
          try {
            this.errors = '';
            this.alertMsg = '';
            this.selectedFile = event.target.files[0];
            this.userProfilePassport = URL.createObjectURL(event.target.files[0]);
            this.disabled = this.userProfilePassport==''? true:false
          } catch (error) {
            this.selectedFile = '';
            this.disabled = this.userProfilePassport==''? true:false
            return false
          }
        },

    validateFile: function(){
          if(this.selectedFile==''){
            this.alertMsg='Please select a valid file'
          }else{
            this.sendPost()
          }
        },

      sendPost: function(){
        this.button='Please wait...';
        this.showOverlay=true;
        this.alertMsg = '';
        const form = new FormData();
        for (var key in this.parameters){
        form.append(key, this.parameters[key])
        }
        form.append('upload_file', this.selectedFile, this.selectedFile.name)
        axios.post('/user/passport', form).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            this.disabled = true;
            setTimeout(function(){
                  window.location.reload()
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
                this.alertMsg='Something went wrong! Kindly confirm and correct the error(s) before you continue.';
            } else if(error.response != undefined && error.response.status==419){
                this.alertMsg='This page has been inactive for long, Kindly refresh and try again.';
            }else if(error.response != undefined && error.response.status==500){
                this.alertMsg='Internal server error! Please refresh and try again or report this error.';
            }else{
                this.alertMsg='Access restricted or Network error! Please refresh and try again or report this error.';
            }
        })
    },



    },


    }
</script>