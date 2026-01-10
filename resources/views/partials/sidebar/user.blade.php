<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{ $navlink === 'Dashboard' ? 'active' : '' }}" href="{{ url('user/dashboard') }}">
                    <div class="sb-nav-link-icon "><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link {{ $navlink === 'Data Barang' ? 'active' : '' }}"
                    href="{{ url('user/data-barang') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                    Data Barang
                </a>

                <a class="nav-link {{ $navlink === 'Barang Masuk' ? 'active' : '' }}"
                    href="{{ url('user/data-barang-masuk') }}">
                    <div class="sb-nav-link-icon "><i class="fas fa-arrow-down"></i></div>
                    Barang Masuk
                </a>

                <a class="nav-link {{ $navlink === 'Barang Keluar' ? 'active' : '' }}"
                    href="{{ url('user/data-barang-keluar') }}">
                    <div class="sb-nav-link-icon "><i class="fas fa-arrow-up"></i></div>
                    Barang Keluar
                </a>

                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link {{ $navlink === 'Data Kategori' ? 'active' : '' }}"
                    href="{{ url('user/kategori') }}">
                    <div class="sb-nav-link-icon "><i class="fas fa-tags"></i></div>
                    Data Kategori
                </a>
                <a class="nav-link {{ $navlink === 'Data Supplier' ? 'active' : '' }}"
                    href="{{ url('user/data-supplier') }}">
                    <div class="sb-nav-link-icon "><i class="fa-solid fa-truck"></i></div>
                    Data Supplier
                </a>
                <a class="nav-link collapsed {{ in_array($navlink, ['laporan_masuk', 'laporan_keluar']) ? 'active' : '' }}"
                    href="#" data-bs-toggle="collapse" data-bs-target="#collapseLaporan" aria-expanded="false"
                    aria-controls="collapseLaporan">

                    <div class="sb-nav-link-icon">
                        <i class="fas fa-chart-area"></i>
                    </div>
                    Laporan
                    <div class="sb-sidenav-collapse-arrow">
                        <i class="fas fa-angle-down"></i>
                    </div>
                </a>

                <div class="collapse {{ in_array($navlink, ['laporan_masuk', 'laporan_keluar', 'laporan_stok']) ? 'show' : '' }}"
                    id="collapseLaporan">

                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link {{ $navlink === 'laporan_masuk' ? 'active' : '' }}"
                            href="{{ route('user.laporan.masuk') }}">
                            <div class="sb-nav-link-icon ">
                                <i class="fas fa-arrow-down"></i>
                            </div>
                            Barang Masuk
                        </a>

                        <a class="nav-link {{ $navlink === 'laporan_keluar' ? 'active' : '' }}"
                            href="{{ route('user.laporan.keluar') }}">
                            <div class="sb-nav-link-icon ">
                                <i class="fas fa-arrow-up"></i>
                            </div>
                            Barang Keluar
                        </a>
                    </nav>
                </div>

            </div>
        </div>
        <div class="sb-sidenav-footer text-uppercase">
            <div class="small ">Logged in as:</div>
            {{ Auth::user()->role }}
        </div>
    </nav>
</div>
