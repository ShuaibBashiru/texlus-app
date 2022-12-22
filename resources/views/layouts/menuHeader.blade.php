<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @extends('layouts.scripts_styles')
</head>
<body>
    <div id="app">
    @yield('content')
    </div>
</body>
</html>

