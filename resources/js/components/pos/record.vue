<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
      <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />  
    <printinvoice :invoice_id="parameters.invoice_number" :timeInterval="timeInterval" />  
<div class="container-fluid">
    <server-alert :server_message="server_message" />
    <a href="#" id="topLink"></a>
        <div class="row">
        <div class="col-md-5">
        <div class="mt-1 mb-2">
            <h5 class="mt-2 ms-0 text-muted"><i class="bi bi-chevron-left" onclick="history.back()" title="Go back" role="button"></i> <span v-text="pageName"></span></h5>
        </div>
        </div>
        <div class="col-md-7 d-flex justify-content-end dropdown">
        <div class="mt-1 mb-2">
        <button class="btn btn-outline-primary" title="Refresh" @click="getRecords()"><i class="bi-arrow-clockwise" style="font-size: 1rem;"></i></button>
        <a type="button" class="btn btn-outline-primary" href="portal"> Make order <i class="bi bi-plus-circle"></i></a>
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
            <th scope="col" class="text-truncate" @click="sortOrder('invoice_number')" title="">Invoice Number <i class="bi bi-sort-down float-end"></i></th>
            <th scope="col" class="text-truncate" title="soldTo">Customer</th>
            <th scope="col" class="text-truncate" title="attendant">Attendant</th>
            <th scope="col" class="text-truncate" title="total price">Total</th>
            <th scope="col" class="text-truncate" title="date_created">Date Created</th>
            <th scope="col" class="text-truncate text-center" title="Action"> Receipt </th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="(d, index) in info.slice(startNumber, endNumber)" :key="index">
            <td class="col-1 text-center"><input type="checkbox" id="" :value="d.generated_id" v-model="parameters.selectedList" name="checkbox" @change="checkBoxOnChange"></td>
            <td class="" v-html="d.invoice_number ? d.invoice_number : ''"></td>
            <td class="" v-html="d.soldTo ? d.soldTo : ''"></td>
            <td class="" v-html="d.attendant ? d.attendant : ''"></td>
            <td class="" v-html="d.totalPrice ? d.totalPrice : ''"></td>
            <td class="" v-html="d.date_created ? d.date_created +' '+ d.time_created : ''"></td>
            <td class="text-center">
                <button type="button" class="btn btn-outline-primary" @click="print(d.invoice_number)" :disabled="disabled"> Print <i class="bi bi-printer"></i></button> 
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

<!--  -->
</div>
</template>

<script>
import * as XLSX from 'xlsx';
export default {
    name: 'Invoice_List',
    props: ['server_message'],
    data (){
        return{
        pageName: 'Invoices',
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        selectedRecord: [],
        info: [],
        startNumber: 0,
        endNumber: 20,
        maximumRow: 20,
        rowSelected: '',
        totalRecord: [],
        progress: null,
        button: 'Proceed',
        btntxt: 'Proceed',
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
        timeInterval: '',
        parameters:{
            selectedList: [],
            status: '',
            invoice_number: '',
        },
        form_success: [],
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
        print: function(id){
            this.parameters.invoice_number = id;
            this.timeInterval = Date.now();
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
           if (
            this.totalRecord[i].invoice_number.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1 ||
            this.totalRecord[i].soldTo.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1 ||
            this.totalRecord[i].attendant.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1 ||
            this.totalRecord[i].date_created.toString().toLowerCase().search(this.search.toString().toLowerCase())!=-1
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
        axios.get('/pos/invoices', {params:this.parameters}).then(response => {
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

    },


    }
</script>