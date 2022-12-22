<template>
<div class="">
    <b-overlay class="position-fixed w-100 h-100" :show="showOverlay" no-wrap spinner-variant="primary" rounded="sm" spinner-type="border" z-index="999999" />
  <div class="row">
  <div class="col-md-12">
        <div class="border rounded-3 p-1 pt-0 pb-0">
          <div class="row m-0 p-0 pb-1 pt-1">
              <div class="col-md-6">
            <h6 class="m-0 pt-2" v-text="chartOptions.chartTitle"></h6> 
          </div>
              <div class="col-md-6 pe-0 dropdown">
            <button class="btn float-end me-2 pt-1 pb-1 btn-outline-primary" @click="getRecords"><i class="bi-arrow-clockwise"></i> 
            <span v-text="button"> </span> <span v-if="loadStatus=='load'" class="spinner-border spinner-border-sm text-primary"></span>
            </button>
            <input type="date" title="Filter" v-model="selectedDate" class="btn float-end me-2 pt-1 pb-1 btn-outline-primary" @input="getRecords">
        </div>
      </div>
      </div>
  </div>
  </div>

 <div class="row bg-primary text-white rounded pt-3 pb-3 m-0 mt-2">
      <div class="col-md-3 mt-2">
        <div class="border rounded-3 p-1 pt-0 pb-0">
             <div class="row border-bottom m-0 p-0 pb-1 pt-1">
                  <div class="col-md-10">
            <h6 class="m-0 pt-2 pb-2" v-text="chartOptions.total.header +' ('+parameters.year+')'"></h6> 
          </div>
              <div class="col-md-2">
              </div>
      </div>
      <div class="row overflow-hidden m-0 mt-2 mb-2">
        <div class="col-md-12">
          <h5 class="mt-4 mb-0"> <span class="" v-text="valueConverter(totalPrice)"></span> </h5>
          <small class="" v-text="'Revenue in '+parameters.year"></small> 
              <hr>
          <h5 class="mt-4 mb-0"> <span class="" v-text="totalItems"></span> </h5>
          <small class="" v-text="'Invoiced in '+parameters.year"></small>
          <hr> 
          <h5 class="mt-4 mb-0"> <span class="" v-text="valueConverter(monthlyAmount)"></span> </h5>
          <small class="">Revenue on  (<small v-text="selectedDate"></small>)</small> 
          <hr>
          <h5 class="mt-4 mb-0"> <span class="" v-text="totalMonthlyInvoiced"></span> </h5>
          <small class="">Invoiced on (<small v-text="selectedDate"></small>)</small> 
    </div>
    </div>
    </div>
    </div>

  <div class="col-md-9 mt-2">
        <div class="border rounded-3 p-1 pt-0 pb-0 m-0">
      <div class="row border-bottom m-0 p-0 pb-1 pt-1">
              <div class="col-md-8">
            <h6 class="m-0 pt-2 pb-2" v-text="chartOptions.optionFLow.header + ', '+parameters.year"></h6> 
          </div>
              <div class="col-md-4">
              </div>
    </div>

      <div class="row overflow-hidden m-0 mt-2 mb-2">
        <div class="col-md-12">
          <p class="text-warning" v-if="norecord"><em v-text="norecordText"></em></p>
            <div v-if="!norecord">
            <section v-if="info.length > 0">
            <GChart class="chart" 
              type="ColumnChart" 
              :data="chartFLows" 
              :resizeDebounce="500"
              :options="chartOptions.optionFLow" />
           </section>
           <section v-else>
            <p class="text-center text-white blinker">Fetching...</p>
           </section>
            </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>
</template>
<style scoped>
  .chart {
        width: 99%;
        min-height: 280px;
    }
</style>
<script>
import { GChart } from 'vue-google-charts/legacy'
export default {
  name: 'sales_chart_monthly',
  props: ['server_message'],
  components: {
    GChart
  },
  data (){
    return{
        alertTitle: '',
        alertMsg: '',
        showOverlay: false,
        info: [],
        totalRecord: [],
        allSales: [],
        loadStatus: 'load',
        progress: null,
        btntxt: 'Refresh',
        button: 'Refresh',
        errors: [],
        selectionTotal: 0,
        years: [],
        norecord: false,
        norecordText: '',
        norecordText: 'Loading',
        parameters:{
            year: '',
            month: '',
            day: '',
        },
        selectedDate: '',
        todayMonth: '',
        totalPrice: 0,
        monthlyAmount: 0,
        counter: 0,
        totalItems: 0,
        totalMonthlyInvoiced: 0,
        chartSummary: [],
        chartItemFLows: [],
        chartFLows: [],
        chartOptions: {
        chartTitle: "Monthly Flow",
        summary: {
          header: 'Summary in Year',
          title: '',
          is3D: true,
          stacked: false,
          responsive: true,

        },
        optionFLow: {
          header: 'Monthly flow in',
          title: '',
          is3D: true,
          stacked: false,
          responsive: true,
          height: 400,
        },
        itemFLows: {
          header: '',
          title: '',
          is3D: true,
          stacked: false,
          responsive: true,
          height: 400,

        },
         total: {
          header: "Invoiced",
          title: '',
          is3D: true,
          stacked: false,
          responsive: true,
        },
        },
            months: {
              '01': 'January',
              '02': 'February',
              '03': 'March',
              '04': 'April',
              '05': 'May',
              '06': 'June',
              '07': 'July',
              '08': 'August',
              '09': 'September',
              '10': 'October',
              '11': 'November',
              '12': 'December',
            },
    }
  },

  created(){
    this.getRecords();
    // this.getYears();
  },
  mounted(){
  },
  methods:{

    getDateInfo: function(){
      let today = this.selectedDate==''? new Date().toISOString().slice(0, 10) : this.selectedDate
      let splitDate = today.split('-')
      this.parameters.year = splitDate[0];
      this.parameters.month = splitDate[1];
      this.parameters.day = splitDate[2];
      this.selectedDate = today;
    },
      valueConverter: function(amount){
        var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'NGN',
        })
        return formatter.format(amount);
    },
 getRecords: function(){
        this.button='Loading...';
        this.loadStatus='load';
        axios.get('/pos2/invoices', {params:this.parameters}).then(response => {
            if((response.status != undefined && response.status==200) && (response['data'].data.status==response['data'].data.statusmsg)){
            this.info = response['data'].data.info;
            this.totalRecord = response['data'].data.info;
            this.allSales = response['data'].data.sales;
            this.refreshChart();
            this.button=this.btntxt;
            this.loadStatus=true;
            }else if(response['data'].data.status=='norecord'){
            this.responseStatus = response['data'].data.msg
            this.info = ''
            this.alertMsg=''
            this.button=this.btntxt;
            this.loadStatus=true;
            }else{
            this.alertMsg=response['data'].data.msg;
            this.button=this.btntxt;
            this.loadStatus=true;
            }
        }).catch(error => {
                this.button=this.btntxt;
                this.errors = '';
                this.loadStatus=true;
            if(error.response != undefined && error.response.status==422){
                this.errors = error.response.data.errors;
                this.alertMsg='Something went wrong! Kindly confirm and correct the error(s) before you continue.'
            } else if(error.response != undefined && error.response.status==419){
                this.alertMsg='This page has been inactive for long, Kindly refresh and try again.';
            }else if(error.response != undefined && error.response.status==500){
                this.alertMsg='Internal server error! Please refresh and try again or report this error.';
            }else{
                this.alertMsg='Access restricted or Network error! Please refresh and try again or report this error.';
            }
        })
    },
  
  refreshChart: function(){
       this.plotChart();
  },  

  plotChart: function(){
      this.getDateInfo();
      this.getFLow();
    },

    sortOrder: function(column, record){
    try {
        record.sort((a, b) =>{
        let s1 = a[column].toString().toLowerCase()
        let s2 = b[column].toString().toLowerCase()
        return s1.localeCompare(s2);
        })
        } catch (error) {
            return false;
        }
    },

  filterData: function(needle, record){
      this.sortOrder('date_created');
      var newRecord = []
      for (let i = 0; i < record.length; i++) {
        if (
            record[i].date_created.toString().toLowerCase().search(needle.toString().toLowerCase())!=-1
            ){
          newRecord.push(record[i]);
        }
        }
        return newRecord;
      },

      slicedBy: function(needle, record){
      this.sortOrder('date_created');
      var newRecord = []
      for (let i = 0; i < record.length; i++) {
        if (
            record[i].date_created.toString().toLowerCase().startsWith(needle)
            ){
          newRecord.push(record[i]);
        }
        }
        return newRecord;
        },
 
    getFLow: function(){
    this.chartFLows=[];
    this.selectionTotal = 0;
    var YearlyAmount = 0;
    var countYearlyInvoice = 0;
    var MonthlyAmount = 0;
    var countMonthlyInvoice = 0;
    this.chartFLows.push(['Date', 'Total sales']);
    this.chartOptions.optionFLow.title = "";
          var needle = this.parameters.year
          var data = this.slicedBy(needle, this.info);
          this.norecord = data== '' ? true : false;
          this.norecordText = data == '' ? 'No Record(s) found' : '';
          const grouped = _.groupBy(data, info => info.date_created.substring(5, 7));
          var columns = []
          for (var key in grouped){
            columns.push(key)
          }
          columns.sort((a, b) => a - b)
          for (let i = 0; i < columns.length; i++){
          var total = 0;
          var qty = 0;
          var thisYear = this.parameters.year;
          var selectedMonth = columns[i];
          for (let index = 0; index < grouped[columns[i]].length; index++) {
              this.selectionTotal += 1;
              qty = qty + 1;
              total += parseFloat(grouped[columns[i]][index].totalPrice);
              if (this.parameters.month == selectedMonth) {
                countMonthlyInvoice += 1
                MonthlyAmount += parseFloat(grouped[columns[i]][index].totalPrice);
                countYearlyInvoice += 1
                YearlyAmount += parseFloat(grouped[columns[i]][index].totalPrice);
              }else if(this.parameters.year == thisYear){
                countYearlyInvoice += 1
                YearlyAmount += parseFloat(grouped[columns[i]][index].totalPrice);
              }
          }
          var label = this.selectedDate == columns[i]? this.months[columns[i]].toString()+'\nActive' : this.months[columns[i]].toString()
          this.chartFLows.push([label, total])
          }
          this.totalPrice = YearlyAmount;
          this.totalItems = countYearlyInvoice;
          this.monthlyAmount = MonthlyAmount;
          this.totalMonthlyInvoiced = countMonthlyInvoice;

    },



  },


    }
</script>