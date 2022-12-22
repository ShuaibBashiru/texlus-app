<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body{
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
   
    .container{
        width: 80%;
        height: auto;
        margin: 10px auto;
        border: 1px solid #eee;
        border-radius: 5px;
        padding: 5px;
        padding-left: 25px;
        padding-right: 25px;
    }
    .content p{
      font-size: 16px;
    }
    .containerFooter p{
      font-size: 13px;
    }
 
    ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333333;
  }

  li {
    float: left;
    color: #ffffff;
  }

  li a{
    display: block;
    color: #ffffff;
    text-align: center;
    padding: 16px;
    text-decoration: none;
  }

  li a:hover {
    background-color: #111111;
    color: #ffffff;
  }
</style>
</head>
<body>
    <div>
    @yield('content')
    </div>
</body>
</html>
  