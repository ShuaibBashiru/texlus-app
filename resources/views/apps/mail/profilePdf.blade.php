<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<title>{{$data['title']}} For {{$data['user_info']['lastname'].'-'.$data['user_info']['firstname'].'-'.$data['dated']}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body{
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            background-color: #edf7ff;
            padding: 5;
            border-radius: 5px;
        }

        @page {
            margin: 10;
            size: letter;
        }
        .bg-lightblue{
        background-color: #edf7ff;
        }
        .bg-lightgray{
        background-color: #edf7ff;

        }
        .bg-light-eee{
        background-color: #fefefe;

        }
        .wrapper{
            width: 100%;
            position: relative;
            height: 98%;
            overflow: hidden;
            padding: 2;
        }
        .container{
            width: 98%;
            min-height: 200px;
            margin: auto;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            padding-bottom: 0px;

        }
        .container2{
            width: 98%;
            height: auto;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
            padding-bottom: 0px;
        }
        .noborder{
            border: 0;
        }
        .wrapper-col-12{
            width: 100%;
            height: auto;
        }
        .wrapper-col-8{
            width: 75%;
            height: auto;
            float: left;
        }
        .wrapper-col-4{
            width: 22%;
            height: auto;
            float: right;
            padding: 4px;
        }
        .border-bottom{
            border-bottom: 1px solid #ccc;
        }
        .border-top{
            border-top: 1px solid #ccc;
        }
        .border{
            border: 1px solid #ccc;
        }
        .passport img{
            width: 99%;
            height: 180px;
            margin: auto;
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
        .muted{
            opacity: 0.5;
        }
        .table-profile{
            width: 98%;
            border-collapse: collapse; 
            margin-left: 10px;
        }
        .table-profile .tr-2 td{
            padding: 15px;
            padding-left: 0px;
            padding-right: 5px;
            font-size: 16px;
        }
    
       .table-profile .tr-2 td:nth-child(1){
            width: 30%;
        }
       .table-profile .tr-2 td:nth-child(2){
            width: 70%;
        }
        .headerTitle{
            padding-left: 10px;
            margin-top: 10px;
        }
        .logoSize2{
        width: 45px;
        height: 45px;
        }
        @media only screen and (max-width: 850px) {
        .wrapper{
            width:100%;
        }
   
        }
    </style>
</head>
<body>
<header>

</header>
<section>
    <div class="wrapper">

        <div class="container2 noborder">
            <div class="wrapper-col-12">
                <img 
                class="logoSize2"
                src="data:image/png;base64,{{ $data['site_logo'] }}"
                alt="No logo"
                >
                <p style="font-size: 22px; margin-top:5px;">{{$data['headerName']}}</p>
            </div>
        </div>

        <div class="container">
            <div class="wrapper-col-8">
                <h3 class="headerTitle">{{$data['title']}}</h3>
                <table class="table-profile">
                    <tbody>
                    <tr class="tr-2">
                        <td class="title border-top"><span class="muted">ACCOUNT ID</span></td>
                        <td class="titleValue border-top"><span>{{$data['user_info']['personal_id']}}</span></td>
                    </tr>
                    <tr class="tr-2">
                        <td class="title border-top"><span class="muted">SURNAME</span></td>
                        <td class="titleValue border-top"><span>{{$data['user_info']['lastname']}}</span></td>
                    </tr>
                    <tr class="tr-2">
                        <td class="title border-top"><span class="muted">OTHER NAME(S)</span></td>
                        <td class="titleValue border-top"><span>{{$data['user_info']['firstname']}} {{$data['user_info']['othername']!=""? $data['user_info']['othername'] : ''}}</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="wrapper-col-4 border passport">
                <img 
                class=""
                src="data:image/png;base64,{{ $data['user_image'] }}"
                alt="No passport"
                >
            </div>
        </div>

        <div class="container2">
            <div class="wrapper-col-12">
                <table class="table-profile">
                    <tbody>
                    <tr class="tr-2">
                        <td class="title"><span class="muted">BIRTHDAY</span></td>
                        <td class="titleValue"><span>{{$data['user_info']['date_of_birth']!="" ? $data['user_info']['date_of_birth'] : "None"}}</span></td>
                    </tr>
                    <tr class="tr-2">
                        <td class="title border-top"><span class="muted">GENDER</span></td>
                        <td class="titleValue border-top"><span>{{$data['user_info']['gender_name']!="" ? $data['user_info']['gender_name'] : "None"}}</span></td>
                    </tr>
                    <tr class="tr-2">
                        <td class="title border-top"><span class="muted">EMAIL ADDRESS</span></td>
                        <td class="titleValue border-top"><span>{{$data['user_info']['email_one']!="" ? $data['user_info']['email_one'] : "None"}} {{$data['user_info']['email_two']!="" ? '| '. $data['user_info']['email_two'] : ""}}</span></td>
                    </tr>
                    <tr class="tr-2">
                        <td class="title border-top"><span class="muted">PHONE NUMBER</span></td>
                        <td class="titleValue border-top"><span>{{$data['user_info']['phone_one']!="" ? $data['user_info']['phone_code'].$data['user_info']['phone_one'] : "None"}} {{$data['user_info']['phone_two']!="" ? '| '. $data['user_info']['phone_two'] : ""}}</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container2">
            <div class="wrapper-col-12">
                <h3 class="headerTitle">Contact address</h3>
                <table class="table-profile">
                    <tbody>
                    <tr class="tr-2">
                        <td class="title border-top"><span class="muted">STATE / COUNTRY</span></td>
                        <td class="titleValue border-top"><span>{{$data['user_info']['state_name']!="" ? $data['user_info']['state_name'] : "None"}} / {{$data['user_info']['country_name']!="" ? $data['user_info']['country_name'] : "None"}}</span></td>
                    </tr>
                    <tr class="tr-2">
                        <td class="title border-top"><span class="muted">ADDRESS</span></td>
                        <td class="titleValue border-top"><span>{{$data['user_info']['address_one']!="" ? $data['user_info']['address_one'] : "None"}}</span></td>
                    </tr>
     
                    </tbody>
                </table>
            </div>
        </div>

        <div class="container2 noborder">
            <div class="wrapper-col-12">
                <p style="text-align: center;"><small>Copyright &copy; {{$data['copyright']}}</small></p>
            </div>
        </div>
        
    </div>
</section>
</div>
</body>
</html>