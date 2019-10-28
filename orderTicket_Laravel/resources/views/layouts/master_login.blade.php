<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.headtag')
@yield('page_Style')
<body class="text-center">
@yield('contain')
</body>
</html>

