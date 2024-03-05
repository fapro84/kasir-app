<!DOCTYPE html><!--
    * CoreUI - Free Bootstrap Admin Template
    * @version v4.2.2
    * @link https://coreui.io/product/free-bootstrap-admin-template/
    * Copyright (c) 2023 creativeLabs Łukasz Holeczek
    * Licensed under MIT (https://github.com/coreui/coreui-free-bootstrap-admin-template/blob/main/LICENSE)
    --><!-- Breadcrumb-->
<html lang="en">

<head>
    @include('layouts.head')
</head>

<body>
    @include('layouts.sidebar')
    <div class="wrapper d-flex flex-column min-vh-100 bg-light">

        @include('layouts.header')

        @yield('content')


    </div>
    @include('layouts.script')
    @yield('request')
</body>

</html>
