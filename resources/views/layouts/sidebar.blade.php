<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <svg class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
        </svg>
        <svg class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
        </svg>
    </div>

    @if (session('user.user_priv') === 'admin')
        {{-- admin===================== --}}
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
            <li class="nav-item"><a class="nav-link" id="sbdashboard" href="/dash">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                    </svg>Dashboard</a>
            </li>
            <li class="nav-item"><a class="nav-link" id="sbtrans" href="/user">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-people') }}"></use>
                    </svg>Registrasi Petugas</a>
            </li>
            <li class="nav-item"><a class="nav-link" id="sbproduk" href="/produk">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-cart') }}"></use>
                    </svg>Produk</a>
            </li>
            <li class="nav-item"><a class="nav-link" id="sbkategori" href="/kategori">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-list') }}"></use>
                    </svg>Kategori</a>
            </li>
            <li class="nav-item"><a class="nav-link" id="sbpelanggan" href="/pelanggan">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-contact') }}"></use>
                    </svg>Pelanggan</a>
            </li>
            <li class="nav-item"><a class="nav-link" id="sblaporan" href="/laporan">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-chart-line') }}"></use>
                    </svg>Laporan</a>
            </li>
        </ul>
    @elseif(session('user.user_priv') === 'petugas')
        {{-- petugas --}}
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
            <li class="nav-item"><a class="nav-link" id="sbdashboard" href="/dash">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-speedometer') }}"></use>
                    </svg>Dashboard</a>
            </li>
            <li class="nav-item"><a class="nav-link" id="sbtrans" href="/transaksi">
                    <svg class="nav-icon">
                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-money') }}"></use>
                    </svg>Transaksi</a>
            </li>
        </ul>
    @endif
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
