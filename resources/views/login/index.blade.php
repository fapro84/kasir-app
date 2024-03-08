<!DOCTYPE html><!--
    * CoreUI - Free Bootstrap Admin Template
    * @version v4.2.2
    * @link https://coreui.io/product/free-bootstrap-admin-template/
    * Copyright (c) 2023 creativeLabs Łukasz Holeczek
    * Licensed under MIT (https://github.com/coreui/coreui-free-bootstrap-admin-template/blob/main/LICENSE)
    -->
<html lang="en">

<head>
    @include('layouts.head')
</head>

<body>
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-group d-block d-md-flex row">
                        <div class="card col-md-7 p-4 mb-0">
                            <form action="" method="POST">
                                @csrf
                                <div class="card-body">
                                    <h1>Login</h1>
                                    <p class="text-medium-emphasis">Masuk ke akun anda</p>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="input-group mb-3"><span class="input-group-text">
                                            <svg class="icon">
                                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                                            </svg></span>
                                        <input class="form-control" value="{{ old('username') }}" type="text"
                                            name="username" placeholder="Username">
                                    </div>
                                    <div class="input-group mb-4"><span class="input-group-text">
                                            <svg class="icon">
                                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked">
                                                </use>
                                            </svg></span>
                                        <input class="form-control" value="{{ old('password') }}" type="password"
                                            name="password" placeholder="Password">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button class="btn btn-primary px-4" type="submit">Login</button>
                                        </div>
                                        <div class="col-6 text-end">
                                            <button class="btn btn-link px-0" type="button" data-coreui-toggle="tooltip"
                                                data-coreui-placement="bottom" title="Hubungi Admin">Lupa
                                                password?</button>


                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card col-md-5 text-white bg-primary py-5">
                            <div class="card-body text-center">
                                <div>
                                    <h2>Kasir</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua.</p>
                                    <button class="btn btn-lg btn-outline-light mt-3" type="button">Selamat
                                        Datang</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.script')

    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-coreui-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new coreui.Tooltip(tooltipTriggerEl))
    </script>


</body>

</html>
