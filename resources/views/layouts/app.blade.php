<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <meta name="description" content="Write an awesome description for your new site here. You can edit this line in _config.yml. It will appear in your document head meta (for Google search results) and in your feed.xml site description.
">
    <title>@yield('title', '首页') - 免费领纸巾</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('lib/weui.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery-weui.css')}}">
    <link rel="stylesheet" href="{{asset('css/demos.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
@include('layouts._header')
<div class="weui-tab">

    @yield('content')

</div>
    @include('layouts._footer')
<!-- Scripts -->
<script src="{{ asset('lib/jquery-2.1.4.js') }}"></script>
<script src="{{ asset('lib/fastclick.js') }}"></script>
<script>
    $(function() {
        FastClick.attach(document.body);
    });
</script>
<script src="{{ asset('js/jquery-weui.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>