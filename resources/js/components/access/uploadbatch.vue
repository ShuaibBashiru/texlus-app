<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />        
<div class="container-fluid">
    <a href="#" id="topLink"></a>
            <div class="row">
            <div class="col-md-6">
            <div class="mt-1 mb-2">
            <h5 class="mt-2 ms-0 text-dark"> <span v-text="pageName" onclick="history.back()" role="button"></span>  <span class="text-muted bi bi-chevron-right"> Upload</span> </h5>
            </div>
            </div>
            <div class="col-md-6 d-flex justify-content-end dropdown">
            <div class="mt-1 mb-2">
            <button type="button" class="btn btn-outline-primary" onclick="location.href='list'" title="Go to records">Records</button>
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
            <ul class="list-group list-group-horizontal-md" style="cursor:pointer;">
            <li class="list-group-item flex-fill" title="Preview" @click="getTotalRecord()"> <a href="#myTable">File Record(s) <span class="badge bg-primary rounded-pill float-end" v-text="totalRecord.length>0 ? totalRecord.length : 0"></span> </a></li>
            <li class="list-group-item flex-fill" title="Preview" @click="getSuccessfulRecord()"><a href="#myTable">Successfully uploaded <span class="badge bg-success rounded-pill float-end" v-text="successfulRecord.length>0 ? successfulRecord.length : 0"></span> </a></li>
            <li class="list-group-item flex-fill" title="Preview" @click="getExistRecord()"><a href="#myTable">Existing record(s) <span class="badge bg-warning rounded-pill float-end" v-text="existRecord.length>0 ? existRecord.length : 0"></span> </a></li>
            <li class="list-group-item flex-fill" title="Preview" @click="getFailedRecord()"><a href="#myTable">Failed to upload <span class="badge bg-danger rounded-pill float-end" v-text="failedRecord.length>0 ? failedRecord.length : 0"></span> </a></li>
            <li class="list-group-item flex-fill" title="Preview" @click="getNoRecord()"><a href="#myTable">Invalid IDs <span class="badge bg-danger rounded-pill float-end" v-text="noRecord.length>0 ? noRecord.length : 0"></span> </a></li> 
            </ul>
            </div>
            </div>

    <div class="border mt-2 rounded">
    <div class="row">
    <div class="col-md">
        <div class="m-1">
         <p class="mb-0"><small class="p-1 m-0">You have selected <span v-text="toUpload.length"></span> record(s)</small></p>
        </div>
    </div>
    <div class="col-md-5">
        <div class="m-1 ms-2 float-end">
        </div>
    </div>
    </div>

<div class="row mt-2">
<div class="col-md-12">
    <div class="p-2">
                <form @submit.prevent="validateForm">
            <fieldset class="border p-2 pt-0">
                <legend class="w-auto" style="float: none; padding: inherit;"></legend>
            <div class="row">
<!--     
      <div class="col-md-6">
                <div class="m-1 mt-3">
                <div class="input-group">
                 <span class="input-group-text"> <i class="bi bi-card-text"></i> </span>
            <select v-model="parameters.group_id" class="form-control shadow-none" required>
                <option value="" selected>Select category</option>
                <option v-for="(d, index) in category_list" :value="d.id" :key="index" v-text="d.group_name"></option>
            </select>
        </div>
        </div>
        </div> -->

        <div class="col-md-12">
                <div class="m-1 mt-3">
                <div class="input-group">
                    <input type="file" id="file" @change="onFileSelected" class="form-control shadow-none" accept=".xlsx, .csv" required :disabled="validated ? disabled : false">
                </div>
                <span class="text-danger" for="" v-if="errors.upload_file && errors.upload_file != ''"><small> <i class="bi bi-x-circle-fill"></i> <span v-text="errors.upload_file[0]"></span> </small></span>
                </div>
        </div>
  
    <div class="col-md-12">
        <div class="m-1 mt-3">
        <button type="submit" class="btn btn-success shadow-none float-end ms-1"><i class="bi-save"></i> <span v-text="button"></span> </button>         
        <span v-if="validated" @click="cancelBtn" class="btn btn-danger float-end ms-1"><i class="bi-x fs-6"></i> Cancel  </span>         
        </div>
    </div>
    </div>
    </fieldset>
            </form>
        
    </div>
</div>

</div>
</div>

    <div class="row mt-2">
        <div class="col-md-12">
            <section v-if="info.length > 0">
        <div class="row m-0 p-0">
            <div class="col-md-6 m-0 p-0">
                <div class="m-1">
                <span class="fs-6" v-text="recordType"></span>
                </div>
            </div>
            <div class="col-md-6 m-0 p-0">
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
    <table class="table table-hover table-bordered" id="myTable">
        <thead>
        <tr>
            <th scope="col" class="text-truncate" @click="sortOrder('routeLink')" title="">Route link </th>
            <th scope="col" class="text-truncate" @click="sortOrder('route_name')" title="">Name</th>
            <th scope="col" class="text-truncate" @click="sortOrder('title')" title="">Title</th>
            <th scope="col" class="text-truncate" @click="sortOrder('descriptions')" title="">Description</th>
            <th scope="col" class="text-truncate">Status</th>
        </tr>

        </thead>
        <tbody>
        <tr v-for="(d, index) in info.slice(startNumber, endNumber)" :key="index">
            <td class="" v-html="d.routeLink? d.routeLink : '<em class=text-danger>None</em>'"></td>
            <td class="" v-html="d.route_name? d.route_name : '<em class=text-danger>None</em>'"></td>
            <td class="" v-html="d.title? d.title : '<em class=text-danger>None</em>'"></td>
            <td class="" v-html="d.descriptions? d.descriptions : '<em class=text-danger>None</em>'"></td>
            <td class=""> <strong><small v-html="d.upload_status ? d.upload_status : 'New'"></small></strong> </td>
        </tr>

        </tbody>
    </table>

</div>
</section>
<section v-else>
    <p class="mt-2 text-center"> <span class="display-7 text-muted" v-html="recordResponse"></span> </p>
</section>

        </div>
    </div>
    </div>
    </div>
</template>

<script>
import * as XLSX from 'xlsx';
export default {
    name: 'Access_Upload',
    props: ['server_message'],
    data (){
        return{
        pageName: 'Access',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        notification: '',
        info: [],
        startNumber: 0,
        endNumber: 10,
        maximumRow: 10,
        rowSelected: '',
        totalRecord: [],
        progress: null,
        button: 'Upload',
        btntxt: 'Upload',
        record:false,
        responseStatus: '',
        usersession: [],
        category_list: [],
        upload_file: '',
        filterlist: '',
        search: '',
        checked: true,
        list_id: [],
        selectToggleValue: '',
        selectedlist: null,
        selectDefault: "Select",
        progress: '0%',
        selectedFile: '',
        uploadStatus: false,
        toUpload: [],
        successfulRecord: [],
        existRecord: [],
        failedRecord: [],
        noRecord: [],
        tabColor: '',
        recordResponse: 'No preview here yet',
        disabled: false,
        validated: false,
        errors: [],
        form_success: [],
        parameters:{
            records: '',
            group_id: '',
            upload_file: '',
        },
        recordType: 'Preview of the selected file.',
    }
    },

    created(){
    // this.getCategory()
    }, 

    methods:{
    onFileSelected(event){
            this.selectedFile = event.target.files[0]
            this.successfulRecord = ''
            this.noRecord = ''
            this.failedRecord = ''
            this.existRecord = ''
            this.readFileSelected(this.selectedFile)
        },

    readFileSelected: function(userProfilePassport){
            var file = userProfilePassport
            var reader = new FileReader();
            reader.onload = function(e, result) {
            var data = e.target.result
            var workbook = XLSX.readFile(data, {type: 'buffer', header:1})
            var sheetName = workbook.SheetNames[0]
            var sheetData = workbook.Sheets[sheetName];
            var records = XLSX.utils.sheet_to_json(sheetData)
            this.info=records;
            this.totalRecord=records;
            this.toUpload=records;
            this.getTotalRecord()
            }.bind(this);
            reader.readAsArrayBuffer(file);
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


    rowsToDisplay: function(){
        if (this.rowSelected != '') {
        this.endNumber = parseInt(this.rowSelected)
        this.maximumRow = parseInt(this.rowSelected)
        }else{
        this.endNumber = 20
        this.maximumRow = 20
        }
    },
   showMore: function(){
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
        if(this.startNumber >= parseInt(this.maximumRow)) {
            this.startNumber = parseInt(this.startNumber) - parseInt(parseInt(this.maximumRow))
            this.endNumber = parseInt(this.endNumber) - parseInt(parseInt(this.maximumRow))
        }else{
            this.startNumber = 0
            this.endNumber = parseInt(this.maximumRow)
        }

    },

    clearRecord: function(){
        this.successfulRecord = ''
        this.noRecord = ''
        this.failedRecord = ''
        this.existRecord = ''
    },
    cancelBtn: function(){
                this.validated = false
                this.disabled = false
                this.button = this.btntxt
    },
    validateForm: function(){
        $(".toaster").toast('hide')
        this.errors = '';
        if(this.toUpload.length > 0 && this.validated) {
            this.sendPost()
            this.validated = false
        }else if(this.toUpload.length > 0 && !this.validated) {
            this.disabled = true;
            this.validated = true;
            this.button = "Continue";
        }else{
            this.validated = false
            this.disabled = false;
            this.alertMsg='You do not have any record on the selected tab.'
            $("#alertDanger").toast('show')
        }

    },

    sendPost: function(){
        this.clearRecord();
        this.button='Please wait...';
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.alertMsg = '';
        this.parameters.records = this.toUpload
        axios.post('/access/upload', this.parameters).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
                this.successfulRecord = response['data'].data.successful
                this.existRecord = response['data'].data.exist
                this.noRecord = response['data'].data.noRecord
                this.alertMsg=response['data'].data.msg;
                $("#alertPrimary").toast('show')
                this.getSuccessfulRecord()
            }else if(response['data'].data.status=='failed'){
                this.successfulRecord = response['data'].data.successful
                this.failedRecord = response['data'].data.failed
                this.existRecord = response['data'].data.exist
                this.noRecord = response['data'].data.noRecord
                this.alertMsg=response['data'].data.msg;
                $("#alertDanger").toast('show')
                this.getTotalRecord()
            }else{
                this.alertMsg=response['data'].data.msg;
                $("#alertDanger").toast('show')
                this.getTotalRecord()
            }

        }).catch(error => {
                this.getTotalRecord()
                this.button=this.btntxt;
                this.showOverlay=false;
                this.errors = '';
            if(error.response != undefined && error.response.status==422){
                this.errors = error.response.data.errors;
                this.alertMsg='Some of the data supplied are invalid, kindly confirm and try again.'
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
    getTotalRecord: function(){
        this.toUpload = this.totalRecord;
        this.info = this.totalRecord;
        this.recordType = 'Preview of the selected file'
        this.recordResponse = "No file is selected yet"
    },
    getSuccessfulRecord: function(){
        this.toUpload = this.successfulRecord;
        this.info = this.successfulRecord;
        this.recordType = 'Preview of the successfully uploaded record(s).'
        this.recordResponse = "No successful record(s) here."

    },
    getFailedRecord: function(){
        this.toUpload = this.failedRecord
        this.info = this.failedRecord;
        this.recordType = 'Preview of the failed record(s) that could not be uploaded.'
        this.recordResponse = "No failed record(s) here."


    },
    getExistRecord: function(){
        this.toUpload = this.existRecord;
        this.info = this.existRecord;
        this.recordType = 'Preview of the existing record(s) that could not be uploaded.'
        this.recordResponse = "No existing record(s) here."

    },
     getNoRecord: function(){
        this.toUpload = this.noRecord;
        this.info = this.noRecord;
        this.recordType = 'Preview of the record(s) that were not found.'
        this.recordResponse = "You do not have any data here."

    },


    getCategory: function(){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        axios.get('/accessgroup/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if(response.status != undefined && response.status==200 && response['data'].data.status=='success'){
            this.category_list = response['data'].data.info
            }else if(response['data'].data.status=='norecord'){
            this.category_list = ''
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


    },


    }
</script>