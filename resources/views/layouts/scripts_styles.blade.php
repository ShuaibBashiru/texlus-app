<meta charset="utf-8">
<!-- <meta name="color-scheme" content="dark" /> -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name') }} - @yield('pageTitle')</title>

<!-- Styles -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="<?php echo asset('css/style.css')?>" type="text/css"> 

<!-- Scripts -->
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ mix('js/app.js') }}" defer></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
