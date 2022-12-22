<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<title>{{$data['title']}} For {{$data['user_info']['lastname'].'-'.$data['user_info']['firstname'].'-'.$data['dated']}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }
         @page { 
            margin: 5px;
            margin-left:12px;
            margin-right:12px;
        }
        body { 
            margin: 5px;
            margin-left:12px;
            margin-right:12px; 
        }
        .app{
            width:46%;
            margin: auto;
            height: auto;
            background-color: #f68084;
            border-radius:5px;

        }
        .page-break {
            page-break-after: always;
        }
        li{
            list-style: none;
        }
        ul{
            margin: 0;
            padding: 0;
        }
        .float-end{
            float:right;
        }
        .text-end{
            float:right;
        }
        .text-center{
            text-align: center;
        }
        .fs-3{
            font-size: 16px;
            padding: 2px;
            margin-left: 0;
        }
        .fs-4{
            font-size: 18px;
            padding: 2px;
            margin-left: 0;
        }
        .p-1{
            padding: 1px;
        }
        .m-0{
            margin: 1px;
        }
        .lsp-1{
            letter-spacing: 1px;
        }
        .text-uppercase{
            text-transform: uppercase;
        }
        .text-capitalize{
            text-transform: capitalize;
        }
        .text-normal{
            text-transform: none;
        }
        .pt-11{
            padding-top: 11px;
        }
        .pb-6{
            padding-bottom: 6px;
        }
        .mt-10{
            margin-top: 10px;
        }
        .mt-20{
            margin-top: 20px;
        }
        .mb-10{
            margin-bottom: 10px;
        }
        .mt-1{
            margin-top: 1px;
        }
        .mt-3{
            margin-top: 3px;
        }
        .mt-0{
            margin-top: 0;
        }
        .mr-0{
            margin-right: 0;
        }
        .mr-5{
            margin-right: 5px;
        }
        .container-wrapper{
            width: 100%;
            height: 305px;
            margin: auto;
            border-radius: 5px;
            /* background-image: linear-gradient(120deg, #a6c0fe 0%, #f68084 100%); */
            padding: 4px;
            padding-bottom: 15px;
        }
        .row-1{
            width: 98%;
            height: auto;
            color: white;
            margin: auto;
            /* background-image: linear-gradient(120deg, #698fe9 0%, #f68084 100%); */
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            border-bottom: 1px solid #e4dddd;
        }
    
        .row-profile{
            width: 98%;
            height:200px;
            display: block;
            margin-top: 5px;
            padding: 5px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .col-3-left{
            width: 29%;
            height: 200px;
            float: left;
            text-align: center;
        }
        .col-9-detail{
            width: 70%;
            float: right;
            min-height: 200px;
        }
        .col-7-right{
            width: 60%;
            height: auto;
            float: right;
        }
        .col-6-right{
            width: 50%;
            height: auto;
            float: left;
        }
      
        .col-3-right{
            width: 29%;
            height: 200px;
            padding: 5px;
            padding-top: 0;
            float: right;
        }
        .col-12{
            width: 100%;
            height: auto;
            padding: 5px;
            padding-top: 0;
        }
        .passport{
            width:80%;
            margin: auto;
            height: 140px;
            border-radius: 10px;
        }
   
        .rows ul li{
            padding: 5px;
            font-size: 18px;
        }
        .col-1-header{
            padding: 5px;
            text-align: center;

        }
        .col-1-header h2{
            margin: 0;
            padding: 0;
            padding-top: 4px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
    
        .barcode{
            width: 45%;
            height: auto; 
            background-color: white;
            padding: 5px;
            overflow: hidden;
            margin: 5px;
            margin-top: 0;
        }
        .barcode-file{
            text-align: center;

        }
        .barcode-file > *{
            width: 90%;
            margin-left: 5px;
            margin-right: 5px;
        }
       
        @media only screen and (max-width: 850px) {
        .app{
            width:100%;
        }
   
        }
    </style>
</head>
<body>
<div id="app" class="app">
    <div class="container-wrapper">
        <div class="row-1">
            <div class="col-1-header">
                <h2>{{$data['owner']}} </h2>
            </div>
        </div>
        <div class="row-profile">
            <div class="col-3-left">
            <div class="mb-5 mt-4">
                 <img 
                 class="passport"
                 src="data:image/png;base64,{{ $data['user_image'] }}"
                 alt="No passport"
                 >
                 <p class="fs-3 mt-3 text-center" style="margin-bottom:2px;"><small>ID: {{$data['user_info']['personal_id']}}</small></p>
            </div>
            
            </div>
            
            <div class="col-9-detail">
            <div class="rows" style="padding-left: 15px;">
                <div class="">
                    <h3 class="mt-3">{{$data['title']}}</h3>
                <ul>
                    <li>Lastname: {{$data['user_info']['lastname']}}</li>
                    <li>Other Name(s): {{$data['user_info']['firstname']}} {{$data['user_info']['othername']}}</li>
                    <li>Email: {{$data['user_info']['email_one']}}</li>
                    <li>Phone: {{$data['user_info']['phone_code']}}{{$data['user_info']['phone_one']}}</li>
                </ul>
                </div>

            </div>
            </div>

            </div>
            <div class="col-12">
                <div class="barcode">
                    <?php
                    echo DNS1D::getBarcodeHTML($data['user_info']['personal_id'], 'C39', 1,33);
                    ?>
                </div>  
                </div>
        </div>
   
        
        <br clear="all"/>
    </div>
</div>
</body>
</html>