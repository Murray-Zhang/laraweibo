<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Weibo App') - Laravel ⼊⻔教程</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
@include('layouts._header')
<div class="container">
    @yield('content')
    @include('layouts._footer')
</div>
</body>
</html>