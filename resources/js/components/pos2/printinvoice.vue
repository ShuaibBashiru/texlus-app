<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
<div class="container-fluid">
<error-alert :message="error_message" />
<div class="modal fade" id="printInvoiceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="newRoleModalLabel" aria-hiden="true">
<div class="modal-dialog ps-md-3 pe-md-3">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="newRoleModalLabel" v-html="pageName"></h5>
        <button type="button" class="btn-close" @click="deleted=false" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
        <p class="text-info text-center m-0 p-0 d-none" v-text="getInvoice"></p>
        </div>
        <div class="row mt-3" id="printable">
        <div class="col-md-12">
        <div class="alert m-1 alert-info border-0 p-1 ps-2 pe-2 m-3 mb-2 mt-2 text-center" role="alert" v-if="alertMsg!=''">
        <small class="" v-text="alertMsg"></small>
        </div>
        </div>
        <div class="col-md-12">
        <div class="mt-1 mb-2 border p-3">
          <div class="row">
            <div class="col-12 text-center">
            <h4 class="bolder"> <span v-html="settings.site_name"></span> </h4>
             <p class="m-0"><small><span></span> <span v-html="settings.office_address"></span></small></p>
            <p class="m-0"><small><span>Phone: </span> <span v-html="settings.phone_one"></span></small></p>
            </div>
            <div class="col-12 text-center">
                <barcode v-bind:value="invoice_id" :options="options">
                    <small v-text="'Order ID: '+invoice_id"></small>
                </barcode>
            </div>
          </div>

   <table class="table table-hover table-bordered" id="">
        <tbody>
        <tr> 
            <td class="col-7"><small class="">Order ID:</small></td>
            <td class="col-5"><small class="" v-text="summary?summary.invoice_number:''"></small></td>
        </tr>
        <tr> 
            <td class="col-7"><small class="">Sold To:</small></td>
            <td class="col-5"><small class="" v-text="summary?summary.soldTo:''"></small></td>
        </tr>
        <tr> 
            <td class="col-7"><small class="">Order Date:</small></td>
            <td class="col-5"><small class="" v-text="summary?summary.date_created+' '+summary.date_created:''"></small></td>
        </tr>
        <tr> 
            <td class="col-7"><small class="">Sales Person:</small></td>
            <td class="col-5"><small class="" v-text="summary?summary.attendant:''"></small></td>
        </tr>
        <tr> 
            <td class="col-7"><small class="">Payment Type:</small></td>
            <td class="col-5"><small class="" v-text="summary?summary.payment_type:''"></small></td>
        </tr>
        </tbody>
   </table>
    <hr>
    
       <table class="table table-hover table-bordered" id="">
        <thead>
            <tr>
                <th><small>Item</small></th>
                <th><small>Unit price</small></th>
                <th><small>Qty</small></th>
                <th><small>Total</small></th>
            </tr>
        </thead>
        <tbody>
        <tr v-for="(d, index) in info" :key="index"> 
            <td class=""><small class="font-weight-bold" v-html="d.item_name"></small></td>
            <td class=""><small class="" v-text="d.unit_price"></small></td>
            <td class=""><small class="" v-html="d.qty"></small></td>
            <td class=""><small class="" v-text="d.amount"></small></td>
        </tr>
        </tbody>
   </table>
    <hr/>
   <table class="table table-hover table-bordered" id="">
        <tbody>
        <tr> 
            <td class="col-7"><small class="font-weight-bold">Total:</small></td>
            <td class="col-5"><small class="font-weight-bold float-end" v-text="summary? valueConverter(summary.totalPrice):''"></small></td>
        </tr>
        </tbody>
   </table>
            <p class="m-0 text-center"><strong>Thanks for your patronage</strong></p>
        </div>
        </div>
       
</div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" @click="print" v-if="info.length>0"> Print <i class="bi bi-printer"></i></button>
      </div>
      </div>
      </div>
      </div>



<!-- Receipt -->



    </div>
<!--  -->

</div>
</template>

<script>
import appsettings from '/storage/settings/app.json'
export default {
    name: 'pointOfSalePrint2',
    props: ['server_message', 'invoice_id', 'timeInterval'],
    data (){
        return{
        pageName: 'POS Print',
        settings: appsettings,
        error_message: '',
        alertTitle: '',
        alertMsg: '',
        status: 0,
        showOverlay: false,
        usersession: [],
        info: [],
        summary: [],
        button: 'Preview',
        btntxt: 'Preview',
        responseStatus: '',
        errors: [],
        statuses: [],
        errorResponse: '',
        options:{
            lineColor: '#ff7069',
            fontSize: 32,
            font: 'Courier',
            width: 3,
            height: 60,
            marginBottom: 60,
            format: 'MSI',
            background: '#ccffff'
        },
        parameters:{
            invoice_number: '',
            status: '',
        },
        form_success: [],
    }
    },

    created(){
    this.getSessionData();
    },

    computed:{
        getInvoice:function(){
            this.parameters.invoice_number = this.invoice_id;
            this.setTimeInterVal = this.timeInterval;
            this.getLists();
            return true;
        }

    },

    mounted(){
    this.getLists();
    },
    methods:{
    async print () {
        $("#printInvoiceModal").modal('hide')
        $("#alertPrimary").toast('hide')
        await this.$htmlToPaper('printable');
    },
    getSessionData: function(){
       try {
         if (this.$session.get('usersession')!=undefined && this.$session.get('usersession')!='') {
            this.usersession = this.$session.get('usersession')
         }else{
            this.error_message='Something went wrong! Please log out and log in again to continue.'
            $("#alertDanger").toast('show')
         }
          } catch (error) {
            this.error_message='Error connecting! Please log out and log in again to continue.'
            $("#alertDanger").toast('show')
          }
    },

    valueConverter: function(amount){
        var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'NGN',
        })
        return formatter.format(amount);
    },


    getLists: function(){
    if (this.parameters.invoice_number != ''){
        this.showOverlay=true;
        axios.get('/pos2/invoice', {params:this.parameters}).then(response => {
            this.errors = '';
            this.showOverlay=false;
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.info = response['data'].data.info
            this.summary = response['data'].data.summary
            this.error_message=''
            $("#printInvoiceModal").modal('show')
            }else if(response['data'].data.status=='norecord'){
            this.error_message = response['data'].data.msg
            this.info = ''
            this.summary = ''
            this.error_message='No sales record yet! Continue selling and confirm order'
            }else{
            this.error_message=response['data'].data.msg;
            }
        }).catch(error => {
            this.showOverlay=false;
            if(error.response != undefined && error.response.status==422){
                this.error_message='Something went wrong! Kindly confirm and correct the error(s) before you continue.'
            } else if(error.response != undefined && error.response.status==419){
                this.error_message='This page has been inactive for long, Kindly refresh and try again.';
            }else if(error.response != undefined && error.response.status==500){
                this.error_message='Internal server error! Please refresh and try again or report this error.';
            }else{
                this.error_message='Access restricted or Network error! Please refresh and try again or report this error.';
            }
        })
    }
    },


    },


    }
</script>