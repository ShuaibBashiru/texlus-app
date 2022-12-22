<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
    <notification :alertTitle="alertTitle" :alertMsg="alertMsg" />  
    <printinvoice :invoice_id="invoice_id" />  
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
            <th scope="col" class="text-truncate" title="">Unit price </th>
            <th scope="col" class="text-truncate" title="">Qty </th>
            <th scope="col" class="text-truncate" title="">Amount </th>
            <th scope="col" class="text-truncate text-center" title="">Remove</th>
       </tr>
        </thead>
        <tbody id="items"> 
        <tr id="product-item0" class="product-item">
        <td class="col-5 text-center">
           <input list="icons" class="form-control shadow-none change itemName" name="itemName" @change="calCulateOnChange(0)" id="0" data-id="" placeholder="Pick item">
            <datalist id="icons">
                <option v-for="(d, index) in info" :value="d.item_name" :key="index" v-text="d.item_name"></option>
            </datalist>
            </td>
            <td class="col-2 text-center">
               <input type="number" name="unitPrice" readonly id="0" class="shadow-none unitPrice form-control form-control-md form-control-sm-lg" min="50">
            </td>
            <td class="col-1 text-center">
            <input type="number" name="qty" id="0" @input="calCulateOnChange(0)" class="shadow-none form-control qty form-control-md inputs form-control-sm-lg" min="1" max="1000" value="1">
            </td>
            <td class="col-2 text-center">
            <input type="text" name="amount" id="0" class="shadow-none form-control amount form-control-md form-control-sm-lg" value="0" readonly>
            </td>
            <td class="col-1 text-center btnHolder"> 
            <button class="btn btn-danger removalBtn" id="removalBtn" value="0" @click="removeItem($event)"> - </button>
            </td>
        </tr>
        </tbody>
    </table>
    </div>

    <div class="row m-0 mt-2">
        <div class="col-md-3 ps-0">
        <button class="btn btn-info shadow-none float-start" @click="addItem"><i class="bi bi-plus"></i> Add item</button>
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
    name: 'pointOfSale',
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
    this.getLists();
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
    getItemInfo: function(itemName){
        const item = [];
        for (let i = 0; i < this.info.length; i++) {
        if (
            this.info[i].item_name.toString().toLowerCase().search(itemName.toString().toLowerCase())!=-1
            ){
        item.push(this.info[i]);
        }
        }
        return item;
    },
    calCulateOnChange: function(index){
        var position = parseInt(index);
        var getItemElement = document.getElementById('product-item'+position).id;
        var itemName = $('#'+getItemElement+' .itemName').val();
        var itemInfo = this.getItemInfo(itemName)
        var qty = $('#'+getItemElement+ ' .qty').val();
        var amount = '';
        var unitPrice = itemInfo[0]? itemInfo[0].unit_price:'';
        if(unitPrice==='' || itemName===''){
            this.calculate();
            return false;
        }else{
            amount = unitPrice * parseInt(qty)
            $('#'+getItemElement+ ' .unitPrice').val(unitPrice ? unitPrice : 0)
            $('#'+getItemElement+ ' .amount').val(amount ? amount : 0)
            $('#'+getItemElement+ ' .itemName').val(itemInfo[0] ? itemInfo[0].item_name : '')
            this.errorResponse = '';
            this.calculate();
            return true;
        }
    },
    validateInput: function(position){
        var getItemElement = document.getElementById('product-item'+position).id;
        var itemName = $('#'+getItemElement+' .itemName').val();
        var qty = $('#'+getItemElement+ ' .qty').val();
        var unitPrice = $('#'+getItemElement+ ' .unitPrice').val();
        var amount = $('#'+getItemElement+ ' .amount').val();
        if(itemName=='' || qty == 0 || qty == '' || unitPrice == 0 || unitPrice == '' || amount == 0 || amount == ''){
            return false;
        }else{
            return true;
        }
    },

    addItem: function(e) {
        var last = this.indexes.slice(-1)
        if (!this.validateInput(parseInt(last))) {
            this.errorResponse= "Kindly fill the above input(s)";
        }else{
        this.errorResponse= "";
        var newindex = parseInt(last) + 1;
        this.indexes.push(newindex)
        // Clone item and assign individual id
        $('.product-item:last').clone(true).insertAfter('.product-item:last');
        $('.product-item:last').attr('id', 'product-item'+newindex);
        $('.product-item:last .unitPrice').attr('id', newindex);
        $('.product-item:last .qty').attr('id', newindex);
        $('.product-item:last .amount').attr('id', newindex);
        $('.removalBtn:last').attr('value', newindex);
        // Reset cloned input to default values
        $('.product-item:last .itemName').val('');
        $('.product-item:last .unitPrice').val(0);
        $('.product-item:last .amount').val(0);
        $('.product-item:last .qty').val(1);
        this.lastid = parseInt(newindex)
        // Select element with event and add their respective EventListener to inputs
        const items = document.querySelectorAll('.product-item button');
        // Key up event for qty and price
        const onchanges = document.querySelectorAll('.change');
        const inputs = document.querySelectorAll('.inputs');
        for (const item of items) {
        item.addEventListener('click', this.removeItem);
        }
        var position = 0;
        for (const change of onchanges) {
            change.addEventListener("change", this.calCulateOnChange.bind(null, position), false);
            position += 1;
        }
        var keyIndex = 0;
        for (const input of inputs) {
            input.addEventListener("input", this.calCulateOnChange.bind(null, keyIndex), false);
            keyIndex += 1;
        }
        
        }
    },

    removeItem: function(e) {
        this.errorResponse= "";
        var id = e.target.value;
        if(id==0) {
            this.errorResponse = "You cannot remove the first item";
            return false;
        }else{
            $('#product-item'+id).remove();
            this.indexes.pop();
            var itemPosition = 0;
            // Iterate over the element and sort ids
            const items = document.querySelectorAll('.product-item');
            for (const item of items) {
                $('#'+item.id).attr('id', 'product-item'+itemPosition);
                $('#'+item.id+' button').attr('value', itemPosition);
                itemPosition += 1;
                }
            this.calculate();
            }
    },

    neworder: function(){
        for(var key in this.indexes){
            var id = this.indexes[key]
            if (id!=0) {
            $('#product-item'+id).remove();
            }else{
                $('.product-item select').val('');
                $('.product-item .unitPrice, .amount').val(0);
                $('.product-item .qty').val(1);
            }
        }
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
        const items = document.querySelectorAll('.product-item button');
        var counter = 0;
        var validInput = 0;
        for (const item of items) {
        var position = counter;
        var getItemElement = document.getElementById('product-item'+position).id;
        var itemName = $('#'+getItemElement+' .itemName').val();
        var qty = $('#'+getItemElement+ ' .qty').val();
        var unitPrice = $('#'+getItemElement+ ' .unitPrice').val();
        var amount = $('#'+getItemElement+ ' .amount').val();
        if(itemName=='' || qty == 0 || qty == '' || unitPrice == 0 || unitPrice == '' || amount == 0 || amount == ''){
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
        var get_prices = document.getElementsByName('unitPrice');
        var get_qty = document.getElementsByName('qty');
        var qtyByUnitPrice = '';
        var totalPrice = 0;
        for (let index = 0; index < itemNames.length; index++) {
            var itemInfo = this.getItemInfo(itemNames[index].value)
            item_id.push(itemInfo ? parseInt(itemInfo[0].id) : 0)
            unit_price.push(get_prices[index].value);    
            qty.push(get_qty[index].value);
            qtyByUnitPrice = parseFloat(get_prices[index].value * parseInt(get_qty[index].value))
            var amount = qtyByUnitPrice ? qtyByUnitPrice : 0;
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
        axios.post('/pos/create', form).then(response => {
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

    getLists: function(){
        $(".toaster").toast('hide')
        this.showOverlay=true;
        this.search = ''
        axios.get('/salesitems/list', {params:this.parameters}).then(response => {
            this.button=this.btntxt;
            this.showOverlay=false;
            this.errors = '';
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.info = response['data'].data.info
            }else if(response['data'].data.status=='norecord'){
            this.info = ''
            this.alertMsg=''
            }else{
            this.alertMsg=response['data'].data.msg;
            $("#alertDanger").toast('show')
            }
        }).catch(error => {
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