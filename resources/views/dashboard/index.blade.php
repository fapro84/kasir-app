@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Produk Terjual</div>
                    <div class="card-body">
                        {{-- <h3>Total Penjualan: $500</h3> --}}
                        <!-- Informasi penjualan lainnya -->
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Total Terjual</div>
                    <div class="card-body">
                        {{-- <h3>Total terjual</h3> --}}
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Keuntungan</div>
                    <div class="card-body">
                        {{-- <h3>Keuntungan Kotor: $200</h3> --}}
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Produk Terjual</div>
                    <div class="card-body">
                        {{-- <h3>Total Penjualan: $500</h3> --}}
                        <!-- Informasi penjualan lainnya -->
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Total Terjual</div>
                    <div class="card-body">
                        {{-- <h3>Total terjual</h3> --}}
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Keuntungan</div>
                    <div class="card-body">
                        {{-- <h3>Keuntungan Kotor: $200</h3> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">Traffic</h4>
                    <div class="small text-medium-emphasis">January - July 2022</div>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    <div class="btn-group btn-group-toggle mx-3" data-coreui-toggle="buttons">
                        <input class="btn-check" id="option1" type="radio" name="options" autocomplete="off">
                        <label class="btn btn-outline-secondary"> Day</label>
                        <input class="btn-check" id="option2" type="radio" name="options" autocomplete="off"
                            checked="">
                        <label class="btn btn-outline-secondary active"> Month</label>
                        <input class="btn-check" id="option3" type="radio" name="options" autocomplete="off">
                        <label class="btn btn-outline-secondary"> Year</label>
                    </div>
                    <button class="btn btn-primary" type="button">
                        <svg class="icon">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-cloud-download"></use>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                <canvas class="chart" id="main-chart" height="300"
                    style="display: block; box-sizing: border-box; height: 300px; width: 1020px;" width="1020"></canvas>
                <div class="chartjs-tooltip" style="opacity: 0; left: 51px; top: 351.46px;">
                    <table style="margin: 0px;">
                        <thead class="chartjs-tooltip-header">
                            <tr style="border-width: 0px;" class="chartjs-tooltip-header-item">
                                <th style="border-width: 0px;">January</th>
                            </tr>
                        </thead>
                        <tbody class="chartjs-tooltip-body">
                            <tr class="chartjs-tooltip-body-item">
                                <td style="border-width: 0px;"><span
                                        style="background: rgba(3, 9, 15, 0.1); border-color: rgb(51, 153, 255); border-width: 2px; margin-right: 10px; height: 10px; width: 10px; display: inline-block;"></span>My
                                    First dataset: 170</td>
                            </tr>
                            <tr class="chartjs-tooltip-body-item">
                                <td style="border-width: 0px;"><span
                                        style="background: rgba(0, 0, 0, 0.1); border-color: rgb(46, 184, 92); border-width: 2px; margin-right: 10px; height: 10px; width: 10px; display: inline-block;"></span>My
                                    Second dataset: 162</td>
                            </tr>
                            <tr class="chartjs-tooltip-body-item">
                                <td style="border-width: 0px;"><span
                                        style="background: rgba(0, 0, 0, 0.1); border-color: rgb(229, 83, 83); border-width: 2px; margin-right: 10px; height: 10px; width: 10px; display: inline-block;"></span>My
                                    Third dataset: 65</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('request')
    <script>
        $('#sbdashboard').addClass("active");
    </script>
@endsection
