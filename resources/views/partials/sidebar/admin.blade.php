<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ url('admin/dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="{{ url('admin/data-barang') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                    Data Barang
                </a>

                <a class="nav-link" href="index.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-arrow-down"></i></div>
                    Barang Masuk
                </a>

                <a class="nav-link" href="index.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-arrow-up"></i></div>
                    Barang Keluar
                </a>

                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="charts.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Laporan
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer text-uppercase">
            <div class="small ">Logged in as:</div>
            {{ Auth::user()->role }}
        </div>
    </nav>
</div>
