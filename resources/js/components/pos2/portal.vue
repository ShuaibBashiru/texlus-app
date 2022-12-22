<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />  
    <printinvoice2 :invoice_id="invoice_id" />  
<div class="container-fluid">
    <server-alert :server_message="server_message" />
    <a href="#" id="topLink"></a>
        <div class="row">
        <div class="col-md-5">
        <div class="mt-1 mb-2">
            <h5 class="mt-2 ms-0 text-muted"> <span v-text="pageName"></span>/invoice: <span v-text="parameters.invoice_number"></span></h5>
        </div>
        </div>
        <div class="col-md-7 d-flex justify-content-end dropdown">
        <div class="mt-1 mb-2">
        <button type="button" class="btn btn-outline-primary" @click="neworder">New <i class="bi bi-plus-circle"></i></button>
</div>
</div>
</div>
        <div class="row">
        <div class="col-md-5">
        <div class="mt-1 mb-2">
        <div class="input-group">
        <label for="recipient" class="input-group-text bg-white">Sold To</label>
        <input type="text" v-model="parameters.soldTo" class="form-control" placeholder="Name" id="recipient">
         </div>
        </div>
        </div>
        <div class="col-md-7 d-flex justify-content-end dropdown">
        <div class="mt-1 mb-2">
         <div class="input-group">
        <label for="amountPaid" class="input-group-text bg-white">Amount paid</label>
        <input type="text" v-model="parameters.amountPaid" class="form-control" placeholder="0.0" id="amountPaid" readonly>
         </div>
</div>
</div>

</div>


<hr/>
<div class="row">
    <div class="col-md-3">
        <span class="float-start" v-text="'Item(s): '+ indexes.length"></span>
    </div>
       <div class="col-md-6 text-center">
        <div class="row">
            <div class="col">
                <div class="input-group">
                <label for="pos" class="input-group-text bg-white border-0">Card</label>
                <input type="radio" v-model="parameters.payment_type" value="Card" id="pos">
                </div>
            </div>
            <div class="col">
                <div class="input-group">
                <label for="cash" class="input-group-text bg-white border-0">Cash</label>
                <input type="radio" v-model="parameters.payment_type" value="Cash" id="cash">
                </div>
            </div>
            <div class="col">
                <div class="input-group">
                <label for="transfer" class="input-group-text bg-white border-0">Transfer</label>
                <input type="radio" v-model="parameters.payment_type" value="Transfer" id="transfer">
                </div>
            </div>
        </div>
    </div>
       <div class="col-md-3">
        <span class="float-end" v-text="'Total: '+ valueConverter(parameters.totalPrice)"></span>
    </div>
</div>
    <div class="row mt-1">
    <div class="col-md-12">
    <div class="table-responsive">
    <table class="table table-hover table-bordered" id="listTable">
        <thead>
        <tr>
            <th scope="col" class="text-truncate" title="">Item </th>
            <th scope="col" class="text-truncate" title="">Amount </th>
       </tr>
        </thead>
        <tbody id="items"> 
        <tr id="product-item0" class="product-item">
        <td class="col-5 text-center">
        <select class="form-control shadow-none itemName change" name="itemName" id="0">
                <option value="Food" selected>Food</option>
        </select>
            </td>
            <td class="col-2 text-center">
            <input type="text" name="amount" id="0" placeholder="Enter Food price" class="shadow-none form-control amount form-control-md form-control-sm-lg" value="" @input="calculate">
            </td>
        </tr>
        <tr id="product-item1" class="product-item">
        <td class="col-5 text-center">
        <select class="form-control shadow-none itemName change" name="itemName" id="1">
                <option value="Drink" selected>Drink</option>
        </select>
            </td>
            <td class="col-2 text-center">
            <input type="text" name="amount" id="1" placeholder="Enter Drink price" class="shadow-none form-control amount form-control-md form-control-sm-lg" value="" @input="calculate">
            </td>
        </tr>
        </tbody>
    </table>
    </div>

    <div class="row m-0 mt-2">
        <div class="col-md-3 ps-0">
        <button class="btn btn-info shadow-none float-start" @click="clear"><i class="bi bi-trash"></i>Clear</button>
        </div>
        <div class="col-md-6"> <p v-html="errorResponse" class="text-danger text-center"></p></div>
        <div class="col-md-3 pe-0">
            <form @submit.prevent="confirmOrder">
          <button type="submit" class="btn btn-primary shadow-none float-end"><span v-text="button"></span> </button>         
        </form>
        </div>
    </div>
    <div class="border-top border-1 border-secondary mt-2"></div>
    </div>

    </div>

    </div>
<!--  -->

</div>
</template>

<script>
import appsettings from '/storage/settings/app.json'
export default {
    name: 'pointOfSale2',
    props: ['server_message'],
    data (){
        return{
        pageName: 'POS',
        invoice_id: '',
        settings: appsettings,
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        selectedRecord: [],
        usersession: [],
        info: [],
        startNumber: 0,
        endNumber: 20,
        maximumRow: 20,
        rowSelected: '',
        totalRecord: [],
        progress: null,
        button: 'Confirm order',
        btntxt: 'Confirm order',
        record:false,
        responseStatus: '',
        errors: [],
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
        disabled: true,
        validated: false,
        search: '',
        statuses: [],
        indexes: [0],
        lastid: 0,
        id: '',
        errorResponse: '',
        itemsCollate: [],
        orderDate: '',
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
            invoice_number: Date.now(),
            status: '',
            qty: [],
            item_id: [],
            unit_price: [],
            totalPrice: 0,
            amountPaid: '',
            payment_type: '',
            soldTo: 'Walk-in',
            customer_id: 0,
        },
        list:{
            qty: 0,
            item_id: '',
            unit_price: 0,
            amount: 0,
        },
        errors: [this.parameters],
        form_success: [],
    }
    },

    created(){
    },

    computed:{

    },

    mounted(){
    },
        
    methods:{
    
    cancelBtn: function(){
            this.validated = false
            this.disabled = false
            this.button = this.btntxt
   },

    valueConverter: function(amount){
        var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'NGN',
        })
        return formatter.format(amount);
    },

    clear: function(){
        $('.product-item .amount').val('');
        this.indexes = [];
        this.indexes.push(0);
        this.errorResponse = '';
        this.parameters.totalPrice = '';
        this.parameters.amountPaid = '';
        this.parameters.payment_type = '';
        this.disabled = false;
        this.alertMsg='';
        $("#alertPrimary").toast('hide')
    },

    neworder: function(){
        $('.product-item .amount').val('');
        this.indexes = [];
        this.indexes.push(0);
        this.parameters.invoice_number = Date.now();
        this.errorResponse = '';
        this.parameters.totalPrice = '';
        this.parameters.amountPaid = '';
        this.parameters.payment_type = '';
        this.disabled = false;
        this.alertMsg='';
        $("#alertPrimary").toast('hide')
    },

    validateAllInput: function(){
        const items = document.querySelectorAll('.product-item');
        var counter = 0;
        var validInput = 0;
        for (const item of items) {
        var position = counter;
        var getItemElement = document.getElementById('product-item'+position).id;
        var itemName = $('#'+getItemElement+' .itemName').val();
        var amount = $('#'+getItemElement+ ' .amount').val();
        if(itemName=='' || amount == ''){
            validInput -= 1;
        }else{
            validInput += 1;
        }
        counter++;
        }
        if (validInput == counter) {
            return true;
        }else{
            return false;
        }

    },

   calculate: function(){
        var item_id = [];
        var qty = [];
        var unit_price = [];
        var itemNames = document.getElementsByName('itemName');
        var totalPrice = 0;
        for (let index = 0; index < itemNames.length; index++) {
            qty.push(1);
            var amount = $('#product-item'+index+ ' .amount').val()
            var itemName = $('#product-item'+index+ ' .itemName').val()
            item_id.push(itemName)
            amount = amount? amount : 0
            unit_price.push(amount);
            totalPrice += parseFloat(amount);
        }
        this.parameters.totalPrice = totalPrice;
        this.parameters.amountPaid = totalPrice;
        this.parameters.item_id = item_id
        this.parameters.unit_price = unit_price
        this.parameters.qty = qty
        },


    confirmOrder: function(){
        if (!this.validateAllInput()) {
            this.errorResponse= "Kindly fill the above input(s)";
        }else if(this.parameters.payment_type == '') {
            this.errorResponse= "Kindly select the payment type (Cash, Card or Transfer).";
        }else if(this.parameters.soldTo == '') {
            this.errorResponse= "Please fill in the recipient name (Walk-in or Customer's name.)";
        }else{
            this.errorResponse= "";
            this.sendPost();
        }
    },

    setId: function(){
        this.invoice_id = this.parameters.invoice_number
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
        axios.post('/pos2/create', form).then(response => {
        this.button=this.btntxt;
        this.showOverlay=false;
        this.errors = '';
        if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.alertMsg=response['data'].data.msg;
            $("#alertPrimary").toast('show')
            this.setId();
            this.neworder()
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

    },


    }
</script>