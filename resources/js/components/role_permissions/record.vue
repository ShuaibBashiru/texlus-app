<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
      <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />  
<div class="container-fluid">
    <server-alert :server_message="server_message" />
    <a href="#" id="topLink"></a>
        <div class="row">
        <div class="col-md-5">
        <div class="mt-1 mb-2">
            <h5 class="mt-2 ms-0 text-muted"><i class="bi bi-chevron-left" onclick="history.back()" title="Go back" role="button"></i> <span v-text="pageName"></span>/<span class="text-muted" v-text="server_info.role_name"></span> </h5>
        </div>
        </div>
        <div class="col-md-7 d-flex justify-content-end dropdown">
        <div class="mt-1 mb-2">
        <button class="btn btn-outline-primary" title="Refresh" @click="getRecords()"><i class="bi-arrow-clockwise" style="font-size: 1rem;"></i></button>
        <button type="button" class="btn btn-primary" @click="assignPermission()" v-text="button">  <i class="bi bi-save"></i></button>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="bi bi-chevron-double-down"></i></button>
        <div class="dropdown-menu w-75 mt-0 pt-0" style="width: 200px !important;">
        <ul class="list-unstyled pb-1 border-bottom" onclick="event.stopPropagation()">
       
        <li class="mb-2">
        <p class="align-items-center ps-2 p-1 mb-0 collapsed dropdown-item" data-bs-toggle="collapse" data-bs-display="static" data-bs-target="#drop3" aria-expanded="false">
        <i class="bi bi-trash text-danger me-1"></i> <span class="text-danger">Permissions</span></p>
        <div class="collapse" id="drop3">
        <ul class="btn-toggle-nav ms-2 list-unstyled fw-normal pb-1 small">
        <li class="p-1 text-center">
        <button type="button" class="btn w-100 btn-sm btn-outline-danger" @click="removePermission()" v-text="'Remove'">  <i class="bi bi-save"></i></button>
        </li>
        </ul>
        </div>
        </li> 
       
          <li class="mb-2">
        <p class="align-items-center ps-2 p-1 mb-0 collapsed dropdown-item" data-bs-toggle="collapse" data-bs-display="static" data-bs-target="#drop5" aria-expanded="false">
        <i class="bi bi-trash text-primary me-1"></i> <span class="text-primary">Set Home page</span></p>
        <div class="collapse" id="drop5">
        <ul class="btn-toggle-nav ms-2 list-unstyled fw-normal pb-1 small">
        <li class="p-1 text-center">
        <button type="button" class="btn w-100 btn-sm btn-outline-primary" @click="setLanding()" v-text="'Set as home page'">  <i class="bi bi-save"></i></button>
        </li>
        </ul>
        </div>
        </li> 
       
        <li class="mb-2">
        <p class="align-items-center ps-2 p-1 mb-0 collapsed dropdown-item" data-bs-toggle="collapse" data-bs-display="static" data-bs-target="#drop4" aria-expanded="false">
        <i class="bi bi-list-task me-1"></i> <span>Number of rows</span></p>
        <div class="collapse" id="drop4">
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

        <li class="mb-2">
        <p class="align-items-center ps-2 p-1 mb-0 collapsed dropdown-item" data-bs-toggle="collapse" data-bs-display="static" data-bs-target="#drop2" aria-expanded="false">
        <i class="bi bi-file-excel me-1"></i> <span>Export data</span></p>
        <div class="collapse" id="drop2">
        <ul class="btn-toggle-nav ms-2 list-unstyled fw-normal pb-1 small">
        <li class="p-1" @click="exportToExcel"> <i class="bi bi-chevron-right"></i> <span>Excel</span> </li>
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
<div class="border p-2 rounded mt-1">
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
            <th scope="col" class="text-truncate" @click="sortOrder('routeLink')" title="">Route <i class="bi bi-sort-down float-end"></i></th>
            <th scope="col" class="text-truncate" @click="sortOrder('title')" title="">Title <i class="bi bi-sort-down float-end"></i></th>
            <th scope="col" class="text-truncate" @click="sortOrder('descriptions')" title="">Description <i class="bi bi-sort-down float-end"></i></th>
            <th scope="col" class="text-truncate text-center" title="Permission"> Access </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(d, index) in info.slice(startNumber, endNumber)" :key="index">
            <td class="text-center"> <input type="checkbox" id="" :value="d.id" v-model="parameters.selectedList" name="checkbox" @change="checkBoxOnChange"></td>
            <td class="" v-html="d.routeLink ? d.routeLink : ''"></td>
            <td class="" v-html="d.title ? d.title : ''"></td>
            <td class="" v-html="d.descriptions ? d.descriptions : ''"></td>
            <td class="text-center"><i class="bi bi-check-square text-primary" v-if="rolePermissions.includes(d.id)"></i> <i v-else class="bi bi-x-square text-danger"></i></td>
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


<!--  -->


</div>
</template>

<script>
import * as XLSX from 'xlsx';
export default {
    name: 'RolePermission_List',
   props: ['role_record', 'server_message'],
    data (){
        return{
        pageName: 'Role Permissions',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        selectedRecord: [],
        server_info: this.role_record,
        info: [],
        rolePermissions: [],
        startNumber: 0,
        endNumber: 20,
        maximumRow: 20,
        rowSelected: '',
        totalRecord: [],
        progress: null,
        button: 'Assign',
        btntxt: 'Assign',
        record:false,
        responseStatus: '',
        errors: [],
        usersession: [],
        category_list: [],
        filterlist: '',
        search: '',
        checked: true,
        list_id: [],
        get_list_array: '0',
        listStatus: '',
        selectToggleValue: '',
        isChecked: false,
        selectDefault: "Select",
        counter: '0',
        disabled: false,
        validated: false,
        search: '',
        checks: [],
        statuses: [],
        parameters:{
            selectedList: [],
            status: '',
            role_id: '',
            role_name: '',
            access_permission_id: '',
        },
        errors: [this.parameters],
        form_success: [],
    }
    },

    created(){
    this.getRoleRecord();
    this.getRecords();
    },

    computed:{

    },
    mounted(){

    },
        
    methods:{

    getRoleRecord: function(){
        this.parameters.role_id = this.role_record.id;
        this.parameters.role_name = this.role_record.role_name;
    },

   validateForm: function(){
    this.alertMsg=''
      if(this.parameters.selectedList.length > 0 && this.parameters.role_id != '') {
            return true;
        }else{
            return false;
        }
    },

    assignPermission: function(){
        if(!this.validateForm()){
            $("#alertDanger").toast('show')
            this.alertMsg="No item(s) selected!"
            return false;
        }
        this.button='Please wait...';
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.alertMsg = '';
        axios.post('/rolepermission/assign', this.parameters).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            $("#alertPrimary").toast('show')
            setTimeout(function(){
                  this.getRecords()
            }.bind(this), 2000)
            }else if(response['data'].data.status=='failed'){
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
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
                this.alertMsg='Something went wrong! Kindly confirm and correct the error(s) before you continue.';
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

    setLanding: function(){
        if(this.parameters.selectedList.length < 1){
            $("#alertDanger").toast('show')
            this.alertMsg="No item is selected!"
            return false;
        }else if(this.parameters.selectedList.length > 1){
            $("#alertDanger").toast('show')
            this.alertMsg="Only one item is allowed to be set as home page."
            return false;
        }
        this.button='Please wait...';
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.alertMsg = '';
        this.parameters.access_permission_id = this.parameters.selectedList[0]
        axios.post('/rolepermission/sethomepage', this.parameters).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            $("#alertPrimary").toast('show')
            setTimeout(function(){
                  this.getRecords()
            }.bind(this), 2000)
            }else if(response['data'].data.status=='failed'){
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
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
                this.alertMsg='Something went wrong! Kindly confirm and correct the error(s) before you continue.';
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
 removePermission: function(){
        if(!this.validateForm()){
            $("#alertDanger").toast('show')
            this.alertMsg="No item(s) selected!"
            return false;
        }
        this.button='Please wait...';
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.alertMsg = '';
        axios.post('/rolepermission/remove', this.parameters).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            $("#alertPrimary").toast('show')
            setTimeout(function(){
                  this.getRecords()
            }.bind(this), 2000)
            }else if(response['data'].data.status=='failed'){
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
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
                this.alertMsg='Something went wrong! Kindly confirm and correct the error(s) before you continue.';
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
            this.totalRecord[i].role_name = this.totalRecord[i].role_name==null ? '' : this.totalRecord[i].role_name 
           if (
            this.totalRecord[i].routeLink.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1 ||
            this.totalRecord[i].role_name.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1 ||
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
        axios.get('/rolepermission/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.info = response['data'].data.info
            this.totalRecord = response['data'].data.info
            this.rolePermissions = response['data'].data.rolePermissions;
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
   
     confirmStatusUpdate: function(){
        this.alertMsg=''
      if(this.parameters.selectedList.length > 0 && this.parameters.status != '') {
            this.manageStatus()
            this.parameters.status = ''
        }else{
            this.parameters.status = ''
            $("#alertDanger").toast('show')
            this.alertMsg="No item(s) selected!"
        }
    },
   
   manageStatus: function(){
        this.alertMsg=''
        $(".toaster").toast('hide')
        this.showOverlay=true;
        axios.get('', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
             if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            $("#alertPrimary").toast('show')
            this.getRecords()
            }else if(response['data'].data.status=='failed'){
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
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


    },


    }
</script>